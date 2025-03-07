<?php

namespace Dimsymfony\Controller\Admin;

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Response;
use Dimsymfony\Entity\CustomerItinerary; // Import the entity
use Doctrine\ORM\EntityManagerInterface;

class OtherPageController extends FrameworkBundleAdminController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    public function indexAction(): Response
    {
        // Fetch all customer itinerary data
        $repository = $this->entityManager->getRepository(CustomerItinerary::class);
        $customerData = $repository->findAll();

        return $this->render('@Modules/dimsymfony/views/templates/admin/other_page.html.twig', [
            'customerData' => $customerData,
        ]);
    }
}
