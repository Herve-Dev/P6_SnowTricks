<?php

namespace App\Controller;

use App\Entity\MediaTricks;
use App\Entity\Tricks;
use App\Form\TricksFormType;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tricks', name: 'tricks_')]
class TricksController extends AbstractController
{
    #[Route('/addNewTricks', name: 'add_new_tricks')]
    public function index(Request $request, EntityManagerInterface $em, PictureService $pictureService): Response
    {

        //On crée un "nouveau tricks"
        $tricks = new Tricks();

        //ajout de l'id de l'utilisateur qui post dans le tricks
        $user = $this->getUser();
        $tricks->setUser($user);

        //On crée le formulaire
        $tricksForm = $this->createForm(TricksFormType::class, $tricks);

        // On traite la requête du formulaire
        $tricksForm->handleRequest($request);

        //On vérifie si le formulaire est soumis et valide
        if ($tricksForm->isSubmitted() && $tricksForm->isValid()) {
            //On récupère les images
            $mediaTricks = $tricksForm->get('media_tricks')->getData();

            foreach($mediaTricks as $mediaTrick) {
                //On définit le dossier de destination
                $folder = "media_tricks";

                //On appelle le service d'ajout
                $file = $pictureService->add($mediaTrick,$folder, 300, 300);

                $mediaEntity = new MediaTricks();
                $mediaEntity->setMediaName($file);
                $tricks->addMediaTrick($mediaEntity);

            }


            //On Stock en base de donnée
            $em->persist($tricks);
            $em->flush();
            
            //On envoie un message flash 
            $this->addFlash('success','tricks ajouté avec succès');

            //On redirige 
            return $this->redirectToRoute('main');
        }

        return $this->render('tricks/index.html.twig', [
            'tricksForm' => $tricksForm->createView()
        ]);
    }
}
