<div class="subheader bg_white">
	<span class="item" ng-class="{'active': activeMenu == ''}">
		<a ng-click="view_by_categ('')">@lang('lang.pr_item_all')</a>
	</span>
	<span class="item" ng-class="{'active': activeMenu === categitem.id}" ng-repeat = "categitem in categitems"><a ng-click="view_by_categ(categitem.id)">{?categitem.description?}</a></span>
</div>
<div class="genadmin_content">
	<div class="col-xs-12 item" ng-repeat = "item in items">
		<div class="col-xs-12 content out_border1">
				<div class="col-xs-5 padding0">
					<div class="icon text-center">
						<img class="img-rounded" ng-src="{?item.image_url?}">
					</div>
					<div>
						<a class="btn btn-info gen_btn" ng-href="#!/generate/add/{?item.id?}">@lang('lang.card_generate')</a>
					</div>
				</div>
				<div class="col-xs-7">
					<div class="info">
						@lang('lang.define_name')：{?item.name?}
					</div>
					<div class="info">
						@lang('lang.no')：{?item.code?}
					</div>
					<div class="info">
						@lang('lang.type')：{?item.typestr_level1?}
					</div>
					<div class="info">
						@lang('lang.st_physical_card')：{? (item.physical_inventory)? item.physical_inventory: 0 ?} @lang('lang.label_card_unit')
					</div>
					<div class="info">
						@lang('lang.st_virtual_card')：{? (item.dealer_inventory)? item.dealer_inventory: 0 ?} @lang('lang.label_card_unit')
					</div>
				</div>
				<div class="clearfix"></div>
		</div>			
	</div>
	<div class="nodata" ng-show="nodata">@lang('lang.str_no_data')</div>
</div>
<div class="col-xs-12 item text-center nopadding margin0" ng-show="busy"><img src="./images/loading.gif" style="width: 15px; height: 15px;"> @lang('lang.now_loading')...</div>