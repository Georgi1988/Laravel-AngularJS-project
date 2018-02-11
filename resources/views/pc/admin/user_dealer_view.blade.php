	<div class="block">
		<div class="left">
			<a href="#!/user/dealer" class="subtitle">< @lang('lang.pr_return')</a>
		</div>
		<div class="clearboth"></div>
	</div>
	<div class="width97 backgroundwhite margintop15">
		<div class="generalblock bgblue paddingtopbottom10 fontcolorwhite textcenter fontsize1p1">@lang('lang.u_dealer_info')</div>		
		<div class="block width90 borderbottomblue">
			<div class="left width50">
				<div class="paddingtopbottom10">
					<div class="left width48 fontcolor777">
						{? dealer.name ?}
					</div>
					<div class="left width48 fontcolor777 textright paddingleft10">
						@lang('lang.u_dealer_code') {? dealer.code ?}
					</div>
					<div class="clearboth"></div>
				</div>	
			</div>
			<div class="left width50">
				<div class="paddingtopbottom10 fontcolor777 textright">
					@lang('lang.u_reg_time')：{? dealer.created_at ?}
				</div>
			</div>
			<div class="clearboth"></div>
		</div>
		<div class="block width90 borderbottomblue">
			<div class="left width50">
				<div class="paddingtopbottom10">
					<div class="left width30 textright fontcolor777">
						@lang('lang.u_office_level'):
					</div>
					<div class="left fontcolor777 paddingleft10">
						{? dealer.level==1 ? '一级经销商' : dealer.level==2 ? '二级经销商' : '零售门店' ?}
					</div>
					<!--<div class="left fontcolorblue paddingleft50">
						订单需审批
					</div>-->
					<div class="clearboth"></div>
				</div>	
				<div class="paddingtopbottom10">
					<div class="left width30 textright fontcolor777">
						@lang('lang.u_customer_type'):
					</div>
					<div class="left fontcolor777 paddingleft10">
						{? dealer.customer_type_id ?}
					</div>
					<div class="clearboth"></div>
				</div>
				<div class="paddingtopbottom10">
					<div class="left width30 textright fontcolor777">
						@lang('lang.u_area'):
					</div>
					<div class="left fontcolor777 paddingleft10">
						{? dealer.up_dealer ?}
					</div>
					<div class="clearboth"></div>
				</div>
			</div>
			<div class="left width50">
				<div class="paddingtopbottom10">
					<div class="left width30 textright fontcolor777">
						@lang('lang.person_charge'):
					</div>
					<div class="left fontcolor777 paddingleft10">
						{? dealer.manager_name ?}
					</div>
					<div class="clearboth"></div>
				</div>	
				<div class="paddingtopbottom10">
					<div class="left width30 textright fontcolor777">
						@lang('lang.contact'):
					</div>
					<div class="left fontcolor777 paddingleft10">
						{? dealer.link ?}
					</div>
					<div class="clearboth"></div>
				</div>
				<div class="paddingtopbottom10">
					<div class="left width30 textright fontcolor777">
						@lang('lang.u_contact_address'):
					</div>
					<div class="left fontcolor777 paddingleft10">
						{? dealer.address ?}
					</div>
					<div class="clearboth"></div>
				</div>
			</div>
			<div class="clearboth"></div>
		</div>
		<div class="block width90 borderbottomblue">
			<div class="block textcenter fontsize1p5"><strong class="fontcolorblue">@lang('lang.u_bindsigned')：{? dealer.dd_account ?}</strong></div>
		</div>
		<div class="block width90 borderbottomblue">
			<div class="left width50">
				<div class="paddingtopbottom10">
					<div class="left width30 textright fontcolor777">
						@lang('lang.u_total_sales'):
					</div>
					<div class="left fontcolor777 paddingleft10">
						{? dealer.total_sale ?} @lang('lang.label_cn_cunit')
					</div>
					<div class="clearboth"></div>
				</div>	
				<div class="paddingtopbottom10">
					<div class="left width30 textright fontcolor777">
						@lang('lang.rew_monthly_sales'):
					</div>
					<div class="left fontcolor777 paddingleft10">
						{? dealer.sale_month ?} @lang('lang.label_cn_cunit')
					</div>
					<div class="clearboth"></div>
				</div>
				<div class="paddingtopbottom10">
					<div class="left width30 textright fontcolor777">
						@lang('lang.u_outstanding_price'):
					</div>
					<div class="left fontcolornavyblue paddingleft10">
						{? dealer.unbalance_sale ?} @lang('lang.label_cn_cunit')
					</div>
					<div class="clearboth"></div>
				</div>
			</div>
			<div class="left width50">
				<div class="paddingtopbottom10">
					<div class="left width30 textright fontcolor777">
						@lang('lang.u_item_stock'):
					</div>
					<div class="left fontcolor777 paddingleft10">
						{? dealer.stock ?} @lang('lang.label_card_unit')
					</div>
					<div class="clearboth"></div>
				</div>	
				<div class="paddingtopbottom10">
					<div class="left width30 textright fontcolor777">
						@lang('lang.u_product_activation'):
					</div>
					<div class="left fontcolor777 paddingleft10">
						{? dealer.stock_activated ?} @lang('lang.label_card_unit')
					</div>
					<div class="clearboth"></div>
				</div>
				<div class="paddingtopbottom10">
					<div class="left width30 textright fontcolor777">
						@lang('lang.u_product_registration'):
					</div>
					<div class="left fontcolor777 paddingleft10">
						{? dealer.stock_registered ?} @lang('lang.label_card_unit')
					</div>
					<div class="clearboth"></div>
				</div>
			</div>
			<div class="clearboth"></div>
		</div>
		<div class="block textcenter margintop15" ng-if="dealer.unbalance_sale>0">
			<a class="basicbtn bgyellow" ng-click="onBalance()">@lang('lang.u_confirm')</a>
		</div>
		<div class="block"></div>
	</div>
	
	<script src="{{url('')}}/js/control.js"></script>