<?php 
namespace AppBundle\Twig; 
use Symfony\Bundle\FrameworkBundle\Translation\Translator; 
use Twig_Extension; 
 
class TransPlural extends Twig_Extension 
{ 
    protected $translator; 
    public function __construct(Translator $translator) 
    { 
        $this->translator = $translator; 
    } 
 
    public function getFilters() 
    { 
        return array( 
            new \Twig_SimpleFilter('transplural', array($this, 'transplural')), 
        ); 
    } 
 
    public function transplural($string, $number) 
    { 
        $translated = $this->translator->trans( 
            $string, 
            array('%d' => $number) 
        ); 
        $type = (($number % 10 == 1) && ($number % 100 != 11)) 
        ? 0 
        : ((($number % 10 >= 2) 
            && ($number % 10 <= 4) 
            && (($number % 100 < 10) 
                || ($number % 100 >= 20))) 
            ? 1 
            : 2 
        ); 
        //this if condition here because on some servers $this->translator->tran
        //was returning wrong strings
        if (strpos($translated,"{")===false) 
        { 
            $translated_array = explode("|", $translated); 
            return $translated_array[$type]; 
        } 
        else 
        { 
            return $this->translator->transChoice($translated,  $type, array("%count%"=>$type)); 
 
        } 
 
    } 
 
    /** 
     * Returns the name of the extension. 
     * 
     * @return string The extension name 
     */ 
    public function getName() 
    { 
        return "translate_plural_russian"; 
    } 
}