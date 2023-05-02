<?php

namespace App\Controller;

use App\Repository\TricksRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'main')]
    public function index(TricksRepository $tricksRepository): Response
    {
        // On recupère toute les données pour l'injecter à la vue
        $tricks = $tricksRepository->findBy([], ['tricks_created_at' => 'DESC']);
        return $this->render('main/index.html.twig', compact('tricks'));
    }
}
