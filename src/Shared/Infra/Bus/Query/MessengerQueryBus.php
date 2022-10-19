<?php

namespace App\Shared\Infra\Bus\Query;

use App\Shared\Domain\Bus\Query\QueryInterface;
use App\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class InMemoryQueryBus
 */
final class MessengerQueryBus implements QueryBusInterface
{
    use HandleTrait;

    /**
     * @param MessageBusInterface $queryBus
     */
    public function __construct(private readonly MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    /**
     * @param QueryInterface $query
     *
     * @return mixed
     */
    public function ask(QueryInterface $query): mixed
    {
        return $this->handle($query);
    }
}
