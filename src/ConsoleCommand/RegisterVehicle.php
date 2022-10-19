<?php

namespace App\ConsoleCommand;

use App\Shared\Domain\Bus\Command\CommandBusInterface;
use App\Shared\Domain\Bus\Query\QueryBusInterface;
use App\VehicleFleet\App\Command\RegisterVehicle\RegisterVehicleCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class RegistreVehicle
 */
class RegisterVehicle extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'register-vehicle';

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
        $this->setDescription('Create fleet')
            ->setHelp('This command register a vehicle into a fleet')
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
        $io->title('Register a vehicle');

        $fleetId = (int) $input->getArgument('fleetId');
        $vehiclePlateNumber = $input->getArgument('vehiclePlateNumber');

        $io->text(sprintf('Register vehicle %s into a fleet %d', $vehiclePlateNumber, $fleetId));
        $io->newLine();

        $this->commandBus->dispatch(new RegisterVehicleCommand($fleetId, $vehiclePlateNumber));

        $io->success('Vehicle register into fleet successfully');

        return Command::SUCCESS;
    }
}
