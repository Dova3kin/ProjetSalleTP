<?php

namespace App\Entity;

use App\Repository\SalleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SalleRepository::class)]
class Salle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 1)]
    #[Assert\Length(min: 1, max: 1, exactMessage: "Votre nom doit faire {{ limit }} caractère")]
    private ?string $batiment = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Assert\Regex(pattern: "/^[0-9]$/", message: "la valeur doit être comprise entre 0 et 9.")]
    private ?int $etage = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Assert\LessThanOrEqual(value: 80, message: "la valeur doit être <= {{ compared_value }}")]
    private ?int $numero = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBatiment(): ?string
    {
        return $this->batiment;
    }

    public function setBatiment(string $batiment): static
    {
        $this->batiment = $batiment;

        return $this;
    }

    public function getEtage(): ?int
    {
        return $this->etage;
    }

    public function setEtage(int $etage): static
    {
        $this->etage = $etage;

        return $this;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function __toString()
    {
        return $this->getBatiment() . '-' . $this->getEtage() . '.' . $this->getNumero();
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function corrigeNomBatiment()
    {
        $this->batiment = strtoupper($this->batiment);
    }
}
