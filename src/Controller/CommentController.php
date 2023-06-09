<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\User;
use App\Form\CommentFormType;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/comment', name: 'comment')]
class CommentController extends AbstractController
{
    #[Route('/', name: 'read_comment', methods: ['GET'])]
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
        $slugTricks = $data['slug'];
        
        $datasFound = $commentRepository->searchCommentWithSlug($slugTricks);

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
        function userConnected(?User $user): array
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
    public function apiUpdateComment(Request $request, CommentRepository $commentRepository, int $id, EntityManagerInterface $em): JsonResponse
    {
        $comment = $commentRepository->findOneBy(['id' => $id]);

        //On verifie si le commentaire existe
        if (!$comment) {
            return new JsonResponse([
                'status' => 'error',
                'message' => "le commentaire n'a pas été trouvé"
            ], 404);
        } else {

            //On récupere les datas du fetch
            $data = json_decode($request->getContent(), true);

            //On verifie si la propriété à mettre à jour existe
            if (isset($data['valueUpdateComment'])) {
                //On stocke les nouvelle données dans le commentaire
                $comment->setCommentTricks($data['valueUpdateComment']);
            }

            //On enregistre les modification en BDD
            $em->persist($comment);
            $em->flush();

            //On crée le message qui sera retourné au front
            $response = [
                'status' => 'success',
                'message' => 'Commentaire modifié avec succes !'
            ];

             return new JsonResponse([
                'data' => $response
            ], 200);
        }
       
    }

    #[route('/api/paginate/deleteComment/{id}/{idUser}', name: 'api_paginate_delete', methods: ['DELETE'])]
    public function apiDeleteComment(Request $request, CommentRepository $commentRepository, int $id, int $idUser, EntityManagerInterface $em): JsonResponse
    {
        // Vérifier si le commentaire existe
        $comment = $commentRepository->find($id);
        if (!$comment) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Commentaire introuvable.'
            ], 404);
        } else {
            //On vérifie si l'utilisateur est le propriétaire du commentaire
            if ($comment->getUser()->getId() !== $idUser) {
                return new JsonResponse([
                    'status' => 'error',
                    'message' => 'Vous n\'êtes pas autorisé à supprimer ce commentaire.'
                ], 404);
            }
        }

        // Supprimer le commentaire
        $em->remove($comment);
        $em->flush();

        //On crée le message qui sera retourné au front
        $response = [
            'status' => 'success',
            'message' => 'Commentaire supprimez avec succes !'
        ];

         return new JsonResponse([
            'data' => $response
        ], 200);
    }

}
