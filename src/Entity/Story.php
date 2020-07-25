<?php

declare(strict_types=1);

/*
 * This file is part of joopdt.nl.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Story.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class Story
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
     *
     * @Assert\Email(mode="strict")
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @var \App\Entity\File[]|\Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\File", mappedBy="story", cascade={"persist", "remove"})
     */
    private $files;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $notify;

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
     * Story constructor.
     */
    public function __construct()
    {
        $this->files = new ArrayCollection();
        $this->notify = false;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return \App\Entity\File[]|Collection
     */
    public function getFiles(): Collection
    {
        return $this->files;
    }

    /**
     * @param \App\Entity\File[] $files
     */
    public function setFiles(array $files): void
    {
        $this->files = $files;
    }

    /**
     * @param \App\Entity\File $file
     */
    public function addFile(File $file): void
    {
        if (false === $this->hasFile($file)) {
            $file->setStory($this);
            $this->files->add($file);
        }
    }

    /**
     * @param \App\Entity\File $file
     *
     * @return bool
     */
    public function hasFile(File $file): bool
    {
        return $this->files->contains($file);
    }

    /**
     * @return bool
     */
    public function isNotify(): bool
    {
        return $this->notify;
    }

    /**
     * @param bool $notify
     */
    public function setNotify(bool $notify): void
    {
        $this->notify = $notify;
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
     */
    public function setCreated(\DateTimeInterface $created): void
    {
        $this->created = $created;
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
     */
    public function setModified(\DateTimeInterface $modified): void
    {
        $this->modified = $modified;
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
