<!DOCTYPE html>
<html ng-app="dingdingApp">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
		<title></title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		@yield('style_part')
	</head>
	<body>
		<div class="container nopadding">
			<div class="nopadding" ng-view>
			</div>
		</div>
		<!--<div class="footer">
			<div class="header_language right">
				<a href="/set_locale/cn" class="language @if($locale != "en") active @endif">中文</a> | 
				<a href="/set_locale/en" class="language @if($locale == "en") active @endif">ENG</a>
			</div>
		</div>-->
	</body>
	
	<!-- dingding api javascript files -->
	<script type="text/javascript" src="//g.alicdn.com/dingding/open-develop/0.8.4/dingtalk.js"></script>
	<script type="text/javascript">var _config = <?php echo dingAuth::getConfig();?></script>
	@yield('javascript_part')
</html>