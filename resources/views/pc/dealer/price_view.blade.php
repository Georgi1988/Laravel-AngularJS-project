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
				<p class="fontcolor777 lineheight240">@lang('lang.pr_item_status')：<span class="fontcolorred">{? promotion===null ? "@lang('lang.discount')" + " " + "@lang('lang.not_have')" : (promotion.promotion_start_date | date:'yyyy.MM.dd').toString() + ' - ' + (promotion.promotion_end_date | date:'yyyy.MM.dd').toString() ?}
				</span>{? promotion===null ? '' : (promotion.promotion_price / 10).toString() + "@lang('lang.ten_pro')" + "@lang('lang.discount')" ?}</p>
			</div>
			<div class="clearboth"></div>
		</div>
		<div class="block"></div>
	</div>
	<div class="width97 backgroundwhite">
		<div class="generalblock bgblue1 paddingtopbottom20 fontcolorwhite textcenter fontsize1p5">
			<span class="inlineblock fontcolorwhite margintop5">@lang('lang.price_store_price')：{?price.sale_price?} @lang('lang.label_cn_cunit')</span>
			<div class="right"></div>
			<div class="clearboth"></div>
		</div>
		<div class="block backgroundwhite">
			<table class="table">
				<thead>
					<tr>
						<tr>
							<th>@lang('lang.type')</th>
							<th>@lang('lang.price_label')（@lang('lang.label_cn_cunit')）</th>
							<th>@lang('lang.price_promotional_discount')</th>
							<th>@lang('lang.price_actual_price')</th>
						</tr>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>@lang('lang.price_purchase_price')</td>
						<td>{? price.purchase_price ?}</td>
						<td>{? promotion===null ? "@lang('lang.not_have')" : (promotion.promotion_price).toString() + '%' ?}</td>
						<td><span class="fontcolorred">{? promotion===null ? price.purchase_price : price.purchase_price * promotion.promotion_price / 100 ?}</span></td>
					</tr>
					<tr>
						<td>@lang('lang.price_shipment_price')</td>
						<td>{? price.wholesale_price ?}</td>
						<td>@lang('lang.not_have')</td>
						<td><span class="fontcolorred">{? price.wholesale_price ?}</span></td>
					</tr>
					<tr>
						<td>@lang('lang.price_store_price')</td>
						<td>{? price.sale_price ?}</td>
						<td>@lang('lang.not_have')</td>
						<td><span class="fontcolorred">{? price.sale_price ?}</span></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>