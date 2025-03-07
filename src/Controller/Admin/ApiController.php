<?php

namespace Dimsymfony\Controller\Admin; // Corrected Namespace

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends FrameworkBundleAdminController
{
    public function indexAction(Request $request): JsonResponse
    {
       // get request data
       $data = $request->request->all();

       return new JsonResponse([
           'status' => 'success',
           'data' => $data
       ]);
    }
}
