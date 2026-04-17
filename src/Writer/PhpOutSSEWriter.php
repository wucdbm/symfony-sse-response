<?php

declare(strict_types=1);

/*
 * This file is part of the Wucdbm Symfony SSE Response package.
 *
 * Copyright (c) Martin Kirilov <wucdbm@gmail.com>
 *
 * Author Martin Kirilov <wucdbm@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Wucdbm\SymfonySseResponse\Writer;

class PhpOutSSEWriter extends SSEWriter
{
    /** @var resource */
    private $out;

    public function __construct()
    {
        $pointer = fopen('php://output', 'wb');

        if (false === $pointer) {
            throw new \RuntimeException(sprintf('Could not open "%s" with mode "%s"', 'php://output', 'wb'));
        }

        $this->out = $pointer;
    }

    protected function doWrite(string $event): void
    {
        fwrite($this->out, $event);
    }
}
