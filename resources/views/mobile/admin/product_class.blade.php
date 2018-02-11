<div class="subheader bg_white">
	<div class="col-xs-4 nopadding text-center">
		<span class="item" ng-class="{active:search.type_level==1}">
			<a ng-click="search_level(1)">@lang('lang.pr_class1_classification_s')</a>
		</span>
	</div>
	<div class="col-xs-4 nopadding text-center">
		<span class="item" ng-class="{active:search.type_level==2}">
			<a ng-click="search_level(2)">@lang('lang.pr_class2_classification_s')</a>
		</span>	
	</div>
	<div class="col-xs-4 nopadding text-center">
		<span class="item" ng-class="{active:search.type_level==3}">
			<a ng-click="search_level(3)">@lang('lang.pr_class3_classification_s')</a>
		</span>	
	</div>
</div>
<div class="prod_v_content">
	<div class="col-xs-6 kind paddingtop20" ng-repeat = "item in items">
		<!--<a class="item active" data-toggle="modal" data-target=".reg_success_modal">-->
		<a class="item" ng-class="{active:item_edit_id==item.id}" ng-click="open_edit_dialog(item.id)">
			{?item.description?}
		</a>
	</div>
	<div class="nodata" ng-show="no_data">@lang('lang.str_no_data')</div>
	<div class="col-xs-12 item text-center nopadding margin0" ng-show="busy"><img src="./images/loading.gif" style="width: 15px; height: 15px;"> @lang('lang.now_loading')...</div>
	
	<div class="reg_success_modal reg_modal_input modal fade" role="dialog">
		<div class="modal-dialog width90">
			<!-- Modal content-->
			<div class="modal-content ">
				<div class="modal-body">
					<form ng-submit="save_class()" method="post" enctype="multipart/form-data">
						<p class="fontsize1_3 paddingtop10 paddingbot10 txt_bold">@lang('lang.pr_enter_type_name')：</p>
						<div class="row nopadidng text-center">
							<select ng-model="item_info_edit.level" ng-options="item.id as item.description for item in type_level" class="edit_field width90 paddingtop5 paddingbot5" ng-disabled="item_info_edit.id" required>
								<option value="" ng-selected="selected"></option>
							</select>
						</div>
						<div class="row nopadidng paddingtop20 text-center">
							<input class="edit_field paddingtop5 paddingbot5 fontsize1_2 width90 text-left" ng-model="item_info_edit.description" minlength="1" required >
						</div>
						<div class="alert marginbot5 margintop10 alert-success" style="display: none;">
							@lang('lang.rg_success_save')
						</div>
						<div class="alert marginbot5 margintop10 alert-danger" style="display: none;">
							@lang('lang.rg_fail_save')
						</div>
						<div class="row nopadidng paddingtop20 text-center">
							<div class="col-xs-6">
								<button type="submit" class="btn bg39f width80 color_white">@lang('lang.pr_item_save')<span class="loading_icons" ng-show="ajax_loading">&nbsp;&nbsp;<img src="./images/loading_now.gif"></span></button>
							</div>
							<div class="col-xs-6">
								<button type="button" class="btn bg999 width80 color_white" ng-click="close_edit_dialog()">@lang('lang.cancel')</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
</div>