<?php
namespace Application\Controller\Error;
use Trojanbox\Framework\Controller;

class TemplateController extends Controller {
	
	protected $errorTemplate;
	
	public function init() {
		$this->errorTemplate = \Trojanbox\Config\Loader::Factory('array')->setConfigFile('ErrorTemplate.php')->getConfig();
	}
	
	public function fafAction() {
		throw new \Exception('404 页面不存在 :(', 404);
	}	
}