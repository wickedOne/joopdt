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
     */
    public function upload(UploadedFile $file): File
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid('', true).'.'.$file->guessExtension();

        try {
            $file->move($this->getDirectory(), $fileName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        $fileReference = new File();
        $fileReference->setMimeType($file->getMimeType());
        $fileReference->setName($fileName);
        $fileReference->setOriginalName($originalFilename);
        $fileReference->setSize($file->getSize());

        return $fileReference;
    }

    /**
     * @return string
     */
    private function getDirectory(): string
    {
        return $this->directory;
    }
}
