<?php
namespace Application\Controller\Admin;

use Trojanbox\Framework\Controller;
use Application\Model\GroupModel;
use Application\Model\ArticleModel;

class GroupController extends Controller {
	
	protected $_group = null;
	
	public function init() {
		$this->Group = new GroupModel();
	}
	
	/** 分组树形图 */
	public function addGroupAction() {
		$groupTreeLists = $this->Group->getGroupLists()->toTree();
		$this->view->groupTreeLists = $groupTreeLists;
		$this->display();
	}
	
	/** 编辑分组 */
	public function editGroupAction() {
		$groupTreeLists = $this->Group->getGroupLists()->toTree();
		$groupInfo = $this->Group->getGroup($this->get['id']);
		$this->view->groupTreeLists = $groupTreeLists;
		$this->view->groupInfo = $groupInfo;
		print_r($groupInfo);
		$this->display();
	}
	
	/** 分组列表 */
	public function groupListAction() {
		$groupTreeLists = $this->Group->getGroupLists()->toTree();
		$this->view->groupTreeLists = $groupTreeLists;
		$this->display();
	}
	
	/** 删除分组 */
	public function Ajax_DeleteGroupAction() {
		$this->Article = new ArticleModel();
		$articleList = $this->Article->getArticleByGroup($this->get['id'], 0, 1);
		if (empty($articleList)) {
			$this->Group->deleteGroup($this->get['id']);
		}
		echo '<script>window.location.href="/Admin/Group/groupList"</script>';
	}
	
	/** 编辑分组 */
	public function Ajax_EditGroupAction() {
		if ($this->Group->editGroup($this->post)) {echo '1'; exit; };
		echo '2'; exit;
	}
	
	/** 创建新分组 */
	public function Ajax_AddGroupAction() {
		if ($this->Group->createNewGroup($_POST)) echo 1;
	}
	
	public function autoGroupAction() {
		$this->display();
	}
	
}