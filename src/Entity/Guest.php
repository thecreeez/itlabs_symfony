<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use App\Repository\GuestRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: GuestRepository::class)]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => ['guest:item']]),
        new GetCollection(normalizationContext: ['groups' => ['guest:list']]),
        new Patch(),
    ],
    forceEager: false,
    paginationEnabled: false,
)]
#[ApiFilter(SearchFilter::class, properties: ['name'  => 'partial'])]
#[ApiFilter(BooleanFilter::class, properties: ['isPresent'])]
class Guest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['guest:list', 'guest:item', 'table:guests', 'table:item'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['guest:list', 'guest:item', 'table:guests', 'table:item'])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(['guest:list', 'guest:item', 'table:guests', 'table:item'])]
    private ?bool $isPresent = null;

    #[ORM\ManyToOne(inversedBy: 'guests')]
    #[Groups(['guest:list', 'guest:item'])]
    private ?Table $table_ = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getIsPresent(): ?bool
    {
        return $this->isPresent;
    }

    public function setIsPresent(bool $isPresent): static
    {
        $this->isPresent = $isPresent;

        return $this;
    }

    public function getTable(): ?Table
    {
        return $this->table_;
    }

    public function setTable(?Table $table_): static
    {
        $this->table_ = $table_;

        return $this;
    }
}
