<?php

namespace TP\RedactorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TP\RedactorBundle\Model\Resource;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/redactor/upload", name="_redactor_upload", options={"expose"=true})
     */
    public function uploadAction()
    {
        $entity = new Resource($this->container->getParameter('kernel.root_dir') . '/../web/uploads/');

        $entity->setFolder("redactor");
        $entity->setFile($this->getRequest()->files->get('file'));

        $entity->upload();
        $data = array("filelink" => "/uploads/redactor/".$entity->getFile());

        return new JsonResponse($data);
    }

    /**
     * @Route("/redactor/images", name="_redactor_images", options={"expose"=true})
     */
    public function imagesAction()
    {

        $finder = new Finder();
        $iterator = $finder
            ->files()
            ->in($this->container->getParameter('kernel.root_dir') . '/../web/uploads/redactor/');

        $data = array();

        foreach ($iterator->files() as $file) {

            $data[] = array(
                "thumb" => "/uploads/redactor/".$file->getFilename(),
                "image" => "/uploads/redactor/".$file->getFilename(),
                "title" => $file->getFilename(),
                "folder" => "Folder 1"
            );
        }

        return new JsonResponse($data);
    }
}
