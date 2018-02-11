	<div class="block">
		<a onclick="history.back(); return false;" class="subtitle">< @lang('lang.pr_return')</a>
	</div>
	
	<div class="subtitle paddingtop15">
		@lang('lang.bulk_register')
	</div>
	<div class="backgroundwhite" style="font-size: 13px;" ng-show="loaded">
		<div class="col-sm-12">
			<div class="col-xs-4 text-center">
				<img class="img_preview width90 max-width-300" ng-src="{?product.image_url?}" >
			</div>
			<div class="col-xs-8">
				<p>
					<span class="col-xs-2 padding0">@lang('lang.pr_item_name')：</span>
					<span class="padding0 fontcolor777">{?product.name?}</span>
					<span class="clearfix"></span>
				</p>
				<p>
					<span class="col-xs-2 padding0 ">@lang('lang.ov_product_code')：</span>
					<span class="padding0 fontcolor777">{?product.code?}</span>
					<span class="clearfix"></span>
				</p>
				<p>
					<span class="col-xs-2 padding0">@lang('lang.pr_item_kind')：</span>
					<span class="padding0 fontcolor777">{?product.typestr_level1?} - {?product.typestr_level2?}</span>
					<span class="clearfix"></span>
				</p>
				<p>
					<span class="col-xs-2 padding0">@lang('lang.pr_item_status')：</span>
					<span class="col-xs-4 padding0 fontcolor777" ng-if="product.status">@lang('lang.use_on')</span> <span ng-if="!product.status">@lang('lang.use_off')</span>
					
					<span class="col-xs-2 padding0">@lang('lang.valid period')：</span>
					<span class="col-xs-4 padding0 fontcolor777">{? product.valid_period | months_to_string ?}</span> 
					<span class="clearfix"></span>
				</p>
				<p>
					<span class="col-xs-2 padding0 ">@lang('lang.st_physical_card')：</span>
					<span class="col-xs-4 padding0 fontcolor777">{? product.stock_info.size_of_physical ?} @lang('lang.label_card_unit')</span>
					<span class="col-xs-2 padding0 ">@lang('lang.st_virtual_card')：</span>
					<span class="col-xs-4 padding0 fontcolor777">{? product.stock_info.size_of_virtual ?} @lang('lang.label_card_unit')</span>
					<span class="clearfix"></span>
				</p>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>
		
		<div class="col-xs-10 col-xs-offset-1 margintop30">	
			<div class="row marginbottom10">
				<form id="bulk_register_form" ng-submit="import_bulk_register()">
					<input type="hidden" name="product_id" value="{? product.id ?}">
					<div class="col-xs-4 text-right paddingtop5">@lang('lang.bulk_register')@lang('lang.template_file')</div>
					<div class="col-xs-4 padding0 overflow-hidden">
						<!--<input type="file" class="form-control" id="bulk_register_file" name="bulk_register_file" accept=".xlsx,.xls">-->
						<div class="form-group">
							<input type="file" class="input-ghost" style="visibility:hidden; height:0" id="bulk_register_file" name="bulk_register_file" accept=".xlsx, .xls">
							<div class="input-group input-file" name="Fichier1">
								<input type="text" class="form-control" placeholder="@lang('lang.choose_file')" style="cursor: pointer;">
								<span class="input-group-addon">
									<a class="file_choose">@lang('lang.select')</a>
								</span>
							</div>
						</div>
						<script>
							$(function() {
								bs_input_file();
							});
						</script>
						<span class="alert_required" ng-show="required_file">@lang('lang.field_required')</span>
					</div>
					<div class="col-xs-4 text-muted">
						<button type="submit" class="btn btn-info font-size">
							@lang('lang.bulk_register')<span class="loading_icons ajax_submit_loading" ng-show="ajax_loading == true">&nbsp;&nbsp;<img src="./images/loading_now.gif"></span>
						</button>&nbsp;
						<a href="{{url('common/download/template/bulk_register')}}" class="fontcolorblue paddingtop10">
							<span class="glyphicon glyphicon-download-alt"></span> @lang('lang.template_sample')
						</a>
					</div>
				</form>
			</div>
				
			<!-- success or error message -->
			<div class="clearfix"></div>
			<div class="alert alert-success alert-save-success paddingtop10" style="display: none;">
				{? msg ?}
			</div>
			<div class="alert alert-danger alert-save-fail paddingtop10" style="display: none;">
				<div class="row text-bold color_7d421e">{? err_msg ?}</div>
				<div class="row margin-lf-15 max-height-200-scroll-auto color_7d421e bordertop-1px-bdabab">
					<div class="col-xs-6 text-left" ng-repeat="card_err_info in invalide_cards">{?card_err_info?}</div>
				</div>
			</div>
				
		</div>
		<div class="clearfix"></div>
		
		
		
		<div class="block"></div>
	</div>