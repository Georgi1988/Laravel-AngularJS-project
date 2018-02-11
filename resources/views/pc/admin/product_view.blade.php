<div class="page-title clearfix">
	<div class="pull-left">
		<h1>@lang('lang.pr_service_card_information')</h1>
		<small><a onclick="history.back(); return false;" class="subtitle">< @lang('lang.pr_return')</a></small>
	</div>
</div>

<div class="conter-wrapper col-lg-8 col-md-12" ng-show="loaded">
	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title">{?product.name?}</h3>
		</div>
		<div class="panel-body">
			<div class="form-group col-md-6">
				<div class="col-md-12">
					<img class="img-responsive img-thumbnail" style="width:100%" src="{?product.image_url?}">
				</div>	
			</div>
			<div class="col-md-6">
				<label class="control-label">@lang('lang.ov_product_code')</label>
					<pre>{?product.code?}</pre>
				<label class="control-label">@lang('lang.pr_item_kind')</label>
					<pre>{?product.typestr_level1?} - {?product.typestr_level2?}</pre>
				<label class="control-label">@lang('lang.pr_item_status')</label>
					<pre><span ng-if="product.status">@lang('lang.use_on')</span><span ng-if="!product.status">@lang('lang.use_off')</span></pre>
				<label class="control-label">@lang('lang.valid period')</label>
					<pre>{? product.valid_period | months_to_string ?}</pre>
			</div>
			<div class="col-md-12">
				<label class="control-label">@lang('lang.pr_description')</label>
					<pre>{?product.description?}</pre>
			</div>
			@if ($user_priv == "admin")
			<div class="page-control col-md-12">
				<a type="button" href="#!product/edit/{?product.id?}" class="btn btn-info">@lang('lang.pr_item_edit')</a>
				<a type="button" href="#!price/edit/{?product.id?}" class="btn btn-info">@lang('lang.price_pricing')</a>
			</div>
			@endif
		</div>
	</div>	
</div>
