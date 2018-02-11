<div class="page-title clearfix">
	<div class="pull-left">
		<h1>@lang('lang.pr_service_card_information')</h1>
		<small><a href="#!/product" class="subtitle">< @lang('lang.pr_return')</a></small>
	</div>
</div>

<div class="conter-wrapper col-lg-8 col-md-12" ng-show="loaded">
	<div class="panel panel-info">
		<div class="panel-body">
			<form id="editForm" class="paddingtop15" ng-submit="form_submit(this)" method="post" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{ csrf_token() }}" />
				<input type="hidden" ng-model="product_id" value="{?product.id?}" />

				<div class="form-group col-md-6">
					<div class="col-md-12">
						<label for="productImage">@lang('lang.label_table_image')</label>
						<img class="img-responsive img-thumbnail" id="productImage" style="width:100%" src="{?product.image_url?}">
					</div>	
					<div class="product_upload_logo col-md-12">
						<label>
							@lang('lang.upload card logo image')
							<input type="file" name="image_file" onchange="angular.element(this).scope().change_image(this)" accept="image/jpeg,image/x-png" />
						</label>
					</div>
					<div class="text-left alert_required" ng-show="required_image">@lang('lang.field_required')</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>@lang('lang.pr_item_name')</label>
						<input type="text" class="form-control" name="product_name" ng-model="product.name" ng-readonly="product.id > 0" minlength="3" requiredeqtrue />
						<span class="alert_required" ng-show="required_name">@lang('lang.field_required')</span>
					</div>
					<div class="form-group">
						<label>@lang('lang.ov_product_code')</label>
						<input type="text" class="form-control" name="product_code" value="{?product.code?}" minlength="5" requiredeqtrue />
						<span class="alert_required" ng-show="required_code">@lang('lang.field_required')</span>
					</div>
					<div class="form-group">
						<label>@lang('lang.pr_item_kind')</label>
						<select class="form-control" name="product_level1_id" requiredeqtrue>
							<option value="">- @lang('lang.pr_class1_classification') -</option>
							<option ng-repeat="option in type_list.level1_type" value="{?option.id?}" ng-selected="option.id==product.level1_id">{?option.description?}</option>
						</select>
						<div class="alert_required" ng-show="required_level1">@lang('lang.field_required_s')</div>
						<br>
						<select class="form-control" name="product_level2_id" requiredeqtrue>
							<option value="">- @lang('lang.pr_class2_classification') -</option>
							<option ng-repeat="option in type_list.level2_type" value="{?option.id?}" ng-selected="option.id==product.level2_id">{?option.description?}</option>
						</select>
						<div class="alert_required" ng-show="required_level1">@lang('lang.field_required_s')</div>
						<br>
						<select class="form-control" name="product_level3_id">
							<option value="">@lang('lang.pr_class3_classification')</option>
							<option ng-repeat="option in type_list.level3_type" value="{?option.id?}" ng-selected="option.id==product.level3_id">{?option.description?}</option>
						</select>
					</div>
					<div class="form-group">
						<label>@lang('lang.valid period')</label>
						<select class="text_sketch form-control" name="product_valid_period" requiredeqtrue>
							<option value=""></option>
							<option value="0" ng-selected="product.valid_period==0">@lang('lang.forever_valid_time')</option>
							<option value="1" ng-selected="product.valid_period==1">@lang('lang.number_1')@lang('lang.months')</option>
							<option value="3" ng-selected="product.valid_period==3">@lang('lang.number_3')@lang('lang.months')</option>
							<option value="6" ng-selected="product.valid_period==6">@lang('lang.Half')@lang('lang.year')</option>
							<option value="12" ng-selected="product.valid_period==12">@lang('lang.number_1')@lang('lang.year')</option>
							<option value="24" ng-selected="product.valid_period==24">@lang('lang.number_2')@lang('lang.years')</option>
							<option value="36" ng-selected="product.valid_period==36">@lang('lang.number_3')@lang('lang.years')</option>
						</select>
						<div class="alert_required" ng-show="required_valid_date">@lang('lang.field_required_s')</div>
					</div>
					<div class="form-group">
						<label>@lang('lang.pr_item_status')</label><br>
						<input class="switch" type="checkbox" name="product_status" ng-checked="product.status" />
					</div>
					<div class="form-group">
						<label>@lang('lang.service_type')</label>
						<select class="form-control" name="product_service_type">
							<option value=""></option>
							<option ng-repeat="item in type_list.dic.dic_service_type" value="{?item.value?}" ng-selected="item.value == product.service_type">{?item.description?}</option>
						</select>
						<div class="alert_required" ng-show="required_service_type">@lang('lang.field_required_s')</div>
					</div>
					<div class="form-group">
						<label>@lang('lang.gen_card_rule')</label>
						<select class="form-control" name="product_card_rule">
							<option value=""></option>
							<option ng-repeat="rule in type_list.rule" value="{?rule.id?}" ng-selected="rule.id == product.card_rule_id">{?rule.rule_name?}</option>
						</select>
						<div class="alert_required" ng-show="required_card_rule">@lang('lang.field_required_s')</div>
					</div>
					<div class="form-group">
						<label>@lang('lang.cost_price')</label>
						<input type="text" class="form-control textright price" name="product_price_sku" value="{?product.price_sku?}" min="1" requiredeqtrue />
						<div class="alert_required" ng-show="required_price">@lang('lang.field_required_s')</div>
					</div>
				</div>	
				<div class="form-group col-md-12">
					<label>@lang('lang.pr_description')</label>
					<span class="alert_required" ng-show="required_description">@lang('lang.field_required')</span>
					<textarea name="product_description" class="form-control" requiredeqtrue>{?product.description?}</textarea>
				</div>
				<div class="form-group col-md-12">
					<button type="submit" class="btn btn-primary">
						@lang('lang.pr_item_save')<span class="loading_icons" ng-show="ajax_loading">&nbsp;&nbsp;<img src="./images/loading_now.gif"></span>
					</button>
					<a type="button" class="btn btn-default" onclick="history.back(); return false;">@lang('lang.cancel')</a>
				</div>
			</form>	
		</div>
	</div>	
</div>

<!-- dialog html -->
<div id="productsave" class="message-dlg" title="{?@lang('lang.product_save_prompt')?}">
	<div class="block"></div>
	<div class="block width85">
		<p class="textcenter fontcolor777 fontsize1p1 lineheight240">@lang('lang.pr_edit_save_msg')</p>
	</div>
	<div class="block textcenter">
		<a class="generalbtn productcategeditbtn ui-button">@lang('lang.pr_setting_price')</a>
		<button href="#" class="cancelbtn ui-button">@lang('lang.pr_not_set_yet')</button>
	</div>
	<div class="block"></div>
</div>

<script src="{{url('')}}/js/control.js"></script>