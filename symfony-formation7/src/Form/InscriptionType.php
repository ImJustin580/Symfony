<?php

namespace App\Form;

use App\Entity\Employe;
use App\Entity\Formation;
use App\Entity\User;
use App\Entity\Inscription;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type as SFType;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('statut', HiddenType::class, [
            'data' => 'En cours', 
            ])
            ->add('luser', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'prenom',
                'label' => 'Prénom', // Définir le label personnalisé
            ])            
            ->add('laFormation', EntityType::class, [
                'class' => Formation::class,
                'choice_label' => 'description',
            ])
            ->add('ajouter', SFType\SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inscription::class,
        ]);
    }
}
