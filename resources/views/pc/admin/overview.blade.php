<div class="page-title clearfix">
	<div class="pull-left">
		<h1>@lang('lang.label_overview')</h1>
		<small class="subtitle">@lang('lang.label_overview_description')</small>
	</div>
	<ol class="breadcrumb pull-right">
		<a href="#!overview/code" type="button" class="btn btn-info">@lang('lang.ov_manage_machine_code')</a>
	</ol>
</div>

<div class="conter-wrapper col-md-12">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">@lang('lang.ov_today_data')</h3>
		</div>
		<div class="panel-body" style="background-color: #f8f8f8;">
			<div class="col-md-2">
				<div class="stat panel striped-bg">
					<div class="row">
						<div class="col-md-3 bg-info icon-col striped-bg">
							<!-- <i class="fa fa-eye fa-4x"></i> -->
						</div>
						<div class="col-md-9 text-col">
							<!-- <i class="fa fa-eye fa-5x"></i> -->
							<span ng-show="today_stock.available_count"><h2>{?today_stock.available_count?}</h2></span>
							<span ng-show="!today_stock.available_count"><h2>0</h2></span>
							<p>@lang('lang.ov_stock_cards')</p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-2">
				<div class="stat panel striped-bg">
					<div class="row">
						<div class="col-md-3 bg-warning icon-col striped-bg">
							<!-- <i class="fa fa-bar-chart fa-4x"></i> -->
						</div>
						<div class="col-md-9 text-col">
							<!-- <i class="fa fa-bar-chart fa-5x"></i> -->
							<span ng-show="today_stock.soon_expired_count"><h2>{?today_stock.soon_expired_count?}</h2></span>
							<span ng-show="!today_stock.soon_expired_count"><h2>0</h2></span>
							<p>@lang('lang.ov_soon_expire')</p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-2">
				<div class="stat panel striped-bg">
					<div class="row">
						<div class="col-md-3 bg-danger icon-col striped-bg">
							<!-- <i class="fa fa-calculator fa-4x"></i> -->
						</div>
						<div class="col-md-9 text-col">
							<!-- <i class="fa fa-calculator fa-5x"></i> -->
							<span ng-show="today_stock.expired_count"><h2>{?today_stock.expired_count?}</h2></span>
							<span ng-show="!today_stock.expired_count"><h2>0</h2></span>
							<p>@lang('lang.ov_expired')</p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-2">
				<div class="stat panel striped-bg">
					<div class="row">
						<div class="col-md-3 bg-info icon-col striped-bg">
							<!-- <i class="fa fa-calculator fa-4x"></i> -->
						</div>
						<div class="col-md-9 text-col">
							<!-- <i class="fa fa-calculator fa-5x"></i> -->
							<span ng-show="today_stock.activation_count"><h2>{?today_stock.activation_count?}</h2></span>
							<span ng-show="!today_stock.activation_count"><h2>0</h2></span>
							<p>@lang('lang.ov_activation')</p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-2">
				<div class="stat panel striped-bg">
					<div class="row">
						<div class="col-md-3 bg-info icon-col striped-bg">
							<!-- <i class="fa fa-calculator fa-4x"></i> -->
						</div>
						<div class="col-md-9 text-col">
							<!-- <i class="fa fa-calculator fa-5x"></i> -->
							<span ng-show="today_stock.register_count"><h2>{?today_stock.register_count?}</h2></span>
							<span ng-show="!today_stock.register_count"><h2>0</h2></span>
							<p>@lang('lang.ov_register')</p>
						</div>
					</div>
				</div>
			</div>
		</div>	
	</div>	
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">@lang('lang.ov_search_card_data')</h3>
		</div>
		<div class="panel-body">
			<form method="get" action="#">
				<div class="left searchlayout paddingtop15">
					<select class="form-control" onchange="angular.element(this).scope().search_change(this)">
						<option value="">-- @lang('lang.od_cards_all') --</option>
						<option ng-repeat="option in product_type.level1_type" value="{?option.id?}" ng-selected="option.id==search.product_type1">{?option.description?}</option>
					</select>
				</div>

				<div class="left searchlayout paddingtop15">
					<input type="text" name="searchdatestart" id="searchdatestart" class="searchdatestart width120p" placeholder="@lang('lang.start date')" ng-model="search.start_date" ng-change="search_date()" readonly />
				</div>
				<div class="left searchlayout paddingtop15">
					<input type="text" name="searchdateend" id="searchdateend" class="searchdateend width120p" placeholder="@lang('lang.end date')" ng-model="search.end_date" ng-change="search_date()" readonly />
				</div>
				<div class="left marginleft30 paddingtop13">
					<a type="button" class="btn btn-info btn-sm weekpicker" ng-class="{periodselected:search.type==1}">@lang('lang.week')</a>
					<a type="button" class="btn btn-info btn-sm  monthpicker" ng-class="{periodselected:search.type==2}">@lang('lang.month')</a>
					<a type="button" class="btn btn-info btn-sm  quaterpicker" ng-class="{periodselected:search.type==3}">@lang('lang.season')</a>
					<a type="button" class="btn btn-info btn-sm  yearpicker" ng-class="{periodselected:search.type==4}">@lang('lang.year')</a>
				</div>
			</div>
			<div class="clearboth"></div>
			<div class="seperatorline"></div>
		</div>

		<div class="panel-body" style="background-color: #f8f8f8;">
			<div class="col-md-2">
				<div class="stat panel striped-bg">
					<div class="row">
						<div class="col-md-3 bg-info icon-col striped-bg">
							<!-- <i class="fa fa-eye fa-4x"></i> -->
						</div>
						<div class="col-md-9 text-col">
							<!-- <i class="fa fa-eye fa-5x"></i> -->
							<span ng-show="period_stock.available_count"><h2>{?period_stock.available_count?}</h2></span>
							<span ng-show="!period_stock.available_count"><h2>0</h2></span>
							<p>@lang('lang.label_stock')</p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-2">
				<div class="stat panel striped-bg">
					<div class="row">
						<div class="col-md-3 bg-warning icon-col striped-bg">
							<!-- <i class="fa fa-bar-chart fa-4x"></i> -->
						</div>
						<div class="col-md-9 text-col">
							<!-- <i class="fa fa-bar-chart fa-5x"></i> -->
							<span ng-show="period_stock.soon_expired_count"><h2>{?period_stock.soon_expired_count?}</h2></span>
							<span ng-show="!period_stock.soon_expired_count"><h2>0</h2></span>
							<p>@lang('lang.ov_soon_expire')</p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-2">
				<div class="stat panel striped-bg">
					<div class="row">
						<div class="col-md-3 bg-danger icon-col striped-bg">
							<!-- <i class="fa fa-calculator fa-4x"></i> -->
						</div>
						<div class="col-md-9 text-col">
							<!-- <i class="fa fa-calculator fa-5x"></i> -->
							<span ng-show="period_stock.expired_count"><h2>{?period_stock.expired_count?}</h2></span>
							<span ng-show="!period_stock.expired_count"><h2>0</h2></span>
							<p>@lang('lang.ov_expired')</p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-2">
				<div class="stat panel striped-bg">
					<div class="row">
						<div class="col-md-3 bg-info icon-col striped-bg">
							<!-- <i class="fa fa-calculator fa-4x"></i> -->
						</div>
						<div class="col-md-9 text-col">
							<!-- <i class="fa fa-calculator fa-5x"></i> -->
							<span ng-show="period_stock.activation_count"><h2>{?period_stock.activation_count?}</h2></span>
							<span ng-show="!period_stock.activation_count"><h2>0</h2></span>
							<p>@lang('lang.activation')</p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-2">
				<div class="stat panel striped-bg">
					<div class="row">
						<div class="col-md-3 bg-info icon-col striped-bg">
							<!-- <i class="fa fa-calculator fa-4x"></i> -->
						</div>
						<div class="col-md-9 text-col">
							<!-- <i class="fa fa-calculator fa-5x"></i> -->
							<span ng-show="period_stock.register_count"><h2>{?period_stock.register_count?}</h2></span>
							<span ng-show="!period_stock.register_count"><h2>0</h2></span>
							<p>@lang('lang.ov_register')</p>
						</div>
					</div>
				</div>
			</div>
		</div>	
	</div>
</div>

<script src="{{url('')}}/js/control.js"></script>