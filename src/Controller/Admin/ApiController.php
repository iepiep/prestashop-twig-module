<?php

namespace Dimsymfony\Controller\Admin;

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Dimsymfony\Entity\CustomerItinerary; // Import the entity
use Doctrine\ORM\EntityManagerInterface;

class ApiController extends FrameworkBundleAdminController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }
    public function indexAction(Request $request): JsonResponse
    {
        $id = $request->request->get('id');

        if (!$id) {
            return new JsonResponse(['error' => 'Missing customer ID.'], 400); // Bad Request
        }

        $repository = $this->entityManager->getRepository(CustomerItinerary::class);
        $customerItinerary = $repository->find($id);

        if (!$customerItinerary) {
            return new JsonResponse(['error' => 'Customer not found.'], 404); // Not Found
        }
        // Itinerary generation logic (replace with your actual logic)
        $itinerary = $this->generateItinerary(
            $customerItinerary->getCustomerName(),
            $customerItinerary->getDestination(),
            $customerItinerary->getTravelDate()
        );
        // Persist the entity to the database
        $customerItinerary->setItineraryDetails($itinerary);
        $this->entityManager->flush();
        return new JsonResponse(['itinerary' => $itinerary]);
    }

    private function generateItinerary($customerName, $destination, $travelDate)
    {
        //  Implement your itinerary generation logic here.
        //  This is just a placeholder example.
        $itinerary = "Itinerary for {$customerName} to {$destination} on " . $travelDate->format('Y-m-d') . ":\n";
        $itinerary .= "- Day 1: Arrive in {$destination}.\n";
        $itinerary .= "- Day 2: Explore the city.\n";
        $itinerary .= "- Day 3: Depart from {$destination}.\n";

        return $itinerary;
    }
}
