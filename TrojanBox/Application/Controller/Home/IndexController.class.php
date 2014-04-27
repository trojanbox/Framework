<?php
namespace Application\Controller\Home;
use Application\Controller\Home\PublicController;
use Application\Model\ArticleModel;
use Application\Model\GroupModel;

class IndexController extends PublicController {
	
	protected $Article;
	protected $page;
	
	public function init() {
		parent::init();
		$this->Article = new ArticleModel();
		$this->Group = new GroupModel();
		$this->header()->footer()->navi()->manage();
	}
	
	/** 首页 */
	public function indexAction() {
		
		try {
			//公共设置
			$this->recommend();
			
			$this->page = \Trojanbox\Page\Loader::Factory(array('_TYPE' => 'BasicPage'));
			$pageConfig = array(
				'total' => $this->Article->getArticleCount(),
				'page' => empty($this->get['page']) ? 0 : $this->get['page'],
				'limit' => 10
			);
			$this->page->destroy()->setConfig($pageConfig);
	
			$this->view->lastPage = $this->page->getLastPage();
			$this->view->downPage = $this->page->getDownPage();
			$this->view->upPage = $this->page->getUpPage();
			$this->view->currentPage = $this->page->getCurrentPage();
			$this->view->firstPage = $this->page->getFirstPage();
			$this->view->listsPage = $this->page->getListsPage();
			
			$this->seo('title', '无头骑士')
				->seo('author', '王权')
				->seo('email', 'justwe9517@foxmail.com')
				->seo('email', 'admin@trojanbox.com')
				->seo('keywords', '个人,博客,学习,trojanbox,获取')
				->seo('description', '取之不尽，用之不竭。')
				->seo('baidu-site-verification', 'pwlPi2dDQo');
			
			$this->view->articleLists = $this->Article->getArticleLists($this->page->getLimitStart(), $this->page->getLimitEnd());
			$this->display();
		
		} catch (\ErrorException $e) {
			throw new \Exception('错误：正在进行维护。', 404);
		}
	}
	
	/** 内容页 */
	public function showAction() {
		$this->articlenavi();
		try {
			$this->view->articleInfo = $this->Article->getArticleInfo($this->get['id']);
			if (empty($this->view->articleInfo)) throw new \Exception('error');
			$this->seo('title', $this->view->articleInfo['title'])
				->seo('keywords', $this->view->articleInfo['key'])
				->seo('description', $this->view->articleInfo['description']);
			$this->display();
		} catch (\ErrorException $e) {
			throw new \Exception('错误：正在进行维护。', 404);
		} catch (\Exception $e) {
			throw new \Exception('404', 4041);
		}
	}
	
	/** 列表页 */
	public function listsAction() {

		try {
			$this->page = \Trojanbox\Page\Loader::Factory(array('_TYPE' => 'BasicPage'));
			$pageConfig = array(
					'total' => $this->Article->getArticleByGroupCount($this->get['id']),
					'page' => empty($this->get['page']) ? 0 : $this->get['page'],
					'limit' => 10
			);
				
			$this->page->destroy()->setConfig($pageConfig);
				
			$this->view->lastPage = $this->page->getLastPage();
			$this->view->downPage = $this->page->getDownPage();
			$this->view->upPage = $this->page->getUpPage();
			$this->view->currentPage = $this->page->getCurrentPage();
			$this->view->firstPage = $this->page->getFirstPage();
			$this->view->listsPage = $this->page->getListsPage();
				
			$this->articlenavi();
			$this->view->articleLists = $this->Article->getArticleByGroup($this->get['id'], $this->page->getLimitStart(), $this->page->getLimitEnd());
			$this->view->articleInfo = $this->Group->getGroup($this->get['id']);
			$this->view->lists = true;
				
			if (empty($this->view->articleInfo)) throw new \Exception('404');
			
			$this->seo('title', $this->view->articleInfo['name'])
				->seo('keywords', $this->view->articleInfo['key'])
				->seo('description', $this->view->articleInfo['description']);
			$this->display();
		} catch (\Exception $e) {
			throw new \Exception('404', 4041);
		}  catch (\ErrorException $e) {
			throw new \Exception('404', 4041);
		}
			
	}
}
