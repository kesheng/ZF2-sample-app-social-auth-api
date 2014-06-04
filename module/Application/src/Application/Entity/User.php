<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Sglib\Model\AbstractModel;
use ZfcUser\Entity\UserInterface;

/**
 * A User.
 *
 * @ORM\Entity(repositoryClass="Application\Repository\UserRepository")
 * @ORM\Table(name="`user`")
 * @property integer $id
 * @property integer $username
 * @property string $firstName
 * @property string $lastName
 * @property string $email
 * @property integer $visibility
 * @property string $updatedAt
 * @property string $createdAt
 */
class User extends AbstractModel implements UserInterface
{
    protected $inputFilter;

    /**
     * @ORM\Id
     * @ORM\Column(name="user_id", type="integer");
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=64, unique=true, nullable=true)
     */
    protected $username;

    /**
     * @ORM\Column(name="first_name", type="string", length=50, nullable=true)
     */
    protected $firstName;

     /**
     * @ORM\Column(name="last_name", type="string", length=50, nullable=true)
     */
    protected $lastName;

     /**
     * @ORM\Column(name="email", type="string", length=255, nullable=true, unique=true)
     */
    protected $email;

     /**
     * @ORM\Column(name="password", type="string", length=255)
     */
    protected $password;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $photo;

    /**
     * @ORM\Column(name="role", type="string", length=12)
     */
    protected $role = 'User';

     /**
     * @ORM\Column(type="integer")
     */
    protected $visibility = 300;

    /**
     * @ORM\Column(name="date_updated", type="datetime", nullable=false)
     */
    protected $updatedAt;

    /**
     * @ORM\Column(name="date_created", type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @ORM\Column(name="display_name", type="string", length=64, nullable=true)
     */
    protected $displayName;

    /**
     * @ORM\Column(columnDefinition="TINYINT")
     */
    protected $state;


    public function __construct()
    {
        if (empty($this->createdAt) === true) {
            $dateTime = new \DateTime();
            $dateTime->setTimeZone(new \DateTimeZone('UTC'));

            $this->updatedAt = $dateTime;
            $this->createdAt = $dateTime;
        }
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $factory = new InputFactory();


            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id.
     *
     * @param int $id
     * @return UserInterface
     */
    public function setId($id)
    {
        $this->id = (int) $id;
        return $this;
    }


    /**
     * Get username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set username.
     *
     * @param string $username
     * @return UserInterface
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }


    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set email.
     *
     * @param string $email
     * @return UserInterface
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }


    /**
     * Get displayName.
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * Set displayName.
     *
     * @param string $displayName
     * @return UserInterface
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
        return $this;
    }


    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set password.
     *
     * @param string $password
     * @return UserInterface
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }


    /**
     * Get state.
     *
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set state.
     *
     * @param int $state
     * @return UserInterface
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }


    /**
     * Get visibility.
     *
     * @return int
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * Set visibility.
     *
     * @param int $visibility
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
        return $this;
    }


    /**
     * Get first name.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set first name.
     *
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }



    /**
     * Get last name.
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set last name.
     *
     * @param string $firstName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }



    /**
     * Get photo.
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set photo.
     *
     * @param string $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
        return $this;
    }


    /**
     * Get the logger object.
     *
     * @return Karmarama\Log\Logger
     */
    public function getLogger()
    {
        return;
    }
}
