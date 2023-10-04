<?php
declare(strict_types=1);

namespace PBergman\Ntfy\Api;

use PBergman\Ntfy\Authentication\AuthenticationInterface;
use PBergman\Ntfy\Encoding\Marshaller;
use PBergman\Ntfy\Encoding\MarshallerInterface;
use PBergman\Ntfy\Exception\PublishException;
use PBergman\Ntfy\Model\PublishParameters;
use PBergman\Ntfy\Model\Message;
use PBergman\Ntfy\Model\SubscribeParameters;
use Symfony\Component\HttpClient\Chunk\ServerSentEvent;
use Symfony\Component\HttpClient\EventSourceHttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class Client
{
    private HttpClientInterface $client;
    private ?AuthenticationInterface $auth;
    private MarshallerInterface $encoder;

    public function __construct(HttpClientInterface $client, ?AuthenticationInterface $auth = null, ?MarshallerInterface $encoder = null)
    {
        $this->client  = $client;
        $this->auth    = $auth;
        $this->encoder = $encoder ?? new Marshaller();
    }

    private function handle(ResponseInterface $response): Message
    {
        try {
            return $this->encoder->unmarshall($response->toArray());
        } catch (\Exception $e) {

            $ctx = $response->getInfo('user_data');

            if (null !== $ctx && \array_key_exists('publish_parameters', $ctx)) {
                throw new PublishException($ctx['publish_parameters'], $response, $ctx['publish_topic'] ?? $response->getInfo('url'), 500, $e);
            }

            throw $e;
        }
    }

    /** @return \Generator|Message[] */
    public function subscribe(string $topic, SubscribeParameters $params): \Generator
    {
        $opts   = ['headers' => $this->encoder->marshall($params)];
        $client = $this->client;

        if (null !== $this->auth) {
            $this->auth->set($opts);
        }

        if (!$client instanceof EventSourceHttpClient) {
            $client = new EventSourceHttpClient($client);
        }

        foreach ($client->stream($client->connect($topic . '/sse', $opts), 2) as $chunk) {
            if ($chunk instanceof ServerSentEvent && null !== $data = \json_decode($chunk->getData(), true)) {
                yield $this->encoder->unmarshall($data);
            }
        }
    }

    public function publish(string $topic, ?PublishParameters $params = null, $body = null): AsyncPublishResponse
    {
        $opts = [
            'body'      => $body,
            'user_data' => [
                'publish_topic'      => $topic,
                'publish_parameters' => $params,
            ]
        ];

        if (null !== $params) {
            $opts['headers'] = $this->encoder->marshall($params, (null === $body ? [] : ['exclude' => ['message']]));

            if (null === $body) {
                $opts['body'] = $params->getMessage();
            }
        }

        if (null !== $this->auth) {
            $this->auth->set($opts);
        }

        return new AsyncPublishResponse(
            $this->client->request('POST', $topic, $opts),
            \Closure::bind(
                function(ResponseInterface $response) {
                    return $this->handle($response);
                },
                $this
            )
        );
    }
}