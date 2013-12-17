<?php

namespace Verber\DevTime\GalleryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Verber\DevTime\GalleryBundle\Entity\Image;

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
     * @param Request $request
     * @return JsonResponse
     */
    public function doUploadAction(Request $request)
    {
        $image = new Image();

        $form = $this->createFormBuilder($image, array('csrf_protection' => false))
            ->add('file', 'file')
            ->getForm();

        $form->submit($request);

        if ($form->isValid()){
            $em = $this->getDoctrine()->getManager();

            $em->persist($image);
            $em->flush();

            return new JsonResponse([
                'success' => 'true',
                'file' => [
                    'id' => $image->getId(),
                    'path' => $image->getWebPath()
                ]
            ]);
        } else {
            return new JsonResponse([
                'success' => 'false'
            ]);
        }

    }

}
