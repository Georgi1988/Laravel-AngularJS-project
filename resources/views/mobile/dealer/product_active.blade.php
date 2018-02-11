<div class="product_content" style="display:none">
	<div class="col-xs-12 bg_white nopadding paddingtop20 paddingbot20 marginbot15 info">
		<div class="col-xs-5 nopadding icon text-center">
			<img class="img-rounded" ng-src="{?product.image_url?}">
		</div>
		<div class="col-xs-7 nopadding detail text-left">
			<p>@lang('lang.no')：{?product.code?}</p>
			<p>@lang('lang.define_name')：{?product.name?}</p>
			<p>@lang('lang.card_no')：{?product.carddata.code?}</p>
			<p>@lang('lang.valid period')：{? product.valid_period | months_to_string ?}</p>
		</div>
	</div>
	<div class="col-xs-12 nopadding fontsize1_2 marginbot15">
		<div class="col-xs-6 text-center txt_bold">@lang('lang.rg_sale_price')：</div>
		<div class="col-xs-6 txt_bold">{?product.price.sale_price?} @lang('lang.label_cn_cunit')</div>
	</div>
	<div class="col-xs-12 bg_white paddingtop20 text-center paddingbot20">
		<div class="row nopadding paddingtop10 paddingbot10 fontsize1_2">
			@lang('lang.pr_enter_card_password')
		</div>
		<!--<div class="row nopadding paddingtop15">
			<div class="col-xs-4 paddingtop5 text-right">
				@lang('lang.card_no')
			</div>
			<div class="col-xs-8 nopadding text-left">
				<input type="text" id="check_code" class="edit_field width80 pad-left5 paddingtop5 paddingbot5" placeholder="" value="{?product.carddata.code?}" readonly>
			</div>
		</div>-->
		
		
		<div class="row nopadding paddingtop20">
			<div class="col-xs-2"></div>	
			<div class="col-xs-8 group">					
				<input type="text" class="marterial" id="check_code" name="check_code" value="{?product.carddata.code?}" readonly required>
				<span class="highlight"></span>
				<span class="bar"></span>
				<label>@lang('lang.card_no')</label>
			</div>	
			<div class="col-xs-2"></div>
		</div>	
		
		
		<div class="row nopadding paddingtop20">
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
		
		<!--<div class="row nopadding paddingtop15">
			<div class="col-xs-4 paddingtop5 text-right">
				@lang('lang.password') 
			</div>
			<div class="col-xs-8 nopadding text-left">
				<input type="password" id="check_pass" class="edit_field width80 pad-left5 paddingtop5 paddingbot5 check_pass" value="{?product.carddata.passwd?}" readonly>
			</div>					
		</div>
		<div class="row nopadding paddingtop10">
			<p class="col-xs-12 text-center" ng-show="activeresult" style="color:red;font-size:1em">@lang('lang.pr_no_card')</p>
		</div>-->
		<div class="row nopadding paddingtop30">
			<div class="textcenter" style="width:75%;margin:0px auto">
				<a class="btn display-block fontsize1_2 text-center bg5ac8fa txt_bold color_white" ng-click="activation()">
					@lang('lang.activate_card')<span ng-show="ajax_loading">&nbsp;<img class="loading_img" src="{{url('')}}/images/loading.gif"></span>
				</a>
			</div>
		</div>
	</div>
	
	<div id="activation_dlg" class="reg_success_modal modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content ">
				<div class="modal-body  text-center">
					<p class="text-center fontsize1_3 paddingtop30">@lang('lang.pr_active_status_desciption')</p>
					<div class="row nopadidng">
						<div class="col-xs-12 textcenter">
							<button type="button" class="confirm btn bg39f color_white">@lang('lang.pr_active_continue')</button>
							<a type="button" class="btn bg999 color_white" onclick="history.back(); return false;">@lang('lang.close')</a>
						</div>
						<!--<div class="col-xs-6">
							<button type="button" class="btn bg999 color_white" data-dismiss="modal">@lang('lang.cancel')</button>
						</div>-->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>