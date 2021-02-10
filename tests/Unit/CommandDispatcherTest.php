<?php

declare(strict_types=1);

namespace Ngmy\PhpWebDav\Tests\Unit;

use Http\Client\HttpClient;
use Mockery;
use Ngmy\PhpWebDav\Command;
use Ngmy\PhpWebDav\CommandDispatcher;
use Ngmy\PhpWebDav\HttpClientFactory;
use Ngmy\PhpWebDav\Tests\TestCase;
use Ngmy\PhpWebDav\WebDavClientOptionsBuilder;
use org\bovigo\vfs\vfsStream;
use Psr\Http\Message\ResponseInterface;

class CommandDispatcherTest extends TestCase
{
    /**
     * @return list<list<mixed>>
     */
    public function dispatchProvider(): array
    {
        $root = vfsStream::setup();
        $file = vfsStream::newFile('file')->at($root);

        return [
            [
                Command::create(
                    'Download',
                    (new WebDavClientOptionsBuilder())->build(),
                    'http://example.com/file',
                    '/tmp/file'
                ),
                ResponseInterface::class,
            ],
            [
                Command::create(
                    'Upload',
                    (new WebDavClientOptionsBuilder())->build(),
                    $file->url(),
                    'http://example.com/file',
                ),
                ResponseInterface::class,
            ],
        ];
    }

    /**
     * @param class-string<object> $expected
     * @dataProvider dispatchProvider
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testDispatch(Command $command, string $expected): void
    {
        $response = Mockery::mock($expected);
        $client = Mockery::mock(HttpClient::class);
        $client->shouldReceive('sendRequest')->andReturn($response);
        $factory = Mockery::mock('overload:' . HttpClientFactory::class);
        $factory->shouldReceive('create')->andReturn($client);
        $dispatcher = new CommandDispatcher($command);
        $actual = $dispatcher->dispatch();
        $this->assertInstanceOf($expected, $actual);
    }
}
