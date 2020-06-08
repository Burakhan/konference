<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use App\Repository\FileRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity(repositoryClass=FileRepository::class)
 * @Vich\Uploadable
 * @ORM\HasLifecycleCallbacks
 */
class ApplicationFiles
{
    use TimestampableTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Vich\UploadableField(mapping="generic_file", fileNameProperty="fileName", originalName="originalName", mimeType="mimeType", size="size")
     */
    private $file;

    /**
     * @ORM\Column(name="size", type="integer", nullable=true)
     *
     * @var int
     */
    private $size;

    /**
     * @ORM\Column(nullable=true)
     *
     * @var string
     */
    private $mimeType;

    /**
     * @ORM\Column(nullable=true)
     *
     * @var string
     */
    private $originalName;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    protected $fileName;

    /**
     * @var ConferenceApplication
     * @ORM\ManyToOne(targetEntity="ConferenceApplication", inversedBy="file")
     * @ORM\JoinColumn(nullable=false)
     */
    private $conferenceApplication;

    public function __construct(){
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param File $file
     * @throws \Exception
     */
    public function setFile(File $file): void
    {
        $this->file = $file;
        if ($file) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime();
        }
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    /**
     * @return string
     */
    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    /**
     * @param string $mimeType
     */
    public function setMimeType(string $mimeType): void
    {
        $this->mimeType = $mimeType;
    }

    /**
     * @return string
     */
    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    /**
     * @param string $originalName
     */
    public function setOriginalName(string $originalName): void
    {
        $this->originalName = $originalName;
    }

    /**
     * @return string
     */
    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     */
    public function setFileName(string $fileName): void
    {
        dump($this);
        $this->fileName = $fileName;
    }

    /**
     * @return ConferenceApplication
     */
    public function getConferenceApplication(): ConferenceApplication
    {
        return $this->conferenceApplication;
    }

    /**
     * @param ConferenceApplication $conferenceApplication
     */
    public function setConferenceApplication(ConferenceApplication $conferenceApplication): void
    {
        $this->conferenceApplication = $conferenceApplication;
    }


    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->getFileName();
    }


}
