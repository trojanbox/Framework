<?php
namespace Application\Engine;

class TwoEngine {
    
    private $a = null;
    
    public function __construct(ThreeEngine $a) {
        $this->a = $a;
    }
    
    public function get() {
        return 1;
    }
    
}