<div class="register_v_content paddingtop10" style="display:none">
	<div class="col-xs-12 nopadding icon text-center">
		<img class="img-rounded" ng-src="{?card.product.image_url?}">
	</div>
	<div class="col-xs-11 col-xs-offset-1 paddingtop10 text-left item">
		<p>@lang('lang.define_name')： {?card.product.name?}</p>
		<p>@lang('lang.type')： {?card.product.level1_info.description?} - {?card.product.level2_info.description?}</p>
		<p>@lang('lang.code')： {?card.code?}</p>
		<p>
			@lang('lang.valid period')：
			<span ng-show="card.valid_forever==false&&card.expire_remain_days>=0">{?card.valid_period?}</span>
			<span ng-show="card.valid_forever==false&&card.expire_remain_days<0">{?card.valid_period?}（@lang('lang.ov_expired')）</span>
			<span ng-show="card.valid_forever">@lang('lang.forever_valid_time')</span>
		</p>
	</div>
	<div class="clearfix"></div>
	<div class="row padding0 bg_white paddingtop10">
		<div class="col-xs-11 col-xs-offset-1">
			<p>@lang('lang.label_dealer')： {?card.dealer.name?}</p>
			<p>@lang('lang.activation')： {?card.active_datetime?}</p>
			<p>@lang('lang.register')： {?card.register_datetime?}</p>
			<p>@lang('lang.st_machine_code')： {?card.machine_code?}</p>
			<p>@lang('lang.st_username')： {?card.customer.name?}</p>
			<p>@lang('lang.contact')： {?card.customer.link?}</p>
			<p ng-show="card.status!=1||card.agree_reg!='r'">
				@lang('lang.register')@lang('lang.ov_status')：
				<span ng-show="card.status==2">@lang('lang.sl_registered')</span>
				<span ng-show="card.status==1&&card.agree_reg=='d'">@lang('lang.rg_card_cancled')</span>
			</p>
		</div>
	</div>
	
	<div class="col-xs-12 borderbottomblue">
		<div class="col-xs-12 text-center paddingtop10" ng-show="card.status==1&&card.agree_reg=='r'">
			<div class="col-xs-12">
				<a class="btn btn-primary width30" ng-click="agree_register()" ng-disabled="ajax_loading">@lang('lang.agree')<span class="loading_icons" ng-show="ajax_agree_loading">&nbsp;&nbsp;<img src="./images/loading_now.gif"></span></a>
				<a class="btn btn-warning width30" ng-click="disagree_register()" ng-disabled="ajax_loading">@lang('lang.od_disagree')<span class="loading_icons" ng-show="ajax_disagree_loading">&nbsp;&nbsp;<img src="./images/loading_now.gif"></span></a>
			</div>
			<div class="col-xs-12 paddingtop5">
				<div class="alert alert-success" style="display: none;">
					@lang('lang.rg_success_save')
				</div>
				<div class="alert alert-danger" style="display: none;">
					@lang('lang.rg_fail_save')
				</div>
			</div>
		</div>
		<div class="clearboth"></div>
	</div>
	<div class="clearboth"></div>
	
</div>