<?php

namespace Dimsymfony\Controller\Admin;

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Dimsymfony\Entity\CustomerItinerary;
use Doctrine\ORM\EntityManagerInterface;
use Configuration;
use Symfony\Component\Routing\Annotation\Route;
use Dimsymfony\Service\ItineraryService; // Import du service
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/itinerary")
 */
class ItineraryController extends FrameworkBundleAdminController
{
    private $entityManager;
    private $itineraryService;

    public function __construct(EntityManagerInterface $entityManager, ItineraryService $itineraryService)
    {
        $this->entityManager = $entityManager;
        $this->itineraryService = $itineraryService; // Injection du service
    }
    /**
     * @Route("/{id}", name="dimsymfony_itinerary_view", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function viewAction(Request $request, int $id): Response
    {
      //Ancienne version, on veut itineraire pour plusieur clients.
        /*$repository = $this->entityManager->getRepository(CustomerItinerary::class);
        $customerItinerary = $repository->find($id);

        if (!$customerItinerary) {
            throw $this->createNotFoundException('Customer itinerary not found.');
        }*/

        // Récupérer la clé API Google
        $googleApiKey = Configuration::get('DIMSYMFONY_GOOGLE_API_KEY');

        // Vérifier si la clé API est configurée
        if (empty($googleApiKey)) {
          $this->addFlash('error', $this->trans('Google API key is not configured.', 'Modules.Dimsymfony.Admin'));
          return $this->redirectToRoute('dimsymfony_customer_list');
        }

        // Utilisation du service pour générer l'itinéraire
        try {
            // Récupérer les IDs des clients sélectionnés (depuis la requête, par exemple)
            // Pour l'instant, on simule avec un seul ID.  Il faudra adapter pour une liste.
            $selectedIds = [$id];  // <-- A MODIFIER pour prendre en compte une liste
            $itineraryData = $this->itineraryService->calculateItinerary($selectedIds, $googleApiKey);
          if (empty($itineraryData)) {
                // Gérer le cas où aucun itinéraire n'a pu être calculé (par exemple, aucun client sélectionné).
                $this->addFlash('warning', $this->trans('No itinerary could be generated.', 'Modules.Dimsymfony.Admin'));
                return $this->redirectToRoute('dimsymfony_customer_list'); // Rediriger vers la liste
            }
        } catch (\Exception $e) {
            // Gérer les exceptions (par exemple, problème avec l'API Google)
            $this->addFlash('error', $this->trans('Error generating itinerary: %error%', ['%error%' => $e->getMessage()], 'Modules.Dimsymfony.Admin'));
             // Rediriger vers la liste des clients.
            return $this->redirectToRoute('dimsymfony_customer_list');
        }

        return $this->render('@Modules/dimsymfony/views/templates/admin/itinerary.html.twig', [
            //'customerItinerary' => $customerItinerary, // Plus nécessaire, car on a $itineraryData
            'itineraryData' => $itineraryData, // Passer les données complètes
        ]);
    }
    /**
     * @Route("/", name="dimsymfony_itinerary", methods={"POST"})
     */
    public function generateItineraryAction(Request $request): Response
    {
        $selectedIds = $request->request->get('selected_customers');

        // Validation des IDs
        if (empty($selectedIds) || !is_array($selectedIds)) {
            return new JsonResponse(['error' => $this->trans('No customers selected.', [], 'Modules.Dimsymfony.Admin')], 400);
        }

        // Filtrer et convertir en entiers
        $selectedIds = array_filter(array_map('intval', $selectedIds), function($id) { return $id > 0; });

        if (empty($selectedIds)) {
          return new JsonResponse(['error' => $this->trans('Invalid customer IDs.', [], 'Modules.Dimsymfony.Admin')], 400);
        }

        $googleApiKey = Configuration::get('DIMSYMFONY_GOOGLE_API_KEY');
        if (empty($googleApiKey)) {
          return new JsonResponse(['error' => $this->trans('Google API key is not configured.', [], 'Modules.Dimsymfony.Admin')], 500); // 500 car c'est une erreur serveur
        }

        try {
          $itineraryData = $this->itineraryService->calculateItinerary($selectedIds, $googleApiKey);

          if (empty($itineraryData)) {
            return new JsonResponse(['error' => $this->trans('No itinerary could be generated.', [], 'Modules.Dimsymfony.Admin')], 404); // 404 Not Found
          }

          // Retourner une réponse JSON (pour AJAX)
          return new JsonResponse($itineraryData);

        } catch (\Exception $e) {
          return new JsonResponse(['error' => $this->trans('Error generating itinerary: %error%', ['%error%' => $e->getMessage()], 'Modules.Dimsymfony.Admin')], 500);
        }
    }
}
