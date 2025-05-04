<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Employe;
use App\Entity\User;
use App\Entity\Inscription;
use App\Entity\Produit;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\InscriptionRepository;
use App\Form\FormationType;
use App\Form\RechercherInscriptionType;
use App\Form\RechercheLettreType;




class RechercheController extends AbstractController
{
    #[Route('/rechInscription', name: 'app_rech')]
    public function rechercheInscriptions(Request $request, ManagerRegistry $doctrine)
    {
        $form = $this->createForm(RechercherInscriptionType::class);        
        $form->handleRequest($request);
        
        $message = '';
        $groupedInscriptions = [];
    
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $nom = $data->getNom();
            $prenom = $data->getPrenom();
    
            $inscriptions = $doctrine->getRepository(Inscription::class)->rechInscriptionsEmployeNomPrenom($nom, $prenom);
    
            foreach ($inscriptions as $inscription) {
                $employeId = $inscription->getLuser()->getId();
                if (!isset($groupedInscriptions[$employeId])) {
                    $groupedInscriptions[$employeId] = [
                        'user' => $inscription->getLuser(),
                        'formations' => []
                    ];
                }
                $groupedInscriptions[$employeId]['formations'][] = $inscription;
            }
    
            if (empty($groupedInscriptions)) {
                $message = "Non trouvé";
            } else {
                $message = "TROUVE";
            }
        }
    
        return $this->render('recherche/form.html.twig', [
            'form' => $form->createView(),
            'groupedInscriptions' => $groupedInscriptions,
            'message' => $message
        ]);
    }

    #[Route('/ChercherLettre', name:'app_chercher_lettre')]
    public function chercherLettre(Request $request, ManagerRegistry $doctrine)
    {
        $form = $this->createForm(RechercheLettreType::class);
        $form->handleRequest($request);
    
        $employes = [];
        $message = '';
    
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $lettre = $data->getLettre();
    
            if (strlen($lettre) === 1) {
                $entityManager = $doctrine->getManager();
                $employes = $entityManager->getRepository(User::class)->createQueryBuilder('e')
                    ->where('e.prenom LIKE :lettre')
                    ->setParameter('lettre', $lettre . '%')
                    ->getQuery()
                    ->getResult();
            } else {
                $message = 'Veuillez saisir une seule lettre.';
            }
        }
    
        return $this->render('formation/Lettre.html.twig', [
            'form' => $form->createView(),
            'employes' => $employes,
            'message' => $message,
        ]);

    }


    }


