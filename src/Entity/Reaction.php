<?php

namespace App\Entity;

use App\Repository\ReactionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ReactionRepository::class)
 * @UniqueEntity(fields={"id"})
 */
class Reaction
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255)
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Event::class, mappedBy="reactions")
     */
    private $events;

    public function __construct()
    {
        $this->events = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getId() ?? static::class;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->addReaction($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            $event->removeReaction($this);
        }

        return $this;
    }
}
