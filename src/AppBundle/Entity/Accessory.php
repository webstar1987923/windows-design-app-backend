<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 * @ORM\Table(name="accessories")
 * @ExclusionPolicy("all")
 */
class Accessory
{
    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * String representation of object
     * @return string
     */
    public function __toString()
    {
        return $this->getId();
    }

    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"list", "project-details"})
     * @Expose
     */
    protected $id;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"list", "project-details"})
     * @Expose
     */
    protected $position;

    /**
     * @var string
     *
     * @ORM\Column(type="text", length=4096, nullable=true)
     * @Groups({"list", "project-details"})
     * @Expose
     */
    protected $description;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", precision=19, scale=4, nullable=true)
     * @Groups({"list", "project-details"})
     * @Expose
     */
    protected $quantity;

    /**
     * @var string
     *
     * @ORM\Column(name="extras_type", type="string", length=100, nullable=true)
     * @Groups({"list", "project-details"})
     * @Expose
     */
    protected $extras_type;

    /**
     * @var float
     *
     * @ORM\Column(name="original_cost", type="decimal", precision=19, scale=4, nullable=true)
     * @Groups({"list", "project-details"})
     * @Expose
     */
    protected $original_cost;

    /**
     * @var string
     *
     * @ORM\Column(name="original_currency", type="string", length=100, nullable=true)
     * @Groups({"list", "project-details"})
     * @Expose
     */
    protected $original_currency;

    /**
     * @var float
     *
     * @ORM\Column(name="conversion_rate", type="decimal", precision=19, scale=4, nullable=true)
     * @Groups({"list", "project-details"})
     * @Expose
     */
    protected $conversion_rate;

    /**
     * @var float
     *
     * @ORM\Column(name="price_markup", type="decimal", precision=19, scale=4, nullable=true)
     * @Groups({"list", "project-details"})
     * @Expose
     */
    protected $price_markup;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", precision=7, scale=4, nullable=true)
     * @Groups({"list", "project-details"})
     * @Expose
     */
    protected $discount;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Quote")
     * @ORM\JoinColumn(name="quote_id", referencedColumnName="id")
     */
    protected $quote;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $value
     * @return Accessory
     */
    public function setId($value)
    {
        $this->id = $value;
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
     * @return Accessory
     */
    public function setDescription($value)
    {
        $this->description = $value;
        return $this;
    }

    /**
     * @return float
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param float $value
     * @return Accessory
     */
    public function setQuantity($value)
    {
        $this->quantity = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getExtrasType()
    {
        return $this->extras_type;
    }

    /**
     * @param string $value
     * @return Accessory
     */
    public function setExtrasType($value)
    {
        $this->extras_type = $value;
        return $this;
    }

    /**
     * @return float
     */
    public function getOriginalCost()
    {
        return $this->original_cost;
    }

    /**
     * @param float $value
     * @return Accessory
     */
    public function setOriginalCost($value)
    {
        $this->original_cost = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getOriginalCurrency()
    {
        return $this->original_currency;
    }

    /**
     * @param string $value
     * @return Accessory
     */
    public function setOriginalCurrency($value)
    {
        $this->original_currency = $value;
        return $this;
    }

    /**
     * @return float
     */
    public function getConversionRate()
    {
        return $this->conversion_rate;
    }

    /**
     * @param float $value
     * @return Accessory
     */
    public function setConversionRate($value)
    {
        $this->conversion_rate = $value;
        return $this;
    }

    /**
     * @return float
     */
    public function getPriceMarkup()
    {
        return $this->price_markup;
    }

    /**
     * @param float $value
     * @return Accessory
     */
    public function setPriceMarkup($value)
    {
        $this->price_markup = $value;
        return $this;
    }

    /**
     * @return float
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param float $value
     * @return Accessory
     */
    public function setDiscount($value)
    {
        $this->discount = $value;
        return $this;
    }

    /**
     * @return Quote
     */
    public function getQuote()
    {
        return $this->quote;
    }

    /**
     * @param Quote $quote
     * @return Accessory
     */
    public function setQuote(Quote $quote)
    {
        $this->quote = $quote;
        return $this;
    }

    /**
     * Set position
     *
     * @param integer $position
     *
     * @return Accessory
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }
}
