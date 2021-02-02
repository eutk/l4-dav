<?php

declare(strict_types=1);

namespace Ngmy\L4Dav;

use GuzzleHttp\Psr7\Utils;
use Http\Client\HttpClient;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class CommandDispatcher
{
    /** @var Command */
    private $command;
    /** @var HttpClient */
    private $httpClient;
    /** @var RequestInterface */
    private $request;

    public function __construct(Command $command)
    {
        $this->command = $command;
        $this->httpClient = (new HttpClientFactory($command->options()))->create();
        $request = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest($this->command->method(), (string) $this->command->uri());
        $this->request = $this->configureRequest($request);
    }

    public function dispatch(): ResponseInterface
    {
        return $this->httpClient->sendRequest($this->request);
    }

    private function configureRequest(RequestInterface $request): RequestInterface
    {
        $newRequest = $request;
        $headers = $this->command->options()->defaultRequestHeaders()
            ->withHeaders($this->command->headers())
            ->toArray();
        foreach ($headers as $key => $value) {
            $newRequest = $newRequest->withHeader($key, $value);
        }
        return $this->command->body()
            ? $newRequest->withBody(Utils::streamFor($this->command->body()))
            : $newRequest;
    }
}