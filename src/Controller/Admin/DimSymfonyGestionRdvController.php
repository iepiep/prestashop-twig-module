<?php
/**
 * @author Roberto Minini <r.minini@solution61.fr>
 * @copyright 2025 Roberto Minini
 * @license MIT
 */
namespace DimSymfony\Controller\Admin;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DimSymfony\Repository\AppointmentRepository;
use DimSymfony\Service\ItineraryService;
use PrestaShop\PrestaShop\Adapter\LegacyContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\JsonResponse;

class DimSymfonyGestionRdvController extends FrameworkBundleAdminController
{
    /**
     * @var ItineraryService
     */
    private $itineraryService;
    
    /**
     * @var string
     */
    private $googleApiKey;
    
    /**
     * @var LegacyContext
     */
    private $context;
    
    /**
     * @var AppointmentRepository
     */
    private $appointmentRepository;
    
    /**
     * @param ItineraryService $itineraryService
     * @param string $googleApiKey
     * @param LegacyContext $context
     * @param AppointmentRepository $appointmentRepository
     */
    public function __construct(
        ItineraryService $itineraryService,
        string $googleApiKey,
        LegacyContext $context,
        AppointmentRepository $appointmentRepository
    ) {
        $this->itineraryService = $itineraryService;
        $this->googleApiKey = $googleApiKey;
        $this->context = $context;
        $this->appointmentRepository = $appointmentRepository;
    }
    
    /**
     * List all appointments
     *
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request): Response
    {
        $appointments = $this->appointmentRepository->findAll();
        
        return $this->render('@Modules/dimsymfony/views/templates/admin/appointments/index.html.twig', [
            'appointments' => $appointments,
            'layoutTitle' => $this->trans('Appointment Management', 'Modules.Dimsymfony.Admin'),
            'enableSidebar' => true,
            'help_link' => false,
        ]);
    }
    
    /**
     * View a single appointment
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function viewAction(Request $request, int $id): Response
    {
        $appointment = $this->appointmentRepository->find($id);
        
        if (!$appointment) {
            $this->addFlash('error', $this->trans('Appointment not found', 'Modules.Dimsymfony.Admin'));
            return $this->redirectToRoute('admin_dimsymphony_gestionrdv_index');
        }
        
        return $this->render('@Modules/dimsymfony/views/templates/admin/appointments/view.html.twig', [
            'appointment' => $appointment,
            'layoutTitle' => $this->trans('Appointment Details', 'Modules.Dimsymfony.Admin'),
            'enableSidebar' => true,
            'help_link' => false,
        ]);
    }
    
    /**
     * Toggle the visited status of an appointment
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function toggleVisitedAction(Request $request, int $id): RedirectResponse
    {
        $csrfToken = $request->request->get('_csrf_token');
        
        if (!$this->isCsrfTokenValid('toggle-visited-' . $id, $csrfToken)) {
            $this->addFlash('error', $this->trans('Invalid CSRF token', 'Modules.Dimsymfony.Admin'));
            return $this->redirectToRoute('admin_dimsymphony_gestionrdv_index');
        }
        
        if ($this->appointmentRepository->toggleVisited($id)) {
            $this->addFlash('success', $this->trans('Appointment status updated successfully', 'Modules.Dimsymfony.Admin'));
        } else {
            $this->addFlash('error', $this->trans('Failed to update appointment status', 'Modules.Dimsymfony.Admin'));
        }
        
        return $this->redirectToRoute('admin_dimsymphony_gestionrdv_index');
    }
    
    /**
     * Delete an appointment
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, int $id): RedirectResponse
    {
        $csrfToken = $request->request->get('_csrf_token');
        
        if (!$this->isCsrfTokenValid('delete-appointment-' . $id, $csrfToken)) {
            $this->addFlash('error', $this->trans('Invalid CSRF token', 'Modules.Dimsymfony.Admin'));
            return $this->redirectToRoute('admin_dimsymphony_gestionrdv_index');
        }
        
        if ($this->appointmentRepository->delete($id)) {
            $this->addFlash('success', $this->trans('Appointment deleted successfully', 'Modules.Dimsymfony.Admin'));
        } else {
            $this->addFlash('error', $this->trans('Failed to delete appointment', 'Modules.Dimsymfony.Admin'));
        }
        
        return $this->redirectToRoute('admin_dimsymphony_gestionrdv_index');
    }
    
    /**
     * Show map for an appointment
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function mapAction(Request $request, int $id): Response
    {
        $appointment = $this->appointmentRepository->find($id);
        
        if (!$appointment) {
            $this->addFlash('error', $this->trans('Appointment not found', 'Modules.Dimsymfony.Admin'));
            return $this->redirectToRoute('admin_dimsymphony_gestionrdv_index');
        }
        
        $itineraryData = $this->itineraryService->getItineraryData($appointment);
        
        return $this->render('@Modules/dimsymfony/views/templates/admin/appointments/map.html.twig', [
            'appointment' => $appointment,
            'itineraryData' => $itineraryData,
            'googleApiKey' => $this->googleApiKey,
            'layoutTitle' => $this->trans('Appointment Map', 'Modules.Dimsymfony.Admin'),
            'enableSidebar' => true,
            'help_link' => false,
        ]);
    }
}
