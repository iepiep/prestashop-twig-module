<?php

namespace Dimsymfony\Controller\Admin;

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Dimsymfony\Entity\Rdv; // Utilisation de la nouvelle entité Rdv
use Doctrine\ORM\EntityManagerInterface;
use Configuration;
use Symfony\Component\Routing\Annotation\Route;
use Dimsymfony\Service\ItineraryService;
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
        $this->itineraryService = $itineraryService;
    }

    /**
     * @Route("/", name="dimsymfony_itinerary", methods={"POST"})
     */
    public function generateItineraryAction(Request $request): Response
    {
        $selectedIds = $request->request->get('selected_customers');

        if (empty($selectedIds) || !is_array($selectedIds)) {
            return new JsonResponse(['error' => $this->trans('No customers selected.', [], 'Modules.Dimsymfony.Admin')], 400);
        }

        $selectedIds = array_filter(array_map('intval', $selectedIds), function($id) { return $id > 0; });

        if (empty($selectedIds)) {
          return new JsonResponse(['error' => $this->trans('Invalid customer IDs.', [], 'Modules.Dimsymfony.Admin')], 400);
        }

        $googleApiKey = Configuration::get('DIMSYMFONY_GOOGLE_API_KEY');
        if (empty($googleApiKey)) {
          return new JsonResponse(['error' => $this->trans('Google API key is not configured.', [], 'Modules.Dimsymfony.Admin')], 500);
        }

        try {
          $itineraryData = $this->itineraryService->calculateItinerary($selectedIds, $googleApiKey);

          if (empty($itineraryData)) {
            return new JsonResponse(['error' => $this->trans('No itinerary could be generated.', [], 'Modules.Dimsymfony.Admin')], 404);
          }

          return new JsonResponse($itineraryData);

        } catch (\Exception $e) {
          return new JsonResponse(['error' => $this->trans('Error generating itinerary: %error%', ['%error%' => $e->getMessage()], 'Modules.Dimsymfony.Admin')], 500);
        }
    }
}
