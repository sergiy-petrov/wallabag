<?php

namespace Wallabag\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\OAuthServerBundle\Entity\Client as BaseClient;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\VirtualProperty;
use OpenApi\Annotations as OA;
use Wallabag\UserBundle\Entity\User;

/**
 * @ORM\Table("oauth2_clients")
 * @ORM\Entity(repositoryClass="Wallabag\ApiBundle\Repository\ClientRepository")
 */
class Client extends BaseClient
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="text", nullable=false)
     *
     * @OA\Property(
     *      description="Name of the API client",
     *      type="string",
     *      example="Default Client",
     * )
     *
     * @Groups({"user_api_with_client"})
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="RefreshToken", mappedBy="client", cascade={"remove"})
     */
    protected $refreshTokens;

    /**
     * @ORM\OneToMany(targetEntity="AccessToken", mappedBy="client", cascade={"remove"})
     */
    protected $accessTokens;

    /**
     * @var string
     *
     * @OA\Property(
     *      description="Client secret used for authorization",
     *      type="string",
     *      example="2lmubx2m9vy80ss8c4wwcsg8ok44s88ocwcc8wo0w884oc8440",
     * )
     *
     * @SerializedName("client_secret")
     * @Groups({"user_api_with_client"})
     */
    protected $secret;

    /**
     * @ORM\ManyToOne(targetEntity="Wallabag\UserBundle\Entity\User", inversedBy="clients")
     */
    private $user;

    public function __construct(User $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Client
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @VirtualProperty
     *
     * @OA\Property(
     *      description="Client secret used for authorization",
     *      type="string",
     *      example="3_1lpybsn0od40css4w4ko8gsc8cwwskggs8kgg448ko0owo4c84",
     * )
     *
     * @SerializedName("client_id")
     * @Groups({"user_api_with_client"})
     */
    public function getClientId()
    {
        return $this->getId() . '_' . $this->getRandomId();
    }
}
