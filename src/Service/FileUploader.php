<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;

class FileUploader
{
    private $target_directory;

    public function __construct($target_directory)
    {
        $this->target_directory = $target_directory;
    }

    public function upload(UploadedFile $file)
    {
        $new_filename = md5(uniqid()) . '.' . $file->guessExtension();

        $file->move($this->getTargetDirectory(), $new_filename);

        return $new_filename;
    }

    public function remove($entity)
    {
        $filesystem = new Filesystem();
        $filesystem_file = $this->getTargetDirectory();

        $file_path = $filesystem_file . $entity;

        if ($filesystem->exists($file_path)) {
            $filesystem->remove($file_path);
        }
    }

    public function getTargetDirectory()
    {
        return $this->target_directory;
    }
}