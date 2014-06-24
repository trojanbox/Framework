<?php
namespace Trojanbox\Config\ConfigInterface;

use Trojanbox\File\FileInterface\FileInterface;

interface ArrayConfigInterface {

	public function __construct(FileInterface $file);
	
}