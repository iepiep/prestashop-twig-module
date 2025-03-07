<?php

namespace Dimsymfony\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Dimsymfony\Entity\CustomerItinerary;
use Configuration;
use Exception;

class ItineraryService
{
    private $entityManager;
    private $httpClient;
    private $durationMatrix = [];
    private $optimizedRouteIndices = [];

    public function __construct(EntityManagerInterface $entityManager, HttpClientInterface $httpClient)
    {
        $this->entityManager = $entityManager;
        $this->httpClient = $httpClient;
    }

   public function calculateItinerary(array $selectedIds, string $googleApiKey): array
    {
        $baseLocation = Configuration::get('DIMSYMFONY_BASE_LOCATION', null, null, null, '25 rue de la Noé Pierre, 53960 Bonchamp-lès-Laval, France');

        // Récupération des données des clients
        $repository = $this->entityManager->getRepository(CustomerItinerary::class);
        $clients = [];
        foreach ($selectedIds as $id) {
            $customerItinerary = $repository->find($id);
            if ($customerItinerary) {
                $clients[] = [
                    'id' => $customerItinerary->getId(),
                    'firstname' => $customerItinerary->getCustomerName(), // Adaptation: utiliser les getters
                    'lastname' => $customerItinerary->getCustomerName(),  // et les noms corrects
                    'full_address' => $customerItinerary->getDestination(), // Destination comme adresse complète
                ];
            }
        }


        if (empty($clients)) {
            return [];
        }

        // Tableau des localisations (le premier élément est le point de départ)
        $locations = [];
        $locations[] = $baseLocation;
        foreach ($clients as $client) {
            $locations[] = $client['full_address'];
        }

        // Appel à l'API Google Distance Matrix
        $origins = implode('|', array_map('urlencode', $locations));
        $destinations = $origins;
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=$origins&destinations=$destinations&key=$googleApiKey";

        try {
            $response = $this->httpClient->request('GET', $url);
            $statusCode = $response->getStatusCode();

            if ($statusCode !== 200) {
                throw new Exception('Error retrieving distances. Status code: ' . $statusCode);
            }

            $data = $response->toArray();

            if (!isset($data['status']) || $data['status'] !== 'OK') {
                throw new Exception('Problem with Google API: ' . ($data['status'] ?? 'Empty response'));
            }
        } catch (Exception $e) {
             throw new Exception('An error occurred during API call: ' . $e->getMessage());
        }

        // Extraction de la matrice des distances et des durées
        $distanceMatrix = [];
        $durationMatrix = [];

        foreach ($data['rows'] as $i => $row) {
            foreach ($row['elements'] as $j => $element) {
                $distanceMatrix[$i][$j] = (isset($element['distance']) && $element['status'] === 'OK') ? $element['distance']['value'] : PHP_INT_MAX;
                $durationMatrix[$i][$j] = (isset($element['duration']) && $element['status'] === 'OK') ? $element['duration']['value'] : PHP_INT_MAX;
            }
        }

        // Stocker la matrice des durées
        $this->durationMatrix = $durationMatrix;

        // Calcul du chemin optimisé (basé sur la distance)
        $optimizedRouteIndices = $this->solveTSP($distanceMatrix);
        $this->optimizedRouteIndices = $optimizedRouteIndices;


        // Construction du tableau ordonné des arrêts
        $orderedRoute = [];
        foreach ($optimizedRouteIndices as $index) {
            if ($index == 0) {
                $orderedRoute[] = [
                    'is_base' => true,
                    'full_address' => $baseLocation,
                ];
            } else {
                $client = $clients[$index - 1];
                $client['is_base'] = false;
                $orderedRoute[] = $client;
            }
        }

        // Calcul de la planification horaire
        $itinerarySchedule = $this->scheduleItinerary($orderedRoute);

        return [
            'optimized_route' => $orderedRoute,
            'itinerary_schedule' => $itinerarySchedule,
            'start_address' => $baseLocation,
            'google_maps_api_key' => $googleApiKey,
        ];
    }

    // Algorithme TSP plus proche voisin
    private function solveTSP(array $distanceMatrix): array
    {
        $numLocations = count($distanceMatrix);
        $unvisited = range(1, $numLocations - 1); // Exclut le point de départ
        $route = [0]; // Commence à la base
        $current = 0;

        while (!empty($unvisited)) {
            $nearest = null;
            $minDistance = PHP_INT_MAX;

            foreach ($unvisited as $i) {
                if ($distanceMatrix[$current][$i] < $minDistance) {
                    $minDistance = $distanceMatrix[$current][$i];
                    $nearest = $i;
                }
            }

            $route[] = $nearest;
            $current = $nearest;
            $unvisited = array_values(array_diff($unvisited, [$nearest]));
        }

        $route[] = 0; // Retour à la base

        return $this->optimizeRoute2Opt($route, $distanceMatrix);

    }

     // optimisation 2‑opt
    private function optimizeRoute2Opt(array $route, array $distanceMatrix): array
    {
        $improved = true;
        $numLocations = count($route);

        while ($improved) {
            $improved = false;

            for ($i = 1; $i < $numLocations - 2; ++$i) {
                for ($j = $i + 1; $j < $numLocations - 1; ++$j) {
                    $newRoute = $this->swapTwoOpt($route, $i, $j);

                    if ($this->calculateTotalDistance($newRoute, $distanceMatrix) < $this->calculateTotalDistance($route, $distanceMatrix)) {
                        $route = $newRoute;
                        $improved = true;
                    }
                }
            }
        }

        return $route;
    }

    private function swapTwoOpt(array $route, int $i, int $j): array
    {
        return array_merge(
            array_slice($route, 0, $i),
            array_reverse(array_slice($route, $i, $j - $i + 1)),
            array_slice($route, $j + 1)
        );
    }
    private function calculateTotalDistance(array $route, array $distanceMatrix): int
    {
        $totalDistance = 0;

        for ($i = 0; $i < count($route) - 1; ++$i) {
            $totalDistance += $distanceMatrix[$route[$i]][$route[$i + 1]];
        }

        return $totalDistance;
    }

    private function scheduleItinerary(array $orderedRoute): array
    {
        // Récupérer les indices optimisés calculés précédemment
        $routeIndices = $this->optimizedRouteIndices;
        $currentTime = new \DateTime('08:30');
        $lunchTaken = false;
        $schedule = [];
        $numLegs = count($routeIndices);

        // On planifie pour chaque RDV (les indices 1 à numLegs-2 correspondent aux RDVs)
        for ($i = 1; $i < $numLegs - 1; ++$i) {
            // Temps de déplacement
            $prevIndex = $routeIndices[$i - 1];
            $currIndex = $routeIndices[$i];

            $travelSeconds = $this->durationMatrix[$prevIndex][$currIndex] ?? 0;
            $currentTime->modify("+$travelSeconds seconds");

            // Pause déjeuner
            if (!$lunchTaken && $currentTime->format('H') >= 12) {
                $currentTime->modify('+1 hour');
                $lunchTaken = true;
            }

            $appointmentTime = clone $currentTime;
            $stop = $orderedRoute[$i];  // Utiliser le tableau ordonné

            $schedule[] = [
                'time' => $appointmentTime->format('H:i'),
                'lastname' => $stop['lastname'],
                'firstname' => $stop['firstname'],
                'address' => $stop['full_address'],
            ];

            $currentTime->modify('+2 hours'); // Durée de l'intervention
        }
        return $schedule;
    }
}
