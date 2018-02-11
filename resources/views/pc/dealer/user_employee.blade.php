<div class="block">
	<span class="subtitle">@lang('lang.label_staff')</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</div>
<div class="name_panel bgdef text-center" style="padding: 0px;">
	<span class="dealer_name">{?dealer.name?}</span>
</div>

<div class="block">
	<div class="left">
		<input type="text" class="search_dealer_box" placeholder="@lang('lang.st_dealer_search')" ng-model="search.name" ng-blur="onSearch()">
		{{--<a class="periodselected period userloadbtn" ng-class="{'bgblue fontcolorwhite'}" ng-click="search_type(1)">--}}
		{{--@lang('lang.label_select_dealer')</a>--}}
	</div>
	<div class="right">
		<a class="periodselected period userloadbtn" ng-click="onChangeDealer(upper_dealer.id);" ng-if="upper_dealer_id != dealer.id">@lang('lang.label_up_dealer_information')</a>
		<a class="periodselected period userloadbtn" ng-click="onChangeDealer(login_dealer_id);" ng-if="upper_dealer_id == dealer.id">@lang('lang.label_self_dealer_information')</a>
	</div>
</div>

<div class="seperatorline"></div>
<div class="paddingtop30"></div>

<div class="loading_page text-center view_loading" ng-show="!loaded">
	<img src="{{url('images/loading_now.gif')}}">
</div>

<div class="row user_panel col-xs-6 bg_white left_info_table">
	<table class="table">
		<thead>
		<th colspan="2" style="padding: 0px;">
			<div class="row info_header margin0" style="margin: 0px;">
				<div class="col-xs-9 label_str" style="text-align: left;">@lang('lang.label_dealer_information')</div>
				<div class="col-xs-3 text-right">
					<a class="user_view_btn fontsize1_0" ng-show="login_dealer_id == dealer.id" ng-href="#!/user/dealer/edit/modify/{? (dealer.detail_id == null ? 'dealer' : 'store' )?}/{?dealer.id?}">
						@lang('lang.pr_item_edit')</a>
				</div>
			</div>
		</th>
		</thead>
		<tbody>
		<tr>
			<td>@lang('lang.corporation')</td>
			<td>{? dealer.corp_info.name ?}</td>
		</tr>
		<tr ng-show="dealer.level != 0">
			<td>@lang('lang.level')</td>
			<td>
				{?
					dealer.level==1 ? "@lang('lang.1st_level_dealer')" :
					dealer.level==2 ? "@lang('lang.2nd_level_dealer')" :
					dealer.level==3 ? "@lang('lang.3rd_level_dealer')" :
					dealer.level==4 ? "@lang('lang.4th_level_dealer')" :
					dealer.level==5 ? "@lang('lang.5th_level_dealer')" :
					dealer.level==6 ? "@lang('lang.6th_level_dealer')" :
					dealer.level==7 ? "@lang('lang.7th_level_dealer')" :
					dealer.level==8 ? "@lang('lang.8th_level_dealer')" :
					dealer.level==9 ? "@lang('lang.9th_level_dealer')" :
					dealer.level==10 ? "@lang('lang.10th_level_dealer')" :
					dealer.level==11 ? "@lang('lang.11th_level_dealer')" :
					dealer.level==12 ? "@lang('lang.12th_level_dealer')" :
					dealer.level==13 ? "@lang('lang.13th_level_dealer')" :
					dealer.level==14 ? "@lang('lang.14th_level_dealer')" :
					dealer.level==15 ? "@lang('lang.15th_level_dealer')" :
					dealer.level==16 ? "@lang('lang.16th_level_dealer')" :
					dealer.level==17 ? "@lang('lang.17th_level_dealer')" :
					dealer.level==18 ? "@lang('lang.18th_level_dealer')" :
					dealer.level==19 ? "@lang('lang.19th_level_dealer')" :
					"@lang('lang.20th_level_dealer')"
				?}
			</td>
		</tr>
		<tr>
			<td>@lang('lang.address')</td>
			<td>{? dealer.address ?}</td>
		</tr>
		<tr>
			<td>@lang('lang.contact')</td>
			<td>{? dealer.link ?}</td>
		</tr>
		<tr>
			<td>@lang('lang.person_charge')</td>
			<td>{? dealer.president.name ?}</td>
		</tr>
		<tr>
			<td>@lang('lang.person_charge_link')</td>
			<td><i class="glyphicon glyphicon-phone" aria-hidden="true"></i>{?dealer.president.link?}</td>
		</tr>
		<tr>
			<td>@lang('lang.dingding_account')</td>
			<td>{? dealer.dd_account ?}</td>
		</tr>
		</tbody>
	</table>
</div>

<div class="row user_panel col-xs-6 bg_white right_info_table">
	<table class="table">
		<thead>
		<th colspan="4" style="padding: 0px;">
			<div class="row info_header margin0" style="margin: 0px;">
				<div class="col-xs-9 label_str" style="text-align: left;">@lang('lang.label_staff')</div>
			</div>
		</th>
		</thead>
		<tbody>
		<tr ng-repeat="user in users">
			<td>{? user.name ?}</td>
			<td>{? user.role.name ?}</td>
			<td><i class="glyphicon glyphicon-phone" aria-hidden="true"></i>{?user.link?}</td>
			<td><a href="#!/user/staff/detail/{?user.id?}" class="user_view_btn">@lang('lang.ov_details')</a></td>
		</tr>
		</tbody>
	</table>
</div>

<div class="clearfix"></div>

