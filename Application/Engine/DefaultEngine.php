<?php
namespace Application\Engine;

class DefaultEngine
{
	
    private $e = null;
    
    public function __construct(TwoEngine $e, FourEngine $f, $string)
    {
        print_r($string);
    	echo 'this class';
    }
    
    public function getget() {
        echo $this->e->get();
    }
}