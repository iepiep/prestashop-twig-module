<?php

namespace Dimsymfony\Controller\Admin;

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Dimsymfony\Entity\CustomerItinerary;
use Doctrine\ORM\EntityManagerInterface;
use Configuration;
use Symfony\Component\Routing\Annotation\Route; // Import pour les annotations (facultatif)
use Symfony\Contracts\HttpClient\HttpClientInterface; // Pour faire des requêtes HTTP (à l'API Google)

/**
 * @Route("/itinerary") // Préfixe de route (facultatif)
 */
class ItineraryController extends FrameworkBundleAdminController
{
    private $entityManager;
    private $httpClient;


    public function __construct(EntityManagerInterface $entityManager, HttpClientInterface $httpClient)
    {
        $this->entityManager = $entityManager;
        $this->httpClient = $httpClient; // Injection du client HTTP
    }
    /**
     * @Route("/{id}", name="dimsymfony_itinerary", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function viewAction(Request $request, int $id): Response
    {
        $repository = $this->entityManager->getRepository(CustomerItinerary::class);
        $customerItinerary = $repository->find($id);

        if (!$customerItinerary) {
            throw $this->createNotFoundException('Customer itinerary not found.');
        }

        // Récupérer la clé API Google
        $googleApiKey = Configuration::get('DIMSYMFONY_GOOGLE_API_KEY');

        // Vérifier si la clé API est configurée
        if (empty($googleApiKey)) {
            $this->addFlash('error', $this->trans('Google API key is not configured.', 'Modules.Dimsymfony.Admin'));
            // Rediriger vers la liste des clients.  Mieux que de planter.
            return $this->redirectToRoute('dimsymfony_customer_list');
        }

        // Appel à l'API Google (exemple simplifié - à adapter à votre logique)
        $itineraryDetails = $this->generateItinerary(
          $customerItinerary->getCustomerName(),
          $customerItinerary->getDestination(),
          $customerItinerary->getTravelDate(),
          $googleApiKey
      );
        // Enregistrer les détails dans l'entité (si pas déjà fait)
        $customerItinerary->setItineraryDetails($itineraryDetails);
        $this->entityManager->flush(); // Enregistrer les modifications

        return $this->render('@Modules/dimsymfony/views/templates/admin/itinerary.html.twig', [
            'customerItinerary' => $customerItinerary,
            'itinerary' => $itineraryDetails, // Passer l'itinéraire généré à la vue
        ]);
    }

    private function generateItinerary(string $customerName, string $destination, \DateTimeInterface $travelDate, string $apiKey): string
    {
      //Exemple d'appel API SANS gestion d'erreur (à améliorer)
        $apiUrl = "https://maps.googleapis.com/maps/api/place/textsearch/json?query={$destination}&key={$apiKey}";

        try {
            $response = $this->httpClient->request('GET', $apiUrl);
            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                $content = $response->toArray(); // Convertit la réponse JSON en tableau PHP
                // Traitez $content pour extraire les informations pertinentes et construire l'itinéraire.
                // C'est ici que vous mettriez votre logique spécifique de traitement de la réponse de l'API Google.
                // ... (votre logique de traitement) ...
                $itinerary = "Itinerary for {$customerName} to {$destination} on " . $travelDate->format('Y-m-d') . ":\n";
                $itinerary .="Details from google API: " . json_encode($content); // Juste un exemple.  A remplacer!
                return $itinerary;


            } else {
                // Gérer les erreurs de l'API (par exemple, clé API invalide, quota dépassé, etc.)
                return "Error generating itinerary. Status code: " . $statusCode;
            }
        } catch (\Exception $e) {
            // Gérer les exceptions (par exemple, problème de réseau)
            return "Error generating itinerary: " . $e->getMessage();
        }
    }
}
