<?php

namespace Verber\DevTime\GalleryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Verber\DevTime\GalleryBundle\Entity\Album;
use Verber\DevTime\GalleryBundle\Entity\Image;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction()
    {
        $albumsRepository = $this->getDoctrine()->getManager()->getRepository('VerberDevTimeGalleryBundle:Album');
        $albums = $albumsRepository->findAll();

        $covers = [];
        $imageRepository = $this->getDoctrine()->getManager()->getRepository('VerberDevTimeGalleryBundle:Image');

        foreach ($albums as $album) {
            $image = $imageRepository->findOneBy(['album' => $album]);
            if ($image) {
                $covers[] = [
                    'link' => $this->get('router')->generate('view_album', ['id' => $album->getId()]),
                    'cover' => $this->get('templating.helper.assets')->getUrl($image->getWebPath()),
                    'title' => $album->getName()
                ];
            }
        }

        return [
            'title' => 'Demo Gallery',
            'covers' => $covers
        ];
    }

    /**
     * @Route("/info", name="info")
     */
    public function infoAction()
    {
        phpinfo(); die();
    }

    /**
     * @Route("/create_album", name="create_album")
     * @Template()
     */
    public function createAlbumAction()
    {
        $album = new Album();

        $form = $this->createFormBuilder($album, [ 'attr' => ['id' => 'create_album'] ])
            ->add('name', 'text')
            ->add('create', 'submit')
            ->setAction($this->get('router')->generate('save_album'))
            ->getForm();

        return [
            'title' => 'Create Album',
            'album_form' => $form->createView()
        ];
    }

    /**
     * @Route("/save_album", name="save_album")
     * @param Request $request
     * @return JsonResponse
     */
    public function saveAlbumAction(Request $request)
    {
        $album = new Album();

        $form = $this->createFormBuilder($album)
            ->add('name', 'text')
            ->add('create', 'submit')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()){
            $em = $this->getDoctrine()->getManager();

            $em->persist($album);
            $em->flush();

            return new JsonResponse([
                'success' => 'true',
                'id' => $album->getId()
            ]);
        } else {
            return new JsonResponse([
                'success' => 'false',
                'erros' => $form->getErrors()
            ]);
        }

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
            ->add('album', 'entity', [
                    'class' => 'VerberDevTimeGalleryBundle:Album',
                    'property'=> 'id'
                ])
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

    /**
     * @Route("album/{id}", requirements={"id" = "\d+"}, defaults={"id" = 0}, name="view_album")
     * @param $id
     * @Template()
     */
    public function viewAlbumAction($id)
    {
        /**
         * @var Album $album;
         */
        $album = $this->getDoctrine()->getManager()->find('VerberDevTimeGalleryBundle:Album', $id);

        if (!$album) {
            throw $this->createNotFoundException('The album does not exist');
        }

        $imageRepository = $this->getDoctrine()->getManager()->getRepository('VerberDevTimeGalleryBundle:Image');

        $images = $imageRepository->findBy(['album' => $album]);

        return [
            'title' => $album->getName(),
            'images' => $images
        ];
    }

}
