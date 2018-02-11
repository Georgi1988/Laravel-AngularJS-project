<div class="subheader bg_white">
	<div class="col-xs-6 text-center" ng-class="{active:search.card_type==0}">
		<a ng-click="search_card_type(0)"> 
			<span class="item">@lang('lang.st_virtual_card')</span>
		</a>
	</div>
	<div class="col-xs-6 text-center" ng-class="{active:search.card_type==1}">
		<a ng-click="search_card_type(1)"> 
			<span class="item">@lang('lang.st_physical_card')</span>
		</a>
	</div>
</div>
<div class="stock_content paddingbot20">
	<div class="col-xs-12 bg_white nopadding marginbot10 item out_border1" ng-repeat="item in items">
		<a href="#!/stock/view/{?item.id?}">
			<div class="col-xs-7 nopadding pad-right5 title">{?item.product.name?}</div>
			<div class="col-xs-2 text-center nopadding quantity">
				X {?item.prod_count?}
			</div>
			<div class="col-xs-2 text-center nopadding quantity">
				<a ng-click="show_download_panel(item.product_id, item.product.name)">
					<img class="width50" src="{{url('/images/download.gif')}}" >
				</a>
			</div>
			<div class="col-xs-1 link-icon text-center nopadding quantity">
				<a ng-click="view_product_stock(item.product.id)">&gt;</a>
			</div>
		</a>
	</div>
	</div class="clearfix"></div>
	<div class="bottom_btn_area">
		<a ng-click="show_search_panel()" class="icon_small"><img src="images/search_blue_sky.gif"></a>&nbsp;&nbsp;
		<a ng-click="show_download_panel()" class="icon_small"><img src="{{url('/images/download.gif')}}" ></a>
	</div>
	<div class="nodata" ng-show="nodata">@lang('lang.str_no_data')</div>
	<div class="col-xs-12 item text-center nopadding margin0" ng-show="busy"><img src="./images/loading.gif" style="width: 15px; height: 15px;"> @lang('lang.now_loading')...</div>
</div>

<div class="download_modal modal fade" role="dialog">
	<div class="modal-dialog margintop50">
		<!-- Modal content-->
		<form id="download_form" ng-submit="submit_stockdownload()" method="POST" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">@lang('lang.st_download_title')</h4>
				</div>
				<div class="modal-body">
					<div class="col-xs-12" ng-show="down_product_name != ''">
						@lang('lang.pr_item_name'): <strong> {?down_product_name?} </strong>
					</div>
					<div class="col-xs-12 paddingtop5">
						<input type="email" class="form-control" id="sendmail" ng-model="send_mail_addr" placeholder="@lang('lang.email')" class="width100" name="" value="{{$email}}" required />
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="modal-footer">
				
					<div class="alert alert-success text-left" role="alert">
						@lang('lang.st_mail_send_message')
					</div>
					<div class="alert alert-danger text-left" role="alert">
						@lang('lang.send_dlg_title_fail')
					</div>
					
					<div class="col-xs-6 nopadding text-center">
						<button type="submit" class="btn bg39f width80 color_white searchbtn">@lang('lang.st_download_toemail')<span class="small_icons" ng-show="ajax_email_loading">&nbsp;&nbsp;<img src="./images/loading_now.gif"></span></button>
					</div>
					<div class="col-xs-6 nopadding text-center">
						<!--<a ng-click="stock_download_byfile()" class="btn bg999 color_white cancelbtn" data-dismiss="modal">@lang('lang.st_download_tofile')</a>-->
						<a class="btn bg999 width80 color_white cancelbtn" data-dismiss="modal">@lang('lang.close')</a>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>


