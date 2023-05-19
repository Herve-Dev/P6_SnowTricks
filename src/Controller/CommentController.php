<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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


}
