<?php
namespace Application\Controller\Admin;
use Trojanbox\Framework\Controller;
use Application\Model\ArticleModel;
use Application\Model\GroupModel;
use Application\Engine\UserLoginEngine;

class ArticleController extends Controller {
	
	public function init() {
		$this->Article = new ArticleModel();
		$this->_group = new GroupModel();
	}
	
	/** 添加文章 */
	public function addArticleAction() {
		
		$groupTreeLists = $this->_group->getGroupLists()->toTree();
		$this->view->groupTreeLists = $groupTreeLists;
		
		$this->display();
	}
	
	/** 编辑文章  */
	public function editArticleAction() {
		$groupTreeLists = $this->_group->getGroupLists()->toTree();
		$articleInfo = $this->Article->getArticleInfo($this->get['id']);
		$this->view->articleInfo = $articleInfo;
		$this->view->groupTreeLists = $groupTreeLists;
		
		$this->display();
	}
	
	/** 文章列表 */
	public function articleListAction() {
		
		$this->page = \Trojanbox\Page\Loader::Factory(array('_TYPE' => 'BasicPage'));
		
		$pageConfig = array(
				'total' => $this->Article->getArticleCount(),
				'page' => empty($this->get['page']) ? 0 : $this->get['page'],
				'limit' => 10
		);
		$this->page->destroy()->setConfig($pageConfig);
		
		$this->view->lastPage = $this->page->getLastPage();
		$this->view->firstPage = $this->page->getFirstPage();
		$this->view->listsPage = $this->page->getListsPage();
		
		$this->view->articleLists = $this->Article->getArticleLists($this->page->getLimitStart(), $this->page->getLimitEnd());
		
		$this->display();
	}
	
	/** 添加文章 */
	public function Ajax_AddArticleAction() {
	
		$data['classify_id'] = $this->post['classify'];
		$data['author_id'] = UserLoginEngine::getInstance()->getUserInfo()['id'];
		$data['classify_id'] = $this->post['classify'];
		$data['title'] = $this->post['titleText'];
		$data['title_sim'] = $this->post['description'];
		$data['content'] = $this->post['content'];
		$data['key'] = $this->post['key'];

		if ($this->Article->addArticle($data)) {echo 'ok'; exit; };
		echo 'no'; exit;
	}
	
	/** 编辑文章 */
	public function Ajax_EditArticleAction() {
		
		$data['id'] = $this->post['id'];
		$data['classify_id'] = $this->post['classify'];
		$data['author_id'] = UserLoginEngine::getInstance()->getUserInfo()['id'];
		$data['classify_id'] = $this->post['classify'];
		$data['title'] = $this->post['titleText'];
		$data['title_sim'] = $this->post['description'];
		$data['content'] = $this->post['content'];
		$data['key'] = $this->post['key'];
		
		if ($this->Article->editArticle($data)) {echo 'ok'; exit; };
		echo 'no'; exit;
	}
	
	/** 删除文章 **/
	public function Ajax_DeleteArticleAction() {
		if (empty($this->get['id'])) exit('not args');
		$this->Article->deleteArticle($this->get['id']);
		echo '<script>window.location.href="/Admin/Article/articleList"</script>';
	}
}