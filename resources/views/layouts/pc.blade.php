<!doctype html>
<html lang="{{ app()->getLocale() }}" ng-app="dingdingApp">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@lang('lang.home_title')</title>
        <!-- Styles -->
		@yield('style_part')
		<link rel="shortcut icon" href="images/dellecomicon.ico">        
    </head>

    <body class="startbg">
		<div class="body_container">
			<div class="header container">
				<div class="header_container">
					<div class="header_left">
						<a href="#" class="logo_img"><img src="{{url('')}}/images/logo.png" alt="logo" /></a>
						<h1>@lang('lang.home_title')</h1>
					</div>
					<div class="header_right">
						<div class="header_user">
							<a href="#!/user/staff/detail/{{$user_info->id}}">
								<img src="{{url('')}}/images/userlogo.png" alt="logo" class="userlogo" />
								<span class="username">

								@if ($dealer_info !== null)
									{{$user_info->name}} &nbsp;

									@if($dealer_info->level == 0)
										( @lang('lang.admin_level_dealer') )
									@elseif($dealer_info->level == 1)
										( @lang('lang.1st_level_dealer') )
									@elseif($dealer_info->level == 2)
										( @lang('lang.2nd_level_dealer') )
									@elseif($dealer_info->level == 3)
										( @lang('lang.3rd_level_dealer') )
									@elseif($dealer_info->level == 4)
										( @lang('lang.4th_level_dealer') )
									@elseif($dealer_info->level == 5)
										( @lang('lang.5th_level_dealer') )
									@elseif($dealer_info->level == 6)
										( @lang('lang.6th_level_dealer') )
									@elseif($dealer_info->level == 7)
										( @lang('lang.7th_level_dealer') )
									@elseif($dealer_info->level == 8)
										( @lang('lang.8th_level_dealer') )
									@elseif($dealer_info->level == 9)
										( @lang('lang.9th_level_dealer') )
									@elseif($dealer_info->level == 10)
										( @lang('lang.10th_level_dealer') )
									@elseif($dealer_info->level == 11)
										( @lang('lang.11th_level_dealer') )
									@elseif($dealer_info->level == 12)
										( @lang('lang.12th_level_dealer') )
									@elseif($dealer_info->level == 13)
										( @lang('lang.13th_level_dealer') )
									@elseif($dealer_info->level == 14)
										( @lang('lang.14th_level_dealer') )
									@elseif($dealer_info->level == 15)
										( @lang('lang.15th_level_dealer') )
									@elseif($dealer_info->level == 16)
										( @lang('lang.16th_level_dealer') )
									@elseif($dealer_info->level == 17)
										( @lang('lang.17th_level_dealer') )
									@elseif($dealer_info->level == 18)
										( @lang('lang.18th_level_dealer') )
									@elseif($dealer_info->level == 19)
										( @lang('lang.19th_level_dealer') )
									@elseif($dealer_info->level == 20)
										( @lang('lang.20th_level_dealer') )
									@endif
								@endif
								</span>
							</a>
							<a href="#!message" class="emailblock">
							<span class="positionrelative">
								<img src="{{url('')}}/images/email.png" alt="logo" class="email" />
								<i class="emailalarm"></i>
							</span>
							</a>
							<a href="#!setting"><img src="{{url('')}}/images/setting.png" alt="setting" class="setting" /></a>
							<a href="#"><img src="{{url('')}}/images/power.png" alt="logo" class="power" /></a>
						</div>
						<div class="header_language right">
							<a href="/set_locale/cn" class="language @if($locale != "cn") active @endif">中文</a> |
							<a href="/set_locale/en" class="language @if($locale != "en") active @endif">ENG</a>
						</div>
					</div>
				</div>

			</div>
			<div class="header_tab">
				<ul>
					<li>
						<a href="#!overview" class="nav nav-tab-menu" ng-class="{navselected: route_status == 'overview'}">
							<img src="{{url('')}}/images/overview.svg" alt="overview" />
							<div class="navtext">@lang('lang.label_overview')</div>
						</a>
					</li>
					<li>
						<a id="product" href="#!product" class="nav nav-tab-menu nav-tab-menubadge_menu" ng-class="{navselected: route_status == 'product'}" >
							<img src="{{url('')}}/images/product.png" alt="product" />
							<div class="navtext">@lang('lang.label_product')</div>
						</a>
					</li>
					<li>
						<a href="#!price" class="nav nav-tab-menu" ng-class="{navselected: route_status == 'price'}">
							<img src="{{url('')}}/images/price.png" alt="price" />
							<div class="navtext">@lang('lang.price_label')</div>
						</a>
					</li>
					@if($user_priv == 'admin')
					<li>
						<a href="#!register/card/agree" class="nav nav-tab-menu" ng-class="{navselected: route_status == 'register'}">
							<img src="{{url('')}}/images/register.png" alt="" />
							<div class="navtext">@lang('lang.register')</div>
						</a>
					</li>
					@endif
					<li>
						<a href="#!stock" class="nav nav-tab-menu" ng-class="{navselected: route_status == 'stock'}">
							<img src="{{url('')}}/images/stock.png" alt="stock" />
							<div class="navtext">@lang('lang.label_stock')</div>
						</a>
					</li>
					<li>
					@if($user_priv == 'admin')
						<a href="#!generate" class="nav nav-tab-menu" ng-class="{navselected: route_status == 'generate'}">
							<img src="{{url('')}}/images/purchase.png" alt="purchase" />
							<div class="navtext">@lang('lang.label_generate')</div>
						</a>
					@elseif($user_priv == 'dealer')
						<a href="#!purchase" class="nav nav-tab-menu" ng-class="{navselected: route_status == 'purchase'}">
							<img src="{{url('')}}/images/purchase.png" alt="purchase" />
							<div class="navtext">@lang('lang.purchase')</div>
						</a>
					@endif
					</li>
					<li>
						<a id="order" href="#!order" class="nav nav-tab-menu nav-tab-menubadge_menu" ng-class="{navselected: route_status == 'order'}" >
							<img src="{{url('')}}/images/order.png" alt="order" />
							<div class="navtext">@lang('lang.label_order')</div>
						</a>
					</li>
					<li>
						<a href="#!sales" class="nav nav-tab-menu" ng-class="{navselected: route_status == 'sales'}">
							<img src="{{url('')}}/images/sales.png" alt="sales" />
							<div class="navtext">@lang('lang.label_sale')</div>
						</a>
					</li>
					<li>
						<a href="#!reward/office/list" class="nav nav-tab-menu" ng-class="{navselected: route_status == 'reward'}">
							<img src="{{url('')}}/images/reward.svg" alt="reward" />
							<div class="navtext">@lang('lang.label_reward')</div>
						</a>
					</li>
					<li>
						@if($user_priv == 'admin')
							<a href="#!user/dealer/{{$dealer_info->id}}" class="nav nav-tab-menu" ng-class="{navselected: route_status == 'user'}">
								<img src="{{url('')}}/images/userlogo.png" alt="Dealer" />
								<div class="navtext">@lang('lang.label_dealer')</div>
							</a>
						@elseif($user_priv == 'dealer')
							<a href="#!user/employee/{{$dealer_info->id}}" class="nav nav-tab-menu" ng-class="{navselected: route_status == 'user'}">
								<img src="{{url('')}}/images/userlogo.png" alt="Employee" />
								<div class="navtext">@lang('lang.label_staff')</div>
							</a>
						@endif
					</li>

					@if($user_priv == 'admin')

					<li>
						<a href="#!log" class="nav nav-tab-menu" ng-class="{navselected: route_status == 'log'}">
							<img src="{{url('')}}/images/log.png" alt="log" />
							<div class="navtext">@lang('lang.label_log')</div>
						</a>
					</li>
					@endif

				</ul>
			</div>

			<div class="conter-wrapper">
				<div ng-view></div>
				<!--@yield('content') -->
			</div>
			<div class="clearboth"></div>
			<div class="footer">
			</div>	
		</div>
    </body>
	<!-- dingding api javascript files -->
	<script type="text/javascript" src="//g.alicdn.com/dingding/dingtalk-pc-api/2.5.0/index.js"></script>
	<script type="text/javascript">var _config = <?php echo dingAuth::getConfig();?></script>
	@yield('javascript_part')
</html>
