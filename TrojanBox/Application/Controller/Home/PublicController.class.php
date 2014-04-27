<?php
namespace Application\Controller\Home;
use Trojanbox\Framework\Controller;
use Trojanbox\Framework\Tools;
use Application\Model\GroupModel;
use Application\Model\ArticleModel;

class PublicController extends Controller {
	
	protected $Request = null;
	
	public function init() {
		if (preg_match('/^Internet Explorer [5678]\.[\d]/i', Tools::getBrowserVersion())) throw new \Exception(':( 快去升级你的浏览器！', '404');
		$this->Request = \Trojanbox\Verification\Loader::Factory(array('_TYPE' => 'Request'));
		$this->view->publicPath = APP_APPLICATION_VIEW . 'Home' . DIRECTORY_SEPARATOR . 'Public' . DIRECTORY_SEPARATOR;
		$this->view->seo = false;
		$this->view->header = false;
		$this->view->navi = false;
		$this->view->articlenavi = false;
		$this->view->link = false;
		$this->view->recommend = false;
		$this->view->footer = false;
		$this->view->manage = false;
	}
	
	/** 头部 */
	public function header() {
		$this->view->header = true;
		return $this;
	}
	
	/** 导航 */
	public function navi() {
		$this->view->navi = true;
		return $this;
	}
	
	/** 文章导航 */
	public function articlenavi() {
		$this->view->articlenavi = true;
		return $this;
	}
	
	/** 友情连接 */
	public function link() {
		$this->view->link = true;
		return $this;
	}
	
	/** 推荐 */
	public function recommend() {
		$this->view->recommend = true;
		return $this;
	}
	
	/** SEO */
	public function seo($key, $value) {
		$this->view->seoLists[$key] = $value;
		$this->view->seo = true;
		return $this;
	}
	
	/** 尾部 */
	public function footer() {
		$this->view->footer = true;
		return $this;
	}
	
	/** 右侧管理 */
	public function manage() {
		$this->view->manage = true;
		$Group = new GroupModel();
		$Article = new ArticleModel();
		$this->view->_groupLists = $Group->getGroupLists()->toTree();
		$this->view->_articleCount = $Article->getArticleCount();
		$this->view->_workDate = (strtotime(date('Ymd'))-strtotime('2014-03-21'))/86400;
		return $this;
	}
	
	public function isAjax() {
		if ($this->Request->isParentDomain() && $this->Request->isAjax()) return true;
		return false;
	}
}