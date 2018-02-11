	<div class="block">
		<div class="left">
			<span class="subtitle">@lang('lang.ov_today_data')</span>
		</div>
		<div class="clearboth"></div>
	</div>
	<div class="block">
		<ul class="infototal">
			<li>
				<div class="infototal_content">
					<p>
						<a>
							<span ng-show="today_stock.available_count">{?today_stock.available_count?}</span>
							<span ng-show="!today_stock.available_count">0</span>
						</a>
					</p>
				</div>
				<div class="infototal_title">@lang('lang.ov_stock_cards')</div>
			</li>
			<li>
				<div class="infototal_content">
					<p>
						<a>
							<span ng-show="today_stock.soon_expired_count">{?today_stock.soon_expired_count?}</span>
							<span ng-show="!today_stock.soon_expired_count">0</span>
						</a>
					</p>
				</div>
				<div class="infototal_title">@lang('lang.ov_soon_expire')</div>
			</li>
			<li>
				<div class="infototal_content">
					<p>
						<a>
							<span ng-show="today_stock.expired_count">{?today_stock.expired_count?}</span>
							<span ng-show="!today_stock.expired_count">0</span>
						</a>
					</p>
				</div>
				<div class="infototal_title">@lang('lang.ov_expired')</div>
			</li>
			<li>
				<div class="infototal_content">
					<p>
						<a>
							<span ng-show="today_stock.activation_count">{?today_stock.activation_count?}</span>
							<span ng-show="!today_stock.activation_count">0</span>
						</a>
					</p>
				</div>
				<div class="infototal_title">@lang('lang.ov_activation')</div>
			</li>
			<li>
				<div class="infototal_content">
					<p>
						<a>
							<span ng-show="today_stock.register_count">{?today_stock.register_count?}</span>
							<span ng-show="!today_stock.register_count">0</span>
						</a>
					</p>
				</div>
				<div class="infototal_title">@lang('lang.ov_register')</div>
			</li>
		</ul>
	</div>
	<div class="block">
		<div class="left">
			<span class="subtitle">@lang('lang.ov_search_card_data')</span>
		</div>
		<div class="clearboth"></div>
	</div>
	<div class="block">
		<div class="left paddingtop15">
			<form method="get" action="#">
				<div class="searchlayout">
					<select class="text_sketch" onchange="angular.element(this).scope().search_change(this)">
						<option value="">-- @lang('lang.od_cards_all') --</option>
						<option ng-repeat="option in product_type.level1_type" value="{?option.id?}" ng-selected="option.id==search.product_type1">{?option.description?}</option>
					</select>
				</div>
				<div class="searchlayout">
					<input type="text" name="searchdatestart" id="searchdatestart" class="searchdatestart width120p" placeholder="@lang('lang.start date')" readonly ng-model="search.start_date" ng-change="search_date()" />
				</div>
				<div class="searchlayout">
					<input type="text" name="searchdateend" id="searchdateend" class="searchdateend width120p" placeholder="@lang('lang.end date')" readonly ng-model="search.end_date" ng-change="search_date()" />
				</div>
			</form>
		</div>
		<div class="left marginleft30 paddingtop13">
			<a class="period weekpicker" ng-class="{periodselected:search.type==1}">@lang('lang.week')</a>
			<a class="period monthpicker" ng-class="{periodselected:search.type==2}">@lang('lang.month')</a>
			<a class="period quaterpicker" ng-class="{periodselected:search.type==3}">@lang('lang.season')</a>
			<a class="period yearpicker" ng-class="{periodselected:search.type==4}">@lang('lang.year')</a>	
		</div>
		<div class="clearboth"></div>
		<div class="seperatorline"></div>
	</div>
	<div class="block">
		<ul class="infototal">
			<li>
				<div class="infototal_content">
					<p>
						<a>
							<span ng-show="period_stock.available_count">{?period_stock.available_count?}</span>
							<span ng-show="!period_stock.available_count">0</span>
						</a>
					</p>
				</div>
				<div class="infototal_title">@lang('lang.label_stock')</div>
			</li>
			<li>
				<div class="infototal_content">
					<p>
						<a>
							<span ng-show="period_stock.soon_expired_count">{?period_stock.soon_expired_count?}</span>
							<span ng-show="!period_stock.soon_expired_count">0</span>
						</a>
					</p>
				</div>
				<div class="infototal_title">@lang('lang.ov_soon_expire')</div>
			</li>
			<li>
				<div class="infototal_content">
					<p>
						<a>
							<span ng-show="period_stock.expired_count">{?period_stock.expired_count?}</span>
							<span ng-show="!period_stock.expired_count">0</span>
						</a>
					</p>
				</div>
				<div class="infototal_title">@lang('lang.ov_expired')</div>
			</li>
			<li>
				<div class="infototal_content">
					<p>
						<a>
							<span ng-show="period_stock.activation_count">{?period_stock.activation_count?}</span>
							<span ng-show="!period_stock.activation_count">0</span>
						</a>
					</p>
				</div>
				<div class="infototal_title">@lang('lang.activation')</div>
			</li>
			<li>
				<div class="infototal_content">
					<p>
						<a>
							<span ng-show="period_stock.register_count">{?period_stock.register_count?}</span>
							<span ng-show="!period_stock.register_count">0</span>
						</a>
					</p>
				</div>
				<div class="infototal_title">@lang('lang.ov_register')</div>
			</li>
		</ul>	
	</div>
	<script src="{{url('')}}/js/control.js"></script>