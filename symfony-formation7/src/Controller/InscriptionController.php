<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Formation;
use App\Entity\Employe;
use App\Entity\Inscription;
use App\Entity\Produit;
use App\Form\FormationType;
use App\Form\InscriptionType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class InscriptionController extends AbstractController
{
    #[Route('/GestionInscription', name:'app_gestion_formation')]
    public function gestionFormationAction(ManagerRegistry $doctrine)
    {
        $inscription = $doctrine->getManager()->getRepository(Inscription::class)->findAll();
        if(!$inscription){
            $message = "Pas d'inscription";
        }
        else {
            $message = null;
        }
        return $this->render('inscription/gestionformation.html.twig',array('ensInscription' => $inscription, 'message' =>$message));
    }

    #[Route('/ajoutInscription', name:'app_ajoutInscription')]
    public function ajoutInscriptionAction(Request $request, ManagerRegistry $doctrine, $inscription = null)
    {
    if ($inscription == null) {
        $inscription = new Inscription();
    }
    $form = $this->createForm(InscriptionType::class, $inscription);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em = $doctrine->getManager();
        $em->persist($inscription);
        $em->flush();
        $message = "Inscription réussie !";
        return $this->redirectToRoute('app_ajoutInscription');
    }

    return $this->render('inscription/formInscription.html.twig', array('form' => $form->createView()));  
    }

}
