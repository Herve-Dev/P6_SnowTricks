<?php

namespace App\Controller;

use App\Entity\MediaTricks;
use App\Entity\Tricks;
use App\Form\TricksFormType;
use App\Repository\TricksRepository;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tricks', name: 'tricks_')]
class TricksController extends AbstractController
{
    #[Route('/', name: 'all_tricks')]
    public function index(TricksRepository $tricksRepository): Response
    {
        // On recupère toute les données pour l'injecter à la vue
        $tricks = $tricksRepository->findBy([], ['tricks_created_at' => 'DESC']);
        return $this->render('tricks/index.html.twig', compact('tricks'));
    }

    #[Route('/addTricks', name: 'add_new_tricks')]
    public function addTricks(Request $request, EntityManagerInterface $em, PictureService $pictureService): Response
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

        return $this->render('tricks/add.html.twig', [
            'tricksForm' => $tricksForm->createView()
        ]);
    }

    #[Route('/updateTricks/{id}', name: 'update_tricks')]
    public function updateTricks(Tricks $tricks, Request $request, EntityManagerInterface $em, PictureService $pictureService): Response
    {
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

        return $this->render('tricks/update.html.twig',  [
            'tricksForm' => $tricksForm->createView(),
            'tricks' => $tricks
        ]);
    }

    #[Route('/delete/image/{id}', name: 'delete_image', methods: ['DELETE'])]
    public function deleteImage(MediaTricks $mediaTrick ,Request $request, EntityManagerInterface $em, PictureService $pictureService): JsonResponse
    {
        
        //On récupère le contenu de la requête
        $data = json_decode($request->getContent(), true);

        if ($this->isCsrfTokenValid('delete' . $mediaTrick->getId(), $data['_token'])) {
            // Le token csrf est valide 
            // On récupère le nom de l'image
            $mediaName = $mediaTrick->getMediaName();

            if ($pictureService->delete($mediaName, 'media_tricks', 300, 300)) {
                // On supprime l'image de la base de données
                $em->remove($mediaTrick);
                $em->flush();

                return new JsonResponse(['success' => true], 200);
            }

            //La supréssion a échoué
            return new JsonResponse(['error' => 'Erreur de suppression', $mediaName], 400);
        }
        
        return new JsonResponse(['error' => 'Token invalide'], 400);
    }
   
}
