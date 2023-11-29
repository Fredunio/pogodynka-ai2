<?php

namespace App\Controller;

use App\Entity\Measurement;
use App\Service\WeatherUtil;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;

class WeatherApiController extends AbstractController
{
    /**
     * @throws NonUniqueResultException
     */
    #[Route('/api/weather', name: 'app_weather_api',methods: ['GET'])]
    public function index(
        #[MapQueryParameter('city')] string $city,
        #[MapQueryParameter('country')] string $country,
        WeatherUtil $util,
        #[MapQueryParameter('format', null)] string $format = 'json',
        #[MapQueryParameter('twig')] bool $twig = false,

    ): Response
    {
        $measurements = $util->getWeatherForCountryAndCity($country, $city);

        if ($twig)
        {
            if ($format === 'csv')

                {
                    return $this->render('weather_api/index.csv.twig', [
                        'city' => $city,
                        'country' => $country,
                        'measurements' => $measurements,
                    ]);
                }

                return $this->render('weather_api/index.json.twig', [
                    'city' => $city,
                    'country' => $country,
                    'measurements' => $measurements,
                ]);
        }


        if ($format === 'csv')
        {
            $csv = "city,country,date,temperature\n";
            $csv .= implode(
                "\n",
                array_map(fn(Measurement $m) => sprintf(
                    '%s,%s,%s,%s,%s',
                    $city,
                    $country,
                    $m->getDate()->format('Y-m-d'),
                    $m->getTemperature(),
                    $m->getFahrenheit()
                ), $measurements)
            );

            return new Response($csv, 200);

        }

        return $this->json([
            'city' => $city,
            'country' => $country,
            'measurements' => array_map(fn(Measurement $m) => [
                'date' => $m->getDate()->format('Y-m-d'),
                'temperature' => $m->getTemperature(),
                'fahrehneit' => $m->getFahrenheit(),
            ], $measurements),
            'format' => $format
        ]);
    }
}
