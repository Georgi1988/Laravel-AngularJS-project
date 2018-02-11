<div class="product_content">
	<div class="col-xs-12 bg_white paddingtop20 text-center paddingbot20">
		<div class="row nopadding paddingtop10 paddingbot10 fontsize1_2">
			@lang('lang.pr_enter_card_password')
		</div>
		
		<div class="row nopadding paddingtop10">
			<div class="col-xs-2"></div>	
			<div class="col-xs-8 group">
				<input type="text" class="marterial" id="check_code" name="check_code" ng-model="card_code" placeholder="" required>
				<span class="highlight"></span>
				<span class="bar"></span>
				<label>@lang('lang.card_no') *</label>
			</div>	
			<div class="col-xs-2 padding0">
				<button class="btn bg5ac8fa padding5 margintop5 width80 color_white txt_bold" ng-click="onQRScan()"><i class="glyphicon glyphicon-barcode"></i></button>
			</div>
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
		<div class="row nopadding paddingtop10">
			<div class="col-xs-2"></div>	
			<div class="col-xs-8 group">					
				<p class="col-xs-12 text-center" ng-show="phonecheck" style="color:red;font-size:1em">@lang('lang.rg_invalid_phone_number')</p>
			</div>	
			<div class="col-xs-2"></div>
		</div>
		
		<!--<div class="row nopadding paddingtop15">
			<div class="col-xs-3 nopadding paddingtop5 text-right">
				@lang('lang.card_no')
			</div>
			<div class="col-xs-6 text-left">
				<input type="text" id="check_code" ng-model="card_code" class="edit_field form-control width100 pad-left5 paddingtop5 paddingbot5" placeholder="">
			</div>
			<div class="col-xs-3 nopadding text-left">
				<a class="btn display-block text-center bg5ac8fa color_white" ng-click="onQRScan()">
					<i class="glyphicon glyphicon-barcode"></i> @lang('lang.scan')
				</a>
			</div>
		</div>-->
		<div class="row nopadding paddingtop15">
			<div class="textcenter" style="width:75%;margin:0px auto">
				<a class="btn display-block fontsize1_2 text-center txt_bold bg5ac8fa color_white" ng-click="activation()">
					<i class="glyphicon glyphicon-ok"></i> @lang('lang.activate_card')<span ng-show="ajax_loading">&nbsp;<img class="loading_img" src="{{url('')}}/images/loading.gif"></span>
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
							<button type="button" class="confirm btn bg39f color_white">
								@lang('lang.pr_active_continue')
							</button>
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