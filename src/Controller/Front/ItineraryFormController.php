<?php

namespace Dimsymfony\Controller\Front;

use PrestaShopBundle\Controller\FrontController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType; // Utilisation de DateTimeType
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Dimsymfony\Entity\Rdv; // Utilisation de la nouvelle entité Rdv
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use DateTime;

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

            $rdv = new Rdv();
            $rdv->setLastName($data['lastname']);
            $rdv->setFirstName($data['firstname']);
            $rdv->setAddress($data['address']);
            $rdv->setPostalCode($data['postal_code']);
            $rdv->setCity($data['city']);
            $rdv->setPhone($data['phone']);
            $rdv->setEmail($data['email']);
            $rdv->setDateCreneau1($data['date_creneau1']);
            $rdv->setDateCreneau2($data['date_creneau2']);
            $rdv->setVisited(false); // Initialisation de 'visited' à false
            $rdv->setCreatedAt(new DateTime());

            $this->entityManager->persist($rdv);
            $this->entityManager->flush();

            $this->addFlash('success', $this->trans('Your appointment request has been submitted!', [], 'Modules.Dimsymfony.Front'));
            return $this->redirectToRoute('home');
        }

        return $this->render('@Modules/dimsymfony/views/templates/front/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    private function createCustomerForm()
    {
        $formBuilder = $this->createFormBuilder();
        $formBuilder
            ->add('lastname', TextType::class, [
                'label' => $this->trans('Last Name', 'Modules.Dimsymfony.Front'),
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => $this->trans('Please enter your last name.', [], 'Modules.Dimsymfony.Front')]),
                ],
            ])
            ->add('firstname', TextType::class, [
                'label' => $this->trans('First Name', 'Modules.Dimsymfony.Front'),
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => $this->trans('Please enter your first name.', [], 'Modules.Dimsymfony.Front')]),
                ],
            ])
            ->add('address', TextType::class, [
                'label' => $this->trans('Address', 'Modules.Dimsymfony.Front'),
                'required' => true,
                 'constraints' => [
                    new NotBlank(['message' => $this->trans('Please enter your address.', [], 'Modules.Dimsymfony.Front')]),
                ],
            ])
            ->add('postal_code', TextType::class, [
                'label' => $this->trans('Postal Code', 'Modules.Dimsymfony.Front'),
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => $this->trans('Please enter your postal code.', [], 'Modules.Dimsymfony.Front')]),
                    new Regex([
                        'pattern' => '/^\d{5}$/',
                        'message' => $this->trans('Please enter a valid 5-digit postal code.', [], 'Modules.Dimsymfony.Front'),
                    ]),
                ],
            ])
            ->add('city', TextType::class, [
                'label' => $this->trans('City', 'Modules.Dimsymfony.Front'),
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => $this->trans('Please enter your city.', [], 'Modules.Dimsymfony.Front')]),
                ],
            ])
            ->add('phone', TextType::class, [
                'label' => $this->trans('Phone', 'Modules.Dimsymfony.Front'),
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => $this->trans('Please enter your phone number.', [], 'Modules.Dimsymfony.Front')]),
                    new Regex([
                        'pattern' => '/^(?:(?:\+|00)33[\s.-]{0,3}(?:\(0\)[\s.-]{0,3})?|0)[1-9](?:(?:[\s.-]?\d{2}){4}|\d{2}(?:[\s.-]?\d{3}){2})$/',
                        'message' => $this->trans('Please enter a valid phone number.', [], 'Modules.Dimsymfony.Front'),
                    ]),
                ],

            ])
            ->add('email', TextType::class, [
                'label' => $this->trans('Email', 'Modules.Dimsymfony.Front'),
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => $this->trans('Please enter your email address.', [], 'Modules.Dimsymfony.Front')]),
                    new Email(['message' => $this->trans('Please enter a valid email address.', [], 'Modules.Dimsymfony.Front')]),
                ],
            ])
            ->add('date_creneau1', TextType::class, [ // Utilisation de TextType
                'label' => $this->trans('Preferred Date/Time 1', 'Modules.Dimsymfony.Front'),
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => $this->trans('Please enter your first preferred date and time.', [], 'Modules.Dimsymfony.Front')]),
                ],
                'attr' => [
                    'placeholder' => $this->trans('YYYY-MM-DD HH:MM', [], 'Modules.Dimsymfony.Front') // Placeholder for guidance
                ]
            ])
            ->add('date_creneau2', TextType::class, [  // Utilisation de TextType
                'label' => $this->trans('Preferred Date/Time 2', 'Modules.Dimsymfony.Front'),
                'required' => false, // Le deuxième créneau est facultatif
                'attr' => [
                    'placeholder' => $this->trans('YYYY-MM-DD HH:MM', [], 'Modules.Dimsymfony.Front')
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => $this->trans('Submit', 'Modules.Dimsymfony.Front'),
            ]);

        return $formBuilder->getForm();
    }
}
