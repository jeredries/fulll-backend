<?php

namespace App\ConsoleCommand;

use App\Shared\Domain\Bus\Command\CommandBusInterface;
use App\Shared\Domain\Bus\Query\QueryBusInterface;
use App\VehicleFleet\App\Command\CreateFleet\CreateFleetCommand;
use App\VehicleFleet\App\Query\FindFleet\FindFleetQuery;
use App\VehicleFleet\Domain\Entity\Fleet;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class Create
 */
class Create extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'create';

    /**
     * @param CommandBusInterface $commandBus
     * @param QueryBusInterface   $queryBus
     */
    public function __construct(private readonly CommandBusInterface $commandBus, private readonly QueryBusInterface $queryBus)
    {
        parent::__construct();
    }

    /**
     * Configures the current command.
     */
    protected function configure(): void
    {
        $this->setDescription('Create fleet')
            ->setHelp('This command create vehicle fleet')
            ->addArgument(
                'userId',
                InputArgument::REQUIRED,
                'id user'
            );
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Create vehicle fleet');

        $userId = (int) $input->getArgument('userId');
        $io->text(sprintf('Creation of a vehicle fleet for the user with id: %d', $userId));
        $io->newLine();

        $this->commandBus->dispatch(new CreateFleetCommand($userId));
        /** @var Fleet $fleet */
        $fleet = $this->queryBus->ask(new FindFleetQuery($userId));

        $io->success(sprintf('Vehicle fleet create successfully with id: %d', $fleet->getId()));

        return Command::SUCCESS;
    }
}
