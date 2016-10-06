<?php

namespace AppBundle\Misc;

class SluggableListener extends \Gedmo\Sluggable\SluggableListener {

    public function __construct()
    {
        $this->setTransliterator(array('\AppBundle\Misc\Transliterator', 'transliterate'));
    }

    protected function getNamespace()
    {
        return parent::getNamespace();
    }

}