<div class="seperatorline"></div>
<div class="paddingtop30"></div>
<div class="block backgroundwhite" ng-show="dealer.detail_id == null && upper_dealer_id != dealer.id">
	<table class="table">
		<thead>
		<tr>
			<th>@lang('lang.sl_dealer_name')</th>
			<th>@lang('lang.u_office_level')</th>
			<th>@lang('lang.person_charge')</th>
			<th>@lang('lang.contact')</th>
			<th ng-if="login_dealer_id == 1">@lang('lang.u_monthly_settlement_amount')(@lang('lang.label_cn_cunit'))</th>
			<th>
				<div class="info_header margin0" style="margin: 0px;" ng-show="upper_dealer.id != null && upper_dealer.level >= login_dealer_level">
					<a class="user_view_btn fontsize1_0" ng-click="onChangeDealer(upper_dealer.id);">@lang('lang.label_up_dealer_information')</a>
				</div>
			</th>
			<th ng-if="login_dealer_id == 1">
			</th>
		</tr>
		</thead>
		<tbody>
		<tr ng-repeat="lower_dealer in lower_dealers.data">
			<td>{? lower_dealer.name ?}</td>
			<td>
				{?
					lower_dealer.level==1 ? "@lang('lang.1st_level_dealer')" :
					lower_dealer.level==2 ? "@lang('lang.2nd_level_dealer')" :
					lower_dealer.level==3 ? "@lang('lang.3rd_level_dealer')" :
					lower_dealer.level==4 ? "@lang('lang.4th_level_dealer')" :
					lower_dealer.level==5 ? "@lang('lang.5th_level_dealer')" :
					lower_dealer.level==6 ? "@lang('lang.6th_level_dealer')" :
					lower_dealer.level==7 ? "@lang('lang.7th_level_dealer')" :
					lower_dealer.level==8 ? "@lang('lang.8th_level_dealer')" :
					lower_dealer.level==9 ? "@lang('lang.9th_level_dealer')" :
					lower_dealer.level==10 ? "@lang('lang.10th_level_dealer')" :
					lower_dealer.level==11 ? "@lang('lang.11th_level_dealer')" :
					lower_dealer.level==12 ? "@lang('lang.12th_level_dealer')" :
					lower_dealer.level==13 ? "@lang('lang.13th_level_dealer')" :
					lower_dealer.level==14 ? "@lang('lang.14th_level_dealer')" :
					lower_dealer.level==15 ? "@lang('lang.15th_level_dealer')" :
					lower_dealer.level==16 ? "@lang('lang.16th_level_dealer')" :
					lower_dealer.level==17 ? "@lang('lang.17th_level_dealer')" :
					lower_dealer.level==18 ? "@lang('lang.18th_level_dealer')" :
					lower_dealer.level==19 ? "@lang('lang.19th_level_dealer')" :
					"@lang('lang.20th_level_dealer')"
				?}
			</td>
			<td>{? lower_dealer.manager_name ?}</td>
			<td>{? lower_dealer.link ?}</td>
			<td ng-if="login_dealer_id == 1"><strong class="fontcolorred">{? lower_dealer.total_unbalance ?}</strong></td>
			<td>
				<a ng-click="onChangeDealer(lower_dealer.id);">@lang('lang.info')</a>
			</td>
			<td ng-if="login_dealer_id == 1">
				<a class="stockservicebtn stockservicedownload" ng-class="{'bgyellow': lower_dealer.total_unbalance != 0}" ng-click="onBalance(lower_dealer.id)" ng-show="lower_dealer.total_unbalance != 0">
					{? "@lang('lang.u_unsettlement')" ?}
				</a>
				<a class="stockservicebtn stockservicedownload" ng-class="{'bggray': lower_dealer.total_unbalance == 0}" ng-show="lower_dealer.total_unbalance == 0">
					{? "@lang('lang.u_settled')" ?}
				</a>
			</td>
		</tr>
		<tr ng-show="no_data" ng-if="login_dealer_id == 1">
			<td colspan="7">@lang('lang.str_no_data')</td>
		</tr>
		<tr ng-show="no_data" ng-if="login_dealer_id != 1">
			<td colspan="4">@lang('lang.str_no_data')</td>
		</tr>
		</tbody>
	</table>
	<div class="pagenav_block" ng-show="lower_dealers.total > 0">
		<span class="pageinfo">@lang('lang.di') {?lower_dealers.from?} - {?lower_dealers.to?} @lang('lang.tiao')， @lang('lang.total') {?lower_dealers.total?} @lang('lang.tiao')</span>
		<ul class="pagination">
			<li ng-class="{disabled:pagenation.currentPage === 1}">
				<a ng-click="setPage(1)">&lt;&lt;</a>
			</li>
			<li ng-class="{disabled:pagenation.currentPage === 1}">
				<a ng-click="setPage(pagenation.currentPage - 1)">&lt;</a>
			</li>
			<li ng-repeat="page in pagenation.pages" ng-class="{active:pagenation.currentPage === page}">
				<a ng-click="setPage(page)">{?page?}</a>
			</li>
			<li ng-class="{disabled:pagenation.currentPage === pagenation.totalPages}">
				<a ng-click="setPage(pagenation.currentPage + 1)">&gt;</a>
			</li>
			<li ng-class="{disabled:pagenation.currentPage === pagenation.totalPages}">
				<a ng-click="setPage(pagenation.totalPages)">&gt;&gt;</a>
			</li>
		</ul>
	</div>
</div>
<div class="block"></div>

<script>
    login_dealer_id = {{$login_dealer_id}};
    login_dealer_level = {{$login_dealer_level}};
    upper_dealer_id = {{$upper_dealer_id}};
</script>

<script src="{{url('')}}/js/control.js"></script>

