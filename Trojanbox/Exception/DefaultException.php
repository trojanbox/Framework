<?php

namespace {

	use Trojanbox\Exception\ApplicationException;
	
	/**
	 * 方法没有找到
	 */
	class NoSuchMethodException extends ApplicationException {}
	
	/**
	 * 加载异常
	 */
	class LoaderException extends ApplicationException {}
	
	/**
	 * 目录异常
	 */
	class DirectoryNotFoundException extends ApplicationException {}
	
	/**
	 * 文件异常
	 */
	class FileNotFoundException extends ApplicationException {}
	
	/**
	 * 输入输出异常
	 */
	class IOException extends ApplicationException {}
	
	/**
	 * 类没有找到
	 */
	class ClassNotFoundException extends ApplicationException {}
	
	/**
	 * 页面没有找到
	 */
	class PageNotFoundException extends ApplicationException {}
	
	/**
	 * 框架异常
	 */
	class FrameworkException extends ApplicationException {}

}