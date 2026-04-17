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

readonly class SSEEvent
{
    public function __construct(
        // The data field for the message. When the EventSource receives multiple consecutive lines that begin with data:, it will concatenate them, inserting a newline character between each one. Trailing newlines are removed.
        private mixed $data,
        // A string identifying the type of event described. If this is specified, an event will be dispatched on the browser to the listener for the specified event name; the website source code should use addEventListener() to listen for named events. The onmessage handler is called if no event name is specified for a message.
        private ?string $event,
        // the event ID to set the EventSource object's last event ID value
        private ?int $id = null,
        // This is just a comment, since it starts with a colon character. As mentioned previously, this can be useful as a keep-alive if messages may not be sent regularly.
        private ?string $comment = null,
        // The reconnection time to use when attempting to send the event. This must be an integer, specifying the reconnection time in milliseconds. If a non-integer value is specified, the field is ignored.
        private ?int $retry = null,
    ) {
    }

    public function toString(): string
    {
        $event = [];

        if ($this->comment) {
            $event[] = sprintf(': %s', $this->comment);
        }

        if ($this->id) {
            $event[] = sprintf('id: %s', $this->id);
        }

        if ($this->retry > 0) {
            $event[] = sprintf('retry: %s', $this->retry);
        }

        if ($this->event) {
            $event[] = sprintf('event: %s', $this->event);
        }

        if (null !== $this->data) {
            $event[] = sprintf('data: %s', json_encode($this->data, JSON_THROW_ON_ERROR));
        }

        return implode("\n", $event);
    }
}
