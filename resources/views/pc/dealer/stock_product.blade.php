	<div class="block">
		<span class="subtitle">@lang('lang.pr_item_stock')</span>
	</div>
	<div>
		<div class="block">
			<!--<div class="searchlayout paddingtop15">
				<select class="text_sketch" onchange="angular.element(this).scope().change_dealer(this)">
					<option value="">-- @lang('lang.select_dealer') --</option>
					<option ng-repeat="dealer in other_info.type_list.dealers" value="{?dealer.id?}" ng-selected="dealer.id==search.dealer_id">{?dealer.name?}</option>
				</select>
			</div>-->
			<div class="inline-block paddingtop15">
			
				{? other_info.type_list.search_dealer.name ?}&nbsp;&nbsp;
				<button type="button" class="btn btn-info btn-xs" ng-click="select_dealer(other_info.type_list.up_dealer_id);">@lang('lang.select')</button>

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
							<div class="col-xs-12" ng-repeat="down_dealer in dealer_info.sub_list">
								<div class="col-xs-8">
									<label>
										<input type="radio" name="selected_dealer" ng-click="set_selected_dealer(down_dealer.id)" ng-value="down_dealer.id"> 
										{? down_dealer.name ?}
									</label>
								</div>
								<div class="col-xs-4">
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
				
			</div>
			<div class="searchlayout paddingtop15">
				<select class="text_sketch" onchange="angular.element(this).scope().change_type1(this)">
					<option value="">-- @lang('lang.pr_class1_classification') --</option>
					<option ng-repeat="option in other_info.type_list.level1_type" value="{?option.id?}" ng-selected="option.id==search.product_type1">{?option.description?}</option>
				</select>
			</div>
			<div class="searchlayout paddingtop15">
				<select class="text_sketch" onchange="angular.element(this).scope().change_type2(this)">
					<option value="">-- @lang('lang.pr_class2_classification') --</option>
					<option ng-repeat="option in other_info.type_list.level2_type" value="{?option.id?}" ng-selected="option.id==search.product_type2">{?option.description?}</option>
				</select>
			</div>
			<div class="searchlayout paddingtop15">
				<input type="search" class="stock_card_code" placeholder="@lang('lang.st_search')" ng-model="search.card_code_keyword" onsearch="angular.element(this).scope().search_card_code()">
			</div>
		</div>
		<div class="block">
			<div class="left">
				<div class="inlineblock stockmenu" ng-click="search_pagetype(1)" ng-class="{bgblue:search.page_type==1,fontcolorwhite:search.page_type==1,bgwhite:search.page_type!=1,fontcolorblue:search.page_type!=1}">@lang('lang.st_usabled')（{?other_info.p1_count?}) </div>
				<div class="inlineblock stockmenu" ng-click="search_pagetype(2)" ng-class="{bgblue:search.page_type==2,fontcolorwhite:search.page_type==2,bgwhite:search.page_type!=2,fontcolorblue:search.page_type!=2}">@lang('lang.st_soon_disable')（{?other_info.p2_count?}）</div>
				<div class="inlineblock stockmenu" ng-click="search_pagetype(3)" ng-class="{bgblue:search.page_type==3,fontcolorwhite:search.page_type==3,bgwhite:search.page_type!=3,fontcolorblue:search.page_type!=3}">@lang('lang.ov_expired')（{?other_info.p3_count?}）</div>
				<div class="inlineblock stockmenu" ng-click="search_pagetype(5)" ng-class="{bgblue:search.page_type==5,fontcolorwhite:search.page_type==5,bgwhite:search.page_type!=5,fontcolorblue:search.page_type!=5}">@lang('lang.st_already_actived')（{?other_info.p5_count?}）</div>
				<div class="inlineblock stockmenu borderblue"  ng-click="search_pagetype(4)" ng-class="{bgblue:search.page_type==4,fontcolorwhite:search.page_type==4,bgwhite:search.page_type!=4,fontcolorblue:search.page_type!=4}">@lang('lang.od_order_sold')（{?other_info.p4_count?}）</div>
			</div>
		</div>
		<div class="clearboth"></div>
		<hr class="borderbottomblue bgwhite" />
		<div class=""block">
			<div class="left paddingtop30">
				<a class="periodselected period" ng-click="search_card_type(1)" ng-class="{bgwhite:search.card_type!=1,fontcolorblue:search.card_type!=1,borderblue:search.card_type!=1}" >@lang('lang.st_physical_card')</a>
				<a class="periodselected period" ng-click="search_card_type(0)" ng-class="{bgwhite:search.card_type!=0,fontcolorblue:search.card_type!=0,borderblue:search.card_type!=0}" >@lang('lang.st_virtual_card')</a>
			</div>
			<div class="right paddingtop30">
				<a class="periodselected period stockcardbtn" ng-click="download_dialog()">@lang('lang.download_all')</a>
			</div>
			<div class="clearboth"></div>
		</div>
	</div>
	<div class="block backgroundwhite">
		<table class="table">
			<thead>
				<tr>
					<th>@lang('lang.pr_item_name') <a><img src="{{url('')}}/images/sort.png" alt="sort"></a></th>
					<th>@lang('lang.ov_product_code')</th>
					<th>@lang('lang.label_dealer') <a><img src="{{url('')}}/images/sort.png" alt="sort"></a></th>
					<th>@lang('lang.quantity') <a><img src="{{url('')}}/images/sort.png" alt="sort"></a></th>
					<th>@lang('lang.label_table_action') </th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="item in list_data.data">
					<td>{?item.product.name?}</td>
					<td>{?item.product.code?}</td>
					<td>{?item.dealer.name?}</td>
					<td>{?item.prod_count?}</td>
					<td>
						<a ng-click="download_dialog(item.product_id, item.product.name)" class="stockservicebtn stockservicedownload">@lang('lang.download')</a>
						@if($user_priv == 'dealer')
							<a ng-href="#!/stock/return/{? item.product.id ?}" class="stockservicebtn stockservicedownload">@lang('lang.return')</a>
							<a ng-href="#!/stock/bulk_register/{? item.product.id ?}" class="stockservicebtn stockservicedownload">@lang('lang.bulk_register')</a>
						@endif
						<a ng-click="view_product_stock(item.product_id)" class="stockservicebtn stockservicedownload">@lang('lang.ov_details')</a>
					</td>
				</tr>
				<tr ng-show="nodata">
					<td colspan="5">@lang('lang.str_no_data')</td>
				</tr>
			</tbody>
		</table>
		<div class="pagenav_block" ng-show="list_data.total > 0">
			<span class="pageinfo">@lang('lang.di') {?list_data.from?} - {?list_data.to?} @lang('lang.tiao')， @lang('lang.total') {?list_data.total?} @lang('lang.tiao')</span>
			<ul class="pagination">
				<li ng-class="{disabled:pagenation.currentPage === 1}">
                    <a ng-click="setPage(1)">&lt;&lt;</a>
                </li>
                <li ng-class="{disabled:pagenation.currentPage === 1}">
                    <a ng-click="setPage(pagenation.currentPage - 1)">&lt;</a>
                </li>
                <li ng-repeat="page in pagenation.pages" ng-class="{active:pagenation.currentPage === page}">
                    <a ng-click="setPage(page)">{?page?}</a>
                </li>                
                <li ng-class="{disabled:pagenation.currentPage === pagenation.totalPages}">
                    <a ng-click="setPage(pagenation.currentPage + 1)">&gt;</a>
                </li>
                <li ng-class="{disabled:pagenation.currentPage === pagenation.totalPages}">
                    <a ng-click="setPage(pagenation.totalPages)">&gt;&gt;</a>
                </li>
			</ul>
		</div>
	</div>
	<div class="block"></div>		
	<!-- dialog html -->
	<div id="stockcard" class="message-dlg" title="@lang('lang.st_download_title')">
		<input type="hidden" id="send_success_message" value="@lang('lang.st_mail_send_message')">
		<div class="block"></div>
		<div class="block width85">
		</div>
		<form id="download_form" ng-submit="submit_stockdownload()" method="POST" enctype="multipart/form-data">
		<div class="block width85" ng-show="down_product_name != ''">
			@lang('lang.pr_item_name'): <strong> {?down_product_name?} </strong>
		</div>
		<div class="block width85">
			<input type="email" id="sendmail" class="form-control" ng-model="send_mail_addr" name="" placeholder="@lang('lang.email')" value="{{$email}}" required />
			<p class="lineheight200"><span class="fontcolorred paddingleft50">@lang('lang.st_emailsend_note')</span></p>
		</div>
		<div class="block textcenter">
			<button type="submit" class="importbtn ui-button">
				@lang('lang.st_download_toemail')
				<span class="loading_icons" ng-show="ajax_email_loading"><img src="./images/loading_now.gif"></span>
			</button>
			<a class="export_file_btn" ng-click="stock_download_byfile()">	
				@lang('lang.st_download_tofile')
				<span class="loading_icons" ng-show="filedown_loading"><img src="./images/loading_now.gif"></span>
			</a>
		</div>
		<div class="block"></div>
	</div>
	<script src="{{url('')}}/js/control.js"></script>