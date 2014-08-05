<?php
namespace Test\Engine;

class DefaultEngine
{
	
    private $e = null;
    
    private $three = null;
    
    public function __construct(TwoEngine $e, $string, $array)
    {
        $this->e = $e;
    	echo 'this class';
    	echo $string;
    	print_r($array);
    }
    
    public function get() {
        echo $this->e->get();
        echo $this->three->get();
    }
    
    public static function factory(TwoEngine $e, $string, $array) {
        return new self($e, $string, $array);
    }
    
    public function setThree(ThreeEngine $three)
    {
    	$this->three = $three;
    }
    
}