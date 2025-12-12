<?php

namespace App\Entity;

use App\Repository\LogicielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: LogicielRepository::class)]
class Logiciel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    private ?string $nom = null;
    #[ORM\ManyToMany(
        targetEntity: Ordinateur::class,
        cascade: ["persist"],
        inversedBy: 'logiciel_installes'
    )]
    private Collection $machine_installees;

    public function __construct()
    {
        $this->machine_installees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection<int, Ordinateur>
     */
    public function getMachineInstallees(): \Doctrine\Common\Collections\Collection
    {
        return $this->machine_installees;
    }

    public function addMachineInstallee(Ordinateur $machineInstallee): static
    {
        if (!$this->machine_installees->contains($machineInstallee)) {
            $this->machine_installees->add($machineInstallee);
        }

        return $this;
    }

    public function removeMachineInstallee(Ordinateur $machineInstallee): static
    {
        $this->machine_installees->removeElement($machineInstallee);

        return $this;
    }
}
