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

final class SSEEventFactory
{
    /**
     * @var string A string identifying the type of event described. If this is specified, an event will be dispatched on the browser to the listener for the specified event name; the website source code should use addEventListener() to listen for named events. The onmessage handler is called if no event name is specified for a message.
     */
    private string $defaultEvent;

    /**
     * @var int The reconnection time to use when attempting to send the event. This must be an integer, specifying the reconnection time in milliseconds. If a non-integer value is specified, the field is ignored.
     */
    private int $defaultRetry;

    private int $id = 0;

    /**
     * @param string $defaultEvent {@see self::$defaultEvent}
     * @param int    $defaultRetry {@see self::$defaultRetry}
     */
    public function __construct(string $defaultEvent = '', int $defaultRetry = 5000)
    {
        $this->defaultEvent = $defaultEvent;
        $this->defaultRetry = $defaultRetry;
    }

    public function create(mixed $data, ?string $eventName = null, ?string $comment = null): SSEEvent
    {
        return new SSEEvent(
            $data,
            $eventName ?? $this->defaultEvent,
            ++$this->id,
            $comment,
            $this->defaultRetry,
        );
    }
}
