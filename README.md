TrojanBox Framework BATA2.1 更新日志
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


<br/>
<b>即将加入的新功能</b>
<ol>
	<li>变量类型约束</li>
</ol>