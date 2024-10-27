<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\ManyToOne]
    private ?Author $authorID = null;

    #[ORM\ManyToOne]
    private ?LoanStatus $loanID = null;

    #[ORM\ManyToOne]
    private ?Customer $customerID = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getAuthorID(): ?Author
    {
        return $this->authorID;
    }

    public function setAuthorID(?Author $authorID): static
    {
        $this->authorID = $authorID;

        return $this;
    }

    public function getLoanID(): ?LoanStatus
    {
        return $this->loanID;
    }

    public function setLoanID(?LoanStatus $loanID): static
    {
        $this->loanID = $loanID;

        return $this;
    }

    public function getCustomerID(): ?Customer
    {
        return $this->customerID;
    }

    public function setCustomerID(?Customer $customerID): static
    {
        $this->customerID = $customerID;

        return $this;
    }
}
