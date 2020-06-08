<?php

namespace App\Entity;

use App\Repository\ConferenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConferenceRepository::class)
 */
class Conference
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $conferenceType;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endDate;

    /**
     * @ORM\ManyToOne(targetEntity=ConferenceInstitution::class, inversedBy="conferences")
     */
    private $institution;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(name="owner", referencedColumnName="id")
     */
    private $owner;

    /**
     * @ORM\OneToMany(targetEntity=ConferenceApplication::class, mappedBy="conference")
     */
    private $conferenceApplications;

    public function __construct()
    {
        $this->conferenceApplications = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getConferenceType(): ?string
    {
        return $this->conferenceType;
    }

    public function setConferenceType(string $conferenceType): self
    {
        $this->conferenceType = $conferenceType;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getInstitution(): ?ConferenceInstitution
    {
        return $this->institution;
    }

    public function setInstitution(?ConferenceInstitution $institution): self
    {
        $this->institution = $institution;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param mixed $owner
     */
    public function setOwner($owner): void
    {
        $this->owner = $owner;
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
            $conferenceApplication->setConference($this);
        }

        return $this;
    }

    public function removeConferenceApplication(ConferenceApplication $conferenceApplication): self
    {
        if ($this->conferenceApplications->contains($conferenceApplication)) {
            $this->conferenceApplications->removeElement($conferenceApplication);
            // set the owning side to null (unless already changed)
            if ($conferenceApplication->getConference() === $this) {
                $conferenceApplication->setConference(null);
            }
        }

        return $this;
    }
}
