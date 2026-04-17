<?php

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

namespace Wucdbm\SymfonySseResponse\Helper;

class MemoryHelper
{
    public static function currentAndPeak(): string
    {
        return sprintf(
            'Current: %s, Peak: %s',
            self::current(),
            self::peak()
        );
    }

    public static function current(): string
    {
        return self::format(memory_get_usage());
    }

    public static function peak(): string
    {
        return self::format(memory_get_peak_usage());
    }

    public static function format(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KiB', 'MiB', 'GiB', 'TiB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= 1 << (10 * $pow);

        return sprintf(
            sprintf(
                '%%.%df %%s',
                $precision,
            ),
            round($bytes, $precision),
            $units[$pow]
        );
    }
}
