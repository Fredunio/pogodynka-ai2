<?php
//declare(strict types=1);
namespace App\Service;


use App\Entity\Location;
use App\Entity\Measurement;
use App\Repository\LocationRepository;
use App\Repository\MeasurementRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bridge\Doctrine\ManagerRegistry;

class WeatherUtil
{
    private LocationRepository $locationRepository;
    private MeasurementRepository $measurementRepository;
 public function __construct(LocationRepository $locationRepository, MeasurementRepository $measurementRepository)
    {
        $this->locationRepository = $locationRepository;
        $this->measurementRepository = $measurementRepository;
    }

    /**
     * @return Measurement[]
     */
    public function getWeatherForLocation(Location $location): array
    {

        return $this->measurementRepository->findByLocation($location);
    }

    /**
     * @return Measurement[]
     * @throws NonUniqueResultException
     */
    public function getWeatherForCountryAndCity(string $countryCode, string $city): array
    {
        $location = $this->locationRepository->findByCountryAndCity($countryCode, $city);
        return $this->getWeatherForLocation($location);
    }
}
