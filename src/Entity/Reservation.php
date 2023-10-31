<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]


class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateReservation = null;


    #[ORM\Column(type: Types::DATE_MUTABLE)]

   

    // ajout de condition pour valider le formulaire (champs qui ne doit pas etre vide et date entre qui ne doit pas etre antérieure à la date du jour)
    #[Assert\NotBlank(
        message: 'Veuillez indiquer une date.',
    )]
    private ?\DateTimeInterface $DateEntree = null;


    #[ORM\Column(type: Types::DATE_MUTABLE)]
    // ajout de condition pour valider le formulaire (champs qui ne doit pas etre vide et date sortie qui ne doit pas etre antérieure à la date entrée)
    #[Assert\NotBlank(
        message: 'Veuillez indiquer une date.',
    )]
    #[Assert\GreaterThan(
    propertyPath: "DateEntree", 
    message : 'La date de sortie doit être postérieure à la date d\'entrée.'
    )]
    private ?\DateTimeInterface $DateSortie = null;


   #[ORM\ManyToOne(inversedBy: 'user')]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity : "Chambre", inversedBy: 'chambre')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Chambre $chambre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateReservation(): ?\DateTimeInterface
    {
        return $this->DateReservation;
    }

    public function setDateReservation(\DateTimeInterface $DateReservation): static
    {
        $this->DateReservation = $DateReservation;

        return $this;
    }

    public function getDateEntree(): ?\DateTimeInterface
    {


        return $this->DateEntree;
    }

    public function setDateEntree(\DateTimeInterface $DateEntree): self
    {
        $this->DateEntree = $DateEntree;


        return $this;
    }

    public function getDateSortie(): ?\DateTimeInterface
    {
        return $this->DateSortie;
    }

    public function setDateSortie(\DateTimeInterface $DateSortie): static
    {
        $this->DateSortie = $DateSortie;

        return $this;
    }


    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getChambre(): ?Chambre
    {
        return $this->chambre;
    }

    public function setChambre(?Chambre $chambre): static
    {
        $this->chambre = $chambre;

        return $this;
    }
public function __toString()
{
    return (string) $this->getId();
}

}