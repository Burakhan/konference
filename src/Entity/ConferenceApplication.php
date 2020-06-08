<?php

namespace App\Entity;

use App\Repository\ConferenceApplicationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConferenceApplicationRepository::class)
 */
class ConferenceApplication
{
    const STATUS_DRAFT = 'draft';
    const STATUS_COMPLETE = 'complete';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $summary;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity="ApplicationFiles", mappedBy="conferenceApplication", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $file;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="conferenceApplications")
     * @ORM\JoinColumn(nullable=false)
     */
    private $applicationUser;

    /**
     * @ORM\ManyToOne(targetEntity=Conference::class, inversedBy="conferenceApplications")
     * @ORM\JoinColumn(nullable=false)
     */
    private $conference;

    public function __construct()
    {
        $this->file = new ArrayCollection;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getApplicationUser(): ?User
    {
        return $this->applicationUser;
    }

    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param $file
     */
    public function setFile($file): void
    {
        $this->file = $file;
    }

    /**
     * Add attachment
     * @param ApplicationFiles $file
     */
    public function addFile(ApplicationFiles $file)
    {
        $file->setConferenceApplication($this);
        $this->file[] = $file;
    }

    /**
     * Remove attachment
     * @param ApplicationFiles $file
     */
    public function removeFile(ApplicationFiles $file)
    {
        $this->file->removeElement($file);
    }

    public function setApplicationUser(?User $applicationUser): self
    {
        $this->applicationUser = $applicationUser;

        return $this;
    }

    public function getConference(): ?Conference
    {
        return $this->conference;
    }

    public function setConference(?Conference $conference): self
    {
        $this->conference = $conference;

        return $this;
    }
}
