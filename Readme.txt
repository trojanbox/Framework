以支持的事件
	


支持的事件钩子：
	[SYSTEM]Framework							监听框架开始
		<event>[start]
		<event>[end]
		
	[SYSTEM]Autoload							监听自动加载
		<event>[start]
		<event>[end]
		
	[SYSTEM]Package								监听包管理器
		<event>[start]
		<event>[end]
		
	[SYSTEM]Route								监听框架程序
		<event>[start]
		<event>[end]
		
	[SYSTEM]EventManager						监听事件驱动
		<event>[start]
		<event>[end]
		
	[SYSTEM]Dispatcher							监听分发器
		<event>[start]
		<event>[end]
		
	[ROUTE]Namespace\Controller					监听路由控制器
		<event>[controller_before]					控制器加载之前
		<event>[controller_after]					控制器加载之后
		<event>[action_before]						控制器方法加载之前
		<event>[action_after]						控制器方法加载之后
	
	[ROUTE]Namespace\Controller::action			监听路由方法
		<event>[controller_before]					控制器加载之前
		<event>[controller_after]					控制器加载之后
		<event>[action_before]						方法加载之前
		<event>[action_after]						方法加载之后
	
	[AUTOLOAD]Namespace\controller				监听自动加载
		<event>[before]								方法加载之前
		<event>[after]								方法加载之后
	
	[PACKAGE]PackageName						监听包加载
		<event>[before]								包加载之前
		<event>[after]								包加载之后
	
	[PACKAGE]PackageName:Namespace\Controller	监听包对象加载
		<event>[before]								包对象加载之前
		<event>[after]								包对象加载之后




$this->RouteNamespaceControllerEvent = $eventLinstener->listen('SystemDispatcher');
$this->RouteNamespaceControllerActionEvent = $eventLinstener->listen('SystemDispatcher');
$this->AutoloadNamespaceControllerEvent = $eventLinstener->listen('SystemDispatcher');
$this->PackagePackageNameEvent = $eventLinstener->listen('SystemDispatcher');
$this->PackageNamespaceNameEvent = $eventLinstener->listen('SystemDispatcher');


// 钩子监听器
if (EventManager::$state) {
	$applicationListenerManager = $eventLinstener->listen('[SYSTEM]Application');
	$applicationListenerManager->setHook('start');
	exit();
}