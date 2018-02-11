	<div class="block">
		<a href="#!/price" class="subtitle">< @lang('lang.pr_return')</a>
		<div class="clearboth"></div>
	</div>
	<div class="subtitle paddingtop15">
		@lang('lang.pr_service_card_information')
	</div>	
	<div class="backgroundwhite">
		<div class="block"></div>
		<div class="block width90">
			<div class="left"><a href="#!price" class="productinfothumb">服务卡封面</a></div>
			<div class="left marginleft50">
				<p class="fontcolor777 lineheight240">@lang('lang.pr_item_name')：灵越笔记本延保一年卡</p>
				<p class="fontcolor777 lineheight240">@lang('lang.ov_product_code')：839-14908</p>
				<p class="fontcolor777 lineheight240">@lang('lang.pr_item_kind')：常规产品-延保卡产品</p>
				<p class="fontcolor777 lineheight240">@lang('lang.pr_item_status')：<span class="fontcolorred">2017.08.30 - 2017.09.30</span>  8折优惠</p>
			</div>
			<div class="clearboth"></div>
		</div>
		<div class="block"></div>
	</div>
	<div class="width97 backgroundwhite">
		<div class="generalblock bgblue1 paddingtopbottom20 textcenter fontsize1p5">
			<span class="inlineblock fontcolorwhite margintop5">@lang('lang.pr_standard_price')：200 @lang('lang.label_cn_cunit')</span>
			<div class="right"><a href="#!price/view/12" class="basicbtn bgyellow fontsize0p75">@lang('lang.pr_item_save')</a></div>
			<div class="clearboth"></div>
		</div>
		<div class="block backgroundwhite">
			<table class="table">
				<thead>
					<tr>
						<th>@lang('lang.u_office_level')</th>
						<th>@lang('lang.pur_purchase_price')（@lang('lang.label_cn_cunit')）</th>
						<th>@lang('lang.price_promotional_discount')</th>
						<th>@lang('lang.price_actual_price')（@lang('lang.label_cn_cunit')）</th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>我的进货价</td>
						<td><input type="text" name="" value="150" /></td>
						<td>80%</td>
						<td><span class="fontcolorred">120</span></td>
						<td></td>
					</tr>
					<tr>
						<td>我的进货价</td>
						<td><input type="text" name="" value="150" /></td>
						<td>80%</td>
						<td><span class="fontcolorred">120</span></td>
						<td></td>
					</tr>
					<tr>
						<td>我的进货价</td>
						<td><input type="text" name="" value="150" /></td>
						<td>80%</td>
						<td><span class="fontcolorred">120</span></td>
						<td></td>
					</tr>
				</tbody>
			</table>
			<div class="pagenav_block" ng-show="list_data.total > 0">
				<span class="pageinfo">第 1-20条 ，共1234条</span>
				<ul class="pagination">
					<li><a href="?pagenum=1"><<</a></li>
					<li><a href="?pagenum=7"><</a></li>
					<li class="active"><a href="?pagenum=1">1</a></li>
					<li><a href="?pagenum=2">2</a></li>
					<li><a href="?pagenum=3">3</a></li>
					<li><a href="?pagenum=4">4</a></li>
					<li><a href="?pagenum=5">5</a></li>
					<li><a href="?pagenum=15">></a></li>
					<li><a href="?pagenum=141">>></a></li>
				</ul>
			</div>
		</div>
	</div>
	
	<script src="{{url('')}}/js/control.js"></script>