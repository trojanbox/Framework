Framework BATAX 2.1.1 更新日志
=========

<b>介绍</b><br/>
TrojanBox 框架核心：基于事件驱动与包管理器的核心框架
<br/>

<b>功能说明</b>
<br/>

自动加载机制<br/>
&nbsp;&nbsp;&nbsp;&nbsp;不需要手动导入文件。TB自动加载可以实现核心文件加载，扩展目录加载以及包文件自动加载。<br/>
&nbsp;&nbsp;&nbsp;&nbsp;所有文件均是按需加载（包文件也是如此）。<br/>
<br/>

包管理器（使用PHP归档）<br/>
&nbsp;&nbsp;&nbsp;&nbsp;将 *.phar 置入Package下，可以实现自动加载。<br/>
&nbsp;&nbsp;&nbsp;&nbsp;注意：TBFramework 仅能识别由 Trojanbox\Package\CreateExtendPackage 类创建的 *.phar 文件。<br/>
<br/>

更加完整的异常处理机制<br/>
&nbsp;&nbsp;&nbsp;&nbsp;try/catch 语句能捕捉大多数错误与异常，但仍有一些错误无法捕捉，如：语法错误。<br/>
&nbsp;&nbsp;&nbsp;&nbsp;ApplicationException 应用程序异常基类，所有异常类均继承自此类。<br/>
&nbsp;&nbsp;&nbsp;&nbsp;ApplicationErrorException 应用程序错误异常基类，所有错误异常类均继承自此类。<br/>
&nbsp;&nbsp;&nbsp;&nbsp;Framework 内置8个基础的异常处理类。<br/>
<br/>

<b>即将添加的新功能</b><br/>
&nbsp;&nbsp;&nbsp;&nbsp;将加入事件控制并将其作为核心。<br/>
&nbsp;&nbsp;&nbsp;&nbsp;监听管理器 - 管理所有已注册的监听器 - 支持两种监控类型<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;行为监听<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;触发监听<br/>
&nbsp;&nbsp;&nbsp;&nbsp;事件管理器 - 管理所有已注册的事件 - 事件需要绑定到监听器<br/>
<br/>
