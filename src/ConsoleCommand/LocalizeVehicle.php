<?php

namespace App\ConsoleCommand;

use App\Shared\Domain\Bus\Command\CommandBusInterface;
use App\Shared\Domain\Bus\Query\QueryBusInterface;
use App\VehicleFleet\App\Command\ParkVehicle\ParkVehicleCommand;
use App\VehicleFleet\App\Query\FindFleet\FindFleetQuery;
use App\VehicleFleet\App\Query\LocalizeVehicle\LocalizeQuery;
use App\VehicleFleet\Domain\Entity\Location;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class LocalizeVehicleCommand
 */
class LocalizeVehicle extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'localize-vehicle';

    /**
     * @param QueryBusInterface $queryBus
     */
    public function __construct(private readonly QueryBusInterface $queryBus)
    {
        parent::__construct();
    }

    /**
     * Configures the current command.
     */
    protected function configure(): void
    {
        $this->setDescription('Localize a vehicle')
            ->setHelp('This command localize a vehicle into a fleet')
            ->addArgument(
                'fleetId',
                InputArgument::REQUIRED,
                'id fleet'
            )->addArgument(
                'vehiclePlateNumber',
                InputArgument::REQUIRED,
                'vehicle plate number'
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
        $io->title('Localize a vehicle');

        $fleetId = (int) $input->getArgument('fleetId');
        $vehiclePlateNumber = $input->getArgument('vehiclePlateNumber');

        $io->text(
            sprintf('Localize vehicle %s into a fleet %d', $vehiclePlateNumber, $fleetId)
        );
        $io->newLine();

        /** @var Location $location */
        $location = $this->queryBus->ask(new LocalizeQuery($fleetId, $vehiclePlateNumber));

        $io->success(
            sprintf(
                'The vehicle %s is parked at lat:%s and lng:%s into the fleet %d',
                $vehiclePlateNumber,
                $location->getLat(),
                $location->getLng(),
                $fleetId,
            )
        );

        return Command::SUCCESS;
    }
}
