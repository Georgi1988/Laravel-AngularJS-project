<div class="page-title clearfix">
	<div class="pull-left">
		<h1>@lang('lang.label_dealer')</h1>
		<small><a href="#!/stock" class="subtitle">< @lang('lang.pr_return')</a></small>
	</div>
</div>

<div class="conter-wrapper col-md-12">
	<div class="panel panel-primary">
		<div class="panel-body">
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
					<a type="button" class="btn btn-info btn-sm leftmargin5 userloadbtn">@lang('lang.u_import')</a>
					<a type="button" class="btn btn-info btn-sm leftmargin5" href="#!/user/dealer/edit/new/dealer/{?dealer.id?}" ng-show="dealer.detail_id == null">@lang('lang.label_add_dealer')</a>
					<a type="button" class="btn btn-info btn-sm leftmargin5" href="#!/user/dealer/edit/new/store/{?dealer.id?}">@lang('lang.label_add_store')</a>
					<a type="button" class="btn btn-info btn-sm leftmargin5" href="#!/user/new/{?dealer.id?}">@lang('lang.label_add_user')</a>
				</div>
			</div>

			<!-- success or error message -->
			<div class="clearfix"></div>
			<div class="alert alert-success alert-save-success paddingtop10">{? msg ?}</div>
			<div class="alert alert-danger alert-save-fail paddingtop10">
				<div class="row text-bold color_7d421e">{? err_msg ?}</div>
				<div class="row margin-lf-15 max-height-200-scroll-auto color_7d421e bordertop-1px-bdabab"></div>
				<div class="col-xs-12 text-left" ng-repeat="card_err_info in invalide_cards">{?card_err_info?}</div>
			</div>

			<div class="seperatorline"></div>
			
			<!-- Loading logo -->
			<div class="loading_page text-center view_loading" ng-show="!loaded">
				<img src="{{url('images/loading_now.gif')}}">
			</div>

			<div class="paddingtop30"></div>

			<!-- Delaer Information Panel -->
			<div class="row user_panel col-xs-6 bg_white left_info_table">
				<table class="table table-striped">
					<thead>
						<th colspan="2" style="padding: 0px;">
							<div class="row info_header margin0" style="margin: 0px;">
								<div class="col-xs-9 label_str text-left">@lang('lang.label_dealer_information')</div>
								<div class="col-xs-3 text-right">
									<a type="button" class="btn btn-warning btn-xs" ng-href="#!/user/dealer/edit/modify/{? (dealer.detail_id == null ? 'dealer' : 'store' )?}/{?dealer.id?}">
										&nbsp; @lang('lang.pr_item_edit') &nbsp; </a>
								</div>
							</div>
						</th>
					</thead>
					<tbody>
						<tr ng-show="dealer.level == 1">
							<td>@lang('lang.corporation')</td>
							<td>{? dealer.corp_info.name ?}</td>
						</tr>
						<tr>
							<td>@lang('lang.label_dealer_code')</td>
							<td>{? dealer.code ?}</td>
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

			<!-- User Panel -->
			<div class="row user_panel col-xs-6 bg_white right_info_table">
				<table class="table table-striped">
					<thead>
						<th colspan="4" style="padding: 0px;">
							<div class="row info_header margin0" style="margin: 0px;">
								<div class="col-xs-9 label_str text-left">@lang('lang.label_staff')</div>
							</div>
						</th>
						</thead>
					<tbody>
						<tr ng-repeat="user in users">
							<td>{? user.name ?}</td>
							<td>{? user.role.name ?}</td>
							<td><i class="glyphicon glyphicon-phone" aria-hidden="true"></i>{?user.link?}</td>
							<td><a type="button" class="btn btn-info btn-xs" href="#!/user/staff/detail/{?user.id?}">@lang('lang.ov_details')</a></td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="clearfix"></div>

			<div class="seperatorline"></div>
			<div class="paddingtop30"></div>

			<!-- Dealer Panel -->
			<div class="block backgroundwhite" ng-show="dealer.detail_id == null">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>@lang('lang.sl_dealer_name')</th>
							<th>@lang('lang.u_office_level')</th>
							<th>@lang('lang.person_charge')</th>
							<th>@lang('lang.contact')</th>
							<th>@lang('lang.u_monthly_settlement_amount')（@lang('lang.label_cn_cunit')）</th>
							<th>@lang('lang.u_monthly_settlement_promotion')（@lang('lang.label_cn_cunit')）</th>
							<th>
								<div class="info_header margin0" style="margin: 0px;" ng-show="upper_dealer != null && upper_dealer.level >= login_dealer_level">
									<a type="button" class="btn btn-info btn-xs" ng-click="onChangeDealer(upper_dealer.id);">@lang('lang.label_up_dealer_information')</a>
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
							<td>
								<strong class="fontcolorred">{? lower_dealer.total_unbalance | floor ?}</strong>
							</td>
							<td>
								<strong class="fontcolorred">{? lower_dealer.total_promotion | floor ?}</strong>
							</td>
							<td>
								<a type="button" class="btn btn-info btn-xs" ng-click="onChangeDealer(lower_dealer.id);">@lang('lang.info')</a>
							</td>
							<td ng-if="login_dealer_id == 1">
								<a type="button" class="btn btn-default btn-xs stockservicedownload" ng-class="{'bgyellow': lower_dealer.total_unbalance != 0}" ng-click="onBalance(lower_dealer.id)" ng-show="lower_dealer.total_unbalance != 0">
									{? "@lang('lang.u_unsettlement')" ?}
								</a>
								<a type="button" class="btn btn-default btn-xs stockservicedownload" ng-class="{'bggray': lower_dealer.total_unbalance == 0}" ng-show="lower_dealer.total_unbalance == 0">
									{? "@lang('lang.u_settled')" ?}
								</a>
							</td>
						</tr>
						<tr ng-show="no_data" ng-if="login_dealer_id == 1">
							<td class="text-center" colspan="6">@lang('lang.str_no_data')</td>
						</tr>
						<tr ng-show="no_data" ng-if="login_dealer_id != 1">
							<td class="text-center" colspan="5">@lang('lang.str_no_data')</td>
						</tr>
					</tbody>
				</table>
				<div class="clearfix text-center" ng-show="lower_dealers.total > 0">
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
		</div>
	</div>
