<?php

declare(strict_types=1);

/*
 * This file is part of joopdt.nl.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service;

use App\Entity\File;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * Upload Service.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
class UploadService
{
    /**
     * @var string
     */
    private $directory;

    /**
     * @var \Symfony\Component\String\Slugger\SluggerInterface
     */
    private $slugger;

    /**
     * @param string                                             $directory
     * @param \Symfony\Component\String\Slugger\SluggerInterface $slugger
     */
    public function __construct(string $directory, SluggerInterface $slugger)
    {
        $this->directory = $directory;
        $this->slugger = $slugger;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     *
     * @return \App\Entity\File
     *
     * @throws \Symfony\Component\HttpFoundation\File\Exception\UploadException
     */
    public function upload(UploadedFile $file): File
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid('', true).'.'.$file->guessExtension();

        try {
            $moved = $file->move($this->getDirectory(), $fileName);
        } catch (FileException $e) {
            throw new UploadException(sprintf('Could not upload file %s', $file->getClientOriginalName()));
        }

        return (new File())
            ->setMimeType($moved->getMimeType())
            ->setName($fileName)
            ->setOriginalName($originalFilename)
            ->setSize($moved->getSize())
        ;
    }

    /**
     * @return string
     */
    private function getDirectory(): string
    {
        return $this->directory;
    }
}
