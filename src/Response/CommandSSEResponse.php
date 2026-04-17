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

use Wucdbm\SymfonySseResponse\SSEOutput;
use Wucdbm\SymfonySseResponse\Writer\PhpOutSSEWriter;
use Wucdbm\SymfonySseResponse\Writer\SSEWriter;

class CommandSSEResponse extends SSEResponse
{
    /**
     * @param callable(SSEOutput): int $callback
     */
    public function __construct(
        callable $callback,
        SSEWriter $writer = new PhpOutSSEWriter(),
        ?int $throttle = 1_000,
    ) {
        $output = new SSEOutput($writer, $throttle);

        parent::__construct(function () use ($callback, $output) {
            try {
                $output->event('GOOD MORNING, VIETNAM', 'connected');

                $output->outputBuffer();

                $returnCode = $callback($output);

                $output->outputBuffer();

                $output->event($returnCode, 'code');
                $output->event($returnCode, 'close');
            } catch (\Throwable $e) {
                $output->error($e);
            }
        });
    }
}
