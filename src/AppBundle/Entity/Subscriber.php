<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subscriber
 *
 * @ORM\Table(name="subscriber")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SubscriberRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Subscriber
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="endpoint", type="text" )
     */
    private $endpoint;

    /**
     * @var string
     *
     * @ORM\Column(name="browserKey", type="string", length=255)
     */
    private $browserKey;

    /**
     * @var string
     *
     * @ORM\Column(name="authSecret", type="string", length=255)
     */
    private $authSecret;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="subscribed_at", type="datetime")
     */
    private $subscribedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="unsubscribed_at", type="datetime")
     */
    private $unsubscribedAt;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set endpoint
     *
     * @param string $endpoint
     *
     * @return Subscriber
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * Get endpoint
     *
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * Set browserKey
     *
     * @param string $browserKey
     *
     * @return Subscriber
     */
    public function setBrowserKey($browserKey)
    {
        $this->browserKey = $browserKey;

        return $this;
    }

    /**
     * Get browserKey
     *
     * @return string
     */
    public function getBrowserKey()
    {
        return $this->browserKey;
    }

    /**
     * Set authSecret
     *
     * @param string $authSecret
     *
     * @return Subscriber
     */
    public function setAuthSecret($authSecret)
    {
        $this->authSecret = $authSecret;

        return $this;
    }

    /**
     * Get authSecret
     *
     * @return string
     */
    public function getAuthSecret()
    {
        return $this->authSecret;
    }

    /**
     * Set subscribedAt
     *
     * @param \DateTime $subscribedAt
     *
     * @return Subscriber
     */
    public function setSubscribedAt($subscribedAt)
    {
        $this->subscribedAt = $subscribedAt;

        return $this;
    }

    /**
     * Get SubscribedAt
     *
     * @return \DateTime
     */
    public function getSubscribedAt()
    {
        return $this->subscribedAt;
    }

    /**
     * Set unsubscribedAt
     *
     * @param \DateTime $unsubscribedAt
     *
     * @return Subscriber
     */
    public function setUnsubscribedAt($unsubscribedAt)
    {
        $this->unsubscribedAt = $unsubscribedAt;

        return $this;
    }

    /**
     * Get unsubscribedAt
     *
     * @return \DateTime
     */
    public function getUnsubscribedAt()
    {
        return $this->unsubscribedAt;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return Subscriber
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return bool
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        if ($this->subscribedAt == null) {
            $this->setSubscribedAt(new \DateTime('now'));
            $this->setUnsubscribedAt(new \DateTime('now'));
        }
    }
}

