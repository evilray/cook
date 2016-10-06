<?php

namespace AppBundle\Twig;
use Knp\Menu\Util\MenuManipulator;
use Knp\Menu\ItemInterface;

class MenuManipulatorExtension extends \Twig_Extension
{

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('menu_manipulator', array($this, 'menuManipulator')),
        );
    }

    public function menuManipulator(ItemInterface $item)
    {
        $manipulator = new MenuManipulator();
        return $manipulator->getBreadcrumbsArray($item);
    }


    public function getName()
    {
        return 'menu_manipulator';
    }

}