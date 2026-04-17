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

use Symfony\Component\HttpFoundation\StreamedResponse;

abstract class SSEResponse extends StreamedResponse
{
    public function __construct(callable $callback)
    {
        parent::__construct($callback);
        $this->headers->set('Content-Type', 'text/event-stream');
        $this->headers->set('Cache-Control', 'no-cache, no-store');
        $this->headers->set('Connection', 'keep-alive');
        // Nginx: unbuffered responses suitable for Comet and HTTP streaming applications
        $this->headers->set('X-Accel-Buffering', 'no');
        // Disable buffering
        ob_implicit_flush();
    }
}
