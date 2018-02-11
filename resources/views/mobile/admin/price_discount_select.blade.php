<div class="subheader bg_white">
	<span class="item" ng-class="{active:type==1}" ng-click="set_type(1)">@lang('lang.price_per_dealer')</span>
	<span class="item" ng-class="{active:type==2}" ng-click="set_type(2)">@lang('lang.price_per_dealerlevel')</span>
	<span class="item" ng-class="{active:type==3}" ng-click="set_type(3)">@lang('lang.price_per_search')</span>
	<span class="item" ng-class="{active:type==4}" ng-click="set_type(4)">@lang('lang.price_edit')</span>
</div>

<div class="price_v_content">
	<div class="list" ng-show="type==1">
		<button type="button" class="btn btn-default btn-sm marginbottom5" ng-click="toUpDealer(dealer_id)" ng-disabled="dealer_id==1"><span class="glyphicon glyphicon-arrow-up"></span></button>
		<button type="button" class="btn btn-primary btn-sm marginbottom5 float-right" ng-click="onSetting()">@lang('lang.setting')</button>
		<div class="col-xs-12 item padding0 marginbot15" ng-repeat="(index, dealer) in dealers">
			<div class="col-xs-2 nopadding paddingtop15 check text-center">
				<input type="checkbox" id="radio-2-{?index?}" name="check_list" class="regular-radio big-radio" ng-model="isCheck[index]" ng-change="onCheck()"/>
				<label for="radio-2-{?index?}"></label>
			</div>
			<div class="col-xs-10 text-left">
				<p class="marginbot5">@lang('lang.sl_dealer_name')： {? dealer.name ?}</p>
				<p class="marginbot5">@lang('lang.price_dealer_level')： {? dealer.level ?}</p>
				<p class="marginbot5">@lang('lang.price_promotional_discount')： {? dealer.promotion_price ?} (%)</p>
				<p class="marginbot5">{? dealer.promotion_start_date ?} --- {? dealer.promotion_end_date ?}</p>
				<p class="marginbot5"><button type="button" class="btn btn-default btn-sm" ng-click="toDownDealer(dealer.id)">@lang('lang.price_sub_ordinate')</button></p>
			</div>
		</div>
		
		<div class="clearfix"></div>
		<div class="nodata" ng-show="no_data">@lang('lang.str_no_data')</div>
		<div class="col-xs-12 item text-center nopadding margin0" ng-show="busy"><img src="./images/loading.gif" style="width: 15px; height: 15px;"> @lang('lang.now_loading')...</div>
	</div>
	<div class="list" ng-show="type==2">
		<div>
			<button class="btn btn-primary btn-sm marginbottom5 float-right" ng-click="submit_leveldiscount()">@lang('lang.pr_item_save')</button>
		</div>
		<p class="marginleft5 alert_required" ng-show="required_leveldiscount">{? msg_type==0 ? "@lang('lang.price_levelpromotion_require')" : "@lang('lang.price_promotion_dateinput')" ?}</p>
		<div class="marginbot20 display-inlineblock" ng-repeat="(index, dealer) in dealers">
			<div class="marginbot15 display-inlineblock">
				<div class="marginleft5 width140 display-inlineblock text-right">
					{? dealer.level ?} @lang('lang.price_level_dealer'):
				</div>
				<div class="marginleft5 width140 display-inlineblock">
					<input type="number" min="1" max="100" ng-model="dealer.promotion_price" placeholder="@lang('lang.promotion')" /> (%)
				</div>
			</div>
			<div class="marginbot15 display-inlineblock">
				<input class="marginleft5 width108" type="text" name="searchdatestart{?index?}" placeholder="@lang('lang.start date')" ng-model="dealer.promotion_start_date"  datepicker />
				<input class="marginleft5 width108" type="text" name="searchdateend{?index?}" placeholder="@lang('lang.end date')" ng-model="dealer.promotion_end_date"  datepicker />
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="nodata" ng-show="no_data">@lang('lang.str_no_data')</div>
		<div class="col-xs-12 item text-center nopadding margin0" ng-show="busy"><img src="./images/loading.gif" style="width: 15px; height: 15px;"> @lang('lang.now_loading')...</div>
	</div>
	<div class="list" ng-show="type==3">
		<div class="searchlayout marginleft5">
			<input type="search" name="keyword" placeholder="@lang('lang.st_dealer_search')" ng-model="search_name" />
			<button type="button" class="btn btn-default btn-sm height26" ng-click="search()"><span class="glyphicon glyphicon-search"></span></button>
			<button type="button" class="btn btn-primary btn-sm marginbottom5 float-right" ng-click="onSetting()">@lang('lang.setting')</button>
		</div>
		<div class="col-xs-12 item padding0 marginbot15" ng-repeat="(index, dealer) in dealers">
			<div class="col-xs-2 nopadding paddingtop15 check text-center">
				<input type="checkbox" id="radio-2-{?index?}" name="check_list" class="regular-radio big-radio" ng-model="isCheck[index]" ng-change="onCheck()"/>
				<label for="radio-2-{?index?}"></label>
			</div>
			<div class="col-xs-10 text-left">
				<p class="marginbot5">@lang('lang.sl_dealer_name')： {? dealer.name ?}</p>
				<p class="marginbot5">@lang('lang.price_dealer_level')： {? dealer.level ?}</p>
				<p class="marginbot5">@lang('lang.price_promotional_discount')： {? dealer.promotion_price ?} (%)</p>
				<p class="marginbot5">{? dealer.promotion_start_date ?} --- {? dealer.promotion_end_date ?}</p>
			</div>
		</div>
		
		<div class="clearfix"></div>
		<div class="nodata" ng-show="no_data">@lang('lang.str_no_data')</div>
		<div class="col-xs-12 item text-center nopadding margin0" ng-show="busy"><img src="./images/loading.gif" style="width: 15px; height: 15px;"> @lang('lang.now_loading')...</div>
	</div>
	<div class="list" ng-show="type==4">
		<div class="col-xs-12 item padding0 marginbot15" ng-repeat="item in items">
			<div class="col-xs-12">
				<div class="col-xs-6 text-left">
					{? item.dealer_id==1 ? item.level + " @lang('lang.price_level_dealer')" : item.dealer.name ?}
				</div>
				<div class="col-xs-6 text-left">
					{? item.promotion_price ?} (%)
				</div>
			</div>
			<div class="col-xs-12">
				<div class="col-xs-12 text-left">
					{? item.promotion_start_date ?} --- {? item.promotion_end_date ?}
				</div>
			</div>
			<div class="col-xs-12 text-right">
				<button type="button" class="btn btn-default btn-sm" ng-click="onEdit(item)">@lang('lang.price_edit')</button>
				<button type="button" class="btn btn-default btn-sm" ng-click="onRemove(item)">@lang('lang.price_remove')</button>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="nodata" ng-show="no_data">@lang('lang.str_no_data')</div>
		<div class="col-xs-12 item text-center nopadding margin0" ng-show="busy"><img src="./images/loading.gif" style="width: 15px; height: 15px;"> @lang('lang.now_loading')...</div>
	</div>
	
	<div class="paddingtop30 paddingbot20"></div>
</div>