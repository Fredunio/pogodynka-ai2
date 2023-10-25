<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\LocationRepository;
use App\Repository\MeasurementRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    /**
     * @throws NonUniqueResultException
     */
    #[Route('/weather/{cityName}', name: 'app_weather', requirements: ['cityName' => '[a-zA-Z]+'])]
    public function city(string $cityName, MeasurementRepository $measurementRepository, LocationRepository $locationRepository): Response
    {

        $location = $locationRepository->findByCityName($cityName);
        $measurements = $measurementRepository->findByLocation($location);

        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'measurements' => $measurements,
            'controller_name' => 'WeatherController',
        ]);
    }
}
