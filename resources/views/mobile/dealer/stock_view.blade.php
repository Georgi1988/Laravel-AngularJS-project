<div class="stock_v_content" style="display:none">
	<div class="col-xs-12 bg_white nopadding marginbot15 info">
		<div class="col-xs-12 nopadding icon text-center">
			<img class="img-rounded" ng-src="{?card.product.image_url?}">
		</div>
		<div class="col-xs-12 nopadding expire text-center" ng-class="{color_red:card.expire_remain_days<0}">
			@lang('lang.valid period')：
			<span ng-show="card.valid_forever==false&&card.expire_remain_days>=0">{?card.valid_period?}</span>
			<span ng-show="card.valid_forever==false&&card.expire_remain_days<0">{?card.valid_period?}（@lang('lang.ov_expired')）</span>
			<span ng-show="card.valid_forever">@lang('lang.forever_valid_time')</span>
		</div>
	</div>
	<div class="col-xs-11 col-xs-offset-1 text-left item">
		<p>@lang('lang.no')： {?card.product.code?}</p>
		<p>@lang('lang.define_name')： {?card.product.name?}</p>
		<p>@lang('lang.type')： {?card.product.level1_info.description?} - {?card.product.level2_info.description?}</p>
	</div>
	<div class="col-xs-12 bg_white nopadding fontsize1_3 text-center txt_bold paddingtop15 paddingbot15">
		<div class="col-xs-4 text-center txt_bold">
			@lang('lang.label_stock')： 
		</div>
		<div class="col-xs-8 text-center txt_bold">
			<p>@lang('lang.st_physical_card')： {?card.product_stock.size_of_physical?} @lang('lang.label_card_unit')</p>
			<p>@lang('lang.st_virtual_card')： {?card.product_stock.size_of_virtual?} @lang('lang.label_card_unit')</p>
		</div>
	</div>
	<div class="col-xs-10 col-xs-offset-1 padding0 paddingtop20 paddingbot15">
		<p>@lang('lang.introduce'):</p>
		<p>{?card.product.description?}</p>
	</div>
	
	
	<div id="download_dlg" class="reg_success_modal reg_modal_input modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<form id="download_form" ng-submit="submit_stockdownload()" method="POST" enctype="multipart/form-data">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title text-center">@lang('lang.st_enter_email')</h4>
					</div>
					<div class="modal-body text-center">
						<input type="email" id="sendmail" name="sendmail" class="edit_field width80 paddingtop5 paddingbot5 pad-left5" value="" placeholder="Email Address" required>
					</div>
					<div class="modal-footer">
						<div class="col-xs-6 nopadding text-center">
							<input type="submit" class="btn bg39f color_white width60" value="@lang('lang.confirm')">
						</div>
						<div class="col-xs-6 nopadding text-center">
							<a class="btn bg999 color_white width60" data-dismiss="modal">@lang('lang.cancel')</a>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	
	<div class="col-xs-12 paddingtop10  paddingbot10 text-center txt_bold fontsize1_3">
		<div class="col-xs-4 nopadding">
			<a class="btn bg5ac8fa color_white fontsize1_1" data-toggle="modal" data-target="#download_dlg">
				@lang('lang.download_short')
			</a>
		</div>
		<div class="col-xs-4 nopadding">
			<button class="btn bg5ac8fa color_white fontsize1_1">
				<a href="#!/stock/add/{?card.product.id?}">@lang('lang.purchase')</a>
			</button>
		</div>
		<div class="col-xs-4 nopadding">
			<button class="btn bg5ac8fa color_white fontsize1_1">
				<a href="#!/stock/return/{?card.product.id?}">@lang('lang.return')</a>
			</button>
		</div>
	</div>
</div>