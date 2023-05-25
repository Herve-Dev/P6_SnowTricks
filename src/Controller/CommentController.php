<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentFormType;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/comment', name: 'comment')]
class CommentController extends AbstractController
{
    #[Route('/', name: 'read_comment')]
    public function index(): Response
    {
        return $this->render('comment/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }

    #[Route('/addComment', name: 'add_comment')]
    public function addComment(): Response
    {

        $comment = new Comment();
        $commentForm = $this->createForm(CommentFormType::class, $comment);

        $test = 'ok';

        return $this->render('comment/form.html.twig',[
            'test' => $test
        ]);
    }

    #[route('/api/paginate', name: 'api_paginate', methods: ['POST'])]
    public function apiGetComment(Request $request, CommentRepository $commentRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        //On récupere id du tricks reçu du front
        $idTricks = $data['idTricks'];

        $datasFound = $commentRepository->findBy(['tricks' => $idTricks]);

        //On crée un array qui stock les donnée a envoyé au front pour paginée
        $sendData = [];

        foreach($datasFound as $data)
        {

            $dataPage = [
                'idComment' => $data->getId(),
                'comment' => $data->getCommentTricks(),
                'createdAt' => $data->getCommentCreatedAt(),
                'user' => $data->getUser()->getUsername(),
                'commentIdUser' => $data->getUser()->getId()
            ];
            array_push($sendData, $dataPage);
        }

        //Fonction envoyer au js si user connecté
        function userConnected($user)
        {
            $userConnected = [
                'isConnected' => false,
            ];

            if ($user !== null) {
                $userConnected  = [
                    'isConnected' => true,
                    'idUserConnected' => $user->getId(),
                ];
            } 
            return $userConnected;
        }

        $user = $this->getUser();
        $userData = userConnected($user);        

        return new JsonResponse([
            'data' => $sendData,
            'userConnected' => $userData
        ], 200);
    }

    #[route('/api/paginate/updateComment/{id}', name: 'api_paginate_update', methods: ['POST'])]
    public function apiUpdateComment(Request $request, CommentRepository $commentRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        return new JsonResponse([
            'data' => $data
        ]);
    }
}
