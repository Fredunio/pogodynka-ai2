<?php

namespace App\Controller;

use App\Entity\Location;
use App\Service\WeatherUtil;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    /**
     */
    #[Route('/weather/{country}/{cityName}' , name: 'app_weather', requirements: ['cityName' => '[a-zA-Z]+'])]
    public function city(
        #[MapEntity(mapping: ['country' => 'country', 'cityName' => 'city'])]
        Location $location,
        WeatherUtil $util,
    ): Response
    {


        $measurements = $util->getWeatherForLocation($location);

        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'measurements' => $measurements,
            'controller_name' => 'WeatherController',
        ]);
    }
}
