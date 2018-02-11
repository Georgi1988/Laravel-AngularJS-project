<div class="block">
    <a class="subtitle" href="#!/reward/setting/view">< @lang('lang.pr_return')</a>
    <div class="subtitle paddingtop15">
		{? isEdit ? "@lang('lang.rew_red_rule_edit_rule')" : "@lang('lang.rew_red_rule_add_rule')" ?}
    </div>
</div>
<form id="redpacket_setting_form" name="redpacket_setting_form" ng-submit="submit_redpacket_setting()" method="POST" enctype="multipart/form-data">
	<div class="width100 paddingtopbottom10">
		<div class="width70 inlineblock">
			@lang('lang.rew_red_packet_name'):
			<input class="width80 generalinput" type="text" ng-model="redpacket_setting.redpacket_name" required />
		</div>
		<div class="width30 inlineblock">
			@lang('lang.rew_amount'):
			<input class="generalinput" type="number" ng-model="redpacket_setting.redpacket_price" min="1" ng-pattern="/^[0-9]*$/" required />
		</div>
	</div>
	<div class="inlineblock backgroundwhite width50 paddingtopbottom10">
		<button type="button" class="btn btn-default btn-sm marginbottom5" ng-click="toUpDealer(dealer_id)" ng-disabled="dealer_id==1 || isEdit==true"><span class="glyphicon glyphicon-arrow-up"></span></button>
		<table class="table">
			<tbody>
				<tr ng-repeat="(index, dealer) in dealers">
					<td>
						<input type="radio" name="dealer_sel" ng-value="dealer.id" ng-model="redpacket_setting.dealer_id">
					</td>
					<td>{? dealer.name ?}</td>
					<td>
						<button ng-disabled="isEdit==true" type="button" class="btn btn-default btn-sm" ng-click="toDownDealer(dealer.id)">@lang('lang.price_sub_ordinate')</button>
					</td>
				</tr>
				<tr ng-if="no_data">
					<td colspan="7">@lang('lang.str_no_data')</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="inlineblock backgroundwhite width50">
		<div class="width100 paddingtopbottom10">
			<div class="width30 paddingtopbottom10 paddingtop15 inlineblock text-right">
				@lang('lang.rew_red_packet_type'):
			</div>
			<div class="width30 paddingtopbottom10 inlineblock text-center">
				<input type="radio" name="redpacket_type" ng-model="redpacket_setting.redpacket_type" ng-value="0" />@lang('lang.rew_red_packet_total_sale')
			</div>
			<div class="width30 paddingtopbottom10 inlineblock text-center">
				<input type="radio" name="redpacket_type" ng-model="redpacket_setting.redpacket_type" ng-value="1"/>@lang('lang.rew_red_packet_card_count')
			</div>
		</div>
		<div class="width100 paddingtopbottom10">
			<div class="width30 paddingtopbottom10 inlineblock paddingtop15 text-right">
				@lang('lang.rew_red_packet_rule'):
			</div>
			<div class="width60 paddingtopbottom10 inlineblock">
				<input class="width100 generalinput" type="number" ng-model="redpacket_setting.redpacket_rule" min="1" ng-pattern="/^[0-9]*$/" required />
			</div>
		</div>
		<div class="width100 paddingtopbottom10" ng-hide="redpacket_setting.redpacket_type==0">
			<div class="width30 paddingtopbottom10 inlineblock paddingtop15 text-right">
				@lang('lang.label_product'):
			</div>
			<div class="width60 paddingtopbottom10 inlineblock">
				<select class="width100 generalinput" ng-options="item.id as item.name for item in products" ng-model="redpacket_setting.product_id" ng-disabled="redpacket_setting.redpacket_type==0" >
				</select>
			</div>
		</div>
		<div class="width100 paddingtopbottom10">
			<div class="width30 paddingtopbottom10 inlineblock paddingtop15 text-right">
				@lang('lang.rew_red_packet_period'):
			</div>
			<div class="width60 paddingtopbottom10 inlineblock">
				<div class="searchlayout">
					<input type="text" name="searchdatestart" id="searchdatestart" class="searchdatestart" placeholder="@lang('lang.start date')" ng-model="redpacket_setting.redpacket_start_date" required />
				</div>
				<div class="searchlayout">
					<input type="text" name="searchdateend" id="searchdateend" class="searchdateend" placeholder="@lang('lang.end date')" ng-model="redpacket_setting.redpacket_end_date" min="redpacket_setting.redpacket_start_date" required />
				</div>
			</div>
		</div>
		<div class="width100 paddingtopbottom10">
			<div class="width30 paddingtopbottom10 inlineblock paddingtop15 text-right">
			</div>
			<div class="width60 paddingtopbottom10 inlineblock text-center">
				<button type="submit" class="btn btn-primary btn-sm marginbottom5 width50">@lang('lang.pr_item_save')</button>
			</div>
		</div>
	</div>
</form>

<script src="{{url('')}}/js/control.js"></script>