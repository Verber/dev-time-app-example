<?php
/**
 * Created by PhpStorm.
 * User: imosiev
 * Date: 17.12.13
 * Time: 16:00
 */

namespace Verber\DevTime\GalleryBundle\Menu;

use Symfony\Component\DependencyInjection\ContainerAware;
use Knp\Menu\FactoryInterface;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        /** @var \Symfony\Component\HttpFoundation\Request $request*/
        $request = $this->container->get('request');
        $menu->setCurrentUri($request->getRequestUri());

        $menu->addChild('Home', array('route' => 'homepage'));
        $menu->addChild('Create Album', array('route' => 'create_album'));

        return $menu;

    }
} 