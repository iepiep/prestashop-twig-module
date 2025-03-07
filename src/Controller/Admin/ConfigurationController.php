<?php

namespace Dimsymfony\Controller\Admin; // Corrected Namespace

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Dimsymfony\Entity\CustomerItinerary; // Import the entity
use Doctrine\ORM\EntityManagerInterface;


class ConfigurationController extends FrameworkBundleAdminController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }
    public function indexAction(Request $request): Response
    {
        $form = $this->createCustomerForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            // Create a new entity instance
            $customerItinerary = new CustomerItinerary();
            $customerItinerary->setCustomerName($data['customer_name']);
            $customerItinerary->setDestination($data['destination']);
            $customerItinerary->setTravelDate($data['travel_date']);

            // Persist the entity to the database
            $this->entityManager->persist($customerItinerary);
            $this->entityManager->flush();

            $this->addFlash('success', $this->trans('Customer data saved!', 'Modules.Dimsymfony.Admin'));
             // Redirect to the same page to clear the form.
            return $this->redirectToRoute('dimsymfony_configuration');
        }

        return $this->render('@Modules/dimsymfony/views/templates/admin/configuration.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function createCustomerForm()
    {
        $formBuilder = $this->createFormBuilder();
        $formBuilder
            ->add('customer_name', TextType::class, [
                'label' => $this->trans('Customer Name', 'Modules.Dimsymfony.Admin'),
                'required' => true,
            ])
            ->add('destination', TextType::class, [
                'label' => $this->trans('Destination', 'Modules.Dimsymfony.Admin'),
                'required' => true,
            ])
            ->add('travel_date', DateType::class, [
                'label' => $this->trans('Travel Date', 'Modules.Dimsymfony.Admin'),
                'widget' => 'single_text', // Use a single text input for the date
                'required' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => $this->trans('Save', 'Admin.Actions'),
            ]);


        return $formBuilder->getForm();
    }
}
