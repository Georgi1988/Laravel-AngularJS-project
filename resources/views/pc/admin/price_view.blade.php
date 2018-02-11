	<div class="block">
		<div class="left">
			<a href="#!/price" class="subtitle">< @lang('lang.pr_return')</a>
		</div>
		<div class="clearboth"></div>
	</div>
	<div class="width97 backgroundwhite">
		<div class="generalblock bgblue paddingtopbottom10 fontcolorwhite textcenter fontsize1p1">@lang('lang.pr_service_card_information')</div>	
		<div class="block"></div>
		<div class="block width90">
			<div class="left width40 textcenter">
				<img class="img_preview width80" ng-src="{?product.image_url?}" >
			</div>
			<div class="left marginleft50">
				<p class="fontcolor777 lineheight240">@lang('lang.pr_item_name')：{? product.name ?}</p>
				<p class="fontcolor777 lineheight240">@lang('lang.ov_product_code')：{? product.code ?}</p>
				<p class="fontcolor777 lineheight240">@lang('lang.pr_item_kind')：{? product.typestr_level1 ?} - {? product.typestr_level2 ?}</p>
			</div>
			<div class="clearboth"></div>
		</div>
		<div class="block"></div>
	</div>
	<div class="width97 backgroundwhite">
		<div class="generalblock bgblue1 paddingtopbottom20 fontcolorwhite textcenter fontsize1p5">
			<span class="inlineblock fontcolorwhite margintop5">@lang('lang.od_original_price')：{? product.price_sku ?} @lang('lang.label_cn_cunit')</span>
			<div class="right">
				<a ng-href="#!/price/edit/{?product.id?}" class="basicbtn bgwhite fontsize0p75 fontcolorgray">@lang('lang.pr_item_edit')</a>
				<a ng-href="#!/generate" class="basicbtn bgwhite fontsize0p75 fontcolorgray">@lang('lang.gen_generate_card_short')</a>
			</div>
			<div class="clearboth"></div>
		</div>
		<div class="block backgroundwhite">
			<table class="table">
				<thead>
					<tr>
						<th>@lang('lang.u_office_level')</th>
						<th>@lang('lang.price_promotional_discount')</th>
						<th>@lang('lang.pur_purchase_price')（@lang('lang.label_cn_cunit')）</th>
						<th>@lang('lang.price_wholesale_price')（@lang('lang.label_cn_cunit')）</th>
						<!--<th>&nbsp;</th>-->
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="item in product.purchase_price_level track by $index">
						<td>{? $index + 1 ?} @lang('lang.price_level_dealer')</td>
						<td>{? product.promotions[$index + 1]===null ? product.promotions[0]===null ? "@lang('lang.not_have')" : (product.promotions[0].promotion_price).toString() + '%' : (product.promotions[$index + 1].promotion_price).toString() + '%' ?}</td>
						<td>
							<p>{? item ?}</p>
							<p class="fontcolorred" ng-show="item!=null">@lang('lang.price_actual_price'):&nbsp {? product.promotions[$index + 1]===null ? product.promotions[0]===null ? item : item * product.promotions[0].promotion_price / 100 : item * product.promotions[$index + 1].promotion_price / 100 ?}</p>
						</td>
						<td>
							<p>{? product.purchase_price_level[$index + 1] != null ? product.purchase_price_level[$index + 1] : $index + 1 == product.max_level ? product.sale_price : '' ?}</p>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	
	<script src="{{url('')}}/js/control.js"></script>