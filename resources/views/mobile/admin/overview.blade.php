<div class="main_top overview_statistics bg_white border-bot-1-EEE">
	<div class="row nomargin">
		<table class="overview_time_type" border="1">
			<tr>
				<td ng-class="{active:search.type==1}" style="width:20%">
					<a onclick="$('.weekpicker').trigger('click');">@lang('lang.ov_period_week_m')</a>
					<a class="weekpicker"></a>
					<a class="monthpicker"></a>
					<a class="quaterpicker"></a>
					<a class="yearpicker"></a>
					<a class="dayspicker"></a>
				</td>
				<td ng-class="{active:search.type==2}" style="width:20%">
					<a onclick="$('.monthpicker').trigger('click');">@lang('lang.ov_period_month_m')</a>
				</td>
				<td ng-class="{active:search.type==3}" style="width:20%">
					<a onclick="$('.quaterpicker').trigger('click');">@lang('lang.ov_period_season_m')</a>
				</td>
				<td ng-class="{active:search.type==4}" style="width:20%">
					<a onclick="$('.yearpicker').trigger('click');">@lang('lang.ov_period_year_m')</a>
				</td>
				<td ng-class="{active:search.type==5}" style="width:20%">
					<a ng-click="show_custom_period()" style="width:20%">@lang('lang.ov_period_custom_m')</a>
				</td>
			</tr>
		</table>
	</div>
	<div class="row nomargin margintop10 date_panel" ng-show="search.type==5">
		<div class="col-xs-6">
			<input type="text" name="searchdatestart" id="searchdatestart" class="width60 searchdatestart width120p" placeholder="@lang('lang.start date')" readonly ng-model="search.start_date" ng-change="search_date()" />
		</div>
		<div class="col-xs-6">
			<input type="text" name="searchdateend" id="searchdateend" class="width60 searchdateend width120p" placeholder="@lang('lang.end date')" readonly ng-model="search.end_date" ng-change="search_date()" />
		</div>
	</div>
	<div class="row nomargin margintop20">
		<div class="overview_item padding-lf-7 text-center col-xs-4">
			<div class="item item_stock">
				<div class="item_label">
					@lang('lang.ov_stock_cards')
				</div>
				<div class="item_value">
					&nbsp;<span id="period_available_count"></span>&nbsp;
				</div>
			</div>
		</div>
		<div class="overview_item padding-lf-7 text-center col-xs-4">
			<div class="item item_soon_ex">
				<div class="item_label">
					@lang('lang.ov_soon_expire_m')
				</div>
				<div class="item_value">
					&nbsp;<span id="period_soon_expired_count"></span>&nbsp;
				</div>
			</div>
		</div>
		<div class="overview_item padding-lf-7 text-center col-xs-4">
			<div class="item item_actived">
				<div class="item_label">
					@lang('lang.ov_expired')
				</div>
				<div class="item_value">
					&nbsp;<span id="period_expired_count"></span>&nbsp;
				</div>
			</div>
		</div>
	</div>
	<div class="row nomargin margintop20">
		<div class="overview_item padding-lf-7 text-center col-xs-4 col-xs-offset-2">
			<div class="item item_actived">
				<div class="item_label">
					@lang('lang.ov_activation')
				</div>
				<div class="item_value">
					&nbsp;<span id="period_activation_count"></span>&nbsp;
				</div>
			</div>
		</div>
		<div class="overview_item padding-lf-7 text-center col-xs-4">
			<div class="item item_stock">
				<div class="item_label">
					@lang('lang.ov_register')
				</div>
				<div class="item_value">
					&nbsp;<span id="period_register_count"></span>&nbsp;
				</div>
			</div>
		</div>
	</div>
	<div class="row nomargin margintop20">					
	</div>
</div>

<div class="row bg_white nomargin margintop20 border-top-1-EEE border-bot-1-EEE">
	<h1 class="overview_menu_label color_blue">@lang('lang.ov_manage_card')</h1>
	<table class="overview_menu text-center table-fixed">
		<tr>
			<td class="active badge_menu">
				<a href="#!product">
					<span class="menu_icon menu_bg_39f" id="product"><img class="" src="./images/m_product.png"></span><br>
					@lang('lang.pr_label')
				</a>
			</td>
			<td>
				<a href="#!price">
					<span class="menu_icon menu_bg_33c"><img class="" src="./images/m_price.png"></span><br>
					@lang('lang.price_pricing')
				</a>
			</td>
			<td>
				<a href="#!stock">
					<span class="menu_icon menu_bg_393"><img class="" src="./images/m_stock.png"></span><br>
					@lang('lang.label_stock')
				</a>
			</td>
			<td>
				<a href="#!generate">
					<span class="menu_icon menu_bg_066"><img class="" src="./images/m_generate.png"></span><br>
					@lang('lang.label_generate')
				</a>
			</td>
		</tr>
	</table>
</div>
<div class="row bg_white nomargin margintop20 border-top-1-EEE border-bot-1-EEE">
	<h1 class="overview_menu_label color_c60">@lang('lang.ov_manage_sales')</h1>
	<table class="overview_menu text-center table-fixed">
		<tr>
			<td class="active badge_menu">
				<a href="#!order">
					<span class="menu_icon menu_bg_c60" id="order"><img class="" src="./images/m_order.png"></span><br>
					@lang('lang.label_order')
				</a>
			</td>
			<td>
				<a href="#!sales/rank/product">
					<span class="menu_icon menu_bg_990"><img class="" src="./images/m_sales.png"></span><br>
					@lang('lang.label_sale_amount')
				</a>
			</td>
			<td>
				<a href="#!/reward/office/list">
					<span class="menu_icon menu_bg_933"><img class="" src="./images/m_reward.png"></span><br>
					@lang('lang.label_reward')
				</a>
			</td>
			<td>
				<a href="#!/user/dealer/{{$dealer_id}}">
					<span class="menu_icon menu_bg_939"><img class="" src="./images/m_dealer.png"></span><br>
					@lang('lang.label_dealer')
				</a>
			</td>
		</tr>
		<tr>
			<td class="active badge_menu">
				<a href="#!register/card/agree">
					<span class="menu_icon menu_bg_939" id="order"><img class="" src="./images/m_register.png"></span><br>
					@lang('lang.register')
				</a>
			</td>
			<td>
				<span class="menu_icon"></span>
			</td>
			<td>
				<span class="menu_icon"></span>
			</td>
			<td>
				<span class="menu_icon"></span>
			</td>
		</tr>
	</table>
</div>