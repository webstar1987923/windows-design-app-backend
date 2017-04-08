<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProjectRepository")
 * @ORM\Table(name="projects")
 * @Serializer\ExclusionPolicy("all")
 */
class Project
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->quotes = new ArrayCollection();
        $this->binaryFiles = new ArrayCollection();
        $this->project_notes = '';
        $this->shipping_notes = '';
    }

    public function __clone()
    {
        $this->id = null;
    }

    /**
     * String representation of object
     * @return string
     */
    public function __toString()
    {
        $name = $this->getProjectName();
        return ($name) ? $name : 'n/a';
    }

    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Groups({"list", "project-details"})
     * @Serializer\Expose
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups({"list", "project-details"})
     * @Serializer\Expose
     */
    protected $client_name;
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups({"list", "project-details"})
     * @Serializer\Expose
     */
    protected $client_company_name;
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups({"list", "project-details"})
     * @Serializer\Expose
     */
    protected $client_phone;
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups({"list", "project-details"})
     * @Serializer\Expose
     */
    protected $client_email;
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups({"list", "project-details"})
     * @Serializer\Expose
     */
    protected $client_address;
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups({"list", "project-details"})
     * @Serializer\Expose
     */
    protected $project_name;
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups({"list", "project-details"})
     * @Serializer\Expose
     */
    protected $project_address;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups({"list", "project-details"})
     * @Serializer\Expose
     */
    protected $quote_date;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Serializer\Groups({"list", "project-details"})
     * @Serializer\Expose
     */
    protected $quote_revision;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     * @Serializer\Groups({"list", "project-details"})
     * @Serializer\Expose
     */
    protected $project_notes;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     * @Serializer\Groups({"list", "project-details"})
     * @Serializer\Expose
     */
    protected $shipping_notes;

    /**
     * @var string
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Serializer\Groups({"list", "project-details"})
     * @Serializer\Expose
     */
    protected $lead_time;

    /**
     * @var string
     *
     * @ORM\Column(name="settings", type="text", length=8192, nullable=true)
     * @Serializer\Groups({"list", "project-details"})
     * @Serializer\Expose
     */
    protected $settings;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true, unique=true)
     * @Serializer\Groups({"list", "project-details"})
     * @Serializer\Expose
     */
    protected $frontapp_thread_id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true, unique=true)
     * @Serializer\Groups({"list", "project-details"})
     * @Serializer\Expose
     */
    protected $frontapp_gdrive_folder_id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true, unique=true)
     * @Serializer\Groups({"list", "project-details"})
     * @Serializer\Expose
     */
    protected $dapulse_pulse_id;

    /**
     * @var string
     *
     * @ORM\Column(type="text", length=8192, nullable=true, unique=true)
     * @Serializer\Groups({"list", "project-details"})
     * @Serializer\Expose
     */
    protected $extra_id_data;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Quote", mappedBy="project", cascade={"persist", "remove"})
     * @Serializer\Groups({"project-details"})
     * @Serializer\Expose
     **/
    protected $quotes;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\BinaryFile", inversedBy="project", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="projects_files",
     *      joinColumns={@ORM\JoinColumn(name="project_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_uuid", referencedColumnName="uuid")}
     *      )
     * @Serializer\Groups({"project-details"})
     * @Serializer\Expose
     * @Serializer\SerializedName("files")
     */
    protected $binaryFiles;

    /**
     * Add file
     *
     * @param BinaryFile $value
     * @return Project
     */
    public function addBinaryFile(BinaryFile $value)
    {
        // TODO: Check file already exists in collection
        $this->binaryFiles[] = $value;
        return $this;
    }

    /**
     * Remove file
     *
     * @param BinaryFile $value
     */
    public function removeBinaryFile(BinaryFile $value)
    {
        // TODO: Check if exists
        $this->binaryFiles->removeElement($value);
    }

    /**
     * Set files
     *
     * @param ArrayCollection $value
     * @return Project
     */
    public function setBinaryFiles(ArrayCollection $value)
    {
        $this->binaryFiles = $value;
        return $this;
    }

    /**
     * Returns files
     *
     * @return ArrayCollection
     */
    public function getBinaryFiles()
    {
        return $this->binaryFiles;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id
     * @return Project
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getClientName()
    {
        return $this->client_name;
    }

    /**
     * @param string $value
     * @return Project
     */
    public function setClientName($value)
    {
        $this->client_name = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getClientCompanyName()
    {
        return $this->client_company_name;
    }

    /**
     * @param string $value
     * @return Project
     */
    public function setClientCompanyName($value)
    {
        $this->client_company_name = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getClientPhone()
    {
        return $this->client_phone;
    }

    /**
     * @param string $value
     * @return Project
     */
    public function setClientPhone($value)
    {
        $this->client_phone = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getClientEmail()
    {
        return $this->client_email;
    }

    /**
     * @param string $value
     * @return Project
     */
    public function setClientEmail($value)
    {
        $this->client_email = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getClientAddress()
    {
        return $this->client_address;
    }

    /**
     * @param string $value
     * @return Project
     */
    public function setClientAddress($value)
    {
        $this->client_address = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getProjectName()
    {
        return $this->project_name;
    }

    /**
     * @param string $value
     * @return Project
     */
    public function setProjectName($value)
    {
        $this->project_name = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getProjectAddress()
    {
        return $this->project_address;
    }

    /**
     * @param string $value
     * @return Project
     */
    public function setProjectAddress($value)
    {
        $this->project_address = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getQuoteDate()
    {
        return $this->quote_date;
    }

    /**
     * @param string $value
     * @return Project
     */
    public function setQuoteDate($value)
    {
        $this->quote_date = $value;
        return $this;
    }

    /**
     * @return int
     */
    public function getQuoteRevision()
    {
        return $this->quote_revision;
    }

    /**
     * @param int $value
     * @return Project
     */
    public function setQuoteRevision($value)
    {
        $this->quote_revision = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getShippingNotes()
    {
        return $this->shipping_notes;
    }

    /**
     * @param string $value
     * @return Project
     */
    public function setShippingNotes($value)
    {
        $this->shipping_notes = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getProjectNotes()
    {
        return $this->project_notes;
    }

    /**
     * @param string $value
     * @return Project
     */
    public function setProjectNotes($value)
    {
        $this->project_notes = $value;
        return $this;
    }

    /**
     * @return int
     */
    public function getLeadTime()
    {
        return $this->lead_time;
    }

    /**
     * @param int $value
     * @return Project
     */
    public function setLeadTime($value)
    {
        $this->lead_time = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * @param string $value
     * @return Project
     */
    public function setSettings($value)
    {
        $this->settings = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getFrontappThreadId()
    {
        return $this->frontapp_thread_id;
    }

    /**
     * @param string $value
     * @return Project
     */
    public function setFrontappThreadId($value)
    {
        $this->frontapp_thread_id = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getFrontappGdriveFolderId()
    {
        return $this->frontapp_gdrive_folder_id;
    }

    /**
     * @param string $value
     * @return Project
     */
    public function setFrontappGdriveFolderId($value)
    {
        $this->frontapp_gdrive_folder_id = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getDapulsePulseId()
    {
        return $this->dapulse_pulse_id;
    }

    /**
     * @param string $value
     * @return Project
     */
    public function setDapulsePulseId($value)
    {
        $this->dapulse_pulse_id = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getExtraIdData()
    {
        return $this->extra_id_data;
    }

    /**
     * @param string $value
     * @return Project
     */
    public function setExtraIdData($value)
    {
        $this->extra_id_data = $value;
        return $this;
    }

    /**
     * Add quote
     *
     * @param \AppBundle\Entity\Quote $quote
     *
     * @return Project
     */
    public function addQuote(\AppBundle\Entity\Quote $quote)
    {
        $quote->setProject($this);
        $this->quotes[] = $quote;

        return $this;
    }

    /**
     * Remove quote
     *
     * @param \AppBundle\Entity\Quote $quote
     */
    public function removeQuote(\AppBundle\Entity\Quote $quote)
    {
        $quote->setProject(null);
        $this->quotes->removeElement($quote);
    }

    /**
     * Get quotes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuotes()
    {
        return $this->quotes;
    }

    /**
     * @param ArrayCollection $quotes
     * @param bool $setProject
     * @return $this
     */
    public function setQuotes(ArrayCollection $quotes, $setProject = true)
    {
        if ($setProject === true) {
            foreach ($quotes as $quote) {
                $quote->setProject($this);
            }
        }

        $this->quotes = $quotes;
        return $this;
    }
}
