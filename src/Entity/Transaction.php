<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
#[ORM\Table(name: '`transaction`')]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(nullable: false)]
    private int $value;

    #[ORM\Column(nullable: false)]
    private bool $reimbursement = false;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    private Budget $budget;

    #[ORM\Column(length: 25)]
    private string $date;

    #[ORM\Column]
    private bool $deleted = false;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getDate(): \DateTime
    {
        return new \DateTime($this->date);
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date->format(DATE_ATOM);

        return $this;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function setValue(int $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function isReimbursement(): bool
    {
        return $this->reimbursement;
    }

    public function setReimbursement(bool $reimbursement): static
    {
        $this->reimbursement = $reimbursement;

        return $this;
    }

    public function getBudget(): Budget
    {
        return $this->budget;
    }

    public function setBudget(Budget $budget): static
    {
        $this->budget = $budget;

        return $this;
    }

    public function isDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): static
    {
        $this->deleted = $deleted;

        return $this;
    }
}
