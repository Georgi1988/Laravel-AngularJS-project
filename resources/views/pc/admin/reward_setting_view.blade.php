<div class="block">
	<a class="subtitle" href="#!/reward/office/list">< @lang('lang.pr_return')</a>
    <div class="subtitle paddingtop15">
        @lang('lang.rew_reward_setting')
    </div>
</div>
<div class="seperatorline"></div>
<div class="paddingtop30"></div>
<div class="right">
    <a class="periodselected period" href="#!/reward/setting/edit/view">
        <i class="glyphicon glyphicon-plus-sign text-white"></i> @lang('lang.rew_red_rule_add_rule')</a>
</div>
<div class="backgroundwhite">
    <div class="block">
        <table class="table">
            <thead>
            <tr>
				<th>@lang('lang.rew_red_packet_name')</th>
                <th>@lang('lang.rew_apply_target')</th>
                <th>@lang('lang.product_style')</th>
                <th>@lang('lang.rew_apply_product')</th>
                <th>@lang('lang.rew_start_time')</th>
                <th>@lang('lang.rew_end_time')</th>
                <th>@lang('lang.rew_apply_kind')</th>
                <th>@lang('lang.rew_red_kind_count')</th>
                <th>@lang('lang.rew_amount')</th>
                <th>@lang('lang.label_table_action')</th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="item in list_data.data">
				<td>
                    <span class="productcateginfoedit inlineblock">{?item.redpacket_name?} </span>
                </td>
                <td>
                    <span class="productcateginfoedit inlineblock">{?item.dealer_name?} </span>
                </td>
                <td>
                    <img class="productthumb" ng-src="{?item.image_url?}">
                </td>
                <td>
                    <span class="productcateginfoedit inlineblock">{?item.product_name?} </span>
                </td>
                <td>
                    <span class="productcateginfoedit inlineblock">{?item.redpacket_start_date?} </span>
                </td>
                <td>
                    <span class="productcateginfoedit inlineblock">{?item.redpacket_end_date?} </span>
                </td>
                <td>
                    <span ng-show="item.redpacket_type==1">@lang('lang.rew_red_allow_count')：</span>
                    <span ng-show="item.redpacket_type==0">@lang('lang.rew_red_allow_amount')：</span>
                </td>
                <td>
                    <span class="productcateginfoedit inlineblock">{?item.redpacket_rule?} </span>
                </td>
                <td>
                    <span class="productcateginfoedit inlineblock">{?item.redpacket_price?} </span>
                </td>
                <td>
                    <a ng-click="onRemove(item.id)" class="stockservicebtn stockservicedownload paddingside20">@lang('lang.price_remove')</a>
                    <a ng-click="onEdit(item)" class="stockservicebtn stockservicedownload paddingside20">@lang('lang.price_edit')</a>
                </td>
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
</div>

<script src="{{url('')}}/js/control.js"></script>