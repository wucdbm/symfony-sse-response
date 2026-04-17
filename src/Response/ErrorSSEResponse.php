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

namespace Wucdbm\SymfonySseResponse\Response;

use Wucdbm\SymfonySseResponse\Helper\MemoryHelper;
use Wucdbm\SymfonySseResponse\SSEOutput;
use Wucdbm\SymfonySseResponse\Writer\PhpOutSSEWriter;
use Wucdbm\SymfonySseResponse\Writer\SSEWriter;

class ErrorSSEResponse extends SSEResponse
{
    public function __construct(
        string|\Throwable $error,
        SSEWriter $writer = new PhpOutSSEWriter(),
        ?int $throttle = 1_000,
    ) {
        $output = new SSEOutput($writer, $throttle);

        parent::__construct(function () use ($error, $output) {
            $output->error($error);

            $output->outputBuffer();

            $output->event(
                sprintf(
                    'Memory Usage: %s',
                    MemoryHelper::currentAndPeak()
                ),
                'memory'
            );

            $output->event(1, 'code');
            $output->event(1, 'close');
        });
    }
}
