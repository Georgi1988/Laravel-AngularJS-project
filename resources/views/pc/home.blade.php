@extends('layouts.pc')

@section('style_part')
	<!-- styles -->
    <link href="{{url('')}}/css/jquery-ui.min.css" type="text/css" rel="stylesheet"/>
	<link href="{{url('')}}/css/bootstrap.min.css" rel="stylesheet"/>
	<link href="{{url('')}}/css/bootstrap-switch.min.css" rel="stylesheet"/>
	<link href="{{url('')}}/css/jquery.dialog.min.css" type="text/css" rel="stylesheet"/>
	<link href="{{url('')}}/css/daterangepicker.min.css" type="text/css" rel="stylesheet"/>
	<link href="{{url('')}}/css/app-green.css" type="text/css" rel="stylesheet"/>
	<link href="{{url('')}}/css/app-vendor.css" type="text/css" rel="stylesheet"/>
	<link href="{{url('')}}/css/app-custom.css" type="text/css" rel="stylesheet"/>
	<link href="{{url('')}}/css/style.css" type="text/css" rel="stylesheet"/>
@endsection

@section('javascript_part')	
	<!-- scripts -->
	<script type="text/javascript">	
		var base_url = '{!!url("/");!!}/';
		var user_priv = '{{$user_priv}}';
		var is_mobile = {{$is_mobile}};
		var g_isDlgOpen = false;
		var g_isCheckingMsg = false;
		var g_newProduct = 0;
		var g_newOrder = 0;
		var g_newPurchase = 0;
		var g_newPrice = 0;
		
		var lang = {
			'error' : "@lang('lang.error')", // Error
			'close' : "@lang('lang.Close')", // Close
			'cancel' : "@lang('lang.cancel')", // cancel
			'go_msg_page' : "@lang('lang.go_msg_page')", // msg page
			'confirm' : "@lang('lang.confirm')", // confirm
			'del_confirm_title' : "@lang('lang.del_confirm_title')", // confirm
			'del_confirm_message' : "@lang('lang.del_confirm_message')", // confirm
			'select_confirm_title' : "@lang('lang.select_confirm_title')", // confirm
			'select_confirm_message' : "@lang('lang.select_confirm_message')", // confirm
			'import_dlg_title' : "@lang('lang.import_dlg_title')", // confirm
			'import_dlg_message' : "@lang('lang.import_dlg_message')", // confirm
			'import_dlg_title_fail' : "@lang('lang.import_dlg_title_fail')", // confirm
			'import_dlg_message_fail' : "@lang('lang.import_dlg_message_fail')", // confirm
			'newmsg_confirm_title' : "@lang('lang.newmsg_confirm_title')", // confirm
			'newmsg_confirm_message' : "@lang('lang.newmsg_confirm_message')", // confirm
			'err_save_fail' : "@lang('lang.err_save_fail')", // confirm
			'err_nofile_select' : "@lang('lang.err_nofile_select')", // confirm
			
			'save_message_fail' : "@lang('lang.save_dlg_message_fail')", // save failed message
			'send_dlg_title' : "@lang('lang.send_dlg_title')", // send failed message
			'send_dlg_title_fail' : "@lang('lang.send_dlg_title_fail')", // send failed message
			'send_dlg_message_fail' : "@lang('lang.send_dlg_message_fail')", // send failed message
			
			'physical_card' : "@lang('lang.st_physical_card')", // Physical_card
			'virtual_card' : "@lang('lang.st_virtual_card')", // Virtual_card
			'virtual_sp_card' : "@lang('lang.st_virtual_sp_card')", // Virtual special card
			
			
			'loading_failed_title' : "@lang('lang.loading_failed_title')", // loading data failed
			'loading_failed_msg' : "@lang('lang.loading_failed_msg')", // loading data failed
			
			'settle_confirm_message' : "@lang('lang.settle_confirm_message')", 			
			'successful_settle_balance' : "@lang('lang.successful_settle_balance')", 	
			'information' : "@lang('lang.information')", 	
			
			
			
			// Date & Time
			'time_forever_valid_time' : "@lang('lang.forever_valid_time')",	//选择产品
			'time_month' : "@lang('lang.month')",	//选择产品
			'time_months' : "@lang('lang.months')",	//选择产品
			'time_months_multi_suffix' : "@lang('lang.months_multi_suffix')",	//选择产品
			'time_year' : "@lang('lang.year')",	//选择产品
			'time_years' : "@lang('lang.years')",	//选择产品
			'time_half' : "@lang('lang.half')",	//选择产品
			'time_Half' : "@lang('lang.Half')",	//选择产品
			'time_composer_and' : "@lang('lang.time_composer_and')",	//选择产品
			
			//Product
			'title_product' : "@lang('lang.pr_item_select_m')",	//选择产品
			'label_product' : "@lang('lang.pr_label')",	//产品
			'title_order' : "@lang('lang.label_order')",			//订单
			'title_type1_lavel' : "@lang('lang.pr_class1_classification')", //一级产品分类
			'title_type2_lavel' : "@lang('lang.pr_class2_classification')", //二级产品分类
			'title_type3_lavel' : "@lang('lang.pr_class3_classification')", //二级产品分类
			'no_data' : "@lang('lang.no_data')", // No data
			'use_on' : "@lang('lang.use_on')", 	 // On
			'use_off' : "@lang('lang.use_off')", // Off
			'l_operation_type' : "@lang('lang.l_operation_type')", // Off
			'product_save_title' : "@lang('lang.pr_save_dlg_title')", // Product save dialog title
			'product_save_message' : "@lang('lang.pr_save_dlg_message')", // Product save dialog title
			'product_save_title_fail' : "@lang('lang.pr_save_dlg_title_fail')", // Product save dialog title
			'product_save_message_fail' : "@lang('lang.pr_save_dlg_message_fail')", // Product save dialog title

			'total_discount' : "@lang('lang.price_total_promotion')", // 总的促销
			'level_dealer' : "@lang('lang.price_level_dealer')", // 级经销商
			'set_promotion' : "@lang('lang.price_promotion_text')", // 促销设置
			'promotion_success' : "@lang('lang.price_success')", // 成功
			'sale_price' : "@lang('lang.pr_standard_price_s')", // 零售价
			'set_price' : "@lang('lang.price_pricing')",	//定价
			'standard_price' : "@lang('lang.pr_standard_price')",	//标准零售价

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

			'purchase_price' : "@lang('lang.pur_purchase_price')",	//进货价
			'wholesale_price' : "@lang('lang.price_wholesale_price')",	//出货价
			'label_machine_code' : "@lang('lang.st_machine_code')",	//机器码
			'label_back' : "@lang('lang.label_back')",	//返回
			'input_valid_num' : "@lang('lang.input_valid_num')",// 输入有效数字
			
			// Price
			'must_select_dealer' : "@lang('lang.must_select_dealer')",	//改价
			'must_select_product' : "@lang('lang.must_select_product')",	//改价
			
			//Generate
			'title_gen_card_rule' : "@lang('lang.gen_card_rule')",	//card code rule
			
			//order
			'rg_fail_save' : "@lang('lang.rg_fail_save')",		//订单详情
			
			//register
			'register_save_message_fail' : "@lang('lang.rg_error_save')",
			'cn_unit' : "@lang('lang.label_cn_cunit')", // 元
			'price_save_fail' : "@lang('lang.price_save_fail')", // 保存失败!
			'price_remove_fail' : "@lang('lang.price_remove_fail')", // 删除失败!
			'card_register': "@lang('lang.rg_card_register')",	// Card register
			
			//purchase alert price
			'purchase_is_price' : "@lang('lang.pur_is_price')",	//出货价
			'purchase_is_price_warning' : "@lang('lang.pur_warning')",	//出货价
			'gen_check_cardcount' : "@lang('lang.gen_check_cardcount')",
			
			'price_set_confirm' : "@lang('lang.price_set_confirm')", //是否确认价格
			'promotion_set_confirm' : "@lang('lang.promotion_set_confirm')", //是否确认促销
			'promotion_remove_confirm' : "@lang('lang.promotion_remove_confirm')", //是否确认删除
			'price_btn_confirm' : "@lang('lang.price_btn_confirm')", //确认
			'price_btn_cancel' : "@lang('lang.price_btn_cancel')", //取消
			'price_set_low_alert' : "@lang('lang.price_set_low_alert')", //“出货价不能低于进货价”是否继续操作
			'price_btn_continue' : "@lang('lang.price_btn_continue')", //继续
			'price_sending' : "@lang('lang.price_sending')", //发送中...
			'price_save_success' : "@lang('lang.price_save_success')", //保存成功!
			'price_remove_success' : "@lang('lang.price_remove_success')", //删除成功!
			
			'price_levelpromotion_require' : "@lang('lang.price_levelpromotion_require')", //开始日期和结束日期必须输入，促销至少1个是必需的输入
			
			// Redpacket
			'rew_confirm_redpacket_setting' : "@lang('lang.rew_confirm_redpacket_setting')", //是不确定红包设置
			'rew_confirm_redpacket_remove' : "@lang('lang.rew_confirm_redpacket_remove')", //是不确定红包删除
			'title_reward_setting' : "@lang('lang.rew_reward_setting')",		//奖励设置			
			'rew_required_redpacket_field' : "@lang('lang.rew_required_redpacket_field')",		//红包名称,奖励金额,达标数量/金额,周期时间必须输入,经销商必须选择.
			'rew_require_redpacket' : "@lang('lang.rew_require_redpacket')", // Do you want to require sending redpacket?
			
			'rew_red_rule_add_rule' : "@lang('lang.rew_red_rule_add_rule')", //奖励规则添加
		};
		
	</script>
	<script src="{{url('')}}/js/jquery-1.12.4.min.js"></script>
	<script src="{{url('')}}/js/jquery-ui.min.js"></script>	
	<script src="{{url('')}}/js/jquery.dialog.min.js"></script>	
	
	<script src="{{url('')}}/js/bootstrap.min.js"></script>
	<script src="{{url('')}}/js/bootstrap-switch.min.js"></script>
	
	<script src="{{url('')}}/js/knockout-min.js"></script>
	<script src="{{url('')}}/js/moment-with-locales.min.js"></script>
	<script src="{{url('')}}/js/daterangepicker.min.js"></script>
	
	<script src="{{url('')}}/js/angular.min.js"></script>
	<script src="{{url('')}}/js/angular-route.min.js"></script>
	
	<script src="{{url('')}}/js/angular_controller/dingdingapp.js"></script>	
		
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
	<script src="{{url('')}}/js/angular_controller/dingdingController_Log.js"></script>
	
	<script src="{{url('')}}/js/angular_controller/dingdingroute.js"></script>
	<script src="{{url('')}}/js/angular_controller/dingdingdirective.js"></script>
	<script src="{{url('')}}/js/angular_controller/dingdingservice.js"></script>
	
	<script>
		setInterval(check_new_message, 15000);

		function check_new_message( )
		{
			$.get("./message/check/new", function( data ) {
				try {
					var json = jQuery.parseJSON(data);
					
					set_product_badge(json.new_product);
					set_order_badge(json.new_purchase, json.new_order);
					
					if(json.msg_check_reset == true){
						$(".emailalarm").css("display", "none");
					}else if(json.count > 0 && json.msg_check_reset == false){
						$(".emailalarm").css("display", "block");
						var snd = new Audio('./contents/alarm/new-message.mp3');
						snd.play();
						
						if(json.count > 0 && g_isDlgOpen == false){
							g_isDlgOpen = true;
							DingTalkPC.device.notification.confirm({
								message: json.count + lang.newmsg_confirm_message,
								title: lang.newmsg_confirm_title,
								buttonLabels: [lang.go_msg_page, lang.close],
								onSuccess : function(result) {
									g_isDlgOpen = false;
									if (result.buttonIndex == 0)
										location.href = "#!/message";	
								},
								onFail : function(err) {}
							});
						}
					}else{
					}
				}catch (e) {
					// error
				}
			});
		}
		
		function set_product_badge(new_product) {
			g_newProduct = new_product;
			if (new_product > 0) {
				html = '<img src="{{url('')}}/images/product.png" alt="product" /><div class="badge_item">' + new_product + '</div><div class="navtext">' + lang.label_product + '</div>';
				$('#product').html(html);
			} else {
				html = '<img src="{{url('')}}/images/product.png" alt="product" /><div class="navtext">' + lang.label_product + '</div>';
				$('#product').html(html);
			}
		}
		
		function set_order_badge(new_purchase, new_order) {
			g_newPurchase = new_purchase;
			g_newOrder = new_order;
			total = new_purchase + new_order;
			if (total > 0) {
				html = '<img src="{{url('')}}/images/order.png" alt="order" /><div class="badge_item">' + total + '</div><div class="navtext">' + lang.title_order + '</div>';
				$('#order').html(html);
			} else {
				html = '<img src="{{url('')}}/images/order.png" alt="order" /><div class="navtext">' + lang.title_order + '</div>';
				$('#order').html(html);
			}
		}
	</script>
	
@endsection
