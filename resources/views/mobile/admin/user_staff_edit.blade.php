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
		<form id="user_info_form" name="user_info_form" ng-submit="user_info_save()">
			<div class="row info_header margin0">
				<div class="col-xs-9 label_str">@lang('lang.info')</div>
				<div class="col-xs-3 text-right">
					<input type="submit" class="btn btn-primary edit_btn fontsize0_9" value="@lang('lang.pr_item_save')" ng-disabled="$scope.save_loading">
				</div>
				<div class="clearfix"></div>
				
				<!-- save result message -->
				<div class="alert alert-success" role="alert">
					@lang('lang.rg_success_save')
				</div>
				<div class="alert alert-danger" role="alert">
				</div>
			</div>
			<div class="row margin0 paddingtop10">
				<div class="col-xs-3 label_col text-right nopadding">@lang('lang.name')</div>
				<div class="col-xs-9">
					<input class="width100" name="user_name" ng-model="user.name" required minlength="2" >
					<p class="required_field" ng-show="form_require_name==true">@lang('lang.field_required')</p>
				</div>
			</div>
			<div class="row margin0 paddingtop10">
				<div class="col-xs-3 label_col text-right nopadding">@lang('lang.position')</div>
				<div class="col-xs-9">{? user.role.name ?}</div>
			</div>
			<div class="row margin0 paddingtop10">
				<div class="col-xs-3 label_col text-right nopadding">@lang('lang.contact')</div>
				<div class="col-xs-9">
					<input class="width100" type="text" name="user_link" ng-model="user.link" required pattern="(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})" >
					<p class="required_field" ng-show="form_require_phone==true">@lang('lang.field_required')</p>
				</div>
			</div>
			<div class="row margin0 paddingtop10">
				<div class="col-xs-3 label_col text-right nopadding">@lang('lang.email')</div>
				<div class="col-xs-9">
					<input class="width100" type="email" name="user_email" ng-model="user.email" required>
					<p class="required_field" ng-show="form_require_email==true">@lang('lang.field_required')</p>
				</div>
			</div>
			<div class="row margin0 paddingtop10">
				<div class="col-xs-3 label_col text-right nopadding">@lang('lang.dingding_account')</div>
				<div class="col-xs-9">{? user.dd_account ?}</div>
			</div>
		</form>
	</div>
	
	
</div>
	
<div class="loading_page text-center view_loading" ng-show="!loaded">
	<img src="{{url('images/loading_now.gif')}}">
</div>