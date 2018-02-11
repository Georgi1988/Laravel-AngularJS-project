	<div class="block">
		<div class="left">
			<a href="#!/product" onclick="history.back();">< @lang('lang.pr_return')</a>
			<div class="subtitle paddingtop15">
				@lang('lang.gen_card_rule')
			</div>
		</div>
		<div class="right paddingtop30">
			<div class="btn-group" role="group" aria-label="Basic example">
				<a ng-href="#!/generate/dictionary/dic_retail" class="width-100px btn btn-info">@lang('lang.gen_dic_corp')</a>
				<a ng-href="#!/generate/dictionary/dic_area" class="width-100px btn btn-info">@lang('lang.gen_dic_area')</a>
				<a ng-href="#!/generate/dictionary/dic_province" class="width-100px btn btn-info">@lang('lang.gen_dic_province')</a>
				<a ng-href="#!/generate/dictionary/dic_card_type" class="width-100px btn btn-info">@lang('lang.gen_dic_cardtype')</a>
				<a ng-href="#!/generate/dictionary/dic_service_type" class="width-100px btn btn-info">@lang('lang.gen_dic_servicetype')</a>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="seperatorline"></div>
	<div class="paddingtop15"></div>
	<div class="right">
		<a class="periodselected period" ng-href="#!/generate/card_rule/edit/0">@lang('lang.gen_add_item')</a>
	</div>
	<div class="clearfix"></div>
	<div class="block">
		<table class="table">
			<thead>
				<tr>
					<th>@lang('lang.no')</th>
					<th>@lang('lang.gen_card_rule_name')</th>
					<th>@lang('lang.gen_card_rule_length')</th>
					<th>@lang('lang.gen_card_rule_fieldtype')</th>
					<th>@lang('lang.gen_card_rule_pwd_length')</th>
					<th>@lang('lang.label_table_action')</th>
				</tr>
			</thead>
			<tbody ng-init="disp_index = 0">
				<tr ng-repeat="item in list_data.data" ng-init="disp_index=disp_index+1" class="product_item">
					<td>{?$index + itemcount_perpage * (pagenum - 1) + 1?}</td>
					<td>{?item.rule_name?}</td>
					<td>{?item.card_code_length	?}<span>@lang('lang.bytes')</span></td>
					<td>{?item.length_type?}</td>
					<td>
						{?item.password_length?}<span>@lang('lang.bytes')</span> 
						(
							<span ng-show="item.password_type == 'n'">@lang('lang.password_type1')</span>
							<span ng-show="item.password_type == 'l'">@lang('lang.password_type2')</span>
							<span ng-show="item.password_type == 'l+n'">@lang('lang.password_type3')</span>
						)
					</td>
					<td>
						<a class="padding_3-6" ng-href="#!/generate/card_rule/edit/{?item.id?}">
							<i class="glyphicon glyphicon-edit text-info"></i>
						</a>
						<a class="padding_3-6" ng-click="item_delete(item.id);">
							<i class="glyphicon glyphicon-trash text-danger"></i>
						</a>
					</td>
				</tr>
				<tr ng-show="no_data">
					<td colspan="6">@lang('lang.str_no_data')</td>
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