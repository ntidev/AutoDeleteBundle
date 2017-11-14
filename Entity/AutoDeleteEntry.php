<?php

namespace NTI\AutoDeleteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AutoDeleteEntry
 *
 * @ORM\Table(name="nti_auto_delete_entry")
 * @ORM\Entity(repositoryClass="NTI\AutoDeleteBundle\Repository\AutoDeleteEntryRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class AutoDeleteEntry
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="text", nullable=false)
     */
    private $path;

    /**
     * @var int
     *
     * @ORM\Column(name="seconds", type="integer", nullable=false)
     */
    private $seconds;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

    /**
     * @var boolean
     *
     * @ORM\Column(name="recursive", type="boolean")
     */
    private $recursive;

    /**
     * @var boolean
     *
     * @ORM\Column(name="keep_empty_dir", type="boolean")
     */
    private $keepEmptyDir;

    /**
     * @var \DateTime()
     *
     * @ORM\Column(name="created_on", type="datetime", nullable=false)
     */
    private $createdOn;

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
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return AutoDeleteEntry
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return int
     */
    public function getSeconds()
    {
        return $this->seconds;
    }

    /**
     * @param int $seconds
     * @return AutoDeleteEntry
     */
    public function setSeconds($seconds)
    {
        $this->seconds = $seconds;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     * @return AutoDeleteEntry
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
        return $this;
    }

    /**
     * @return bool
     */
    public function isRecursive()
    {
        return $this->recursive;
    }

    /**
     * @param bool $recursive
     * @return AutoDeleteEntry
     */
    public function setRecursive($recursive)
    {
        $this->recursive = $recursive;
        return $this;
    }

    /**
     * @return bool
     */
    public function isKeepEmptyDir()
    {
        return $this->keepEmptyDir;
    }

    /**
     * @param bool $keepEmptyDir
     * @return AutoDeleteEntry
     */
    public function setKeepEmptyDir($keepEmptyDir)
    {
        $this->keepEmptyDir = $keepEmptyDir;
        return $this;
    }
    
    /**
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @ORM\PrePersist()
     * @return AutoDeleteEntry
     */
    public function setCreatedOn()
    {
        $this->createdOn = new \DateTime();
        return $this;
    }

}

