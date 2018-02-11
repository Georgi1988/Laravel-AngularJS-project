@extends('layouts.mobile')


@section('style_part')
	<link href="{{url('')}}/css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
	<link href="{{url('')}}/css/bootstrap-switch.min.css" rel="stylesheet"/>
	<link href="{{url('')}}/css/jquery.dialog.min.css" type="text/css" rel="stylesheet"/>
	<link href="{{url('')}}/css/daterangepicker.min.css" type="text/css" rel="stylesheet"/>
	<link href="{{url('')}}/css/jquery-ui.min.css" type="text/css" rel="stylesheet"/>
	<link href="{{url('')}}/css/mobile_style.css" type="text/css" rel="stylesheet"/>
@endsection

@section('javascript_part')
	<script src="{{url('')}}/js/jquery-1.12.4.min.js"></script>
	<script src="{{url('')}}/js/jquery-ui.min.js"></script>	
	
	<script src="{{url('')}}/js/knockout-min.js"></script>
	<script src="{{url('')}}/js/moment-with-locales.min.js"></script>
	<script src="{{url('')}}/js/daterangepicker.min.js"></script>
	
	<script src="{{url('')}}/js/bootstrap.min.js"></script>
	<script src="{{url('')}}/js/bootstrap-switch.min.js"></script>
	<script src="{{url('')}}/js/angular.min.js"></script>
	<script src="{{url('')}}/js/angular-route.min.js"></script>

	
	<script type="text/javascript">	
		var base_url = '{!!url("/");!!}/';
		var user_priv = '{{$user_priv}}';
		var is_mobile = {{$is_mobile}};
		
		// mobile container min height setting
		$(".container").css('min-height', jQuery(window).height() + 'px');
		
		/* start of Language local variables */
		
		var lang = {
			'error' : "@lang('lang.error')", 											// Error
			'close' : "@lang('lang.Close')", 											// Close
			'cancel' : "@lang('lang.cancel')", 											// cancel
			'go_msg_page' : "@lang('lang.go_msg_page')", 								// msg page
			'confirm' : "@lang('lang.confirm')", 										// confirm
			'del_confirm_title' : "@lang('lang.del_confirm_title')", 					// confirm
			'del_confirm_message' : "@lang('lang.del_confirm_message')", 				// confirm
			'select_confirm_title' : "@lang('lang.select_confirm_title')", 				// confirm
			'select_confirm_message' : "@lang('lang.select_confirm_message')", 			// confirm
			'import_dlg_title' : "@lang('lang.import_dlg_title')", 						// confirm
			'import_dlg_message' : "@lang('lang.import_dlg_message')", 					// confirm
			'import_dlg_title_fail' : "@lang('lang.import_dlg_title_fail')", 			// confirm
			'import_dlg_message_fail' : "@lang('lang.import_dlg_message_fail')", 		// confirm
			'newmsg_confirm_title' : "@lang('lang.newmsg_confirm_title')", 				// confirm
			'newmsg_confirm_message' : "@lang('lang.newmsg_confirm_message')", 			// confirm
			'err_save_fail' : "@lang('lang.err_save_fail')", 							// confirm
			'err_nofile_select' : "@lang('lang.err_nofile_select')", 							// confirm
			
			'save_message_fail' : "@lang('lang.save_dlg_message_fail')", 				// save failed message
			'send_dlg_title' : "@lang('lang.send_dlg_title')", 							// send failed message
			'send_dlg_title_fail' : "@lang('lang.send_dlg_title_fail')", 				// send failed message
			'send_dlg_message_fail' : "@lang('lang.send_dlg_message_fail')", 			// send failed message
			
			'physical_card' : "@lang('lang.st_physical_card')", 						// Physical_card
			'virtual_card' : "@lang('lang.st_virtual_card')", 							// Virtual_card
			'virtual_sp_card' : "@lang('lang.st_virtual_sp_card')", 					// Virtual special card
			
			'loading_failed_title' : "@lang('lang.loading_failed_title')", 				// loading data failed
			'loading_failed_msg' : "@lang('lang.loading_failed_msg')", 					// loading data failed

			'settle_confirm_message' : "@lang('lang.settle_confirm_message')", 			
			'successful_settle_balance' : "@lang('lang.successful_settle_balance')", 	
			'information' : "@lang('lang.information')", 	
			
			
			// title part	

			'btn_edit' : "@lang('lang.pr_item_edit')",									// 定价
			'btn_promo' : "@lang('lang.pr_promo_edit')",								// 促销
			'btn_save' : "@lang('lang.pr_item_save')",									// 保存
			'btn_complete' : "@lang('lang.complete')",									// 完成
			'btn_cancle' : "@lang('lang.cancel')",										// 取消
			'btn_setting' : "@lang('lang.setting')",									// 设置
			
			
			// Date & Time
			'time_forever_valid_time' : "@lang('lang.forever_valid_time')",				// 选择产品
			'time_month' : "@lang('lang.month')",										// 选择产品
			'time_months' : "@lang('lang.months')",										// 选择产品
			'time_months_multi_suffix' : "@lang('lang.months_multi_suffix')",			// 选择产品
			'time_year' : "@lang('lang.year')",											// 选择产品
			'time_years' : "@lang('lang.years')",										// 选择产品
			'time_half' : "@lang('lang.half')",											// 选择产品
			'time_Half' : "@lang('lang.Half')",											// 选择产品
			'time_composer_and' : "@lang('lang.time_composer_and')",					// 选择产品
			
			//overview
			'title_home' : "@lang('lang.home_title_m')",								// DELL服务卡系统
			'import_machine_code' : "@lang('lang.list_machine_code_m')",				// 导入DELL机器码
			'scan_machine_code' : "@lang('lang.scan_machine_code_m')",					// 扫描DELL机器码
			
			//Product
			@if($user_priv == "seller")	
			'title_product' : "@lang('lang.pr_item_select_m')",							// 产品
			@else
			'title_product' : "@lang('lang.pr_label')",									// 选择产品
			@endif
			'title_product_edit' : "@lang('lang.pr_edit_m')",							// 产品编辑
			'title_product_view' : "@lang('lang.pr_info')",								// 产品编辑
			'title_product_add' : "@lang('lang.pr_item_add')",							// 添加产品
			'title_product_type_manage_title' : "@lang('lang.pr_type_manage_title')", 	// 分类管理
			'title_product_type_manage' : "@lang('lang.pr_type_manage')", 				//+ 分类管理
			'title_product_type_add' : "@lang('lang.pr_type_add')", 					//+ 添加分类
			'title_type1_lavel' : "@lang('lang.pr_class1_classification')", 			// 一级产品分类
			'title_type2_lavel' : "@lang('lang.pr_class2_classification')", 			// 二级产品分类
			'title_type3_lavel' : "@lang('lang.pr_class3_classification')", 			// 二级产品分类
			'no_data' : "@lang('lang.no_data')", 										// No data
			'product_save_title' : "@lang('lang.pr_save_dlg_title')", 					// Product save dialog title
			'product_save_message' : "@lang('lang.pr_save_dlg_message')", 				// Product save dialog title
			'product_save_title_fail' : "@lang('lang.pr_save_dlg_title_fail')", 		// Product save dialog title
			'product_save_message_fail' : "@lang('lang.pr_save_dlg_message_fail')", 	// Product save dialog title
			
			//Price
			@if($user_priv == "admin")	
			'title_price' : "@lang('lang.price_pricing')",								// 定价
			@else
			'title_price' : "@lang('lang.price_label')",								// 价格
			@endif
			'title_price_product' : "@lang('lang.price_discount_product')",				// 选择折扣产品
			'title_price_discount' : "@lang('lang.price_discount_price')",				// 折扣促销
			'btn_price_promotion' : "@lang('lang.price_promotion')",					//+ 促销设置
			'btn_price_change' : "@lang('lang.price_change_price')",					// 改价
			'must_select_dealer' : "@lang('lang.must_select_dealer')",					// 改价
			'must_select_product' : "@lang('lang.must_select_product')",					// 改价
			
			//Register
			'title_register' : "@lang('lang.rg_already_act')",							// 已激活产品
			'card_register': "@lang('lang.rg_card_register')",							// Card register
			
			//Stock
			'title_stock' : "@lang('lang.label_stock')",								//库存
			'title_stock_setting' : "@lang('lang.setting')",							//库存设置
			'title_stock_add' : "@lang('lang.purchase')",	    						//进货
			'title_stock_return' : "@lang('lang.return')",	    						//退货
			'title_bulk_register' : "@lang('lang.bulk_register')",	    				//退货
			
			//Generate
			'title_select_card' : "@lang('lang.gen_select_card')",						//选择服务卡
			'title_gen_new' : "@lang('lang.gen_generate_card')",						//生成服务卡
			'title_gen_card_rule' : "@lang('lang.gen_card_rule')",						//card code rule
			
			//order
			'title_order' : "@lang('lang.label_order')",								//订单
			'title_order_setting' : "@lang('lang.od_setting')",							//订单设置
			'title_order_detail' : "@lang('lang.od_detail')",							//订单详情
			'rg_fail_save' : "@lang('lang.rg_fail_save')",								//订单详情
			
			//sales
			'title_sales_amount' : "@lang('lang.label_sale_amount')",					//销量
			'menu_this_week' : "@lang('lang.ov_period_week_m')",						//本周
			'menu_this_month' : "@lang('lang.current_month_m')",						//当月
			'menu_this_quater' : "@lang('lang.time_quater')",							//季度
			'menu_this_year' : "@lang('lang.one_year_m')",								//一年
			'menu_custom' : "@lang('lang.custom')",										//自定义
				
			//reward
			'title_reward' : "@lang('lang.label_reward')",			//奖励
			'btn_reward_setting' : "@lang('lang.rew_reward_setting_btn')",		//+奖励设置
			'title_reward_setting' : "@lang('lang.rew_reward_setting')",		//奖励设置	
			'rew_required_redpacket_field' : "@lang('lang.rew_required_redpacket_field')",		//红包名称,奖励金额,达标数量/金额,周期时间必须输入,经销商必须选择.
			'rew_require_redpacket' : "@lang('lang.rew_require_redpacket')", // Do you want to require sending redpacket?
				
			//user
			@if($user_priv == "dealer")	
			'title_user' : "@lang('lang.label_staff')",									//人员
			@else
			'title_user' : "@lang('lang.label_dealer')",								//经销商
			@endif
			'title_dealer_info' : "@lang('lang.u_dealer_info')", 						//经销商信息
			'btn_synchronize' : "@lang('lang.label_dealer')",							//经销商

			'title_add_dealer' : "@lang('lang.label_add_dealer')",						// 增加经销商
            'title_add_store' : "@lang('lang.label_add_store')",						// 增加零消店
            'title_add_user' : "@lang('lang.label_add_user')",							// 增加人员

			//message
			'title_msg' : "@lang('lang.msg_notify')", 									// 通知
			'title_msg_detail' : "@lang('lang.msg_notify_detail')", 					// 通知详情
			'use_on' : "@lang('lang.use_on')", 	 										// On
			'use_off' : "@lang('lang.use_off')", 										// Off
            'title_dealer_level1' : "@lang('lang.1st_level_dealer')",
            'title_dealer_level2' : "@lang('lang.2nd_level_dealer')",
            'title_dealer_level3' : "@lang('lang.3rd_level_dealer')",
            'title_dealer_level4' : "@lang('lang.4th_level_dealer')",
            'title_dealer_level5' : "@lang('lang.5th_level_dealer')",
            'title_dealer_level6' : "@lang('lang.6th_level_dealer')",
            'title_dealer_level7' : "@lang('lang.7th_level_dealer')",
            'title_dealer_level8' : "@lang('lang.8th_level_dealer')",
            'title_dealer_level9' : "@lang('lang.9th_level_dealer')",
            'title_dealer_level10' : "@lang('lang.10th_level_dealer')",
            'title_dealer_level11' : "@lang('lang.11th_level_dealer')",
            'title_dealer_level12' : "@lang('lang.12th_level_dealer')",
            'title_dealer_level13' : "@lang('lang.13th_level_dealer')",
            'title_dealer_level14' : "@lang('lang.14th_level_dealer')",
            'title_dealer_level15' : "@lang('lang.15th_level_dealer')",
            'title_dealer_level16' : "@lang('lang.16th_level_dealer')",
            'title_dealer_level17' : "@lang('lang.17th_level_dealer')",
            'title_dealer_level18' : "@lang('lang.18th_level_dealer')",
            'title_dealer_level19' : "@lang('lang.19th_level_dealer')",
            'title_dealer_level20' : "@lang('lang.20th_level_dealer')",

			'total_discount' : "@lang('lang.price_total_promotion')", 					// 总的促销
			'level_dealer' : "@lang('lang.price_level_dealer')", 						// 级经销商
			'set_promotion' : "@lang('lang.price_promotion_text')", 					// 促销设置
			'promotion_success' : "@lang('lang.price_success')", 						// 成功
			'sale_price' : "@lang('lang.pr_standard_price_s')", 						// 零售价
			'set_price' : "@lang('lang.price_pricing')",								// 定价
			'standard_price' : "@lang('lang.pr_standard_price')",						// 标准零售价
			'purchase_price' : "@lang('lang.pur_purchase_price')",						// 进货价
			'wholesale_price' : "@lang('lang.price_wholesale_price')",					// 出货价
			'label_machine_code' : "@lang('lang.st_machine_code')",						// 机器码
			'label_back' : "@lang('lang.label_back')",									// 返回
			'input_valid_num' : "@lang('lang.input_valid_num')",						// 输入有效数字
			
			//register
			'register_save_message_fail' : "@lang('lang.rg_error_save')",
			'cn_unit' : "@lang('lang.label_cn_cunit')", 								// 元
			'price_save_fail' : "@lang('lang.price_save_fail')", 						// 保存失败!
			'price_remove_fail' : "@lang('lang.price_remove_fail')", 					// 删除失败!
			//purchase alert price
			'purchase_is_price' : "@lang('lang.pur_is_price')",							// 出货价
			'purchase_is_price_warning' : "@lang('lang.pur_warning')",					// 出货价
			"activation_title" : "@lang('lang.activation')",
			"register_title" : "@lang('lang.register')",
			"ac_phy_card_title" : "@lang('lang.ac_phy_card_title')",
			"ac_vir_card_title" : "@lang('lang.ac_vir_card_title')",
			"ac_card_exist_title" : "@lang('lang.ac_card_exist_title')",
			"ac_card_avtivated_title" : "@lang('lang.ac_card_avtivated_title')",
			"rt_card_registered_title" : "@lang('lang.rt_card_registered_title')",
			"rt_machinecode_no_title" : "@lang('lang.rt_machinecode_no_title')",
			"gen_check_cardcount" : "@lang('lang.gen_check_cardcount')",
			"rg_invalid_pass" : "@lang('lang.rg_invalid_pass')",
			
			'price_set_confirm' : "@lang('lang.price_set_confirm')", 					// 是否确认价格
			'promotion_set_confirm' : "@lang('lang.promotion_set_confirm')", 			// 是否确认促销
			'promotion_remove_confirm' : "@lang('lang.promotion_remove_confirm')", 		// 是否确认删除
			'price_btn_confirm' : "@lang('lang.price_btn_confirm')", 					// 确认
			'price_btn_cancel' : "@lang('lang.price_btn_cancel')", 						// 取消
			'price_set_low_alert' : "@lang('lang.price_set_low_alert')", 				// “出货价不能低于进货价”是否继续操作
			'price_btn_continue' : "@lang('lang.price_btn_continue')", 					// 继续
			'price_sending' : "@lang('lang.price_sending')", 							// 发送中...
			'price_save_success' : "@lang('lang.price_save_success')", 					// 保存成功!
			'price_remove_success' : "@lang('lang.price_remove_success')", 				// 删除成功!
			'price_promotion_dateinput' : "@lang('lang.price_promotion_dateinput')", 	// 开始日期必须早于截止日期!
			'price_levelpromotion_require' : "@lang('lang.price_levelpromotion_require')", 		// 开始日期和结束日期必须输入，促销至少1个是必需的输入
			
			'rew_confirm_redpacket_setting' : "@lang('lang.rew_confirm_redpacket_setting')", 	// 是不确定红包设置
			'rew_confirm_redpacket_remove' : "@lang('lang.rew_confirm_redpacket_remove')", 		// 是不确定红包删除
			'rew_required_redpacket_field' : "@lang('lang.rew_required_redpacket_field')",		// 红包名称,奖励金额,达标数量/金额,周期时间必须输入,经销商必须选择.
			'rew_red_rule_add_rule' : "@lang('lang.rew_red_rule_add_rule')", 					// 奖励规则添加
		};
		
		var oldURL = document.referrer;
		console.log('oldurl');
		console.log(oldURL);

		var backButtonUrl = "";
		var backbutton_click = function(e) {
			e.preventDefault();
			//document.removeEventListener("backbutton", backbutton_click);
//			console.log("back button clicked!");
//			console.log(backButtonUrl);
			if (backButtonUrl == "") {
				history.back();
			}
			else {
				var temp_url = backButtonUrl;
				backButtonUrl = "";
				location.href = temp_url;
			}
		}
		
		dd.ready(function() {
			document.addEventListener('backbutton', backbutton_click, false);
		});

		var g_isNewMsg = false;
		var g_isDlgOpen = false;
		var g_isCheckingMsg = false;
		var g_newProduct = 0;
		var g_newOrder = 0;
		var g_newPurchase = 0;
		var g_newPrice = 0;
		
