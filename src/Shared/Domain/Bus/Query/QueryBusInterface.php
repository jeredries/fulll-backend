<?php

namespace App\Shared\Domain\Bus\Query;

/**
 * interface QueryBusInterface
 */
interface QueryBusInterface
{
    /**
     * @param QueryInterface $query
     *
     * @return mixed
     */
    public function ask(QueryInterface $query): mixed;
}
