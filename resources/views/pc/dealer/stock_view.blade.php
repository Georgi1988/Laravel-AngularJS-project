	<div class="block">
		<div class="left">
			<a onclick="history.back();" class="subtitle">< @lang('lang.pr_return')</a>
		</div>
		<div class="clearboth"></div>
	</div>
	<div class="width97 backgroundwhite margintop15" ng-show="loaded">
		<div class="generalblock bgblue paddingtopbottom10 fontcolorwhite textcenter fontsize1p1">@lang('lang.st_service_card_information_details')</div>		
		<div class="block"></div>
		<div class="block width90 borderbottomblue">
			<div class="left">
				<img class="productinfothumb" ng-src="{?card.product.image_url?}">
			</div>
			<div class="left marginleft50">
				<p class="fontcolor777 lineheight200">@lang('lang.pr_item_name')：{?card.product.name?}</p>
				<p class="fontcolor777 lineheight200">@lang('lang.ov_product_code')：{?card.product.code?}</p>
				<p class="fontcolor777 lineheight200">@lang('lang.pr_item_kind')：{?card.product.level1_info.description?}-{?card.product.level2_info.description?}</p>
				<p class="fontcolor777 lineheight200">
					@lang('lang.st_product_type')：
					<span ng-show="card.type==1">@lang('lang.st_physical_card')</span>
					<span ng-show="card.type==0">@lang('lang.st_virtual_card')</span>
				</p>
				<p class="fontcolor777 lineheight200">
					@lang('lang.pr_item_status')：
					<span ng-show="card.product.status==1">@lang('lang.use_on')</span>
					<span ng-show="card.product.status==0">@lang('lang.use_off')</span>
				</p>
			</div>
			<div class="clearboth"></div>
		</div>
		<div class="block width90 borderbottomblue">
			<div class="left width50">
				<div class="paddingtopbottom10">
					<div class="left width30 textright fontcolor777">
						@lang('lang.label_dealer')：
					</div>
					<div class="left fontcolor777 paddingleft10">
						{?card.dealer.name?}
						<span ng-show='card.dealer.level==1'>@lang('lang.1st_level_dealer')</span>
						<span ng-show='card.dealer.level==2'>@lang('lang.2nd_level_dealer')</span>
						<span ng-show='card.dealer.level==3'>@lang('lang.3rd_level_dealer')</span>
						<span ng-show='card.dealer.level==4'>@lang('lang.4th_level_dealer')</span>
						<span ng-show='card.dealer.level==5'>@lang('lang.5th_level_dealer')</span>
						<span ng-show='card.dealer.level==6'>@lang('lang.6th_level_dealer')</span>
						<span ng-show='card.dealer.level==7'>@lang('lang.7th_level_dealer')</span>
						<span ng-show='card.dealer.level==8'>@lang('lang.8th_level_dealer')</span>
						<span ng-show='card.dealer.level==9'>@lang('lang.9th_level_dealer')</span>
						<span ng-show='card.dealer.level==10'>@lang('lang.10th_level_dealer')</span>
						<span ng-show='card.dealer.level==11'>@lang('lang.11th_level_dealer')</span>
						<span ng-show='card.dealer.level==12'>@lang('lang.12th_level_dealer')</span>
						<span ng-show='card.dealer.level==13'>@lang('lang.13th_level_dealer')</span>
						<span ng-show='card.dealer.level==14'>@lang('lang.14th_level_dealer')</span>
						<span ng-show='card.dealer.level==15'>@lang('lang.15th_level_dealer')</span>
						<span ng-show='card.dealer.level==16'>@lang('lang.16th_level_dealer')</span>
						<span ng-show='card.dealer.level==17'>@lang('lang.17th_level_dealer')</span>
						<span ng-show='card.dealer.level==18'>@lang('lang.18th_level_dealer')</span>
						<span ng-show='card.dealer.level==19'>@lang('lang.19th_level_dealer')</span>
						<span ng-show='card.dealer.level==20'>@lang('lang.20th_level_dealer')</span>
					</div>
					<div class="clearboth"></div>
				</div>	
				<div class="paddingtopbottom10">
					<div class="left width30 textright fontcolor777">
						@lang('lang.code')：
					</div>
					<div class="left fontcolor777 paddingleft10">
						{?card.code?}
					</div>
					<div class="clearboth"></div>
				</div>
				<div class="paddingtopbottom10">
					<div class="left width30 textright fontcolor777">
						@lang('lang.activation')：
					</div>
					<div class="left fontcolor777 paddingleft10">
						{?card.active_datetime?}
					</div>
					<div class="clearboth"></div>
				</div>
				<div class="paddingtopbottom10">
					<div class="left width30 textright fontcolor777">
						@lang('lang.valid period')：
					</div>
					<div class="left fontcolor777 paddingleft10">
						{?card.valid_period?}
						<span class="fontcolorblue" ng-show="card.expire_remain_days>=0">（@lang('lang.remain'){?card.expire_remain_days?}@lang('lang.days')）</span>
						<span class="fontcolorblue" ng-show="card.expire_remain_days<0">（@lang('lang.ov_expired')）</span>
					</div>
					<div class="clearboth"></div>
				</div>
			</div>
			<div class="left width50">
				<div class="paddingtopbottom10">
					<div class="left width30 textright fontcolor777">
						@lang('lang.ov_sales_store')：
					</div>
					<div class="left fontcolor777 paddingleft10">
						{?card.dealer.name?}
					</div>
					<div class="clearboth"></div>
				</div>	
				<div class="paddingtopbottom10">
					<div class="left width30 textright fontcolor777">
						@lang('lang.password')：
					</div>
					<div class="left fontcolor777 paddingleft10">
						{?card.passwd?}
					</div>
					<div class="clearboth"></div>
				</div>
				<div class="paddingtopbottom10">
					<div class="left width30 textright fontcolor777">
						@lang('lang.register')：
					</div>
					<div class="left fontcolor777 paddingleft10">
						{?card.register_datetime?}
					</div>
					<div class="clearboth"></div>
				</div>
				<div class="paddingtopbottom10">
					<div class="left width30 textright fontcolor777">
						@lang('lang.st_machine_code')：
					</div>
					<div class="left fontcolor777 paddingleft10">
						{?card.machine_code?}
					</div>
					<div class="clearboth"></div>
				</div>
			</div>
			<div class="clearboth"></div>
		</div>
		<div class="block width90 borderbottomblue" ng-show="card.customer">
			<div class="fontcolor777 paddingleft25 paddingtopbottom10"><strong>@lang('lang.st_customer_information')</strong></div>
			<div class="left width50">
				<div class="paddingtopbottom10">
					<div class="left width30 textright fontcolor777">
						@lang('lang.st_username')：
					</div>
					<div class="left fontcolor777 paddingleft10">
						{?card.customer.name?}
					</div>
					<div class="clearboth"></div>
				</div>
			</div>
			<div class="left width50">
				<div class="paddingtopbottom10">
					<div class="left width30 textright fontcolor777">
						@lang('lang.contact')：
					</div>
					<div class="left fontcolor777 paddingleft10">
						{?card.customer.link?}
					</div>
					<div class="clearboth"></div>
				</div>
			</div>
			<div class="clearboth"></div>
		</div>
		<div class="block"></div>
	</div>
	
	<script src="{{url('')}}/js/control.js"></script>