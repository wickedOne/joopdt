<?php

declare(strict_types=1);

/*
 * This file is part of joopdt.nl.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * File.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class File
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $originalName;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $mimeType;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $size;

    /**
     * @var \App\Entity\Story
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Story", inversedBy="files")
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
     */
    private $story;

    /**
     * @var \DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var \DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     */
    private $modified;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return File
     */
    public function setId(int $id): File
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return File
     */
    public function setName(string $name): File
    {
        $this->name = $name;

        return $this;
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
     *
     * @return File
     */
    public function setOriginalName(string $originalName): File
    {
        $this->originalName = $originalName;

        return $this;
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
     *
     * @return File
     */
    public function setMimeType(string $mimeType): File
    {
        $this->mimeType = $mimeType;

        return $this;
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
     *
     * @return File
     */
    public function setSize(int $size): File
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @return \App\Entity\Story
     */
    public function getStory(): \App\Entity\Story
    {
        return $this->story;
    }

    /**
     * @param \App\Entity\Story $story
     *
     * @return File
     */
    public function setStory(\App\Entity\Story $story): File
    {
        $this->story = $story;

        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getCreated(): \DateTimeInterface
    {
        return $this->created;
    }

    /**
     * @param \DateTimeInterface $created
     *
     * @return File
     */
    public function setCreated(\DateTimeInterface $created): File
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getModified(): \DateTimeInterface
    {
        return $this->modified;
    }

    /**
     * @param \DateTimeInterface $modified
     *
     * @return File
     */
    public function setModified(\DateTimeInterface $modified): File
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function setLifecycle(): void
    {
        if (null === $this->created) {
            $this->created = new \DateTime();
        }

        $this->modified = new \DateTime();
    }
}
