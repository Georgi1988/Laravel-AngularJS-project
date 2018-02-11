
dingdingApp.controller('loginController', function($scope, $rootScope, $route, $routeParams, myDialogService) {
});

// PC, Mobile overview page controller
dingdingApp.controller('overviewController', function($scope, $rootScope, $http, $route, $routeParams, $location, myDialogService) {
	
	if (is_mobile) {
		$scope.newProduct = g_newProduct;
		$scope.newOrder = g_newOrder;
		$scope.newPurchase = g_newPurchase;
		setBadgeHtml($scope.newProduct, $scope.newPurchase, $scope.newOrder);
	}
	
	moment.locale('zh-cn'); 
	
	$scope.pagenum = 1;	
	$scope.itemcount_perpage = 6;
	if(is_mobile) $scope.itemcount_perpage = 12;
	$scope.search = {type: 1, product_type1: '', start_date: '', end_date: ''};
	
	/*******************************
		start date, end date init
	*******************************/
	if(typeof $routeParams.search != "undefined") {
		search_option = JSON.parse(b64DecodeUnicode($routeParams.search));
		Object.keys(search_option).forEach(function(key) {
			if(typeof $scope.search[key] != "undefined") $scope.search[key] = search_option[key];
		});
	}
	
	if($scope.search.start_date == '' && $scope.search.end_date == ''){
		var curr = new Date;
		$scope.search.end_date = curr.getFullYear() + '-' + (curr.getMonth() + 1) + '-' + curr.getDate();
		var firstday = new Date(curr.setDate(curr.getDate() - curr.getDay()));
		$scope.search.start_date = firstday.getFullYear() + '-' + (firstday.getMonth() + 1) + '-' + (firstday.getDate() + 1);
		if(is_mobile) $scope.search.start_date = firstday.getFullYear() + '-' + (firstday.getMonth() + 1) + '-' + (firstday.getDate() + 1);
	}
	
	console.log($scope.search.start_date + " - " + $scope.search.end_date);
	
	if($scope.search.type != 5) $('.date_panel').css('display', 'none');
	
	// Mobile dingding Menu
	if (is_mobile){
		dd.config({
			agentId: _config.agentId,
			corpId: _config.corpId,
			timeStamp: _config.timeStamp,
			nonceStr: _config.nonceStr,
			signature: _config.signature,
			jsApiList: [
				'runtime.info',
				'device.notification.prompt',
				'biz.chat.pickConversation',
				'device.notification.confirm',
				'device.notification.alert',
				'device.notification.prompt',
				'biz.telephone.call',
				'biz.telephone.showCallMenu',
				'biz.chat.open',
				'biz.util.open',
				'biz.user.get',
				'biz.contact.choose',
				'biz.telephone.call',
				'biz.cspace.saveFile',
				'biz.ding.post']
		});

		dd.userid = 0;

		// For only test
//		dd.ready(function() {
			// When back button closed
			backButtonUrl = "#!/overview";

			// Only for iphone
			dd.biz.navigation.setLeft({
				control: true,//是否控制点击事件，true 控制，false 不控制， 默认false
				text: lang.label_back,//控制显示文本，空字符串表示显示默认文本
				onSuccess : function(result) {
					if (backButtonUrl == "") {
						history.back();
					}
					else {
						var temp_url = backButtonUrl;
						backButtonUrl = "";
						location.href = temp_url;
					}
				},
				onFail : function(err) {}
			});
//		});

		// Setup title
		dd.biz.navigation.setTitle({
			title : lang.title_home,// DELL服务卡系统
			onSuccess : function(result) {
			},
			onFail : function(err) {
			}
		});

		console.log("Setup title");

		function ov_set_menu(message_img) {

			// Setup the menus
			switch (user_priv) {
				case 'admin': // When user_priv is admin
					dd.biz.navigation.setMenu({
						backgroundColor : "#ffffff",
						textColor : "#000000",
						items : [
							{ // Inbox icon
								"id": "1",
								"url": base_url + "images/" + message_img, // No new inbox icon
								"text":"邮箱"
							},
							{ // DELL机器码 menu
								"id":"2",
								"text":lang.import_machine_code
							},
							{ // 扫描DELL机器码 menu
								"id":"3",
								"text":lang.scan_machine_code
							},
						],

						onSuccess: function(data) {
							switch (data.id) {
								case '1':
									// Go to message box
									g_isNewMsg = false;
									window.location = "#!/message";
									break;
								case '2':
									window.location = "#!/overview/code";
									break;
								case '3':
									dd.biz.util.scan({
										type: 'all' , // type 为 all、qrCode、barCode，默认是all。
										onSuccess: function(data) {
											console.log(data);
											$http.get(base_url + 'overview/machine_code/insert/' + data.text).then(
												function(response){
													console.log('success');
													window.location = "#!/overview/code/" + response.data.success + "/" + data.text;
												}
											);
										},
										onFail : function(err) {
										}
									});
									break;
							}

							console.log(data);
						},

						onFail: function(err) {
							console.log(err);
						}
					});
					break;
				case 'dealer': // When user_priv is dealer
					dd.biz.navigation.setMenu({
						backgroundColor : "#ffffff",
						textColor : "#000000",
						items : [
							{ // Inbox icon
								"id": "1",
								"url": base_url + "images/" + message_img,
								"text":"邮箱"
							},
						],

						onSuccess: function(data) {
							switch (data.id) {
								case '1':
									// Go to message box
									g_isNewMsg = false;
									window.location = "#!/message";
									break;
								case '2':
									window.location = "#!/overview/code";
									break;
								}
								console.log(data);
							},

						onFail: function(err) {
							console.log(err);
						}
					});
					break;
				case 'seller': // When user_priv is seller
					dd.biz.navigation.setMenu({
						backgroundColor : "#ADD8E6",
						textColor : "#ADD8E611",
						items : [
							{ // Inbox icon
								"id": "1",
								"url": base_url + "images/" + message_img,
								"text":"邮箱"
							}
						],

						onSuccess: function(data) {
							g_isNewMsg = false;
							window.location = "#!/message";
							console.log(data);
						},

						onFail: function(err) {
								console.log(err);
						}
					});
					break;
			}

			console.log("Setup the menus");
		}

		if (g_isNewMsg == true)
			// ov_set_menu('inbox_new-170-64.png');
			ov_set_menu('test_new-170-64.png');
		else
			// ov_set_menu('inbox_in-170-64.png');
			ov_set_menu('test_in-170-64.png');

		setInterval(check_new_message, 10000);

		function check_new_message()
		{
			if (g_isCheckingMsg)
				return;

			g_isCheckingMsg = true;
			$.get("./message/check/new", function( data ) {
				g_isCheckingMsg = false;

				try {
					var json = jQuery.parseJSON(data);

					// For badge
					/***********************************************/
					g_newProduct = json.new_product;
					g_newOrder = json.new_order;
					g_newPurchase = json.new_purchase;

					$scope.newProduct = g_newProduct;
					$scope.newOrder = g_newOrder;
					$scope.newPurchase = g_newPurchase;

					console.log($scope.newProduct);
					console.log($scope.newOrder);
					console.log($scope.newOrdered);

					setBadgeHtml($scope.newProduct, $scope.newPurchase, $scope.newOrder);

					/************************************************/

					/*console.log('message');
					console.log($location.path());
					console.log(json.count);*/

					/*if(json.msg_check_reset == true){
						if ($location.path() == '/overview')
							ov_set_menu('inbox_in-170-64.png');
					}else*/
						if (json.count > 0 || g_isNewMsg == true) {
							if ($location.path() == '/overview')
								// ov_set_menu('inbox_new-170-64.png');
								ov_set_menu('test_new-170-64.png');
							g_isNewMsg = true;

							if (json.count > 0) {
								var snd = new Audio('./contents/alarm/new-message.mp3');
								snd.play();
							}

							if(json.count > 0 && g_isDlgOpen == false){
								g_isDlgOpen = true;

								dd.device.notification.confirm({
									message: json.count + lang.newmsg_confirm_message,
									title: lang.newmsg_confirm_title,
									buttonLabels: [lang.go_msg_page, lang.close],

									onSuccess : function(result) {
										g_isDlgOpen = false;

										if (result.buttonIndex == 0) {
											location.href = "#!/message";
										}
									},

									onFail : function(err) {}
								});
							}
						} else {
							if ($location.path() == '/overview')
								// ov_set_menu('inbox_in-170-64.png');
								ov_set_menu('test_in-170-64.png');
						}
				} catch (e) {
						// error
				}
			});
		}
	}
	// PC Menu
	else{
		$rootScope.route_status = 'overview';
	}
	
	function setBadgeHtml(new_product, new_purchase, new_order) {
		if (user_priv != "seller") {
			if (new_product > 0) {
				html = '<img class="" src="./images/m_product.png"><div class="badge_item">' + new_product + '</div>';
				$('#product').html(html);
			} else {
				html = '<img class="" src="./images/m_product.png">';
				$('#product').html(html);
			}
			
			if (new_purchase + new_order > 0) {
				total = new_purchase + new_order;
				html = '<img class="" src="./images/m_order.png"><div class="badge_item">' + total + '</div>';
				$('#order').html(html);
			} else {
				html = '<img class="" src="./images/m_order.png">';
				$('#order').html(html);
			}
		}
	}
	
	/*******************************
		date picker part
	*******************************/
	$( ".searchdatestart" ).datepicker({
		showOn: "both",
		buttonImage: base_url + "images/date.png",
		buttonImageOnly: true,
		buttonText: "Select date",
		dateFormat: "yy-mm-dd"
    });
	
	$( ".searchdateend" ).datepicker({
		showOn: "both",
		buttonImage: base_url + "images/date.png",
		buttonImageOnly: true,
		buttonText: "Select date",
		dateFormat: "yy-mm-dd"
    });
	
	var daterange_ori = (is_mobile)? 'right': 'left';
	//moment.locale('zh-cn'); 
	$(".weekpicker").daterangepicker({
		minDate: moment().subtract(3, 'years'),
		single: true,
		startDate: $scope.search.start_date,
		orientation: daterange_ori,
		period: 'week'
	}, function (startDate, endDate, period) {
		$scope.search.type = 1;
		$scope.search_period(startDate.format("YYYY-MM-DD"), endDate.format("YYYY-MM-DD"));
	});
	$(".monthpicker").daterangepicker({
		minDate: moment().subtract(3, 'years'),
		single: true,
		startDate: $scope.search.start_date,
		orientation: daterange_ori,
		period: 'month'
	}, function (startDate, endDate, period) {
		$scope.search.type = 2;
		$scope.search_period(startDate.format("YYYY-MM-DD"), endDate.format("YYYY-MM-DD"));
	});
	$(".quaterpicker").daterangepicker({
		minDate: moment().subtract(3, 'years'),
		single: true,
		startDate: $scope.search.start_date,
		orientation: daterange_ori,
		period: 'quarter'
	}, function (startDate, endDate, period) {
		$scope.search.type = 3;
		$scope.search_period(startDate.format("YYYY-MM-DD"), endDate.format("YYYY-MM-DD"));
	});
	$(".yearpicker").daterangepicker({
		minDate: moment().subtract(3, 'years'),
		single: true,
		startDate: $scope.search.start_date,
		orientation: daterange_ori,
		period: 'year'
	}, function (startDate, endDate, period) {
		$scope.search.type = 4;
		$scope.search_period(startDate.format("YYYY-MM-DD"), endDate.format("YYYY-MM-DD"));
	});
	
	// scope function
	
	$scope.show_custom_period = function(){
		$('.date_panel').css('display', 'block');
		$scope.search.type = 5;
	}
	
	$scope.search_period = function(start_date, end_date){
		$scope.search.start_date = start_date;
		$scope.search.end_date = end_date;
		location.href = "#!/overview/search/" + b64EncodeUnicode(JSON.stringify($scope.search));
	}
	
	$scope.search_date = function(){
		$scope.search.type = 5;
		location.href = "#!/overview/search/" + b64EncodeUnicode(JSON.stringify($scope.search));
	}

	
	$scope.search_change = function(select_tag){
		$scope.search.product_type1 = $(select_tag).val();
		location.href = "#!/overview/search/" + b64EncodeUnicode(JSON.stringify($scope.search));
	}
	
	$scope.loaded =  false;
	$http.get(base_url + 'overview/stock_info/' + JSON.stringify($scope.search)).then(
		function(response){
			if(response.status == 200 && response.data.status){
				
				function null2zero(value){
					if(value == null || typeof value == "undefined") return 0;
					else return value;
				}
				
				$('#period_available_count').text(null2zero(response.data.period_stock.available_count));
				$('#period_soon_expired_count').text(null2zero(response.data.period_stock.soon_expired_count));
				$('#period_expired_count').text(null2zero(response.data.period_stock.expired_count));
				$('#period_activation_count').text(null2zero(response.data.period_stock.activation_count));
				$('#period_register_count').text(null2zero(response.data.period_stock.register_count));
				$scope.today_stock = response.data.today_stock;
				$scope.period_stock = response.data.period_stock;
				$scope.yes_top_seller = response.data.yes_top_seller;
				$scope.product_type = response.data.product_type;
				$scope.loaded =  true;
				
				$(".overview_bestseller").css("display", "block");
			}
		}
	);
});


