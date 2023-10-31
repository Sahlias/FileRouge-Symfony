<?php

namespace App\Entity;

use App\Repository\ChambreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChambreRepository::class)]

class Chambre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $tarif = null;

    #[ORM\Column(length: 255)]
    private ?string $superficie = null;

    #[ORM\Column]
    private ?int $vueSurMer = null;

    #[ORM\Column]
    private ?int $Chaines_a_laCarte = null;

    #[ORM\Column]
    private ?int $climatisation = null;

    #[ORM\Column]
    private ?int $television_a_ecranPlat = null;

    #[ORM\Column]
    private ?int $telephone = null;

    #[ORM\Column]
    private ?int $chainesSatellite = null;

    #[ORM\Column]
    private ?int $chainesDuCable = null;

    #[ORM\Column]
    private ?int $coffreFort = null;

    #[ORM\Column]
    private ?int $materielDeRepassage = null;

    #[ORM\Column]
    private ?int $WiFiGratuit= null;


    #[ORM\ManyToOne(inversedBy: 'categorie')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $categorie = null;


    #[ORM\Column]
    private ?bool $etat = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\OneToMany(mappedBy: 'chambre', targetEntity: Reservation::class)]
    private Collection $chambre;

    public function __construct()
    {
        $this->chambre = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTarif(): ?int
    {
        return $this->tarif;
    }

    public function setTarif(int $tarif): static
    {
        $this->tarif = $tarif;

        return $this;
    }

    public function getSuperficie(): ?string
    {
        return $this->superficie;
    }

    public function setSuperficie(string $superficie): static
    {
        $this->superficie = $superficie;

        return $this;
    }

    public function getVueSurMer(): ?int
    {
        return $this->vueSurMer;
    }

    public function setVueSurMer(int $vueSurMer): static
    {
        $this->vueSurMer = $vueSurMer;

        return $this;
    }

    public function getChainesaLaCarte(): ?int
    {
        return $this->Chaines_a_laCarte;
    }

    public function setChainesaLaCarte(int $Chaines_a_laCarte): static
    {
        $this->Chaines_a_laCarte = $Chaines_a_laCarte;

        return $this;
    }

    public function getClimatisation(): ?int
    {
        return $this->climatisation;
    }

    public function setClimatisation(int $climatisation): static
    {
        $this->climatisation = $climatisation;

        return $this;
    }

    public function getTelevisionaEcranPlat(): ?int
    {
        return $this->television_a_ecranPlat;
    }

    public function setTelevisionaEcranPlat(int $television_a_ecranPlat): static
    {
        $this->television_a_ecranPlat = $television_a_ecranPlat;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getChainesSatellite(): ?int
    {
        return $this->chainesSatellite;
    }

    public function setChainesSatellite(int $chainesSatellite): static
    {
        $this->chainesSatellite = $chainesSatellite;

        return $this;
    }

    public function getChainesDuCable(): ?int
    {
        return $this->chainesDuCable;
    }

    public function setChainesDuCable(int $chainesDuCable): static
    {
        $this->chainesDuCable = $chainesDuCable;

        return $this;
    }

    public function getCoffreFort(): ?int
    {
        return $this->coffreFort;
    }

    public function setCoffreFort(int $coffreFort): static
    {
        $this->coffreFort = $coffreFort;

        return $this;
    }

    public function getMaterielDeRepassage(): ?int
    {
        return $this->materielDeRepassage;
    }

    public function setMaterielDeRepassage(int $materielDeRepassage): static
    {
        $this->materielDeRepassage = $materielDeRepassage;

        return $this;
    }

    public function getWiFiGratuit(): ?int
    {
        return $this->WiFiGratuit;
    }

    public function setWifiGratuit(int $WiFiGratuit): static
    {
        $this->WiFiGratuit= $WiFiGratuit;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }



    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): static
    {
        $this->etat = $etat;

        return $this;
    }


    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getChambre(): Collection
    {
        return $this->chambre;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->chambre->contains($reservation)) {
            $this->chambre->add($reservation);
            $reservation->setChambre($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->chambre->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getChambre() === $this) {
                $reservation->setChambre(null);
            }
        }

        return $this;
    }

public function __toString(){

   return $this->libelle;
}


}