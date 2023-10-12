<?php
declare(strict_types=1);

namespace PBergman\Ntfy\Encoding;

use PBergman\Ntfy\Model\AbstractActionButton;
use PBergman\Ntfy\Model\BroadcastAction;
use PBergman\Ntfy\Model\HttpAction;
use PBergman\Ntfy\Model\ParametersInterface;
use PBergman\Ntfy\Model\Message;
use PBergman\Ntfy\Model\ViewAction;

class Marshaller implements MarshallerInterface
{
    private ?\Closure $exporter = null;
    private ?\Closure $importer = null;

    private function getExporter(): \Closure
    {
        if (null === $this->exporter) {
            $this->exporter = \Closure::fromCallable(function(array $ctx, \Closure $marshaller) {
                $data       = [];
                $hasExclude = \array_key_exists('exclude', $ctx);
                foreach (\get_object_vars($this) as $key => $value) {
                    if (null === $value || ($hasExclude && \in_array($key, (array)$ctx['exclude']))) {
                        continue;
                    }
                    switch ($key) {
                        case 'tags':
                        case 'priority':
                            $value = \implode(',', (array)$value);
                            break;
                        case 'actions':
                            $value = \implode('; ', \array_map('strval', $value));
                            break;
                        case 'pollId':  // fall trough
                            $key   = 'Poll-ID';
                        default:
                            $value = (string)$value;
                    }

                    // Check for all non ASCII, new line and carriage return if so we
                    // just encode message because server not supporting multi headers
                    if (\preg_match('/[^\x01-\x7f]|\x0a|\x0d/', $value) > 0) {
                        $value = sprintf('=?UTF-8?B?%s?=', \base64_encode($value));
                    }

                    $data['x-' . $key] = $value;
                }
                return $data;
            });
        }
        return $this->exporter;
    }

    public static function newAction(string $action): AbstractActionButton
    {
        switch ($action) {
            case BroadcastAction::ACTION:
                return new BroadcastAction('');
            case HttpAction::ACTION:
                return new HttpAction('', '');
            case ViewAction::ACTION:
                return new ViewAction('', '');
            default:
                throw new \RuntimeException('Invalid action "' . $action . '"');
        }
    }


    private function getImporter(): \Closure
    {
        if (null === $this->importer) {
            $this->importer = \Closure::fromCallable(function(array $data, array $ctx, \Closure $marshaller) {

                foreach ($data as $key => $value) {

                    if (null === $value) {
                        continue;
                    }

                    switch ($key) {
                        case 'actions':
                            $actions = [];
                            foreach ($value as $action) {
                                $actions[] = $marshaller->call(Marshaller::newAction($action['action']), $action, $ctx, $marshaller);
                            }
                            $value = $actions;
                            break;
                    }

                    if (\property_exists($this, $key)) {
                        $this->{$key} = $value;
                    }
                }
                return $this;
            });
        }
        return $this->importer;
    }

    public function marshall(ParametersInterface $params, array $ctx = []): array
    {
        return $this->getExporter()->call($params, $ctx, $this->getExporter());
    }

    public function unmarshall(array $data, array $ctx = []): Message
    {
        return $this->getImporter()->call(new Message(), $data, $ctx, $this->getImporter());
    }
}