<?php
namespace Application\Controller\Home;

use Application\Controller\Home\PublicController;
use Application\Model\CommentModel;

class CommentController extends PublicController {

	protected $Comment;
	
	public function init() {
		parent::init();
		$this->Comment = new CommentModel();
		if (empty($_SERVER['HTTP_REFERER'])) throw new \Exception('异常：无法识别的请求！', 404);
		if (!preg_match('/\/show\/(\d+)\.html$/i', $_SERVER['HTTP_REFERER'], $urlRule)) {
			echo 'not args';exit();
		}
		$this->Comment->setArticleId($urlRule[1]);
	}
	
	public function ajax_addAction() {
		if (!$this->isAjax()) throw new \Exception('异常：无法识别的请求！', 404);
		if ($this->Comment->setParentId($_POST['floor'])->addComment($_POST)) {
			echo 'data'; exit();
		}
		echo 'not data'; exit();
	}
	
	public function ajax_getListsAction() {
		if (!$this->isAjax()) throw new \Exception('异常：无法识别的请求！', 404);
		$this->view->commentLists = $this->Comment->getCommentLists();
		$this->display();
	}
}