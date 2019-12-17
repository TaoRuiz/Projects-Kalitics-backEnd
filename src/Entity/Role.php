<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *  normalizationContext={"groups":{"roles:read"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\RoleRepository")
 */
class Role
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"positions:read", "users:read", "roles:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"positions:read", "users:read", "roles:read"})
     */
    private $title;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Position", mappedBy="roles")
     * @Groups({"roles:read"})
     */
    private $positions;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="roles")
     * @Groups({"roles:read"})
     */
    private $users;

    public function __construct()
    {
        $this->positions = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|Position[]
     */
    public function getPositions(): Collection
    {
        return $this->positions;
    }

    public function addPosition(Position $position): self
    {
        if (!$this->positions->contains($position)) {
            $this->positions[] = $position;
            $position->addRole($this);
        }

        return $this;
    }

    public function removePosition(Position $position): self
    {
        if ($this->positions->contains($position)) {
            $this->positions->removeElement($position);
            $position->removeRole($this);
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addRole($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeRole($this);
        }

        return $this;
    }
}
