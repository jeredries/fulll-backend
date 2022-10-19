<?php

namespace App\Shared\Domain\Bus\Command;

/**
 * interface CommandBusInterface
 */
interface CommandBusInterface
{
    /**
     * @param CommandInterface $command
     *
     * @return void
     */
    public function dispatch(CommandInterface $command) : void;
}
