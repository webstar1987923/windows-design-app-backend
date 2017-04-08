<?php
namespace AppBundle\Entity;

use AppBundle\Helpers\UuidHelper;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Entity
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\Table(name="users")
 * @ExclusionPolicy("all")
 */
class User implements UserInterface, AdvancedUserInterface
{
    CONST ROLE_ADMIN = 'ROLE_ADMIN';
    CONST ROLE_MANAGER = 'ROLE_MANAGER';
    CONST ROLE_USER = 'ROLE_USER';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose
     * @Groups({"api", "Default"})
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Expose
     * @Assert\NotBlank(
     *     message="Please, enter a username"
     * )
     * @Assert\Length(
     *     min=4,
     *     max=20,
     *     minMessage="Username must be at least 4 characters long",
     *     maxMessage="Username is too long (should be no longer than 20 characters)"
     * )
     * @Groups({"api", "Default"})
     */
    protected $username;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Expose
     * @Groups({"api", "Default"})
     */
    protected $usernameCanonical;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank(
     *     message="Please, enter a password"
     * )
     * @Assert\Length(
     *     min=8,
     *     minMessage="Password must be at least 8 characters long"
     * )
     */
    protected $password;

    /**
     * @Assert\Expression(
     *     "this.getPassword() === this.getPasswordConfirm()",
     *     message="Passwords don't match"
     * )
     */
    protected $passwordConfirm;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Expose
     * @Assert\NotBlank(
     *     message="Please, enter an email address"
     * )
     * @Assert\Email(
     *     message="Please, enter a valid email address"
     * )
     * @Groups({"api", "Default"})
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Expose
     * @Assert\NotBlank(
     *     message="Please, enter a firstname"
     * )
     * @Assert\Length(
     *     min=3,
     *     minMessage="Firstname must be at least 3 characters long"
     * )
     * @Groups({"api", "Default"})
     */
    protected $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Expose
     * @Assert\NotBlank(
     *     message="Please, enter a lastname"
     * )
     * @Assert\Length(
     *     min=3,
     *     minMessage="Lastname must be at least 3 characters long"
     * )
     * @Groups({"api", "Default"})
     */
    protected $lastname;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $locked;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $enabled;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $salt;

    /**
     * @ORM\Column(type="array", nullable=false)
     * @Expose
     * @Assert\NotBlank(
     *     message="Please, select at least one role"
     * )
     * @Groups({"api", "Default"})
     */
    protected $roles;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $deletedAt;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\BinaryFile", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="users_files",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_uuid", referencedColumnName="uuid")}
     *      )
     */
    protected $binaryFiles;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->binaryFiles = new ArrayCollection();
        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
    }

    public function __toString()
    {
        return (string)$this->username;
    }

    /**
     * Add file
     *
     * @param BinaryFile $value
     * @return User
     */
    public function addBinaryFile(BinaryFile $value)
    {
        if (!$this->binaryFiles->contains($value)) {
            $this->binaryFiles->add($value);
        }
        return $this;
    }

    /**
     * Remove file
     *
     * @param BinaryFile $value
     * @return User
     */
    public function removeBinaryFile(BinaryFile $value)
    {
        if ($this->binaryFiles->contains($value)) {
            $this->binaryFiles->removeElement($value);
        }
        return $this;
    }

    /**
     * Set files
     *
     * @param ArrayCollection $value
     * @return User
     */
    public function setBinaryFiles(ArrayCollection $value)
    {
        $this->binaryFiles = $value;
        return $this;
    }

    /**
     * Returns files
     *
     * @return array BinaryFile
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
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $value
     * @return User
     */
    public function setUsername($value)
    {
        $this->username = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsernameCanonical()
    {
        return $this->usernameCanonical;
    }

    /**
     * @param string $value
     * @return User
     */
    public function setUsernameCanonical($value)
    {
        $this->usernameCanonical = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $value
     * @return User
     */
    public function setPassword($value)
    {
        $this->password = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getPasswordConfirm()
    {
        return $this->passwordConfirm;
    }

    /**
     * @param string $value
     * @return User
     */
    public function setPasswordConfirm($value)
    {
        $this->passwordConfirm = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $value
     * @return User
     */
    public function setEmail($value)
    {
        $this->email = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $value
     * @return User
     */
    public function setFirstname($value)
    {
        $this->firstname = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $value
     * @return User
     */
    public function setLastname($value)
    {
        $this->lastname = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param string $value
     * @return User
     */
    public function setSalt($value)
    {
        $this->salt = $value;
        return $this;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param array $value
     * @return User
     */
    public function setRoles($value)
    {
        if (!is_array($value)) {
            $value = (array)$value;
        }
        $this->roles = $value;
        return $this;
    }

    /**
     * @return bool
     */
    public function getLocked()
    {
        return $this->locked;
    }

    /**
     * @param bool $value
     * @return User
     */
    public function setLocked($value)
    {
        $this->locked = $value;
        return $this;
    }

    /**
     * @return bool
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param bool $value
     * @return User
     */
    public function setEnabled($value)
    {
        $this->enabled = $value;
        return $this;
    }

    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }

    public function eraseCredentials()
    {

    }

    /**
     * Serializes the user.
     *
     * The serialized data have to contain the fields used by the equals method and the username.
     *
     * @return string
     */
    public function serialize()
    {
        return serialize(array(
            $this->password,
            $this->salt,
            $this->username,
            $this->enabled,
            $this->locked,
            $this->id,
            $this->email,
            $this->firstname,
            $this->lastname,
            $this->roles,
        ));
    }

    /**
     * Unserializes the user.
     *
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        $data = unserialize($serialized);
        // add a few extra elements in the array to ensure that we have enough keys when unserializing
        // older data which does not include all properties.
        $data = array_merge($data, array_fill(0, 2, null));

        list(
            $this->password,
            $this->salt,
            $this->username,
            $this->enabled,
            $this->locked,
            $this->id,
            $this->email,
            $this->firstname,
            $this->lastname,
            $this->roles,
            ) = $data;
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->enabled;
    }

    public function isAccountNonLocked()
    {
        return !$this->locked;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

}