<?php

namespace App\Entity;

use App\Repository\LettreRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LettreRepository::class)]
class Lettre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Lettre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLettre(): ?string
    {
        return $this->Lettre;
    }

    public function setLettre(string $Lettre): static
    {
        $this->Lettre = $Lettre;

        return $this;
    }
}
