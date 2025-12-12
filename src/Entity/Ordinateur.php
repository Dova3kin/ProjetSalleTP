<?php

namespace App\Entity;

use App\Repository\OrdinateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrdinateurRepository::class)]
class Ordinateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 15, unique: true)]
    private ?string $ip = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $numero = null;

    #[ORM\ManyToOne(cascade: ["persist"], inversedBy: 'ordinateurs')]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private ?Salle $salle = null;

    #[ORM\ManyToMany(targetEntity: Logiciel::class, cascade: ["persist"], mappedBy: 'machine_installees')]
    private Collection $logiciel_installes;

    public function __construct()
    {
        $this->logiciel_installes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(string $ip): static
    {
        $this->ip = $ip;

        return $this;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(?int $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getSalle(): ?Salle
    {
        return $this->salle;
    }

    public function setSalle(?Salle $salle): static
    {
        $this->salle = $salle;

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection<int, Logiciel>
     */
    public function getLogicielInstalles(): \Doctrine\Common\Collections\Collection
    {
        return $this->logiciel_installes;
    }

    public function addLogicielInstalle(Logiciel $logicielInstalle): static
    {
        if (!$this->logiciel_installes->contains($logicielInstalle)) {
            $this->logiciel_installes->add($logicielInstalle);
            $logicielInstalle->addMachineInstallee($this);
        }

        return $this;
    }

    public function removeLogicielInstalle(Logiciel $logicielInstalle): static
    {
        if ($this->logiciel_installes->removeElement($logicielInstalle)) {
            $logicielInstalle->removeMachineInstallee($this);
        }

        return $this;
    }
}
