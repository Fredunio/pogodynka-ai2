<?php

namespace App\Command;

use App\Repository\LocationRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'location:country-city',
    description: 'Add a short description for your command',
)]
class LocationCountryCityCommand extends Command
{
    private LocationRepository $locationRepository;
    public function __construct(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('countryCode', InputArgument::REQUIRED, 'Country Code')
            ->addArgument('cityName', InputArgument::REQUIRED, 'City Name')
//            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    /**
     * @throws NonUniqueResultException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $countryCode = $input->getArgument('countryCode');
        $cityName = $input->getArgument('cityName');

        $location = $this->locationRepository->findByCountryAndCity($countryCode, $cityName);

        $io->success('Location details for ' . $location->getCity() . ':');
        $io->text('Country: ' . $location->getCountry());
        $io->text('City: ' . $location->getCity());
        $io->text('Latitude: ' . $location->getLatitude());
        $io->text('Longitude: ' . $location->getLongitude());



        return Command::SUCCESS;
    }
}
