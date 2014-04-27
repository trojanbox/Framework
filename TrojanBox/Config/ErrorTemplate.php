<?php
//异常模板
return array(
	'0' => function (Exception $exception) {
		echo '<div style="clear:both;"></div>
			<div style="border:2px solid #2d2d2d; font-family: 微软雅黑; background: #2d2d2d; color: white; padding: 5px 8px; font-size: 12px;">
				<div style="WORD-BREAK: break-all; WORD-WRAP: break-word">错误信息：<b>' . $exception->getMessage() . '</b></div>
				<div style="WORD-BREAK: break-all; WORD-WRAP: break-word">错误等级：' . $exception->getCode() . '</div>
				<div style="WORD-BREAK: break-all; WORD-WRAP: break-word">错误文件：' . $exception->getFile() . ' ' . $exception->getLine() . '</div>
			</div>';
	},
	'404' => function (Exception $exception) {
		header("HTTP/1.0 404 Not Found");
		echo "<html>
				<body style='background: #2d2d2d; color: white; font-family: 微软雅黑;'>
					<div style='position: fixed; font-size:60px;  top: 50%; left: 50%; margin-left: -310px; margin-top: -39px;'>" . $exception->getMessage() . "</div>
				</body>
			</html>";
	},
	
	'4041' => function () {
		header("HTTP/1.0 404 Not Found");
		echo "<html>
				<body style='background: #2d2d2d; color: white; font-family: 微软雅黑;'>
					<div style='position: fixed; font-size:60px;  top: 50%; left: 50%; margin-left: -310px; margin-top: -39px;'>错误：404 页面未找到！</div>
				</body>
			</html>";
	},
);