// PC overview list page controller
dingdingApp.controller('overviewListController', function($scope, $rootScope, $route, $routeParams, myDialogService) {
	$rootScope.route_status = 'overview';
});


// PC overview list page controller
dingdingApp.controller('overviewListController', function($scope, $rootScope, $route, $routeParams, myDialogService) {
	$rootScope.route_status = 'overview';
});


// PC overview Code page controller
dingdingApp.controller('overviewCodeController', function($scope, $rootScope, $http, $location, PagerService, $route, $routeParams, myDialogService) {
	if(typeof $routeParams.success == "undefined") {
		$scope.isdlg = false;
	} else {
		$scope.isdlg = true;
		$scope.success = $routeParams.success;
		$scope.machine_code = $routeParams.code;
	}

	$rootScope.route_status = 'overview';
	
	// Config variables
	$scope.pagenum = 1;
	$scope.itemcount_perpage = 7;
	if(is_mobile) $scope.itemcount_perpage = 12;
	
	$("#overviewimport").css("display", "none");
	
	var overviewimport = $( "#overviewimport" ).dialog({
		autoOpen: false,
		resizable: false,
		height: "auto",
		width: 740,
		modal: true,
	});
		
	$( ".overviewimport" ).click( function() {
		overviewimport.dialog( "open" );
	});
	
	$scope.close_import_dlg = function() {
		overviewimport.dialog( "close" );
	}
	
	get_page_list($scope.pagenum, $scope.itemcount_perpage);
	
	function get_page_list(pagenum, itemcount){
		$scope.loaded =  false;
		$scope.busy = true;
		$http.get('overview/machine_code/list/' + $scope.itemcount_perpage + '/' + pagenum).then(
			function(response){
				$scope.busy = false;	// It is true when this is loading
				$scope.loaded =  true;
				if(is_mobile){
					if(pagenum == 1){
						delete $scope.items;
						$scope.items = [];
					}
					var list_data = response.data.list;
					$scope.last_page = list_data.last_page;
					$scope.pagenum = list_data.current_page;
					var items = list_data.data;
					for (var i = 0; i < items.length; i++) {
						$scope.items.push(items[i]);
					}
				}else{					
					$scope.list_data = response.data.list;
					$scope.last_page = $scope.list_data.last_page;
					$scope.pagenation = PagerService.GetPager($scope.list_data.total, $scope.list_data.current_page, $scope.list_data.per_page, 10);
				}
			}
		);
	}

	if (is_mobile) {
		// Scroll event listener
		$(window).on('scroll', function() {
			if( $(window).scrollTop() >= $(document).height() - $(window).height() ) {
				if($scope.loaded && $scope.pagenum < $scope.last_page){
					get_page_list(($scope.pagenum + 1), $scope.itemcount_perpage);
				}
			}
		}).scroll();

		//dd.ready(function() {
			backButtonUrl = "#!/overview";

			// Only for iphone
			dd.biz.navigation.setLeft({
				control: true,//是否控制点击事件，true 控制，false 不控制， 默认false
				text: lang.label_back,//控制显示文本，空字符串表示显示默认文本
				onSuccess : function(result) {
					if (backButtonUrl == "") {
						history.back();
					}
					else {
						var temp_url = backButtonUrl;
						backButtonUrl = "";
						location.href = temp_url;
					}
				},
				onFail : function(err) {}
			});
		//});
			// Setup title
			dd.biz.navigation.setTitle({
				title : lang.label_machine_code,// 机器码
				onSuccess : function(result) {
				},
				onFail : function(err) {}
			});

			// Set empty menu
			dd.biz.navigation.setRight({
				show: false,//控制按钮显示， true 显示， false 隐藏， 默认true
				control: true,//是否控制点击事件，true 控制，false 不控制， 默认false
				text: '发送',//控制显示文本，空字符串表示显示默认文本
				onSuccess : function(result) {
				},
				onFail : function(err) {}
			});
		//});

		if ($scope.isdlg) {
			$("#successDlg").modal({backdrop: 'static', keyboard: false});
		}

	}

	$scope.setPage = function(pagenum){
		if(pagenum < 1) pagenum = 1;
		else if(pagenum > $scope.list_data.last_page) pagenum = $scope.list_data.last_page;
		get_page_list(pagenum, $scope.itemcount_perpage);
	}
	
	$scope.delete_selected = function() {
		var selected_list = [];
		$('input:checked.checkbox_list').each(function(index){
			selected_list[index] = $(this).val();
		});
		
		if(selected_list.length == 0) {
//			custom_alert("Please select machine code to delete!", "Error");
			
			myDialogService.alert({
				title: lang.select_confirm_title,
				message: lang.select_confirm_message,
				button: lang.close,
				animation: "fade",
			});

			return;
		}
		
		myDialogService.confirm({
			title: lang.del_confirm_title,
			message: lang.del_confirm_message,
			confirm_txt: lang.confirm,
			cancle_txt: lang.cancel,
			success_callback: function(){				
				$http.post('overview/machine_code/delete', selected_list).then(
					function(response) {
						if(response.status == 200 && response.data.status){
							$route.reload();
						}
					}
				);
			},
			cancle_callback: null,
			fail_callback: null
		});
	}
	
	$scope.submit_import_csv = function() {
		
		var csv_formData = new FormData(document.getElementById("csv_file_form"));
		
		console.log(csv_formData);
		
		$.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')	
            }
        });
		
		$.ajax({
			url: "overview/machine_code/import",
			type: 'POST',
			data:  csv_formData,
			encType:"multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			success: function(result, textStatus, jqXHR)
			{
				try{
					var data = jQuery.parseJSON(result);
					if(data.status){
						myDialogService.alert({
							title: lang.import_dlg_title,
							message: lang.import_dlg_message,
							button: lang.close,
							animation: "fade",
							callback: function(){
								overviewimport.dialog( "close" );
								$route.reload();
							}
						});
					}else{
						myDialogService.alert({
							title: lang.import_dlg_title_fail,
							message: lang.import_dlg_message_fail,
							button: lang.close,
							animation: "fade",
							callback: function(){
							}
						});
						
					}
				} catch (err){
					//console.log(err);
					custom_alert('Server error occures!', "error");
					myDialogService.alert({
						title: lang.import_dlg_title_fail,
						message: lang.import_dlg_message_fail,
						button: lang.close,
						animation: "fade",
						callback: function(){
						}
					});
				}
			}
		});
		
		return false;
	}
	
	function custom_alert( message, title ) {
		if ( !title )
			title = 'Alert';

		if ( !message )
			message = 'No Message to Display.';

		$('<div></div>').html( message ).dialog({
			title: title,
			resizable: false,
			modal: true
		});
	}
});