<?php

namespace Verber\DevTime\GalleryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;

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
     * @Route("/create_album", name="create_album")
     * @Template()
     */
    public function createAlbumAction()
    {
        return array(
            'title' => 'Create Album',
        );
    }

    /**
     * @Route("/doupload", name="do_upload")
     * @return JsonResponse
     */
    public function doUploadAction()
    {
        $request = $this->get('request');
        $files = $request->files;

        // configuration values
        //$directory = //...

        // $file will be an instance of Symfony\Component\HttpFoundation\File\UploadedFile
        foreach ($files as $uploadedFile) {
            // name the resulting file
            //$name = //...
            //$file = $uploadedFile->move($directory, $name);

            // do something with the actual file
            //$this->doSomething($file);
        }

        // return data to the frontend
        return new JsonResponse([]);
    }
}
