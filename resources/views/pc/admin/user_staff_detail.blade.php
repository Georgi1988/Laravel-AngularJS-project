<div class="user_v_content" ng-show="loaded">
	<div class="block">
		<div class="left ">
			<a onclick="history.back(); return false;" class="subtitle">< @lang('lang.pr_return')</a>
		</div>
		<div class="clearboth"></div>
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
						<div class="col-xs-9 label_str" style="text-align: left;">@lang('lang.label_user_information')</div>
						<div class="col-xs-3 text-right">
							<a class="user_view_btn fontsize1_0" ng-href="#!/user/staff/edit/{?user.id?}" class="edit_btn fontsize0_9">@lang('lang.pr_item_edit')</a>
						</div>
					</div>
				</th>
			</thead>
			<tbody>
				<tr>
					<td>@lang('lang.name')</td>
					<td>{? user.name ?}</td>
				</tr>
				<tr>
					<td>@lang('lang.label_affiliation_name')</td>
					<td>{? user.dealer.structure_name ?}</td>
				</tr>
				<tr>
					<td>@lang('lang.position')</td>
					<td>{? user.role.name ?}</td>
				</tr>
				<tr>
					<td>@lang('lang.contact')</td>
					<td><i class="glyphicon glyphicon-phone" aria-hidden="true"></i>{? user.link ?}</td>
				</tr>
				<tr>
					<td>@lang('lang.email')</td>
					<td>{? user.email ?}</td>
				</tr>
				<tr>
					<td>@lang('lang.dingding_account')</td>
					<td>{? user.dd_account ?}</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
	
<div class="loading_page text-center view_loading" ng-show="!loaded">
	<img src="{{url('images/loading_now.gif')}}">
</div>