<div class="prod_v_content" style="display:none">
	<form id="editForm" ng-submit="form_submit(this)" method="post" enctype="multipart/form-data">
		<input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
		<input type="hidden" ng-model="product_id" value="{?product.id?}">
		
		<div class="prod_v_thumb text-center">
			<img class="img-rounded img_preview" src="{?product.image_url?}" >
			<div class="img_upload">
				<label>
					@lang('lang.upload card logo image')
					<input type="file" name="image_file" onchange="angular.element(this).scope().change_image(this)"></label>
				</label>
			</div>
		</div>
		<div class="col-xs-offset-3 alert_required" ng-show="required_image">@lang('lang.field_required')</div>
		
		
		<div class="info">
			<div class="type col-xs-3 padding-lf-7 paddingtop5 text-right">@lang('lang.define_name')</div>
			<div class="value col-xs-8 nopadding">
				<input type="text" class="form-control" name="product_name" value="{?product.name?}"  ng-readonly="product.id > 0" required />
				<div class="alert_required" ng-show="required_name">@lang('lang.field_required')</div>
			</div>
		</div>
		<div class="info">
			<div class="type col-xs-3 padding-lf-7 paddingtop5 text-right">@lang('lang.code')</div>
			<div class="value col-xs-8 nopadding">
				<input type="text" class="form-control" name="product_code" value="{?product.code?}" minlength="5" required />
				<div class="alert_required" ng-show="required_code">@lang('lang.field_required')</div>
			</div>
		</div>
		<div class="info">
			<div class="type col-xs-3 padding-lf-7 paddingtop5 text-right">@lang('lang.type')</div>
			<div class="value col-xs-8 nopadding">
				<select class="form-control" id="product_level1_id" name="product_level1_id" required>
					<option value="">-- @lang('lang.pr_class1_classification') --</option>
					<option ng-repeat="option in type_list.level1_type" value="{?option.id?}" ng-selected="option.id==product.level1_id">{?option.description?}</option>					
				</select>
				<div class="alert_required" ng-show="required_level1">@lang('lang.field_required')</div>
				<select class="form-control margintop10" id="product_level2_id" name="product_level2_id" required>
					<option value="">-- @lang('lang.pr_class2_classification') --</option>
					<option ng-repeat="option in type_list.level2_type" value="{?option.id?}" ng-selected="option.id==product.level2_id">{?option.description?}</option>					
				</select>
				<div class="alert_required" ng-show="required_level2">@lang('lang.field_required')</div>
				<select class="form-control margintop10" name="product_level3_id">
					<option value="">-- @lang('lang.pr_class3_classification') --</option>
					<option ng-repeat="option in type_list.level3_type" value="{?option.id?}" ng-selected="option.id==product.level3_id">{?option.description?}</option>					
				</select>
			</div>
		</div>
		<div class="info">
			<div class="type col-xs-3 padding-lf-7 paddingtop5 text-right">@lang('lang.state')</div>
			<div class="value col-xs-8 nopadding">		
				<input class="switch" type="checkbox" name="product_status" ng-checked="product.status">
			</div>
		</div>
		<div class="info">
			<div class="type col-xs-3 padding-lf-7 paddingtop5 text-right">@lang('lang.valid period')</div>
			<div class="value col-xs-8 nopadding">
				<select class="form-control" id="product_valid_period" name="product_valid_period" required>
					<option value=""></option>
					<option value="0" ng-selected="product.valid_period==0">@lang('lang.forever_valid_time')</option>
					<option value="1" ng-selected="product.valid_period==1">@lang('lang.number_1')@lang('lang.months')</option>
					<option value="3" ng-selected="product.valid_period==3">@lang('lang.number_3')@lang('lang.months')</option>
					<option value="6" ng-selected="product.valid_period==6">@lang('lang.Half')@lang('lang.year')</option>
					<option value="12" ng-selected="product.valid_period==12">@lang('lang.number_1')@lang('lang.year')</option>
					<option value="24" ng-selected="product.valid_period==24">@lang('lang.number_2')@lang('lang.years')</option>
					<option value="36" ng-selected="product.valid_period==36">@lang('lang.number_3')@lang('lang.years')</option>
				</select>
				<div class="alert_required" ng-show="required_valid_date">@lang('lang.field_required')</div>
			</div>
		</div>
		<div class="info">
			<div class="type col-xs-3 padding-lf-7 paddingtop5 text-right">@lang('lang.service_type')</div>
			<div class="value col-xs-8 nopadding">		
				<!--<input type="text" class="form-control width60 text-right" name="product_service_type" value="{? (product.service_type)? product.service_type: '' ?}" pattern="[0-9]+" minlength="3" maxlength="3" required />-->
				<select class="form-control" name="product_service_type">
					<option value=""></option>
					<option ng-repeat="item in type_list.dic.dic_service_type" value="{?item.value?}" ng-selected="item.value == product.service_type">{?item.description?}</option>
				</select>
				<div class="alert_required" ng-show="required_service_type">@lang('lang.field_required')</div>
			</div>
		</div>
		<div class="info">
			<div class="type col-xs-3 padding-lf-7 paddingtop5 text-right">@lang('lang.gen_card_rule')</div>
			<div class="value col-xs-8 nopadding">
				<select class="form-control" name="product_card_rule">
					<option value=""></option>
					<option ng-repeat="rule in type_list.rule" value="{?rule.id?}" ng-selected="rule.id == product.card_rule_id">{?rule.rule_name?}</option>
				</select>
				<div class="alert_required" ng-show="required_card_rule">@lang('lang.field_required_s')</div>
			</div>
		</div>
		<div class="info">
			<div class="type col-xs-3 padding-lf-7 paddingtop5 text-right">@lang('lang.cost_price')</div>
			<div class="value col-xs-8 nopadding">		
				<input type="number" min="1" class="form-control display-inlineblock width90 text-right" name="product_price_sku" value="{?product.price_sku?}" required /> @lang('lang.label_cn_cunit')
				<div class="alert_required" ng-show="required_price">@lang('lang.field_required')</div>
			</div>
		</div>
		<!--<div class="info">
			<div class="type col-xs-3 paddingtop5 text-right">@lang('lang.pr_standard_price_s')</div>
			<div class="value col-xs-8 nopadding">		
				<input type="number" class="form-control width60 text-right" name="product_standard_price" value="{?product.standard_price?}" min="1" required /> @lang('lang.label_cn_cunit')
			</div>
		</div>-->
		<div class="info">
			<div class="type col-xs-3 padding-lf-7 paddingtop5 text-right">@lang('lang.introduce_m')</div>
			<div class="value col-xs-8 nopadding">
				<textarea class="form-control" rows="6" name="product_description" required>{?product.description?}</textarea>
				<div class="alert_required" ng-show="required_description">@lang('lang.field_required')</div>
			</div>
		</div>
		<!-- for test -->
		<div class="submit_button">
			<input type="submit" id="save_submit_button" value="save">
		</div>
		<div class="clearfix"></div>
	</form>
	<div class="clearfix"></div>
	<script>
		/* setTimeout(function(){
			$("input[class='switch']").bootstrapSwitch({
				onText: "@lang('lang.use_on')",
				offText: "@lang('lang.use_off')",
			});
		}, 400); */
	</script>
</div>

<div id="save_result_dlg" class="reg_success_modal modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">@lang('lang.pr_notify_no_price')</h4>
			</div>
			<div class="modal-body">
				<p>@lang('lang.pr_notify_set_price?')</p>
			</div>
			<div class="modal-footer">
				<div class="col-xs-6 nopadding text-center">
					<button type="button" class="btn bg39f color_white generalbtn">@lang('lang.pr_set_price')</button>
				</div>
				<div class="col-xs-6 nopadding text-center">
					<button type="button" class="btn bg999 color_white cancelbtn" data-dismiss="modal">@lang('lang.pr_not_now')</button>
				</div>
			</div>
		</div>

	</div>
</div>