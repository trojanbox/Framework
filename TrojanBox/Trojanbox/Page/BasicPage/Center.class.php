<?php
namespace Trojanbox\Page\BasicPage;

class Center {
	/** 类状态 */
	protected $_state = false;
	
	/** Limit */
	protected $_perPage = null;

	/** 数据总量 */
	protected $_totalItems = null;

	/** 总页数 */
	protected $_totalPages = null;

	/** 当前页 */
	protected $_currentPage = null;

	/** 当前头条记录ID */
	protected $_listStart = null;

	/** 当前最后条记录ID */
	protected $_listEnd = null;

	/** 首页 */
	protected $_pageStart = null;

	/** 尾页 */
	protected $_pageEnd = null;

	/** 分页列表 */
	protected $_pageData = null;

	/** 其他参数 */
	protected $_linkData = null;

	/** 从数据库读出的起始ID */
	protected $_startId = null;

	/** 完整URL信息 */
	protected $_url = null;

	/**
	 * 设置PageID用于获取页数，默认page。
	 *
	 * 页数将从$_url中获取
	 */
	protected $_pageId = null;

	/**
	 * 设置参数
	 * @param <b>Array</b><br>$array = array ( <br>
			&nbsp;&nbsp;&nbsp;&nbsp;'page' => 211,		//当前页 <br>
			&nbsp;&nbsp;&nbsp;&nbsp;'total' => 2000,	//数据总量 <br>
			&nbsp;&nbsp;&nbsp;&nbsp;'limit' => 10,		//数量LIMIT <br>
		);
	 */
	function setConfig($array) {
		$pageId = 'page';
		$this->_url = $array;
		$this->_totalItems = $array['total'];
		$this->_perPage = $array['limit'];
		$this->_pageId = strtolower($pageId);
		
		$this->_totalPages = ceil((int)$this->_totalItems / $this->_perPage);
		$_currentPage = $this->_url[$this->_pageId] == '' ? '1' : ceil((int)$this->_url[$this->_pageId]) ;
		$this->_pageStart = 1;
		$this->_currentPage = ($_currentPage < 1) ? $this->_pageStart : (($_currentPage > $this->_totalPages) ? $this->_totalPages : $_currentPage);
		$this->_pageEnd = ceil((int)$this->_totalItems / $this->_perPage);
		$this->_listStart = ($this->_currentPage - 1) * $this->_perPage + 1;
		$this->_listEnd =  ($this->_currentPage - 1) * $this->_perPage + $this->_perPage;
		$this->_startId = $this->_listStart - 1;
		$this->_listStart = ($this->_listStart - 1) < 0 ? 1 : $this->_listStart;
		
		$this->_state = true;
		return $this;
	}
	
	/**
	 * 重置对象
	 */
	public function destroy() {
		$this->_perPage = null;
		$this->_totalItems = null;
		$this->_totalPages = null;
		$this->_currentPage = null;
		$this->_listStart = null;
		$this->_listEnd = null;
		$this->_pageStart = null;
		$this->_pageEnd = null;
		$this->_pageData = null;
		$this->_linkData = null;
		$this->_startId = null;
		$this->_url = null;
		$this->_state = false;
		return $this;
	}
	
	/**
	 * 返回记录数
	 */
	public function getLimit(){
		if($this->_state)
			return $this->_perPage;
	}

	/**
	 * 获取当前页的头条记录ID
	 * @return string|number
	 */
	public function getLimitStart(){
		if($this->_state)
			return ($this->_listStart - 1) <= 0 ? 0 : ($this->_listStart - 1);
	}

	/**
	 * 获取当前页的最后一条记录ID
	 * @return string|number
	 */
	public function getLimitEnd(){
		if($this->_state)
			return $this->_perPage;
	}

	/**
	 * 获取当前页ID
	 * @return string|number
	 */
	public function getCurrentPage(){
		if($this->_state)
			return $this->_currentPage;
	}

	/**
	 * 获取总页数
	 * @return string|number
	 */
	public function getTotal(){
		if($this->_state)
			return $this->_totalPages;
	}

	/**
	 * 获取第一页
	 * @param string $boolean 可选布尔型，true返回一个完整的URL，false只返回ID页
	 * @return string|number
	 */
	public function getFirstPage(){
		if($this->_state)
			return $this->_pageStart;
	}

	/**
	 * 获取最后一页
	 * @param string $boolean 可选布尔型，true返回一个完整的URL，false只返回ID页
	 * @return string|number
	 */
	public function getLastPage(){
		if($this->_state)
			return $this->_pageEnd;
	}

	/**
	 * 获取一组ID页
	 * @param number $num 可选，默认获取当前页前五后五的ID页
	 * @param string $boolean  可选布尔型，true返回一个完整的URL，false只返回ID页
	 * @return array;
	 */
	public function getListsPage($num = 5){
		if(!$this->_state) return;
		if ($num*2+1 >= $this->_totalPages) {
			for ($i = 1;$i <= $this->_totalPages;$i++)
				$url[$i] = $i;
		} else {
			$start = ($this->_currentPage-$num < $this->_pageStart) ? $this->_pageStart :$this->_currentPage-$num;
			$end = ($this->_currentPage+$num > $this->_pageEnd) ? $this->_pageEnd :$this->_currentPage+$num;
			for ($i = $start;$i <= $end;$i++)
				$url[$i] = $i;
		}
		
		return empty($url) ? array() : $url ;
	}

	/**
	 * 获取下一页ID
	 * @param string $boolean 可选布尔型，true返回一个完整的URL，false只返回ID页
	 * @return string|number
	 */
	public function getDownPage(){
		if($this->_state)
			return ($this->_currentPage+1 > $this->_totalPages)? $this->_totalPages : $this->_currentPage+1;
	}

	/**
	 * 获取上一页ID
	 * @param string $boolean 可选布尔型，true返回一个完整的URL，false只返回ID页
	 * @return string|number
	 */
	public function getUpPage(){
		if($this->_state)
			return ($this->_currentPage-1 < $this->_pageStart)? $this->_pageStart : $this->_currentPage-1;
	}
}
?>