// 		console.log(lang);
		
		/* the end of Language local variables */
		
		
		//var userdetail;
		//var departstruct;

				

	</script>
	
	<script src="{{url('')}}/js/jquery.dialog.min.js"></script>	
	
	<script src="{{url('')}}/js/angular_controller/dingdingapp.js"></script>
	
	<script src="{{url('')}}/js/angular_controller/dingdingroute.js"></script>
	<script src="{{url('')}}/js/angular_controller/dingdingdirective.js"></script>
	<script src="{{url('')}}/js/angular_controller/dingdingservice.js"></script>

	<script src="{{url('')}}/js/angular_controller/dingdingController_Overview.js"></script>
	<script src="{{url('')}}/js/angular_controller/dingdingController_Product.js"></script>
	<script src="{{url('')}}/js/angular_controller/dingdingController_Price.js"></script>
	<script src="{{url('')}}/js/angular_controller/dingdingController_Register.js"></script>
	<script src="{{url('')}}/js/angular_controller/dingdingController_Stock.js"></script>
	<script src="{{url('')}}/js/angular_controller/dingdingController_Generate.js"></script>
	<script src="{{url('')}}/js/angular_controller/dingdingController_Purchase.js"></script>
	<script src="{{url('')}}/js/angular_controller/dingdingController_Order.js"></script>
	<script src="{{url('')}}/js/angular_controller/dingdingController_Sales.js"></script>
	<script src="{{url('')}}/js/angular_controller/dingdingController_Reward.js"></script>
	<script src="{{url('')}}/js/angular_controller/dingdingController_RewardSetting.js"></script>
	<script src="{{url('')}}/js/angular_controller/dingdingController_User.js"></script>
	<script src="{{url('')}}/js/angular_controller/dingdingController_Message.js"></script>
	
@endsection