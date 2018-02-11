<div class="reg_v_content" style="display:none">
	<div class="col-xs-12 bg_white nopadding marginbot15 info">
		<div class="col-xs-6 nopadding icon text-center">
			<img class="img-rounded" ng-src="{?product.image_url?}">
		</div>
		<div class="col-xs-6 nopadding detail text-left">
			<p>@lang('lang.no')：{?product.code?}</p>
			<p>@lang('lang.define_name')：{?product.name?}</p>
			<p>@lang('lang.card_no')：{?product.carddata.code?}</p>
			<p>@lang('lang.valid period')：{?product.valid_period | months_to_string ?}</p>
		</div>
	</div>
	<div class="col-xs-12 nopadding text-center fontsize1_2 marginbot15 item">
		@lang('lang.rg_regiset_dell_machine_code')
	</div>
	<div class="col-xs-12 bg_white nopadding paddingtop30 paddingbot20">
		<div class="row nopadding paddingbot15 textcenter fontsize1_2 txt_bold">
			@lang('lang.rg_sale_price') : {?product.price.sale_price?} @lang('lang.label_cn_cunit')
		</div>	
		<div class="row nopadding paddingtop10">
			<div class="col-xs-2"></div>	
			<div class="col-xs-8 group">					
				<input type="text" class="marterial" id="user_name" name="user_name" placeholder="" ng-model="customer_name" required>
				<span class="highlight"></span>
				<span class="bar"></span>
				<label>@lang('lang.name')</label>
			</div>	
			<div class="col-xs-2"></div>
		</div>	
		<div class="row nopadding paddingtop10">
			<div class="col-xs-2"></div>	
			<div class="col-xs-8 group">					
				<input type="text" class="marterial" id="user_phone" name="user_phone" placeholder="" ng-model="customer_phone" required>
				<span class="highlight"></span>
				<span class="bar"></span>
				<label>@lang('lang.phone')</label>
			</div>	
			<div class="col-xs-2"></div>
		</div>
		<div class="row nopadding paddingtop10">
			<div class="col-xs-2"></div>	
			<div class="col-xs-8 group">					
				<p class="col-xs-12 text-center" ng-show="phonecheck" style="color:red;font-size:1em">@lang('lang.rg_invalid_number')</p>
			</div>	
			<div class="col-xs-2"></div>
		</div>
		<div class="row nopadding paddingtop10">
			<div class="col-xs-2"></div>	
			<div class="col-xs-8 group">					
				<input type="text" class="marterial" id="machine_code" name="machine_code" ng-model="machine_code" required>
				<span class="highlight"></span>
				<span class="bar"></span>
				<label>@lang('lang.st_machine_code_s')*</label>
			</div>
			<div class="col-xs-2 padding0">
				<button class="btn bg5ac8fa padding5 margintop5 width80 color_white txt_bold" ng-click="onQRScan()"><i class="glyphicon glyphicon-qrcode"></i></button>
			</div>
			<div class="col-xs-2"></div>
		</div>
		<div class="row nopadding paddingtop10">
			<div class="col-xs-2"></div>	
			<div class="col-xs-8 group">					
				<input type="password" class="marterial" id="check_pass" name="check_pass" ng-model="check_pass" required>
				<span class="highlight"></span>
				<span class="bar"></span>
				<label>@lang('lang.password_short')*</label>
			</div>	
			<div class="col-xs-2 paddingtop10">
				<a ng-click="show_password()">
					<i class="glyphicon glyphicon-eye-close text-muted" ng-if="!show_pwd"></i>
					<i class="glyphicon glyphicon-eye-open text-danger" ng-if="show_pwd"></i>
				</a>
			</div>
		</div>
		
		<div class="row nopadding paddingtop10">
			<p class="col-xs-12 text-center" ng-show="registerresult" style="color:red;font-size:1em">@lang('lang.pr_register_fail')</p>
		</div>
		<div class="row nopadding paddingtop15">
			<div id="card_code" class="col-xs-9 col-xs-offset-3 padding0 text-left">
				<span>@lang('lang.st_machine_code_s') : </span><span id="card_code_val"></span>
			</div>
		</div>
		
		<div class="row nopadding paddingtop15">
			<div class="col-xs-2"></div>	
			<div class="col-xs-8" id="">					
				<button class="btn bg5ac8fa width100 color_white txt_bold fontsize1_2" ng-click="register()">@lang('lang.rg_submit')<span ng-show="ajax_loading">&nbsp;&nbsp;<img class="loading_img" src="{{url('')}}/images/loading.gif"></span></button>
			</div>	
			<div class="col-xs-2"></div>
		</div>	
	</div>
	
	<div id="register_dlg" class="reg_success_modal modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content ">
				<div class="modal-body text-center fontsize0_9">
					<p class="paddingtop10 fontsize0_9">@lang('lang.rg_success_register')</p>
					<p class="paddingtop5 fontsize0_9">@lang('lang.card_no') ： {?cardcode?}</p>
					<p class="paddingtop5 fontsize0_9">@lang('lang.st_machine_code') : {?machine_code?}</p>
					<a type="button" class="confirm btn bg39f color_white">@lang('lang.confirm')</a>
					<!--<button type="button" class="btn bg999 color_white" data-dismiss="modal">@lang('lang.cancel')</button>-->
				</div>
			</div>
		</div>
	</div>
</div>