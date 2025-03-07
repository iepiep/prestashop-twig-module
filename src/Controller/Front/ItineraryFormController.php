<?php

namespace Dimsymfony\Controller\Front;

use PrestaShopBundle\Controller\FrontController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Dimsymfony\Entity\CustomerItinerary;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/itinerary-form")
 * Class ItineraryFormController
 */
class ItineraryFormController extends FrontController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();

    }
    /**
     * @Route("/", name="dimsymfony_itinerary_form", methods={"GET", "POST"})
     */
    public function indexAction(Request $request): Response
    {

        $form = $this->createCustomerForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $customerItinerary = new CustomerItinerary();
            $customerItinerary->setCustomerName($data['customer_name']);
            $customerItinerary->setDestination($data['destination']);
            $customerItinerary->setTravelDate($data['travel_date']);

            $this->entityManager->persist($customerItinerary);
            $this->entityManager->flush();

            // Message de confirmation (à afficher dans la vue)
            $this->addFlash('success', $this->trans('Your request has been submitted!', [], 'Modules.Dimsymfony.Front'));

            // Redirection après succès (vers la page d'accueil, par exemple)
            return $this->redirectToRoute('home');
        }

        return $this->render('@Modules/dimsymfony/views/templates/front/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function createCustomerForm()
    {
         // ... (same as createCustomerForm in ConfigurationController) ...
         $formBuilder = $this->createFormBuilder();
        $formBuilder
            ->add('customer_name', TextType::class, [
                'label' => $this->trans('Customer Name', 'Modules.Dimsymfony.Front'),
                'required' => true,
            ])
            ->add('destination', TextType::class, [
                'label' => $this->trans('Destination', 'Modules.Dimsymfony.Front'),
                'required' => true,
            ])
            ->add('travel_date', DateType::class, [
                'label' => $this->trans('Travel Date', 'Modules.Dimsymfony.Front'),
                'widget' => 'single_text', // Use a single text input for the date
                'required' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => $this->trans('Submit', 'Modules.Dimsymfony.Front'),
            ]);


        return $formBuilder->getForm();
    }
}
