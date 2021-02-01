<?php

declare(strict_types=1);

namespace Ngmy\L4Dav\Tests\Unit;

use Http\Discovery\Psr17FactoryDiscovery;
use Exception;
use InvalidArgumentException;
use Ngmy\L4Dav\BaseUrl;
use Ngmy\L4Dav\Tests\TestCase;

class BaseUrlTest extends TestCase
{
    /**
     * @return list<list<mixed>>
     */
    public function instantiateClassProvider(): array
    {
        return [
            ['http://example.com'],
            ['http://example.com:'],
            ['http://user:password@example.com:80'],
            ['http://example.com/'],
            ['http://example.com/path'],
            ['http://example.com/path/'],
            ['http://example.com?key=value', new InvalidArgumentException()],
            ['http://example.com#fragment', new InvalidArgumentException()],
            ['https://example.com'],
            ['ftp://example.com', new InvalidArgumentException()],
            ['http://', new InvalidArgumentException()],
            ['path', new InvalidArgumentException()],
        ];
    }

    /**
     * @param Exception $expected
     * @dataProvider instantiateClassProvider
     */
    public function testInstantiateClass(string $url, $expected = null): void
    {
        if (\is_null($expected)) {
            $this->expectNotToPerformAssertions();
        }
        if ($expected instanceof Exception) {
            $this->expectException(\get_class($expected));
        }
        new BaseUrl($url);
    }

    /**
     * @return list<list<mixed>>
     */
    public function withPathProvider(): array
    {
        return [
            [
                new BaseUrl('http://example.com'),
                'shortcut',
                Psr17FactoryDiscovery::findUriFactory()->createUri('http://example.com/shortcut'),
            ],
            [
                new BaseUrl('http://example.com'),
                '/shortcut',
                Psr17FactoryDiscovery::findUriFactory()->createUri('http://example.com/shortcut'),
            ],
            [
                new BaseUrl('http://example.com/'),
                'shortcut',
                Psr17FactoryDiscovery::findUriFactory()->createUri('http://example.com/shortcut'),
            ],
            [
                new BaseUrl('http://example.com/'),
                '/shortcut',
                Psr17FactoryDiscovery::findUriFactory()->createUri('http://example.com/shortcut'),
            ],
            [
                new BaseUrl('http://example.com/path'),
                'shortcut',
                Psr17FactoryDiscovery::findUriFactory()->createUri('http://example.com/path/shortcut'),
            ],
            [
                new BaseUrl('http://example.com/path'),
                '/shortcut',
                Psr17FactoryDiscovery::findUriFactory()->createUri('http://example.com/path/shortcut'),
            ],
            [
                new BaseUrl('http://example.com/path/'),
                'shortcut',
                Psr17FactoryDiscovery::findUriFactory()->createUri('http://example.com/path/shortcut'),
            ],
            [
                new BaseUrl('http://example.com/path/'),
                '/shortcut',
                Psr17FactoryDiscovery::findUriFactory()->createUri('http://example.com/path/shortcut'),
            ],
            [
                new BaseUrl('http://example.com'),
                '',
                Psr17FactoryDiscovery::findUriFactory()->createUri('http://example.com'),
            ],
            [
                new BaseUrl('http://example.com/'),
                '',
                Psr17FactoryDiscovery::findUriFactory()->createUri('http://example.com/'),
            ],
            [
                new BaseUrl('http://example.com/'),
                'shortcut?key=value#fragment',
                Psr17FactoryDiscovery::findUriFactory()->createUri('http://example.com/shortcut?key=value#fragment'),
            ],
            [
                new BaseUrl('http://example.com/'),
                'http://example.com/',
                new InvalidArgumentException(),
            ],
        ];
    }

    /**
     * @param BaseUrl $expected
     * @dataProvider withPathProvider
     */
    public function testWithPass(BaseUrl $baseUrl, string $path, $expected): void
    {
        if ($expected instanceof Exception) {
            $this->expectException(\get_class($expected));
        }
        $actual = $baseUrl->uriWithShortcutUrl($path);
        $this->assertEquals($expected, $actual);
    }
}