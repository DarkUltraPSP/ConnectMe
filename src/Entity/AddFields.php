<?php

namespace App\Entity;

use App\Repository\AddFieldsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AddFieldsRepository::class)]
class AddFields
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $fieldName = null;

    #[ORM\Column(length: 255)]
    private ?string $fieldContent = null;

    #[ORM\Column]
    private ?int $idContact = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFieldName(): ?string
    {
        return $this->fieldName;
    }

    public function setFieldName(string $fieldName): self
    {
        $this->fieldName = $fieldName;

        return $this;
    }

    public function getFieldContent(): ?string
    {
        return $this->fieldContent;
    }

    public function setFieldContent(string $fieldContent): self
    {
        $this->fieldContent = $fieldContent;

        return $this;
    }

    public function getIdContact(): ?int
    {
        return $this->idContact;
    }

    public function setIdContact(int $idContact): self
    {
        $this->idContact = $idContact;

        return $this;
    }
}
