<div class="prod_v_content">
	<form id="redpacket_setting_form" name="redpacket_setting_form" ng-submit="submit_redpacket_setting()" method="POST" enctype="multipart/form-data">
		<div class="rewinfo">
			<div class="type col-xs-3 padding-lf-7 paddingtop5 text-right">@lang('lang.rew_red_packet_name'):</div>
			<div class="value col-xs-8 nopadding">
				<input type="text" class="form-control" ng-model="redpacket_setting.redpacket_name" required />
			</div>
		</div>
		<div class="rewinfo">
			<div class="type col-xs-3 padding-lf-7 paddingtop5 text-right">@lang('lang.rew_amount'):</div>
			<div class="value col-xs-8 nopadding">
				<input class="form-control" type="number" ng-model="redpacket_setting.redpacket_price" min="1" ng-pattern="/^[0-9]*$/" required />
			</div>
		</div>
		<div class="rewinfo">
			<button type="button" class="btn btn-default btn-sm marginbottom5" ng-click="toUpDealer(dealer_id)" ng-disabled="dealer_id==1 || isEdit==true"><span class="glyphicon glyphicon-arrow-up"></span></button>
			<table class="table">
				<tbody>
					<tr ng-repeat="(index, dealer) in dealers">
						<td class="text-center">
							<input type="radio" name="dealer_sel" ng-value="dealer.id" ng-model="redpacket_setting.dealer_id">
						</td>
						<td class="text-center">{? dealer.name ?}</td>
						<td class="text-center">
							<button ng-disabled="isEdit==true" type="button" class="btn btn-default btn-sm" ng-click="toDownDealer(dealer.id)">@lang('lang.price_sub_ordinate')</button>
						</td>
					</tr>
					<tr ng-if="no_data" class="text-center">
						<td colspan="7">@lang('lang.str_no_data')</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="rewinfo">
			<div class="type col-xs-3 padding-lf-7 text-right">@lang('lang.rew_red_packet_type'):</div>
			<div class="value col-xs-8 nopadding">
				<div class="value col-xs-6 nopadding text-center">
					<input type="radio" name="redpacket_type" ng-model="redpacket_setting.redpacket_type" ng-value="0" />@lang('lang.rew_red_packet_total_sale')
				</div>
				<div class="value col-xs-6 nopadding text-center">
					<input type="radio" name="redpacket_type" ng-model="redpacket_setting.redpacket_type" ng-value="1" />@lang('lang.rew_red_packet_card_count')
				</div>
			</div>
		</div>
		<div class="rewinfo">
			<div class="type col-xs-3 padding-lf-7 paddingtop5 text-right">@lang('lang.rew_red_packet_rule'):</div>
			<div class="value col-xs-8 nopadding">
				<input class="form-control" type="number" ng-model="redpacket_setting.redpacket_rule" min="1" ng-pattern="/^[0-9]*$/" required />
			</div>
		</div>
		<div class="rewinfo" ng-hide="redpacket_setting.redpacket_type==0">
			<div class="type col-xs-3 padding-lf-7 paddingtop5 text-right">@lang('lang.label_product'):</div>
			<div class="value col-xs-8 nopadding">
				<select class="form-control" ng-options="item.id as item.name for item in products" ng-model="redpacket_setting.product_id" ng-disabled="redpacket_setting.redpacket_type==0" >
				</select>
			</div>
		</div>
		<div class="rewinfo">
			<div class="type col-xs-3 padding-lf-7 paddingtop5 text-right">@lang('lang.rew_red_packet_period'):</div>
			<div class="value col-xs-8 nopadding">
				<input class="marginleft5 width108" type="text" name="searchdatestart" id="searchdatestart" class="searchdatestart" placeholder="@lang('lang.start date')" ng-model="redpacket_setting.redpacket_start_date" datepicker required />
			</div>
		</div>
		<div class="rewinfo">
			<div class="type col-xs-3 padding-lf-7 paddingtop5 text-right"></div>
			<div class="value col-xs-8 nopadding">
				<input class="marginleft5 width108" type="text" name="searchdateend" id="searchdateend" class="searchdateend" placeholder="@lang('lang.end date')" ng-model="redpacket_setting.redpacket_end_date" min="redpacket_setting.redpacket_start_date" datepicker required />
			</div>
		</div>
		<div class="rewinfo text-center paddingtop30 marginbot20">
			<button type="submit" class="btn btn-primary btn-sm marginbottom5 width30">@lang('lang.pr_item_save')</button>
		</div>
	</form>
</div>