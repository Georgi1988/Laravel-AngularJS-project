<div class="page-title clearfix">
	<div class="pull-left">
		<h1>@lang('lang.st_service_card_information_details')</h1>
		<small><a onclick="history.back(); return false;" class="subtitle">< @lang('lang.pr_return')</a></small>
	</div>
</div>

<div class="conter-wrapper col-md-10" ng-show="loaded">
	<div class="panel panel-info float-center">
		<div class="panel-heading">
			<h3 class="panel-title">{?card.product.name?}</h3>
		</div>
		<div class="panel-body">
			<div class="form-group col-md-6">
				<div class="col-md-12">
					<img class="img-responsive img-thumbnail" style="width:100%" src="{?card.product.image_url?}">
				</div>	
			</div>
			<div class="col-md-6">
				<label class="control-label">@lang('lang.ov_product_code')</label>
					<pre>{?card.product.code?} </pre>
				<label class="control-label">@lang('lang.pr_item_kind')</label>
					<pre>{?card.product.level1_info.description?}-{?card.product.level2_info.description?} </pre>
				<label class="control-label">@lang('lang.st_product_type')</label>
					<pre><span ng-show="card.type==1">@lang('lang.st_physical_card')</span><span ng-show="card.type==0">@lang('lang.st_virtual_card')</span> </pre>
				<label class="control-label">@lang('lang.pr_item_status')</label>
					<pre><span ng-show="card.product.status==1">@lang('lang.use_on')</span><span ng-show="card.product.status==0">@lang('lang.use_off')</span> </pre>
			</div>
		</div>
		<div class="panel-body">
			<div class="col-md-6">
				<label class="control-label">@lang('lang.ov_sales_store')</label>
					<pre>{?card.dealer.name?} </pre>
			</div>
			<div class="col-md-6">
				<label class="control-label">@lang('lang.label_dealer')</label>
					<pre>{?card.dealer.name?} (<span ng-show='card.dealer.level==1'>@lang('lang.1st_level_dealer')</span><span ng-show='card.dealer.level==2'>@lang('lang.2nd_level_dealer')</span><span ng-show='card.dealer.level==3'>@lang('lang.3rd_level_dealer')</span><span ng-show='card.dealer.level==4'>@lang('lang.4th_level_dealer')</span><span ng-show='card.dealer.level==5'>@lang('lang.5th_level_dealer')</span><span ng-show='card.dealer.level==6'>@lang('lang.6th_level_dealer')</span><span ng-show='card.dealer.level==7'>@lang('lang.7th_level_dealer')</span><span ng-show='card.dealer.level==8'>@lang('lang.8th_level_dealer')</span><span ng-show='card.dealer.level==9'>@lang('lang.9th_level_dealer')</span><span ng-show='card.dealer.level==10'>@lang('lang.10th_level_dealer')</span><span ng-show='card.dealer.level==11'>@lang('lang.11th_level_dealer')</span><span ng-show='card.dealer.level==12'>@lang('lang.12th_level_dealer')</span><span ng-show='card.dealer.level==13'>@lang('lang.13th_level_dealer')</span><span ng-show='card.dealer.level==14'>@lang('lang.14th_level_dealer')</span><span ng-show='card.dealer.level==15'>@lang('lang.15th_level_dealer')</span><span ng-show='card.dealer.level==16'>@lang('lang.16th_level_dealer')</span><span ng-show='card.dealer.level==17'>@lang('lang.17th_level_dealer')</span><span ng-show='card.dealer.level==18'>@lang('lang.18th_level_dealer')</span><span ng-show='card.dealer.level==19'>@lang('lang.19th_level_dealer')</span><span ng-show='card.dealer.level==20'>@lang('lang.20th_level_dealer')</span>) </pre>
			</div>
			<div class="col-md-6">
				<label class="control-label">@lang('lang.code')</label>
					<pre>{?card.code?} </pre>
			</div>
			<div class="col-md-6">
				<label class="control-label">@lang('lang.password')</label>
					<pre>{?card.passwd?} </pre>
			</div>
			<div class="col-md-6">
				<label class="control-label">@lang('lang.st_machine_code')</label>
					<pre>{?card.machine_code?} </pre>
			</div>
			<div class="col-md-6">
				<label class="control-label">@lang('lang.valid period')</label>
					<pre>{?card.valid_period?}<span class="fontcolorblue" ng-show="card.valid_forever==false&&card.expire_remain_days>=0">（@lang('lang.remain'){?card.expire_remain_days?}@lang('lang.days')）</span><span class="fontcolorblue" ng-show="card.valid_forever==false&&card.expire_remain_days<0">（@lang('lang.ov_expired')）</span><span ng-show="card.valid_forever">@lang('lang.forever_valid_time')</span> </pre>
			</div>
			<div class="col-md-6">
				<label class="control-label">@lang('lang.activation')</label>
					<pre>{?card.active_datetime?} </pre>
			</div>
			<div class="col-md-6">
				<label class="control-label">@lang('lang.register')</label>
					<pre>{?card.register_datetime?} </pre>
			</div>
		</div>
		<div class="panel-body">
			<div class="col-md-6">
				<label class="control-label">@lang('lang.st_username')</label>
					<pre>{?card.customer.name?} </pre>
			</div>
			<div class="col-md-6">
				<label class="control-label">@lang('lang.contact')</label>
					<pre>{?card.customer.link?} </pre>
			</div>
		</div>
	</div>
</div>	

<script src="{{url('')}}/js/control.js"></script>