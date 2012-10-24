<?php
namespace TP\RedactorBundle\Model;

use Exception;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * Represent a file resource
 */
class Resource
{
    /**
     * @var File
     */
    protected $file;

    /**
     * @var string
     */
    protected $folder;

    /**
     * @var string
     */
    protected $webDir;

    /**
     * @param string $webDir
     */
    public function __construct($webDir)
    {
        $this->webDir = $webDir;
    }

    /**
     * @return string
     */
    public function getWeb()
    {
        return $this->webDir;
    }

    /**
     * @param string $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param string $folder
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;
    }

    /**
     * @return string
     *
     * @throws \Exception
     */
    public function getFolder()
    {
        if (null === $this->folder) {
            throw new Exception("folder is required for your ressource", 1);
        }

        return $this->folder;
    }

    /**
     * @throws FileException
     */
    public function upload()
    {
        if ($this->file instanceof File) {
            $name = sha1($this->file->getClientOriginalName() . uniqid() . getrandmax()) . '.' . $this->file->guessExtension();
            $this->file->move($this->getWeb() . $this->folder, $name);
            $this->file = $name;
        } else {
            throw new FileException('It must be a Symfony\Component\HttpFoundation\File\File instance');
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array(
            'folder' => $this->folder,
            'file'   => $this->file,
        );
    }
}
