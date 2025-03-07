<?php

namespace Dimsymfony\Controller\Admin;

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Response;
use Dimsymfony\Entity\CustomerItinerary;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/customer-list")
 */
class CustomerListController extends FrameworkBundleAdminController
{
     private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/", name="dimsymfony_customer_list", methods={"GET"})
     */
    public function indexAction(): Response
    {
        $repository = $this->entityManager->getRepository(CustomerItinerary::class);
        $customerData = $repository->findAll();

        return $this->render('@Modules/dimsymfony/views/templates/admin/customer_list.html.twig', [
            'customerData' => $customerData,
        ]);
    }
}
