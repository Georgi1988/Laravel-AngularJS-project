<div class="page-title clearfix">
	<div class="pull-left">
		<h1>@lang('lang.pr_service_card_information')</h1>
		<small><a onclick="history.back(); return false;" class="subtitle">< @lang('lang.pr_return')</a></small>
	</div>
</div>

<div class="conter-wrapper col-md-12">
	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title">{?product.name?}</h3>
		</div>
		<div class="panel-body">
			<div class="form-group col-lg-4 col-md-6">
				<div class="col-md-12">
					<img class="img-responsive img-thumbnail" style="width:100%" src="{?product.image_url?}">
				</div>	
			</div>
			<div class="col-lg-4 col-md-6">
				<label class="control-label">@lang('lang.ov_product_code')</label>
					<pre>{?product.code?}</pre>
				<label class="control-label">@lang('lang.pr_item_kind')</label>
					<pre>{?product.typestr_level1?} - {?product.typestr_level2?}</pre>
			</div>
		</div>
		<form id="editForm" ng-submit="form_submit(this)" method="post">
			<div class="panel-body text-center" style="background-color:skyblue">
				<div class="form-inline">
					<label for="price_sku">@lang('lang.price_base') &nbsp;</label>
					<input type="number" id="price_sku" name="price_sku" class="form-control" ng-model="product.price_sku" min="1" required="true" />
					<button type="submit" class="btn btn-default">@lang('lang.pr_item_save')</button>
				</div>
			</div>
			<div class="panel-body">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>@lang('lang.u_office_level')</th>
							<th>@lang('lang.pur_purchase_price')(@lang('lang.label_cn_cunit'))</th>
							<th>@lang('lang.price_order_min_limit')(@lang('lang.gen_check_count'))</th>
							<th>@lang('lang.price_order_max_limit')(@lang('lang.gen_check_count'))</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="item in product.purchase_price_level track by $index">
							<td>{? $index + 1 ?} @lang('lang.price_level_dealer')</td>
							<td>
								<input type="number" id="purchase_price_level{?$index?}" class="form-control" name="purchase_price_level{?$index?}" ng-model="product.purchase_price_level[$index]" min="1" required="true" />
							</td>
							<td>
								<input type="number" id="limit_down_{?$index?}" name="limit_down_{?$index?}" class="form-control" ng-model="product.order_limit_down_level[$index]" required="true" />
							</td>
							<td>
								<input id="limit_up_{?$index?}" type="number" name="limit_up_{?$index?}" class="form-control" ng-model="product.order_limit_up_level[$index]" min="{? product.order_limit_down_level[$index] + 1 ?}" required="true" />
							</td>
						</tr>
						<tr>
							<td>@lang('lang.price_seller')@lang('lang.price_sell')</td>
							<td><input type="number" id="sale_price" name="sale_price" class="form-control" ng-model="product.sale_price" min="1" required="true" /></td>
						</tr>
					</tbody>
				</table>
			</div>				
		</form>				
	</div>	
</div>

<script src="{{url('')}}/js/control.js"></script>