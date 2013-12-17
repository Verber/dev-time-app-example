<?php

namespace Verber\DevTime\GalleryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction()
    {
        return array(
            'title' => 'Demo Gallery',
        );
    }

    /**
     * @Route("/upload", name="upload")
     * @Template()
     */
    public function uploadAction()
    {
        return array(
            'title' => 'Upload Images',
        );
    }
}
