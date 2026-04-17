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

use Symfony\Component\Console\Output\BufferedOutput;
use Wucdbm\SymfonySseResponse\Helper\MemoryHelper;
use Wucdbm\SymfonySseResponse\Writer\SSEWriter;

class SSEOutput extends BufferedOutput
{
    private SSEEventFactory $eventFactory;
    private float $lastOutput;

    public function __construct(
        private readonly SSEWriter $writer,
        private readonly ?int $throttle,
    ) {
        parent::__construct(null, false, new SSEOutputFormatter());

        $this->eventFactory = new SSEEventFactory('lines', 1000);
        $this->lastOutput = microtime(true);
    }

    public function outputBuffer(): void
    {
        $lines = $this->fetch();

        $lines = explode("\n", $lines);
        $lastKey = array_key_last($lines);

        if ('' === $lines[$lastKey]) {
            unset($lines[$lastKey]);
        }

        if (empty($lines)) {
            return;
        }

        $this->writer->write(
            $this->eventFactory->create(
                [
                    'lines' => $lines,
                ]
            )
        );

        $this->writer->write(
            $this->eventFactory->create(
                MemoryHelper::currentAndPeak(),
                'memory'
            )
        );
    }

    protected function doWrite(string $message, bool $newline): void
    {
        parent::doWrite($message, $newline);

        $now = microtime(true);
        $diff = ($now - $this->lastOutput) * 1000;

        if (!$this->throttle || $diff > $this->throttle) {
            $this->outputBuffer();
            $this->lastOutput = $now;
        }
    }

    public function event(
        mixed $data,
        ?string $event = null,
        ?string $comment = null,
    ): void {
        $this->outputBuffer();

        $this->writer->write(
            $this->eventFactory->create($data, $event, $comment)
        );
    }

    public function error(
        string|\Throwable $error,
    ): void {
        $this->outputBuffer();

        $this->writer->write(
            $this->eventFactory->create(
                $error instanceof \Throwable ? self::getSimpleTrace($error) : $error,
                'error'
            )
        );
    }

    private function getSimpleTrace(\Throwable $e): string
    {
        $message = sprintf(
            'Caught %s thrown from %s at line %s: %s',
            get_class($e),
            $e->getFile(),
            $e->getLine(),
            $e->getMessage()
        );

        while ($e = $e->getPrevious()) {
            $message = sprintf(
                '%s. Previous: %s',
                $message,
                self::getSimpleTrace($e)
            );
        }

        return $message;
    }
}
