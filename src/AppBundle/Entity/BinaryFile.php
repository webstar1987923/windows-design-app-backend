<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;

use AppBundle\Model\AuditableInterface;
use AppBundle\Model\AuditableTrait;
use AppBundle\Model\TimestampableInterface;
use AppBundle\Model\TimestampableTrait;

/**
 * @ORM\Entity
 * @ORM\Table(name="binary_files")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BinaryFileRepository")
 * @ExclusionPolicy("all")
 */
class BinaryFile implements TimestampableInterface, AuditableInterface
{
    use TimestampableTrait; // Adds CreatedAt, UpdatedAt properties and Implements required methods of TimestampableInterface
    use AuditableTrait; // Adds CreatedBy, UpdatedBy properties and Implements required methods of AuditableInterface

    /**
     * String representation of object
     * @return string
     */
    public function __toString()
    {
        return $this->getOriginalName() ?: 'n/a';
    }

    /**
     * @var string
     *
     * @ORM\Column(type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @Type("string")
     * @Expose
     */
    protected $uuid;

    /**
     * File name (As it was uploaded from client, i.e. Client file name)
     * Used for Download action as UserFriendly filename
     *
     * @var string
     *
     * @ORM\Column(name="original_name", type="string", length=1024)
     * @Expose
     */
    protected $originalName;

    /**
     * @var string
     *
     * @ORM\Column(name="content_type", type="string", length=256)
     * @Expose
     */
    protected $contentType;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @Expose
     */
    protected $size;

    /**
     * @var string
     *
     * @ORM\Column(name="filesystem", type="string", length=512)
     * @Groups({"files-metadata"})
     * @Expose
     */
    protected $filesystem;

    /**
     * FileSystem filename (As it stored in FileSystem storage)
     * Used for storing in filesystem AND slug for URI, so it must be
     * validated as URI applicable chars
     *
     * @var string
     *
     * @ORM\Column(name="filesystem_name", type="string", length=1024)
     * @Groups({"files-metadata"})
     * @Expose
     */
    protected $filesystemName;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     * @Expose
     */
    protected $description;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Project", mappedBy="binaryFiles")
     */
    protected $project;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=true)
     * @Expose
     */
    protected $has_thumbnail = false;

    /**
     * @var string
     *
     * @ORM\Column(type="smallint", nullable=true)
     * @Expose
     */
    protected $thumbnail_width;

    /**
     * @var string
     *
     * @ORM\Column(type="smallint", nullable=true)
     * @Expose
     */
    protected $thumbnail_height;


    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param string $value
     * @return BinaryFile
     */
    public function setUuid($value)
    {
        $this->uuid = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getOriginalName()
    {
        return $this->originalName;
    }

    /**
     * @param string $value
     * @return BinaryFile
     */
    public function setOriginalName($value)
    {
        // TODO: Validate this value to have only available chars
        $this->originalName = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * @param string $value
     * @return BinaryFile
     */
    public function setContentType($value)
    {
        $this->contentType = $value;
        return $this;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param int $value
     * @return BinaryFile
     */
    public function setSize($value)
    {
        $this->size = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getFilesystem()
    {
        return $this->filesystem;
    }

    /**
     * @param string $value
     * @return BinaryFile
     */
    public function setFilesystem($value)
    {
        $this->filesystem = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getFilesystemName()
    {
        return $this->filesystemName;
    }

    /**
     * @param string $value
     * @return BinaryFile
     */
    public function setFilesystemName($value)
    {
        // TODO: Validate this value to have only available in URI (filename) chars
        // [a-z-_]
        $this->filesystemName = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $value
     * @return BinaryFile
     */
    public function setDescription($value = null)
    {
        $this->description = $value;
        return $this;
    }

    /**
     * @return Project | null when field is empty
     * @throws \Exception when object is not instance of PersistentCollection or collection has invalid length
     */
    public function getProject()
    {
        if ($this->project instanceof PersistentCollection) {
            if (1 === $this->project->count() || 0 === $this->project->count()) {
                return $this->project->count() ? $this->project->first() : null;
            }
            throw new \Exception('PersistentCollection containing 0 or 1 object is expected');
        }
        throw new \Exception('PersistentCollection is expected');
    }

    /**
     * @param Project
     * @return BinaryFile
     */
    public function setProject($value)
    {
        if ($value instanceof Project) {
            $this->project = $value;
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function getHasThumbnail()
    {
        return $this->has_thumbnail;
    }

    /**
     * @param boolean $has_thumbnail
     * @return BinaryFile
     */
    public function setHasThumbnail($has_thumbnail)
    {
        $this->has_thumbnail = $has_thumbnail;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getThumbnail()
    {
        if ($this->getHasThumbnail()) {
            return sprintf('%s-thumbnail', $this->getUuid());
        }

        return null;
    }

    /**
     * @return integer
     */
    public function getThumbnailWidth()
    {
        return $this->thumbnail_width;
    }

    /**
     * @param integer $value
     * @return BinaryFile
     */
    public function setThumbnailWidth($value)
    {
        $this->thumbnail_width = $value;
        return $this;
    }

    /**
     * @return integer
     */
    public function getThumbnailHeight()
    {
        return $this->thumbnail_height;
    }

    /**
     * @param integer $value
     * @return BinaryFile
     */
    public function setThumbnailHeight($value)
    {
        $this->thumbnail_height = $value;
        return $this;
    }
}
