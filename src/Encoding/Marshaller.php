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
                        case 'title':
                        case 'message':
                            // symfony HttpClientTrait::normalizeHeaders will check for null byte, newline and carriage return
                            // so we encode the message when found. Using base64 and ignoring the line limit because ntfy server
                            // is not supporting multiple headers
                            if (false !== \strpos($value, "\x00") || false !== \strpos($value, "\x0a") || false !== \strpos($value, "\x0d")) {
                                $value = sprintf('=?UTF-8?B?%s?=', \base64_encode($value));
                            }
                            break;
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