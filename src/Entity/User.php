<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var string First and Second name
     * @ORM\Column(type="string")
     */
    private $fullName;

    /**
     * @ORM\OneToMany(targetEntity=Conference::class, mappedBy="owner")
     */
    private $conferences;

    /**
     * @ORM\OneToMany(targetEntity=ConferenceApplication::class, mappedBy="applicationUser")
     */
    private $conferenceApplications;

    public function __construct()
    {
        $this->conferences = new ArrayCollection();
        $this->conferenceApplications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getFullName(): string
    {
        return (string) $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Conference[]
     */
    public function getConferences(): Collection
    {
        return $this->conferences;
    }

    public function addConference(Conference $conference): self
    {
        if (!$this->conferences->contains($conference)) {
            $this->conferences[] = $conference;
            $conference->setOwner($this);
        }

        return $this;
    }

    public function removeConference(Conference $conference): self
    {
        if ($this->conferences->contains($conference)) {
            $this->conferences->removeElement($conference);
            // set the owning side to null (unless already changed)
            if ($conference->getOwner() === $this) {
                $conference->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ConferenceApplication[]
     */
    public function getConferenceApplications(): Collection
    {
        return $this->conferenceApplications;
    }

    public function addConferenceApplication(ConferenceApplication $conferenceApplication): self
    {
        if (!$this->conferenceApplications->contains($conferenceApplication)) {
            $this->conferenceApplications[] = $conferenceApplication;
            $conferenceApplication->setApplicationUser($this);
        }

        return $this;
    }

    public function removeConferenceApplication(ConferenceApplication $conferenceApplication): self
    {
        if ($this->conferenceApplications->contains($conferenceApplication)) {
            $this->conferenceApplications->removeElement($conferenceApplication);
            // set the owning side to null (unless already changed)
            if ($conferenceApplication->getApplicationUser() === $this) {
                $conferenceApplication->setApplicationUser(null);
            }
        }

        return $this;
    }
}
