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

namespace Wucdbm\SymfonySseResponse;

use Symfony\Component\Console\Formatter\OutputFormatter;

class SSEOutputFormatter extends OutputFormatter
{
    public function __construct(bool $decorated = false, array $styles = [])
    {
        parent::__construct($decorated, $styles);
    }

    public function formatAndWrap(?string $message, int $width): string
    {
        if (null === $message) {
            return '';
        }

        return $message;
    }
}
