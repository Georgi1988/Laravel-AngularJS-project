<div class="user_v_content" style="display:none; font-size: 12px;">
	<div class="name_panel bgdef">
		<div class="row fontsize1_5 margin0 text-center paddingtop20 padding-lf-8 color_39f">
			{? user.name ?} - {? user.role.name ?}
		</div>
		<div class="row margin0 paddingtop10">
			<div class="col-xs-12 text-muted">{? user.dealer.structure_name ?}</div>
		</div>
	</div>
	<div class="info_panel bg_white">
		<div class="row info_header margin0">
			<div class="col-xs-9 label_str">@lang('lang.info')</div>
			<div class="col-xs-3 text-right">
				<a class="user_view_btn fontsize1_0" ng-href="#!/user/staff/edit/{?user.id?}" class="edit_btn fontsize0_9">@lang('lang.pr_item_edit')</a>
			</div>
		</div>
		<div class="row margin0 paddingtop10">
			<div class="col-xs-3 label_col text-right nopadding">@lang('lang.name')</div>
			<div class="col-xs-9">{? user.name ?}</div>
		</div>
		<div class="row margin0 paddingtop10">
			<div class="col-xs-3 label_col text-right nopadding">@lang('lang.position')</div>
			<div class="col-xs-9">{? user.role.name ?}</div>
		</div>
		<div class="row margin0 paddingtop10">
			<div class="col-xs-3 label_col text-right nopadding">@lang('lang.contact')</div>
			<div class="col-xs-9"><i class="glyphicon glyphicon-phone" aria-hidden="true"></i>{? user.link ?}</div>
		</div>
		<div class="row margin0 paddingtop10">
			<div class="col-xs-3 label_col text-right nopadding">@lang('lang.email')</div>
			<div class="col-xs-9">{? user.email ?}</div>
		</div>
		<div class="row margin0 paddingtop10">
			<div class="col-xs-3 label_col text-right nopadding">@lang('lang.dingding_account')</div>
			<div class="col-xs-9">{? user.dd_account ?}</div>
		</div>
	</div>
</div>
	
<div class="loading_page text-center view_loading" ng-show="!loaded">
	<img src="{{url('images/loading_now.gif')}}">
</div>