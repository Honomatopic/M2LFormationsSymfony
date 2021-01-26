<?php
/** Class entité métier des sessions de formation proposées par l'assoc' */

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SessionRepository::class)
 */
class Session
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Formation::class, inversedBy="sessions")
     */
    private $formations;

    /**
     * @ORM\ManyToOne(targetEntity=Duree::class, inversedBy="sessions")
     */
    private $durees;

    /**
     * @ORM\ManyToOne(targetEntity=Salle::class, inversedBy="sessions")
     */
    private $salles;

    /**
     * @ORM\ManyToOne(targetEntity=Intervenant::class, inversedBy="sessions")
     */
    private $intervenants;

    /**
     * @ORM\ManyToOne(targetEntity=Prestataire::class, inversedBy="sessions")
     */
    private $prestataires;

    /**
     * @ORM\ManyToMany(targetEntity=Employe::class, mappedBy="sessions")
     */
    private $inscrits;

    public function __construct()
    {
        $this->inscrits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFormations(): ?Formation
    {
        return $this->formations;
    }

    public function setFormations(?Formation $formations): self
    {
        $this->formations = $formations;

        return $this;
    }

    public function getDurees(): ?Duree
    {
        return $this->durees;
    }

    public function setDurees(?Duree $durees): self
    {
        $this->durees = $durees;

        return $this;
    }

    public function getSalles(): ?Salle
    {
        return $this->salles;
    }

    public function setSalles(?Salle $salles): self
    {
        $this->salles = $salles;

        return $this;
    }

    public function getIntervenants(): ?Intervenant
    {
        return $this->intervenants;
    }

    public function setIntervenants(?Intervenant $intervenants): self
    {
        $this->intervenants = $intervenants;

        return $this;
    }

    public function getPrestataires(): ?Prestataire
    {
        return $this->prestataires;
    }

    public function setPrestataires(?Prestataire $prestataires): self
    {
        $this->prestataires = $prestataires;

        return $this;
    }

    /**
     * @return Collection|Employe[]
     */
    public function getInscrits(): Collection
    {
        return $this->inscrits;
    }

    public function addInscrit(Employe $inscrit): self
    {
        if (!$this->inscrits->contains($inscrit)) {
            $this->inscrits[] = $inscrit;
            $inscrit->addSession($this);
        }

        return $this;
    }

    public function removeInscrit(Employe $inscrit): self
    {
        if ($this->inscrits->contains($inscrit)) {
            $this->inscrits->removeElement($inscrit);
            $inscrit->removeSession($this);
        }

        return $this;
    }
}
