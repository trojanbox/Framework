Framework Master 2.0
=========

TrojanBox 框架核心：基于事件驱动与包管理器的核心框架


自动加载机制

  不需要手动导入文件。TB自动加载可以实现核心文件加载，扩展目录加载以及包文件自动加载。
  所有文件均是按需加载（包文件也是如此）。


包管理器（使用PHP归档）

  将 *.phar 置入Package下，可以实现自动加载。
  注意：TBFramework 仅能识别由 Trojanbox\Package\CreateExtendPackage 类创建的 *.phar 文件。
