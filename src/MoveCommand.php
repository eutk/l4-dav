<?php

declare(strict_types=1);

namespace Ngmy\L4Dav;

use League\Uri\Components\Path;
use Psr\Http\Message\UriInterface;

class MoveCommand extends Command
{
    /**
     * @param string|UriInterface $srcUri
     * @param string|UriInterface $destUri
     */
    public function __construct(WebDavClientOptions $options, $srcUri, $destUri)
    {
        $destUri = !\is_null($options->baseUrl())
            ? $options->baseUrl()->withPath(new Path($destUri))->uri()
            : new AbsoluteUri($destUri);
        parent::__construct($options, 'MOVE', $srcUri, new Headers([
            'Destination' => (string) $destUri,
        ]));
    }
}
