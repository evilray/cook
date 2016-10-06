<?php

namespace AppBundle\Twig;

use Knp\Menu\Util\MenuManipulator;
use Knp\Menu\ItemInterface;

class LabelExtension extends \Twig_Extension {

    public function getFunctions() {
        return array(
            new \Twig_SimpleFunction('label', function($flag) {
                        if ($flag) {
                            return '<span class="label label-success">Да</span>';
                        } else {
                            return '<span class="label label-danger">Нет</span>';
                        }
                    }));
    }

    public function menuManipulator(ItemInterface $item) {
        $manipulator = new MenuManipulator();
        return $manipulator->getBreadcrumbsArray($item);
    }

    public function getName() {
        return 'menu_manipulator';
    }

}
