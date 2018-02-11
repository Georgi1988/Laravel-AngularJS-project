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
		<form id="user_info_form" name="user_info_form" ng-submit="user_info_save()" style="font-size: 13px;">
			<div class="row info_header margin0">
				<div class="col-xs-10 label_str">@lang('lang.label_user_information')</div>
				<div class="col-xs-2 text-center">
					<input type="submit" class="user_view_btn fontsize1_0"  style="padding: 4px 12px;" value="@lang('lang.pr_item_save')" ng-disabled="$scope.save_loading">
				</div>
			</div>
			<!-- save result message -->
			<div class="alert alert-success" role="alert">
				@lang('lang.rg_success_save')
			</div>
			<div class="alert alert-danger" role="alert">
			</div>
			<div class="clearfix"></div>
			<div class="row">
				<div class="col-xs-11 paddingtop10">
					<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.name')</div>
					<div class="col-xs-8"><input class="form-control width100 organ_ctrl_size" type="text" name="user_name" ng-model="user.name" required minlength="2"></div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-11 paddingtop10">
					<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.label_affiliation_name')</div>
					<div class="col-xs-8 organ_static_size">{? user.dealer.structure_name ?}</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-11 paddingtop10">
					<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.position')</div>
					<div class="col-xs-8 organ_static_size">{? user.role.name ?}</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-11 paddingtop10">
					<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.label_user_link')</div>
					<div class="col-xs-8">
						<input class="form-control width100 organ_ctrl_size" type="text" name="user_link" ng-model="user.link" required pattern="(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-11 paddingtop10">
					<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.email')</div>
					<div class="col-xs-8"><input class="form-control width100 organ_ctrl_size" type="email" name="user_email" ng-model="user.email" required></div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-11 paddingtop10">
					<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.dingding_account')</div>
					<div class="col-xs-8 organ_static_size">{? user.dd_account ?}</div>
				</div>
			</div>
		</form>
	</div>
</div>

<div class="loading_page text-center view_loading" ng-show="!loaded">
	<img src="{{url('images/loading_now.gif')}}">
</div>

