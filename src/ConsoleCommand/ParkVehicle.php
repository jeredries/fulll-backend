<?php

namespace App\ConsoleCommand;

use App\Shared\Domain\Bus\Command\CommandBusInterface;
use App\VehicleFleet\App\Command\ParkVehicle\ParkVehicleCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class ParkVehicle
 */
class ParkVehicle extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'park-vehicle';

    /**
     * @param CommandBusInterface $commandBus
     */
    public function __construct(private readonly CommandBusInterface $commandBus)
    {
        parent::__construct();
    }

    /**
     * Configures the current command.
     */
    protected function configure(): void
    {
        $this->setDescription('Park a vehicle')
            ->setHelp('This command park a vehicle into a fleet')
            ->addArgument(
                'fleetId',
                InputArgument::REQUIRED,
                'id fleet'
            )->addArgument(
                'vehiclePlateNumber',
                InputArgument::REQUIRED,
                'vehicle plate number'
            )->addArgument(
                'lat',
                InputArgument::REQUIRED,
                'location latitude'
            )->addArgument(
                'lng',
                InputArgument::REQUIRED,
                'location longitude'
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
        $io->title('Park a vehicle');

        $fleetId = (int) $input->getArgument('fleetId');
        $vehiclePlateNumber = $input->getArgument('vehiclePlateNumber');
        $lat = $input->getArgument('lat');
        $lng = $input->getArgument('lng');

        $io->text(
            sprintf('Park vehicle %s into a fleet %d at lat %s lng %s', $vehiclePlateNumber, $fleetId, $lat, $lng)
        );
        $io->newLine();

        $this->commandBus->dispatch(new ParkVehicleCommand($fleetId, $vehiclePlateNumber, $lat, $lng));

        $io->success('Successfully park a vehicle');

        return Command::SUCCESS;
    }
}
