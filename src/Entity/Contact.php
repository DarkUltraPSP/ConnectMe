<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $lname = null;

    #[ORM\Column(length: 255)]
    private ?string $fname = null;

    #[ORM\Column(length: 255)]
    private ?string $tel = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mail = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column(nullable: true)]
    private ?int $idGroup = null;

    /**
     * @param int|null $id
     * @param string|null $lname
     * @param string|null $fname
     * @param string|null $tel
     * @param string|null $mail
     * @param string|null $photo
     * @param int|null $idGroup
     */
    public function __construct(?int $id, ?string $lname, ?string $fname, ?string $tel, ?string $mail, ?string $photo, ?int $idGroup)
    {
        $this->id = $id;
        $this->lname = $lname;
        $this->fname = $fname;
        $this->tel = $tel;
        $this->mail = $mail;
        $this->photo = $photo;
        $this->idGroup = $idGroup;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLname(): ?string
    {
        return $this->lname;
    }

    public function setLname(string $lname): self
    {
        $this->lname = $lname;

        return $this;
    }

    public function getFname(): ?string
    {
        return $this->fname;
    }

    public function setFname(string $fname): self
    {
        $this->fname = $fname;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getIdGroup(): ?int
    {
        return $this->idGroup;
    }

    public function setIdGroup(?int $idGroup): self
    {
        $this->idGroup = $idGroup;

        return $this;
    }
}
