<!--<div class="main_top bg_white">
	<div class="row nomargin overview_news_panel height172 bg3cf">
		<span class="overview_news_label">秋季销售红包奖励活动已开始</span>
	</div>
</div>-->
<div class="main_top overview_statistics bg_white border-bot-1-EEE">
	<div class="row nomargin">
		<table class="overview_time_type" border="1">
			<tr>
				<td ng-class="{active:search.type==1}">
					<a onclick="$('.weekpicker').trigger('click');">@lang('lang.ov_period_week_m')</a>
					<a class="weekpicker"></a>
					<a class="monthpicker"></a>
					<a class="quaterpicker"></a>
					<a class="yearpicker"></a>
					<a class="dayspicker"></a>
				</td>
				<td ng-class="{active:search.type==2}">
					<a onclick="$('.monthpicker').trigger('click');">@lang('lang.ov_period_month_m')</a>
				</td>
				<td ng-class="{active:search.type==3}">
					<a onclick="$('.quaterpicker').trigger('click');">@lang('lang.ov_period_season_m')</a>
				</td>
				<td ng-class="{active:search.type==4}">
					<a onclick="$('.yearpicker').trigger('click');">@lang('lang.ov_period_year_m')</a>
				</td>
				<td ng-class="{active:search.type==5}">
					<a ng-click="show_custom_period()">@lang('lang.ov_period_custom_m')</a>
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

<div class="col-xs-10 col-xs-offset-1 text-center margintop20 overview_bestseller" style="display: none;">
	@lang('lang.ov_yesterday_gold_sale')：{?yes_top_seller.name?}（{?yes_top_seller.dealer.name?}）</div>
<div class="clearfix"></div>

<div class="row bg_white nomargin margintop20 border-top-1-EEE border-bot-1-EEE">
	<h1 class="overview_menu_label color_blue">@lang('lang.ov_manage_card')</h1>
	<table class="overview_menu text-center table-fixed">
		<tr>
			<td class="active">
				<a href="#!activation/active">
					<span class="menu_icon menu_bg_39f"><img class="" src="./images/m_activation.png"></span><br>
					@lang('lang.activation')
				</a>
			</td>
			<td>
				<a href="#!register">
					<span class="menu_icon menu_bg_33c"><img class="" src="./images/m_register.png"></span><br>
					@lang('lang.register')
				</a>
			</td>
			<td>
				<a href="#!stock">
					<span class="menu_icon menu_bg_393"><img class="" src="./images/m_stock.png"></span><br>
					@lang('lang.label_stock')
				</a>
			</td>
			<td>
				<span class="menu_icon"></span>
			</td>
		</tr>
	</table>
</div>
<div class="row bg_white nomargin margintop20 border-top-1-EEE border-bot-1-EEE">
	<h1 class="overview_menu_label color_c60">@lang('lang.ov_manage_sales')</h1>
	<table class="overview_menu text-center table-fixed">
		<tr>
			<td>
				<a href="#!sales/rank/product">
					<span class="menu_icon menu_bg_990"><img class="" src="./images/m_sales.png"></span><br>
					@lang('lang.label_sale_amount')
				</a>
			</td>
			<td>
				<!--<a href="#!/reward/user">-->
				<a href="#!/reward/office/list">
					<span class="menu_icon menu_bg_933"><img class="" src="./images/m_reward.png"></span><br>
					@lang('lang.label_reward')
				</a>
			</td>
			<td>
				<a href="#!/user/staff/detail/{{$user_id}}">
					<span class="menu_icon menu_bg_939"><img class="" src="./images/m_dealer.png"></span><br>
					@lang('lang.my_account')
				</a>
			</td>
			<td>
				<span class="menu_icon"></span>
			</td>
		</tr>
	</table>
</div>