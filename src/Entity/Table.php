<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\NumericFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use App\Repository\TableRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: TableRepository::class)]
#[ORM\Table(name: '`table`')]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => 'table:item']),
        new GetCollection(normalizationContext: ['groups' => 'table:list']),
        new Get(uriTemplate: '/tables/{id}/guests', normalizationContext: ['groups' => 'table:guests']),
        new GetCollection(uriTemplate: '/tables_stats', normalizationContext: ['groups' => 'table:tables_stats']),
        new Patch(),
    ],
    forceEager: false,
    paginationEnabled: false,
)]
#[ApiFilter(NumericFilter::class, properties: ['number'])]
class Table
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['table:list', 'table:item', 'table:tables_stats', 'guest:list', 'guest:item'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['table:list', 'table:item', 'table:tables_stats', 'guest:list', 'guest:item'])]
    private ?int $number = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['table:list', 'table:item', 'guest:list', 'guest:item'])]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['table:list', 'table:item', 'table:tables_stats', 'guest:list', 'guest:item'])]
    private ?int $maxGuests = null;

    /**
     * @var Collection<int, Guest>
     */
    #[ORM\OneToMany(targetEntity: Guest::class, mappedBy: 'table_')]
    #[Groups(['table:list', 'table:item', 'table:guests', 'guest:list', 'guest:item'])]
    private Collection $guests;

    #[Groups(['table:list', 'table:item', 'table:tables_stats', 'guest:list', 'guest:item'])]
    public function getGuestsDef(): int
    {
        return $this->guests->count();
    }

    #[Groups(['table:list', 'table:item', 'table:tables_stats', 'guest:list', 'guest:item'])]
    public function getGuestsNow(): int
    {
        return $this->guests->filter(function($guest) {
            return $guest->getIsPresent();
        })->count();
    }

    public function __construct()
    {
        $this->guests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getMaxGuests(): ?int
    {
        return $this->maxGuests;
    }

    public function setMaxGuests(?int $maxGuests): static
    {
        $this->maxGuests = $maxGuests;

        return $this;
    }

    /**
     * @return Collection<int, Guest>
     */
    public function getGuests(): Collection
    {
        return $this->guests;
    }

    public function addGuest(Guest $guest): static
    {
        if (!$this->guests->contains($guest)) {
            $this->guests->add($guest);
            $guest->setTable($this);
        }

        return $this;
    }

    public function removeGuest(Guest $guest): static
    {
        if ($this->guests->removeElement($guest)) {
            // set the owning side to null (unless already changed)
            if ($guest->getTable() === $this) {
                $guest->setTable(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return 'Стол ' . $this->number;
    }
}
