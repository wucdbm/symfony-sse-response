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

use Wucdbm\SymfonySseResponse\SSEEvent;

abstract class SSEWriter
{
    final public function write(SSEEvent $event): void
    {
        $this->doWrite(sprintf(
            "%s\n\n",
            $event->toString()
        ));
    }

    abstract protected function doWrite(string $event): void;
}
