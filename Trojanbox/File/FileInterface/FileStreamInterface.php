<?php
namespace Trojanbox\File\FileInterface;

interface FileStreamInterface {
	
	public function __construct(FileInterface $file);
	
	public function close();
	
}