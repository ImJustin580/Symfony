<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
class Inscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    //lien user
    #[ORM\ManyToOne(targetEntity:User::class)]
    #[ORM\JoinColumn(nullable:true)] 
    private $luser = null;    

    #[ORM\ManyToOne(targetEntity: Formation::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?Formation $laFormation = null;

    #[ORM\Column(length: 255)]
    private ?string $statut = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getLuser(): ?User
    {
        return $this->luser;
    }

    public function setLuser(?User $luser): static
    {
        $this->luser = $luser;

        return $this;
    }

    public function getLaFormation(): ?Formation
    {
        return $this->laFormation;
    }

    public function setLaFormation(?Formation $laFormation): static
    {
        $this->laFormation = $laFormation;

        return $this;
    }
}
