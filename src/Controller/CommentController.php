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

        $idTricks = $data['idTricks'];
        //$page = $data['page'];

        //$commentPaginate = $commentRepository->findCommentsPaginated($page, $idTricks, 2);
        
        //$datasFound = $commentPaginate['data'];

        $datasFound = $commentRepository->findBy(['tricks' => $idTricks]);

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

        // Code pour verifier si user connecter pour crud des commentaires
        
       /* if ($userConnected !== null) {
            $userConnected = [
                'idUser' => $userConnected->getId() //Erreur sur IDE mais fonctionne
            ];
        }*/
        
        


        

        return new JsonResponse([
            'data' => $sendData,
            'userConnected' => $userData
        ], 200);
    }

}
