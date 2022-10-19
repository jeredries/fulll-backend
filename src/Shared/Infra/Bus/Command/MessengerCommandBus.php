<?php

namespace App\Shared\Infra\Bus\Command;

use App\Shared\Domain\Bus\Command\CommandInterface;
use App\Shared\Domain\Bus\Command\CommandBusInterface;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class MessengerCommandBus
 */
final class MessengerCommandBus implements CommandBusInterface
{
    /**
     * @param MessageBusInterface $commandBus
     */
    public function __construct(private readonly MessageBusInterface $commandBus)
    {
    }

    /**
     * @param CommandInterface $command
     *
     * @return void
     */
    public function dispatch(CommandInterface $command): void
    {
        $this->commandBus->dispatch($command);
    }
}