<div class="search_panel width90">
	<div class="panel-header">
		<h4 >@lang('lang.search')</h4>
	</div>
	<div class="panel-body">
		
		<p>
			<select class="width100 form-control" id="srch_pagetype">
				<option value="1" ng-selected="search.page_type==1">@lang('lang.st_usabled')</option>
				<option value="2" ng-selected="search.page_type==2">@lang('lang.st_soon_disable')</option>
				<option value="3" ng-selected="search.page_type==3">@lang('lang.ov_expired')</option>
				<option value="5" ng-selected="search.page_type==5">@lang('lang.st_already_actived')</option>
				<option value="4" ng-selected="search.page_type==4">@lang('lang.od_order_sold')</option>
			</select>
		</p>
		<!--<p>
			<select class="width100 form-control" id="srch_dealer">
				<option value="">-- @lang('lang.select_dealer') --</option>
				<option ng-repeat="dealer in other_info.type_list.dealers" value="{?dealer.id?}" ng-selected="dealer.id==search.dealer_id">{?dealer.name?}</option>
			</select>
		</p>-->
		<p>
			
			<div class="col-xs-9 padding0">
				{? other_info.type_list.search_dealer.name ?}
			</div>
			<div class="col-xs-3 text-right padding0">
				<button type="button" class="btn btn-info btn-xs" ng-click="select_dealer(other_info.type_list.up_dealer_id);">@lang('lang.select')</button>
			</div>
			<div class="clearfix"></div>

			<!-- Modal -->
			<div id="dealer_select" class="modal fade" role="dialog">
			  <div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">@lang('lang.select_dealer')</h4>
				  </div>
				  <div class="modal-body">
					<div class="dealer_order_part">
						<span class="updealer_item" ng-repeat="up_dealer in dealer_info.upper_list">
							<a ng-click="get_sub_dealer(up_dealer.parent_id)" ng-if="up_dealer.can_list_view">
								{? up_dealer.name ?}
							</a>
							<span ng-if="!up_dealer.can_list_view">
								{? up_dealer.name ?}
							</span>
						</span>
					</div>
					<div class="sub_dealerlist_part">
						<div class="col-xs-12 padding0" ng-repeat="down_dealer in dealer_info.sub_list">
							<div class="col-xs-8 padding0">
								<label>
									<input type="radio" name="selected_dealer" ng-click="set_selected_dealer(down_dealer.id)" ng-value="down_dealer.id"> 
									{? down_dealer.name ?}
								</label>
							</div>
							<div class="col-xs-4 padding0 text-right">
								<a ng-click="get_sub_dealer(down_dealer.id)" ng-if="!down_dealer.calc_salespoint">
									@lang('lang.price_sub_ordinate')
								</a>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="clearfix"></div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-primary" ng-disabled="user_selected_dealer==0" ng-click="user_select_dealer()">@lang('lang.confirm')</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">@lang('lang.cancel')</button>
				  </div>
				</div>
			  </div>
			</div>
		</p>
		<p>
			<select class="width100 form-control" id="srch_type1">
				<option value="">-- @lang('lang.pr_class1_classification') --</option>
				<option ng-repeat="option in other_info.type_list.level1_type" value="{?option.id?}" ng-selected="option.id==search.product_type1">{?option.description?}</option>
			</select>
		</p>
		<p>
			<select class="width100 form-control" id="srch_type2">
				<option value="">-- @lang('lang.pr_class2_classification') --</option>
				<option ng-repeat="option in other_info.type_list.level2_type" value="{?option.id?}" ng-selected="option.id==search.product_type2">{?option.description?}</option>
			</select>
		</p>
		<p>
			<input type="search" class="width100 form-control" id="srch_code" placeholder="@lang('lang.st_search')" ng-model="search.card_code_keyword">
		</p>
	</div>
	<div class="">
		<div class="col-xs-6 nopadding text-center">
			<button type="button" class="btn bg39f color_white searchbtn" onclick="angular.element(this).scope().search_panel()">@lang('lang.search')</button>
		</div>
		<div class="col-xs-6 nopadding text-center">
			<button type="button" class="btn bg999 color_white cancelbtn" ng-click="close_search_panel()">@lang('lang.close')</button>
		</div>
	</div>
</div>
<script>
	$('.search_panel').hide();
</script>

<!--<div class="search_modal modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">@lang('lang.search')</h4>
			</div>
			<div class="modal-body">
				
				<p>
					<select class="width100 form-control" id="srch_pagetype">
						<option value="1" ng-selected="search.page_type==1">@lang('lang.st_usabled')</option>
						<option value="2" ng-selected="search.page_type==2">@lang('lang.st_soon_disable')</option>
						<option value="3" ng-selected="search.page_type==3">@lang('lang.ov_expired')</option>
						<option value="5" ng-selected="search.page_type==5">@lang('lang.st_already_actived')</option>
						<option value="4" ng-selected="search.page_type==4">@lang('lang.od_order_sold')</option>
					</select>
				</p>
				<p>
					<select class="width100 form-control" id="srch_dealer">
						<option value="">-- @lang('lang.select_dealer') --</option>
						<option ng-repeat="dealer in other_info.type_list.dealers" value="{?dealer.id?}" ng-selected="dealer.id==search.dealer_id">{?dealer.name?}</option>
					</select>
				</p>
				<p>
					<select class="width100 form-control" id="srch_type1">
						<option value="">-- @lang('lang.pr_class1_classification') --</option>
						<option ng-repeat="option in other_info.type_list.level1_type" value="{?option.id?}" ng-selected="option.id==search.product_type1">{?option.description?}</option>
					</select>
				</p>
				<p>
					<select class="width100 form-control" id="srch_type2">
						<option value="">-- @lang('lang.pr_class2_classification') --</option>
						<option ng-repeat="option in other_info.type_list.level2_type" value="{?option.id?}" ng-selected="option.id==search.product_type2">{?option.description?}</option>
					</select>
				</p>
				<p>
					<input type="search" class="width100 form-control" id="srch_code" placeholder="@lang('lang.st_search')" ng-model="search.card_code_keyword">
				</p>
			</div>
			<div class="modal-footer">
				<div class="col-xs-6 nopadding text-center">
					<button type="button" class="btn bg39f color_white searchbtn" onclick="angular.element(this).scope().search_panel()">@lang('lang.search')</button>
				</div>
				<div class="col-xs-6 nopadding text-center">
					<button type="button" class="btn bg999 color_white cancelbtn" data-dismiss="modal">@lang('lang.close')</button>
				</div>
			</div>
		</div>

	</div>
</div>-->