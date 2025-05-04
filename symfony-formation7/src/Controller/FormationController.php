<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Formation;
use App\Entity\Employe;
use App\Entity\Inscription;
use App\Entity\Produit;
use App\Entity\Lettre;
use App\Entity\User;
use App\Form\FormationType;
use App\Form\InscriptionType;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\RechercheLettreType;

class FormationController extends AbstractController
{

    #[Route('/home', name: 'app_home')]
    #[IsGranted('ROLE_USER')]
    public function Home(): Response
    {    
        return $this->render('login/home.html.twig');
    }

    #[Route('/ajoutFormation', name:'app_ajoutFormation')]
    public function ajoutFormationAction(Request $request, ManagerRegistry $doctrine, $formation = null)
    {
    if ($formation == null) {
        $formation = new Formation();
    }
    $form = $this->createForm(FormationType::class, $formation);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em = $doctrine->getManager();
        $em->persist($formation);
        $em->flush();
        return $this->redirectToRoute('app_dashboard');
    }

    return $this->render('formation/editer.html.twig', array('form' => $form->createView()));  
}

#[Route('/suppFormation/{id}', name:'app_formation_sup')]
public function suppFilmAction($id, ManagerRegistry $doctrine)
{
    $entityManager = $doctrine->getManager();
    $formation = $entityManager->getRepository(Formation::class)->find($id);

    if ($formation) {
        $inscriptions = $entityManager->getRepository(Inscription::class)->findBy(['laFormation' => $formation]);
        foreach ($inscriptions as $inscription) {
            $entityManager->remove($inscription);
        }

        $entityManager->remove($formation);
        $entityManager->flush();
    }

    return $this->redirectToRoute('app_dashboard');
}
    #[Route('/dashboard', name:'app_dashboard')]
    #[IsGranted('ROLE_USER')]
    public function afficherFormationAction(ManagerRegistry $doctrine)
    {
        $formation = $doctrine->getManager()->getRepository(Formation::class)->findAll();

        if (!$formation){
            $message = "Pas de formation";
        }
        else {
            $message = null;
        }

        return $this->render('formation/listeformation.html.twig',array('ensFormations' => $formation,'message' =>$message));
    }


    #[Route('/modifierStatutTerminer/{id}', name:'app_gestion_statut_terminer')]
    public function modifierStatutTerminer($id, ManagerRegistry $doctrine)
    {
        $statut = $doctrine->getManager()->getRepository(Inscription::class)->find($id);
        if($statut){
            $statut->setStatut('Terminer');
            $entityManager = $doctrine->getManager();
            $entityManager->persist($statut);
            $entityManager->flush();
        }
        
        return $this->redirectToRoute('app_gestion_formation');
    }

    #[Route('/modifierStatutCours/{id}', name:'app_gestion_statutCours')]
    public function modifierStatutCours($id, ManagerRegistry $doctrine)
    {
        $statut = $doctrine->getManager()->getRepository(Inscription::class)->find($id);
        if($statut){
            $statut->setStatut('En cours');
            $entityManager = $doctrine->getManager();
            $entityManager->persist($statut);
            $entityManager->flush();
        }
        
        return $this->redirectToRoute('app_gestion_formation');
    }

    #[Route('/modifierStatutRefuser/{id}', name:'app_gestion_statut_refuser')]
    public function modifierStatutRefuser($id, ManagerRegistry $doctrine)
    {
        $statut = $doctrine->getManager()->getRepository(Inscription::class)->find($id);
        if($statut){
            $statut->setStatut('Refuser');
            $entityManager = $doctrine->getManager();
            $entityManager->persist($statut);
            $entityManager->flush();
        }
        
        return $this->redirectToRoute('app_gestion_formation');
    }

    #[Route('/listeEmploye', name: 'app_listeEmploye')]
    public function ShowListeEmploye(Request $request, ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(User::class);
        $repository2 = $doctrine->getRepository(Inscription::class);
        
        $nom = $request->query->get('nom', '');
        $prenom = $request->query->get('prenom', '');
        
        $ensEmployes = $repository->findByFilters($prenom, $nom);
        $message = empty($ensEmployes) ? 'Aucun employé trouvé pour les critères spécifiés.' : null;
    
        return $this->render('recherche/listeEmploye.html.twig', [
            'ensEmployes' => $ensEmployes, 
            'message' => $message,
            'currentNom' => $nom,
            'currentPrenom' => $prenom,
            'ensFormations' => $repository2,
        ]);
    }
    

}