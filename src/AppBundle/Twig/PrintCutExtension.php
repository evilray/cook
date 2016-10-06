<?php

namespace AppBundle\Twig;

use Twig_Extension;

class PrintCutExtension extends Twig_Extension
{

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter(
                'printcut', function ($text) {
                if (strpos($text, '<!-- pagebreak -->')) {
                    return substr($text, 0, strpos($text, '<!-- pagebreak -->'));
                } else {
                    return $text;
                }
            }
            ),
        );
    }


    public function getName()
    {
        return 'printcut_filter';
    }

}
