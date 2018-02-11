<!DOCTYPE html>
<html ng-app="dingdingApp">
	<head>
		<title>{{$home_title}}</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
		<meta name="apple-mobile-web-app-capable" content="yes"/>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		@yield('style_part')
		<LINK REL="SHORTCUT ICON" HREF="images/dellecomicon.ico">
	</head>
	<body>
		<div class="container">
			<div class="header">
				<div class="header_left">
					<a href="#" class="logo_img"><img src="{{url('')}}/images/logo.png" alt="logo" /></a>
					<h1>{!!trans('lang.home_title')!!}</h1>
				</div>
				<div class="header_right">
					<div class="header_language right">
						<a href="/set_locale/cn" class="language @if($locale != "en") active @endif">中文</a> | 
						<a href="/set_locale/en" class="language @if($locale == "en") active @endif">ENG</a>
					</div>
					<div class="header_user">
						<img src="{{url('')}}/images/userlogo.png" alt="logo" class="userlogo" />
						<span class="username">王经理（经销商)</span>
						<a href="#!message" class="emailblock">
							<span class="positionrelative">
								<img src="{{url('')}}/images/email.png" alt="logo" class="email" />
								<i class="emailalarm"></i>
							</span>
						</a>
						<a href="#"><img src="{{url('')}}/images/power.png" alt="logo" class="power" /></a>
					</div>
				</div>	
			</div>
			<div class="container">
				<div class="sidebar" ng-controller="MainController">
					<a href="#!overview" class="nav" ng-class="{navselected: route_status == 'overview'}">
						<img src="{{url('')}}/images/overview.png" alt="overview" />
						<span class="navtext">{!!trans('lang.label_overview')!!}</span>
					</a>
					<a href="#!product" class="nav" ng-class="{navselected: route_status == 'product'}">
						<img src="{{url('')}}/images/product.png" alt="product" />
						<span class="navtext">{!!trans('lang.label_product')!!}</span>
					</a>
					<a href="#!order" class="nav" ng-class="{navselected: route_status == 'order'}">
						<img src="{{url('')}}/images/order.png" alt="order" />
						<span class="navtext">{!!trans('lang.label_order')!!}</span>
					</a>
					<a href="#!sales" class="nav" ng-class="{navselected: route_status == 'sale'}">
						<img src="{{url('')}}/images/sales.png" alt="sales" />
						<span class="navtext">{!!trans('lang.label_sale')!!}</span>
					</a>
					<a href="#!stock" class="nav" ng-class="{navselected: route_status == 'stock'}">
						<img src="{{url('')}}/images/stock.png" alt="stock" />
						<span class="navtext">{!!trans('lang.label_stock')!!}</span>
					</a>
					<a href="#!statistics/dealer" class="nav" ng-class="{navselected: route_status == 'statistics'}">
						<img src="{{url('')}}/images/statistics.png" alt="statistics" />
						<span class="navtext">{!!trans('lang.label_statistic')!!}</span>
					</a>
					<a href="#!user/client" class="nav" ng-class="{navselected: route_status == 'user'}">
						<img src="{{url('')}}/images/userlogo.png" alt="user" />
						<span class="navtext">{!!trans('lang.label_user')!!}</span>
					</a>
				</div>
				<div class="content">
					<div ng-view></div>				
					<!--@yield('content') -->
				</div>
				<div class="clearboth"></div>
			</div>
			<div class="footer">
			</div>			
		</div>		
	</body>
	@yield('javascript_part')
	<!-- dingding api javascript files -->
	<script type="text/javascript" src="//g.alicdn.com/dingding/dingtalk-pc-api/2.5.0/index.js"></script>
	<script type="text/javascript">var _config = <?php echo dingAuth::getConfig();?></script>
	<script type="text/javascript" src="{{url('')}}/js/ding_api_pc.js"></script>
</html>