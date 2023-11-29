<?php

namespace App\Command;

use App\Repository\LocationRepository;
use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'weather:location',
    description: 'Get weather forecast for a location ID',
)]
class WeatherLocationCommand extends Command
{

    private WeatherUtil $weatherUtil;
    private LocationRepository $locationRepository;

    public function __construct(WeatherUtil $weatherUtil, LocationRepository $locationRepository)
    {
        $this->weatherUtil = $weatherUtil;
        $this->locationRepository = $locationRepository;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('locationId', InputArgument::REQUIRED, 'Provide location ID')
//            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $locationId = $input->getArgument('locationId');

        if ($locationId) {
            $io->note(sprintf('Location ID passed: %s', $locationId));
        }
        $location = $this->locationRepository->find($locationId);

        $weatherForecast = $this->weatherUtil->getWeatherForLocation($location);


        $io->success('Weather Forecast for ' . $location->getCity() . ':');
        foreach ($weatherForecast as $forecast) {
            $io->text('Date: ' . $forecast->getDate()->format('Y-m-d'));
            $io->text('Temperature: ' . $forecast->getTemperature(), '°C');
            $io->newLine();
        }


        return Command::SUCCESS;
    }
}
