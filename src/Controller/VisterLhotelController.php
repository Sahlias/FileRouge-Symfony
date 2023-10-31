<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VisterLhotelController extends AbstractController
{
    #[Route('/vister/lhotel', name: 'app_vister_lhotel')]
    public function index(): Response
    {
        return $this->render('vister_lhotel/index.html.twig');
    }
}