</div>

<!-- dialog html -->
<div id="userload" title="@lang('lang.u_import')">
	<form id="import_dealer_form" ng-submit="submit_import_dealer()" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
		<div class="block"></div>
		<div class="block width85">
			
			<div class="col-xs-3 paddingtop10 text-right">
				@lang('lang.ov_select_the_import_file')
			</div>
			<div class="col-xs-9">
				<div class="form-group">
					<input type="file" class="input-ghost" style="visibility:hidden; height:0" name="dealer_file" accept=".xlsx, .xls">
					<div class="input-group input-file" name="Fichier1">
						<input type="text" class="form-control" placeholder="@lang('lang.choose_file')" style="cursor: pointer;" required>
						<span class="input-group-addon">
							<a class="file_choose">@lang('lang.select')</a>
						</span>
					</div>
				</div>
				<span class="alert_required" ng-show="required_file">@lang('lang.field_required')</span>
				<script>
					$(function() {
						bs_input_file();
					});
				</script>
			</div>
			
			<!--<label>@lang('lang.ov_select_the_import_file') : <input type="file" name="dealer_file" accept=".xls,.xlsx" required /></label>-->
			<p class="textcenter lineheight200">@lang('lang.ov_alarm_dealerimport_msg')</p>
		</div>
		<div class="block textcenter">
			<button class="importbtn ui-button">@lang('lang.ov_import')</button>
			<a class="cancelbtn ui-button" ng-click="close_dlg_userload();" >@lang('lang.pr_item_cancel')</a>
		</div>
		<div class="block"></div>
	</form>
</div>

<script>
	login_dealer_id = {{$login_dealer_id}};
	login_dealer_level = {{$login_dealer_level}};
</script>

<script src="{{url('')}}/js/control.js"></script>