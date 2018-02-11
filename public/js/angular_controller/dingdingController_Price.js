
// Mobile price page controller only admin and dealer
dingdingApp.controller('priceController', function($scope, $rootScope, $route, $routeParams, $http, PagerService, myDialogService) {
	// Config variables
	$scope.pagenum = 1;
	$scope.itemcount_perpage = 5;
	if(is_mobile) $scope.itemcount_perpage = 4;
	$scope.search = {level1_type: '', level2_type: '', keyword: '', status: ''};

	$scope.no_data = false;

	function get_page_list(pagenum, itemcount, search){
		if(is_mobile){
			if(pagenum == 1){
				delete $scope.items;
				$scope.items = [];
			}
		}
		$scope.no_data = false;
		$scope.loaded =  false;
		$scope.busy = true;
		$http.get('product/list/' + JSON.stringify(search) + '/' + itemcount + '/' + pagenum).then(
			function(response){
				console.log(response);
				$scope.busy = false;	// It is true when this is loading
				$scope.loaded =  true;
				if(is_mobile){
					var list_data = response.data.list;
					$scope.last_page = list_data.last_page;
					$scope.pagenum = list_data.current_page;
					var items = list_data.data;
					for (var i = 0; i < items.length; i++) {
						$scope.items.push(items[i]);
					}
					if ($scope.items.length == 0) {
						$scope.no_data = true;
					}
				}else{					
					$scope.list_data = response.data.list;
					$scope.last_page = $scope.list_data.last_page;
					$scope.pagenation = PagerService.GetPager($scope.list_data.total, $scope.list_data.current_page, $scope.list_data.per_page, 10);
					if ($scope.list_data.data.length == 0) {
						$scope.no_data = true;
					}
				}
			}
		);
	}
	// When pagination changed
	$scope.setPage = function(pagenum){
		if(pagenum < 1) pagenum = 1;
		else if(pagenum > $scope.list_data.last_page) pagenum = $scope.list_data.last_page;
		get_page_list(pagenum, $scope.itemcount_perpage, $scope.search);
	}

	// Update the page list's data when selectbox is changed
	$scope.search_change = function(){
		get_page_list(1, $scope.itemcount_perpage, $scope.search);
	}
	// Update the page list's data when tab is changed in mobile
	$scope.search_type1 = function(type1){
		$scope.search.level1_type = type1;
		get_page_list(1, $scope.itemcount_perpage, $scope.search);
	}

	// For calculate the diff days between two dates
	$scope.parseDate = function(str) {
		var mdy = str.split('-');
		return new Date(mdy[0], mdy[1]-1, mdy[2]);
	}

	$scope.dayDiff = function(first, second) {
		return Math.round((second-first)/(1000*60*60*24));
	}

	// Get the current date
	d = new Date();
	$scope.cur_date = d.getFullYear() + "-" + (d.getMonth() + 1) + "-" + d.getDate();

	$http.get('product/get/class/all').then(
		function(response){
			var level1_select = {id: "", description: "--" + lang['title_type1_lavel'] + "--"};
			$scope.typelist1 = response.data.level1_type;
			if(!is_mobile){
				$scope.typelist1.unshift(level1_select);
			} 
			else{
				//$scope.search.level1_type = $scope.typelist1[0].id;
			}
			var level2_select = {id: "", description: "--" + lang['title_type2_lavel'] + "--"};
			$scope.typelist2 = response.data.level2_type;
			if(!is_mobile) $scope.typelist2.unshift(level2_select);
			
			get_page_list($scope.pagenum, $scope.itemcount_perpage, $scope.search);
		}
	);
	
	// Mobile dingding Menu
	if(is_mobile){
		// Scroll event listener
		$(window).on('scroll', function(){
			if( $(window).scrollTop() >= $(document).height() - $(window).height() ) {
				if($scope.loaded && $scope.pagenum < $scope.last_page){
					get_page_list(($scope.pagenum + 1), $scope.itemcount_perpage, $scope.search);
				}
			}
		}).scroll();

		//dd.ready(function() {
			// When back button closed
			// document.addEventListener('backbutton', function(e) {
			// 	e.preventDefault();
			// 	window.location = "#!/overview";
			// }, false);
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
				title : lang.title_price,// 价格, 定价
				onSuccess : function(result) {
				},
				onFail : function(err) {}
			});

			switch (user_priv) {
			case 'admin': // When user_priv is admin
				// Setup menus
				/*dd.biz.navigation.setMenu({
					backgroundColor : "#ffffff",
					textColor : "#000000",
					items : [
						{ // +促销设置 menu
							"id":"1",
							"text":lang.btn_price_promotion
						},
					],
					onSuccess: function(data) {
						window.location = "#!/price/discount/select";
						console.log(data);
					},
					onFail: function(err) {
						console.log(err);
					}
				});*/
				// Set empty menu
				dd.biz.navigation.setRight({
					show: false,//控制按钮显示， true 显示， false 隐藏， 默认true
					control: true,//是否控制点击事件，true 控制，false 不控制， 默认false
					text: '发送',//控制显示文本，空字符串表示显示默认文本
					onSuccess : function(result) {
					},
					onFail : function(err) {}
				});
				break;
			case 'dealer': // When user_priv is dealer
				// Set empty menu
				dd.biz.navigation.setRight({
					show: false,//控制按钮显示， true 显示， false 隐藏， 默认true
					control: true,//是否控制点击事件，true 控制，false 不控制， 默认false
					text: '发送',//控制显示文本，空字符串表示显示默认文本
					onSuccess : function(result) {
					},
					onFail : function(err) {}
				});
				break;
			}
			console.log("Setup the menus");
		//});
	}
	// PC Menu
	else{
		$rootScope.route_status = 'price';
	}
});

// Mobile price discount input controller only admin
dingdingApp.controller('priceDiscountInputController', function($scope, $rootScope, $route, $routeParams, $http, myDialogService) {
	if(typeof $routeParams.product_id == "undefined") {
		$scope.product_id = '0';
	} else {
		$scope.product_id = $routeParams.product_id;
	}
	
	if(typeof $routeParams.dealers == "undefined") {
		dealers = '';
	} else {
		dealers = $routeParams.dealers;
	}
	
	if(typeof $routeParams.promotion == "undefined") {
		promotion = null;
	} else {
		promotion = JSON.parse($routeParams.promotion);
	}
	
	$scope.dealers = JSON.parse(dealers);
	$scope.dealer_cnt = $scope.dealers.length;
	
	if (promotion) { // promotion edit mode	
		$scope.promotion_price = promotion.promotion_price;
		$scope.promotion_start_date = promotion.promotion_start_date;
		$scope.promotion_end_date = promotion.promotion_end_date;
	}
	
	$http.get('product/get/item/' + $scope.product_id).then(
		function(response) {
			console.log(response.data);
			$scope.product = response.data.value;
		}
	);
	
	backButtonUrl = "#!/price/discount/select/" + $scope.product_id;
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

	// Setup title
	dd.biz.navigation.setTitle({
		title : lang.btn_promo,// 促销
		onSuccess : function(result) {
		},
		onFail : function(err) {}
	});

	// Setup menus
	dd.biz.navigation.setMenu({
		backgroundColor : "#ffffff",
		textColor : "#000000",
		items : [
			{ // 完成 menu
				"id":"1",
				"text":lang.btn_complete
			},
		],
		onSuccess: function(data) {
			$("#discount_save").trigger( "click" );
			console.log(data);
		},
		onFail: function(err) {
			console.log(err);
		}
	});
	
	$scope.required_leveldiscount = false;
	$scope.msg_type = 0;
	$scope.ajax_loading = false;
	
	$scope.submit_discount = function () {
		$scope.required_leveldiscount = false;
		if ($scope.ajax_loading) return;
		$scope.ajax_loading = true;
		if ($scope.promotion_price == null || $scope.promotion_start_date == null || $scope.promotion_end_date == null) {
			$scope.ajax_loading = false;
			$scope.required_leveldiscount = true;
			$scope.msg_type = 0;
			return;
		}
		start_date = new Date($scope.promotion_start_date);
		end_date = new Date($scope.promotion_end_date);
		if (start_date >= end_date) {
			$scope.ajax_loading = false;
			$scope.required_leveldiscount = true;
			$scope.msg_type = 1;
			return;
		}
		
		dealers = [];
		if (!promotion) {
			for (index in $scope.dealers) {
				dealers.push($scope.dealers[index].dealer_id);
			}
		}
		
		dd.device.notification.confirm({
			message: lang.promotion_set_confirm,
			title: lang.set_promotion,
			buttonLabels: [lang.price_btn_confirm, lang.price_btn_cancel],
			onSuccess : function(result) {
				if (result.buttonIndex == 0) {// confirm
					save_data = {
						product_id: $scope.product_id,
						promotion_price: $scope.promotion_price,
						promotion_start_date: $scope.promotion_start_date,
						promotion_end_date: $scope.promotion_end_date,
						dealers: dealers
					};
					// Show loading
					dd.device.notification.showPreloader({
						text: lang.price_sending, //loading显示的字符，空表示不显示文字
						showIcon: true, //是否显示icon，默认true
						onSuccess : function(result) {},
						onFail : function(err) {}
					});
					if (promotion) { // Promotion edit mode
						promotion.promotion_price = $scope.promotion_price;
						promotion.promotion_start_date = $scope.promotion_start_date;
						promotion.promotion_end_date = $scope.promotion_end_date;
						$http.post('/price/edit/dealer/promotion', JSON.stringify(promotion)).then(
							function(response) {
								// Hide loading
								dd.device.notification.hidePreloader({
									onSuccess : function(result) {},
									onFail : function(err) {}
								});
								if (response.data.success === true) {
									// Show success toast
									dd.device.notification.toast({
										icon: 'success', //icon样式，有success和error，默认为空 0.0.2
										text: lang.price_save_success, //提示信息
										duration: 2, //显示持续时间，单位秒，默认按系统规范[android只有两种(<=2s >2s)]
										delay: 2, //延迟显示，单位秒，默认0
										onSuccess : function(result) {},
										onFail : function(err) {}
									});
									$scope.ajax_loading = false;
									window.location = "#!/price/discount/select/" + $scope.product_id;
								} else {
									// Show fail toast
									dd.device.notification.toast({
										icon: 'error', //icon样式，有success和error，默认为空 0.0.2
										text: response.data.err_msg, //提示信息
										duration: 2, //显示持续时间，单位秒，默认按系统规范[android只有两种(<=2s >2s)]
										delay: 2, //延迟显示，单位秒，默认0
										onSuccess : function(result) {},
										onFail : function(err) {}
									});
									$scope.ajax_loading = false;
								}	
							}, function (response) {
								// Hide loading
								dd.device.notification.hidePreloader({
									onSuccess : function(result) {},
									onFail : function(err) {}
								});
								// Show fail toast
								dd.device.notification.toast({
									icon: 'error', //icon样式，有success和error，默认为空 0.0.2
									text: lang.price_save_fail, //提示信息
									duration: 2, //显示持续时间，单位秒，默认按系统规范[android只有两种(<=2s >2s)]
									delay: 2, //延迟显示，单位秒，默认0
									onSuccess : function(result) {},
									onFail : function(err) {}
								});
								$scope.ajax_loading = false;
							}
						);
					} else {
						$http.post('/price/set/dealer/promotion', JSON.stringify(save_data)).then(
							function(response) {
								// Hide loading
								dd.device.notification.hidePreloader({
									onSuccess : function(result) {},
									onFail : function(err) {}
								});
								if (response.data.success === true) {
									// Show success toast
									dd.device.notification.toast({
										icon: 'success', //icon样式，有success和error，默认为空 0.0.2
										text: lang.price_save_success, //提示信息
										duration: 2, //显示持续时间，单位秒，默认按系统规范[android只有两种(<=2s >2s)]
										delay: 2, //延迟显示，单位秒，默认0
										onSuccess : function(result) {},
										onFail : function(err) {}
									});
									$scope.ajax_loading = false;
									window.location = "#!/price/discount/select/" + $scope.product_id;
								} else {
									// Show fail toast
									dd.device.notification.toast({
										icon: 'error', //icon样式，有success和error，默认为空 0.0.2
										text: response.data.err_msg, //提示信息
										duration: 2, //显示持续时间，单位秒，默认按系统规范[android只有两种(<=2s >2s)]
										delay: 2, //延迟显示，单位秒，默认0
										onSuccess : function(result) {},
										onFail : function(err) {}
									});
									$scope.ajax_loading = false;
								}	
							}, function (response) {
								// Hide loading
								dd.device.notification.hidePreloader({
									onSuccess : function(result) {},
									onFail : function(err) {}
								});
								// Show fail toast
								dd.device.notification.toast({
									icon: 'error', //icon样式，有success和error，默认为空 0.0.2
									text: lang.price_save_fail, //提示信息
									duration: 2, //显示持续时间，单位秒，默认按系统规范[android只有两种(<=2s >2s)]
									delay: 2, //延迟显示，单位秒，默认0
									onSuccess : function(result) {},
									onFail : function(err) {}
								});
								$scope.ajax_loading = false;
							}
						);
					}
				} else {
					$scope.ajax_loading = false;
				}
			}
		});
	}
});

// Mobile price discount select controller only admin
dingdingApp.controller('priceDiscountSelectController', function($scope, $rootScope, $route, $routeParams, $http, myDialogService) {
	if(typeof $routeParams.product_id == "undefined") {
		$scope.product_id = '0';
	} else {
		$scope.product_id = $routeParams.product_id;
	}
	// Config variables
	console.log("price discount select");
	$scope.dealer_id = 1;
	$scope.type = 1;
	$scope.sel_itemcount = 0;
	$scope.isCheck = [];
	
	// Config variables
	$scope.pagenum = 1;
	$scope.itemcount_perpage = 5;
	if(is_mobile) $scope.itemcount_perpage = 6;

	$scope.no_data = false;
	
	// Mobile dingding Menu
	if(is_mobile){
		// Scroll event listener
		$(window).on('scroll', function(){
			if( $(window).scrollTop() >= $(document).height() - $(window).height() ) {
				if($scope.loaded && $scope.pagenum < $scope.last_page && $scope.type == 4){
					get_page_list(($scope.pagenum + 1), $scope.itemcount_perpage);
				}
			}
		}).scroll();
		
		backButtonUrl = "#!/price/view/" + $scope.product_id;

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

		// Setup title
		dd.biz.navigation.setTitle({
			title : lang.btn_promo,// 促销
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
	}
	else{
		$rootScope.route_status = 'price';
	}
		
	get_list(1);
	
	function get_list(type) {
		$scope.busy = true;
		$scope.no_data = false;
		switch (type) {
		case 1:
			$scope.dealers = [];
			$scope.isCheck = [];
			$scope.isCheckAll = false;
			$http.get('price/get/downdealerwithpromotion/' + $scope.product_id + '/' + $scope.dealer_id).then(
				function(response) {
					console.log(1);
					console.log(response);
					$scope.dealers = response.data;
					$scope.busy = false;
					
					if ($scope.dealers.length == 0) {
						$scope.no_data = true;
					}
				}
			);
			break;
		case 2:
			$scope.dealers = [];
			$http.get('price/get/levelpromotion/' + $scope.product_id).then(
				function(response) {
					console.log(2);
					console.log(response);
					$scope.dealers = response.data;
					$scope.busy = false;
					
					if ($scope.dealers.length == 0) {
						$scope.no_data = true;
					}
				}
			);
			break;
		case 3:
			$scope.dealers = [];
			$scope.isCheck = [];
			$scope.isCheckAll = false;
			if (typeof $scope.search_name != 'undefined' && $scope.search_name != '') {
				$http.get('price/get/dealerpromotion/' + $scope.product_id + '/' + $scope.search_name).then(
					function(response) {
						console.log(3);
						console.log(response);
						$scope.dealers = response.data;
						$scope.busy = false;
						
						if ($scope.dealers.length == 0) {
							$scope.no_data = true;
						}
					}
				);
			} else {
				$scope.busy = false;
				if ($scope.dealers.length == 0) {
					$scope.no_data = true;
				}
			}
			break;
		}
	}
	
	function get_page_list(pagenum, itemcount){
		if(is_mobile){
			if(pagenum == 1){
				delete $scope.items;
				$scope.items = [];
			}
		}
		$scope.no_data = false;
		$scope.loaded =  false;
		$scope.busy = true;
		$http.get('price/get/promotion/list/' + $scope.product_id + '/' + itemcount + '/' + pagenum).then(
			function(response){
				console.log(response);
				$scope.busy = false;	// It is true when this is loading
				$scope.loaded =  true;
				if(is_mobile){
					var list_data = response.data;
					console.log('last_page = ' + list_data.last_page);
					$scope.last_page = list_data.last_page;
					$scope.pagenum = list_data.current_page;
					var items = list_data.data;
					for (var i = 0; i < items.length; i++) {
						$scope.items.push(items[i]);
					}
					if ($scope.items.length == 0) {
						$scope.no_data = true;
					}
				} else {					
					$scope.list_data = response.data;
					$scope.last_page = $scope.list_data.last_page;
					$scope.pagenation = PagerService.GetPager($scope.list_data.total, $scope.list_data.current_page, $scope.list_data.per_page, 10);
					if ($scope.list_data.data.length == 0) {
						$scope.no_data = true;
					}
				}
			}
		);
	}
	
	// When pagination changed
	$scope.setPage = function(pagenum){
		if(pagenum < 1) pagenum = 1;
		else if(pagenum > $scope.list_data.last_page) pagenum = $scope.list_data.last_page;
		get_page_list(pagenum, $scope.itemcount_perpage);
	}
	
	
	$scope.toUpDealer = function (dealer_id) {
		$scope.busy = true;
		$scope.no_data = false;
		$scope.dealers = [];
		$scope.isCheck = [];
		$scope.isCheckAll = false;
		$http.get('price/get/updealerwithpromotion/' + $scope.product_id + '/' + dealer_id).then(
			function(response) {
				console.log(response);
				$scope.dealers = response.data;
				$scope.dealer_id = $scope.dealers[0].parent_id;
				$scope.busy = false;
				
				if ($scope.dealers.length == 0) {
					$scope.no_data = true;
				}
			}
		);
	}
	
	$scope.toDownDealer = function (dealer_id) {
		$scope.dealers = [];
		$scope.isCheck = [];
		$scope.isCheckAll = false;
		$scope.busy = true;
		$scope.no_data = false;
		$http.get('price/get/downdealerwithpromotion/' + $scope.product_id + '/' + dealer_id).then(
			function(response) {
				console.log(response);
				$scope.dealer_id = dealer_id;
				console.log($scope.dealer_id);
				$scope.dealers = response.data;
				$scope.busy = false;
				
				if ($scope.dealers.length == 0) {
					$scope.no_data = true;
				}
			}
		);
	}
	
	$scope.set_type = function (type) {
		$scope.type = type;
		if (type == 4)
			get_page_list(1, $scope.itemcount_perpage);
		else
			get_list(type);
	}
	
	$scope.search = function() {
		get_list(3);
	}
	
	$scope.isCheckAll = false;

	$scope.onCheckAll = function() {
		$scope.sel_itemcount = 0;
		for (i = 0; i < $scope.dealers.length; i++) {
			$scope.isCheck[i] = $scope.isCheckAll;
			if ($scope.isCheck[i]) $scope.sel_itemcount++;
		}
	}

	$scope.onCheck = function() {
		totalCheck = false;
		$scope.sel_itemcount = 0;
		for (i = 0; i < $scope.dealers.length; i++) {
			if ($scope.isCheck[i]) {
				totalCheck = true;
				$scope.sel_itemcount++;
			}
		}
		$scope.isCheckAll = totalCheck;
	}
	
	$scope.onSetting = function () {
		$scope.ajax_loading = false;
		dealer_ary = [];
		for (i = 0; i < $scope.isCheck.length; i++) {
			if ($scope.isCheck[i]) {
				item = {'dealer_id': $scope.dealers[i].id, 'dealer_name': $scope.dealers[i].name};
				dealer_ary.push(item);
			}
		}
		
		if (dealer_ary.length > 0) {
			window.location = "#!/price/discount/input/" + $scope.product_id + "/" + JSON.stringify(dealer_ary);
		}else{
			console.log('not selected');
		}
	}
	
	$scope.onEdit = function (promotion) {
		dealer_ary = [];
		if (promotion.level) {
			dealer = {'dealer_name': promotion.level + lang.level_dealer};
			dealer_ary.push(dealer);
		} else {
			dealer = {'dealer_name': promotion.dealer.name};
			dealer_ary.push(dealer);
		}
		promo = {
			'id': promotion.id,
			'product_id': promotion.product_id,
			'dealer_id': promotion.dealer_id,
			'level': promotion.level,
			'promotion_price': promotion.promotion_price,
			'promotion_start_date': promotion.promotion_start_date,
			'promotion_end_date': promotion.promotion_end_date
		};
		window.location = "#!/price/discount/input/" + $scope.product_id + "/" + JSON.stringify(dealer_ary) + "/" + JSON.stringify(promo);
	}
	
	$scope.onRemove = function (promotion) {
		if ($scope.level_saving) return;
		$scope.level_saving = true;
		
		dd.device.notification.confirm({
			message: lang.promotion_remove_confirm,
			title: lang.set_promotion,
			buttonLabels: [lang.price_btn_confirm, lang.price_btn_cancel],
			onSuccess : function(result) {
				if (result.buttonIndex == 0) {// confirm
					// Show loading
					dd.device.notification.showPreloader({
						text: lang.price_sending, //loading显示的字符，空表示不显示文字
						showIcon: true, //是否显示icon，默认true
						onSuccess : function(result) {},
						onFail : function(err) {}
					});
					$http.post("/price/remove/dealer/promotion", JSON.stringify(promotion)).then(
						function (response) {
							console.log(response);
							// Hide loading
							dd.device.notification.hidePreloader({
								onSuccess : function(result) {},
								onFail : function(err) {}
							});
							if (response.data.success === true) {
								// Show success toast
								dd.device.notification.toast({
									icon: 'success', //icon样式，有success和error，默认为空 0.0.2
									text: lang.price_remove_success, //提示信息
									duration: 2, //显示持续时间，单位秒，默认按系统规范[android只有两种(<=2s >2s)]
									delay: 2, //延迟显示，单位秒，默认0
									onSuccess : function(result) {},
									onFail : function(err) {}
								});
								get_page_list(1, $scope.itemcount_perpage);
								$scope.level_saving = false;
							} else {
								// Show fail toast
								dd.device.notification.toast({
									icon: 'error', //icon样式，有success和error，默认为空 0.0.2
									text: response.data.err_msg, //提示信息
									duration: 2, //显示持续时间，单位秒，默认按系统规范[android只有两种(<=2s >2s)]
									delay: 2, //延迟显示，单位秒，默认0
									onSuccess : function(result) {},
									onFail : function(err) {}
								});
								$scope.level_saving = false;
							}
							
						}, function (response) {
							// Hide loading
							dd.device.notification.hidePreloader({
								onSuccess : function(result) {},
								onFail : function(err) {}
							});
							// Show fail toast
							dd.device.notification.toast({
								icon: 'error', //icon样式，有success和error，默认为空 0.0.2
								text: lang.price_remove_fail, //提示信息
								duration: 2, //显示持续时间，单位秒，默认按系统规范[android只有两种(<=2s >2s)]
								delay: 2, //延迟显示，单位秒，默认0
								onSuccess : function(result) {},
								onFail : function(err) {}
							});
							$scope.level_saving = false;
						}
					);
				} else {
					$scope.level_saving = false;
					return;
				}
			}
		});
	}
	
	$scope.required_leveldiscount = false;
	$scope.level_saving = false;
	$scope.submit_leveldiscount = function () {
		$scope.required_leveldiscount = false;
		if ($scope.level_saving) return;
		$scope.level_saving = true;
		for (key in $scope.dealers) {
			if (typeof $scope.dealers[key].promotion_price != 'undefined' && $scope.dealers[key].promotion_price != null) {
				if (typeof $scope.dealers[key].promotion_start_date == 'undefined' || 
					$scope.dealers[key].promotion_start_date == null ||
					typeof $scope.dealers[key].promotion_end_date == 'undefined' ||
					$scope.dealers[key].promotion_end_date == null) {
					$scope.required_leveldiscount = true;
					$scope.msg_type = 0;
					$scope.level_saving = false;
					return;
				}
			}
		}
			
		isempty = true;
		promotions = [];
		promotion_start_dates = [];
		promotion_end_dates = [];
		for (key in $scope.dealers) {
			console.log($scope.dealers[key].promotion_price);
			if (typeof $scope.dealers[key].promotion_price != 'undefined' && $scope.dealers[key].promotion_price != '' && $scope.dealers[key].promotion_price != null) {
				isempty = false;
				start_date = new Date($scope.dealers[key].promotion_start_date);
				end_date = new Date($scope.dealers[key].promotion_end_date);
				if (start_date >= end_date) {
					$scope.required_leveldiscount = true;
					$scope.msg_type = 1;
					$scope.level_saving = false;
					return;
				}
				promotions.push($scope.dealers[key].promotion_price);
				promotion_start_dates.push($scope.dealers[key].promotion_start_date);
				promotion_end_dates.push($scope.dealers[key].promotion_end_date);
			} else {
				promotions.push(null);
				promotion_start_dates.push(null);
				promotion_end_dates.push(null);
			}
		}
		if (isempty) {
			$scope.required_leveldiscount = true;
			$scope.msg_type = 0;
			$scope.level_saving = false;
			return;
		}
		
		dd.device.notification.confirm({
			message: lang.promotion_set_confirm,
			title: lang.set_promotion,
			buttonLabels: [lang.price_btn_confirm, lang.price_btn_cancel],
			onSuccess : function(result) {
				if (result.buttonIndex == 0) {// confirm
					save_data = {
						'product_id': $scope.product_id,
						'promotions': promotions,
						'promotion_start_dates': promotion_start_dates,
						'promotion_end_dates': promotion_end_dates
					};
					// Show loading
					dd.device.notification.showPreloader({
						text: lang.price_sending, //loading显示的字符，空表示不显示文字
						showIcon: true, //是否显示icon，默认true
						onSuccess : function(result) {},
						onFail : function(err) {}
					});
					$http.post("/price/set/level/promotion", JSON.stringify(save_data)).then(
						function (response) {
							console.log(response);
							// Hide loading
							dd.device.notification.hidePreloader({
								onSuccess : function(result) {},
								onFail : function(err) {}
							});
							if (response.data.success === true) {
								// Show success toast
								dd.device.notification.toast({
									icon: 'success', //icon样式，有success和error，默认为空 0.0.2
									text: lang.price_save_success, //提示信息
									duration: 2, //显示持续时间，单位秒，默认按系统规范[android只有两种(<=2s >2s)]
									delay: 2, //延迟显示，单位秒，默认0
									onSuccess : function(result) {},
									onFail : function(err) {}
								});
								$scope.level_saving = false;
							} else {
								// Show fail toast
								dd.device.notification.toast({
									icon: 'error', //icon样式，有success和error，默认为空 0.0.2
									text: lang.price_save_fail, //提示信息
									duration: 2, //显示持续时间，单位秒，默认按系统规范[android只有两种(<=2s >2s)]
									delay: 2, //延迟显示，单位秒，默认0
									onSuccess : function(result) {},
									onFail : function(err) {}
								});
								$scope.level_saving = false;
							}
							
						}, function (response) {
							// Hide loading
							dd.device.notification.hidePreloader({
								onSuccess : function(result) {},
								onFail : function(err) {}
							});
							// Show fail toast
							dd.device.notification.toast({
								icon: 'error', //icon样式，有success和error，默认为空 0.0.2
								text: lang.price_save_fail, //提示信息
								duration: 2, //显示持续时间，单位秒，默认按系统规范[android只有两种(<=2s >2s)]
								delay: 2, //延迟显示，单位秒，默认0
								onSuccess : function(result) {},
								onFail : function(err) {}
							});
							$scope.level_saving = false;
						}
					);
				} else {
					$scope.level_saving = false;
					return;
				}
			}
		});
	}
});

// PC price discount edit controller only admin
dingdingApp.controller('priceDiscountEditController', function($scope, $rootScope, $route, $routeParams, $http, PagerService, myDialogService) {
	if(typeof $routeParams.product_id == "undefined") {
		$scope.product_id = '0';
	} else {
		$scope.product_id = $routeParams.product_id;
	}
	$scope.isSaving = false;
	
	$scope.dealer_id = 1;
	$scope.type = 1;
	$scope.sel_itemcount = 0;
	$scope.isCheck = [];
	
	// Config variables
	$scope.pagenum = 1;
	$scope.itemcount_perpage = 5;
	if(is_mobile) $scope.itemcount_perpage = 6;

	$scope.no_data = false;

	$http.get('product/get/item/' + $scope.product_id).then(
		function(response) {
			console.log(response.data);
			$scope.product = response.data.value;
		}
	);
	
	get_list(1);
	
	function get_list(type) {
		$scope.no_data = false;
		switch (type) {
		case 1:
			$scope.dealers = [];
			$scope.isCheck = [];
			$scope.isCheckAll = false;
			$http.get('price/get/downdealerwithpromotion/' + $scope.product_id + '/' + $scope.dealer_id).then(
				function(response) {
					console.log(1);
					console.log(response);
					$scope.dealers = response.data;
					
					if ($scope.dealers.length == 0) {
						$scope.no_data = true;
					}
				}
			);
			break;
		case 2:
			$scope.dealers = [];
			$http.get('price/get/levelpromotion/' + $scope.product_id).then(
				function(response) {
					console.log(2);
					console.log(response);
					$scope.dealers = response.data;
					
					if ($scope.dealers.length == 0) {
						$scope.no_data = true;
					}
				}
			);
			break;
		case 3:
			$scope.dealers = [];
			$scope.isCheck = [];
			$scope.isCheckAll = false;
			if (typeof $scope.search_name != 'undefined' && $scope.search_name != '') {
				$http.get('price/get/dealerpromotion/' + $scope.product_id + '/' + $scope.search_name).then(
					function(response) {
						console.log(3);
						console.log(response);
						$scope.dealers = response.data;
						
						if ($scope.dealers.length == 0) {
							$scope.no_data = true;
						}
					}
				);
			} else {
				if ($scope.dealers.length == 0) {
					$scope.no_data = true;
				}
			}
			break;
		}
	}
	
	function get_page_list(pagenum, itemcount){
		if(is_mobile){
			if(pagenum == 1){
				delete $scope.items;
				$scope.items = [];
			}
		}
		$scope.no_data = false;
		$scope.loaded =  false;
		$scope.busy = true;
		$http.get('price/get/promotion/list/' + $scope.product_id + '/' + itemcount + '/' + pagenum).then(
			function(response){
				console.log(response);
				$scope.busy = false;	// It is true when this is loading
				$scope.loaded =  true;
				if (is_mobile) {
					var list_data = response.data;
					console.log('last_page = ' + list_data.last_page);
					$scope.last_page = list_data.last_page;
					$scope.pagenum = list_data.current_page;
					var items = list_data.data;
					for (var i = 0; i < items.length; i++) {
						$scope.items.push(items[i]);
					}
					if ($scope.items.length == 0) {
						$scope.no_data = true;
					}
				} else {					
					$scope.list_data = response.data;
					$scope.last_page = $scope.list_data.last_page;
					$scope.pagenation = PagerService.GetPager($scope.list_data.total, $scope.list_data.current_page, $scope.list_data.per_page, 10);
					if ($scope.list_data.data.length == 0) {
						$scope.no_data = true;
					}
				}
			}
		);
	}
	
	// When pagination changed
	$scope.setPage = function(pagenum){
		if(pagenum < 1) pagenum = 1;
		else if(pagenum > $scope.list_data.last_page) pagenum = $scope.list_data.last_page;
		get_page_list(pagenum, $scope.itemcount_perpage);
	}
	
	
	$scope.toUpDealer = function (dealer_id) {
		$scope.no_data = false;
		$scope.dealers = [];
		$scope.isCheck = [];
		$scope.isCheckAll = false;
		$http.get('price/get/updealerwithpromotion/' + $scope.product_id + '/' + dealer_id).then(
			function(response) {
				console.log(response);
				$scope.dealers = response.data;
				$scope.dealer_id = $scope.dealers[0].parent_id;
				
				if ($scope.dealers.length == 0) {
					$scope.no_data = true;
				}
			}
		);
	}
	
	$scope.toDownDealer = function (dealer_id) {
		$scope.no_data = false;
		$scope.dealers = [];
		$scope.isCheck = [];
		$scope.isCheckAll = false;
		$http.get('price/get/downdealerwithpromotion/' + $scope.product_id + '/' + dealer_id).then(
			function(response) {
				console.log(response);
				$scope.dealer_id = dealer_id;
				console.log($scope.dealer_id);
				$scope.dealers = response.data;
				
				if ($scope.dealers.length == 0) {
					$scope.no_data = true;
				}
			}
		);
	}
	
	$scope.set_type = function (type) {
		$scope.type = type;
		if (type == 4)
			get_page_list(1, $scope.itemcount_perpage);
		else
			get_list(type);
	}
	
	$scope.search = function() {
		get_list(3);
	}
	
	$scope.isCheckAll = false;

	$scope.onCheckAll = function() {
		$scope.sel_itemcount = 0;
		for (i = 0; i < $scope.dealers.length; i++) {
			$scope.isCheck[i] = $scope.isCheckAll;
			if ($scope.isCheck[i]) $scope.sel_itemcount++;
		}
	}

	$scope.onCheck = function() {
		totalCheck = false;
		$scope.sel_itemcount = 0;
		for (i = 0; i < $scope.dealers.length; i++) {
			if ($scope.isCheck[i]) {
				totalCheck = true;
				$scope.sel_itemcount++;
			}
		}
		$scope.isCheckAll = totalCheck;
	}
	
	discountInputDlg = $( "#discountinput" ).dialog({
		autoOpen: false,
		resizable: false,
		height: "auto",
		width: 400,
		modal: true,
	});
	
	isEdit = false;
	$scope.onSetting = function () {
		$scope.ajax_loading = false;
		dealer_ary = [];
		for (i = 0; i < $scope.isCheck.length; i++) {
			if ($scope.isCheck[i])
				dealer_ary.push($scope.dealers[i].id);
		}
		
		if (dealer_ary.length > 0) {
			isEdit = false;
			discountInputDlg.dialog('open');
		}else{
			console.log('not selected');
			myDialogService.alert({
				// message: lang.gen_check_cardcount,
				message: lang.must_select_dealer,
				button: lang.close,
				animation: "fade",
				callback: function(){
				}
			});
		}
	}
	
	$scope.onRemove = function (promotion) {
		if ($scope.level_saving) return;
		$scope.level_saving = true;
		
		DingTalkPC.device.notification.confirm({
			message: lang.promotion_remove_confirm,
			title: lang.set_promotion,
			buttonLabels: [lang.price_btn_confirm, lang.price_btn_cancel],
			onSuccess : function(result) {
				if (result.buttonIndex == 0) {// confirm
					$http.post("/price/remove/dealer/promotion", JSON.stringify(promotion)).then(
						function (response) {
							console.log(response);
							if (response.data.success === true) {
								// Show success toast
								DingTalkPC.device.notification.toast({
									icon: 'success', //icon样式，有success和error，默认为空 0.0.2
									text: lang.price_remove_success, //提示信息
									duration: 2, //显示持续时间，单位秒，默认按系统规范[android只有两种(<=2s >2s)]
									delay: 2, //延迟显示，单位秒，默认0
									onSuccess : function(result) {},
									onFail : function(err) {}
								});
								get_page_list(1, $scope.itemcount_perpage);
								$scope.level_saving = false;
							} else {
								// Show fail toast
								DingTalkPC.device.notification.toast({
									icon: 'error', //icon样式，有success和error，默认为空 0.0.2
									text: response.data.err_msg, //提示信息
									duration: 2, //显示持续时间，单位秒，默认按系统规范[android只有两种(<=2s >2s)]
									delay: 2, //延迟显示，单位秒，默认0
									onSuccess : function(result) {},
									onFail : function(err) {}
								});
								$scope.level_saving = false;
							}
							
						}, function (response) {
							// Show fail toast
							DingTalkPC.device.notification.toast({
								icon: 'error', //icon样式，有success和error，默认为空 0.0.2
								text: lang.price_remove_fail, //提示信息
								duration: 2, //显示持续时间，单位秒，默认按系统规范[android只有两种(<=2s >2s)]
								delay: 2, //延迟显示，单位秒，默认0
								onSuccess : function(result) {},
								onFail : function(err) {}
							});
							$scope.level_saving = false;
						}
					);
				} else {
					$scope.level_saving = false;
					return;
				}
			}
		});
	}
	
	editPromotion = null;
	$scope.onEdit = function (promotion) {
		isEdit = true;
		editPromotion = promotion;
		$scope.dlg_promotion_price = promotion.promotion_price;
		$scope.dlg_promotion_start_date = promotion.promotion_start_date;
		$scope.dlg_promotion_end_date = promotion.promotion_end_date;
		discountInputDlg.dialog('open');
	}
	
	$scope.required_leveldiscount = false;
	$scope.msg_type = 0;
	$scope.level_saving = false;
	$scope.submit_leveldiscount = function () {
		if ($scope.level_saving) return;
		$scope.level_saving = true;
		$scope.required_leveldiscount = false;
		for (key in $scope.dealers) {
			if (typeof $scope.dealers[key].promotion_price != 'undefined' && $scope.dealers[key].promotion_price != null) {
				if (typeof $scope.dealers[key].promotion_start_date == 'undefined' || 
					$scope.dealers[key].promotion_start_date == null ||
					typeof $scope.dealers[key].promotion_end_date == 'undefined' ||
					$scope.dealers[key].promotion_end_date == null) {
					$scope.required_leveldiscount = true;
					$scope.msg_type = 0;
					$scope.level_saving = false;
					return;
				}
			}
		}
			
		isempty = true;
		promotions = [];
		promotion_start_dates = [];
		promotion_end_dates = [];
		for (key in $scope.dealers) {
			console.log($scope.dealers[key].promotion_price);
			if (typeof $scope.dealers[key].promotion_price != 'undefined' && $scope.dealers[key].promotion_price != '' && $scope.dealers[key].promotion_price != null) {
				isempty = false;
				start_date = new Date($scope.dealers[key].promotion_start_date);
				end_date = new Date($scope.dealers[key].promotion_end_date);
				if (start_date >= end_date) {
					$scope.required_leveldiscount = true;
					$scope.msg_type = 1;
					$scope.level_saving = false;
					return;
				}
				promotions.push($scope.dealers[key].promotion_price);
				promotion_start_dates.push($scope.dealers[key].promotion_start_date);
				promotion_end_dates.push($scope.dealers[key].promotion_end_date);
			} else {
				promotions.push(null);
				promotion_start_dates.push(null);
				promotion_end_dates.push(null);
			}
		}
		if (isempty) {
			$scope.required_leveldiscount = true;
			$scope.msg_type = 0;
			$scope.level_saving = false;
			return;
		}
		
		DingTalkPC.device.notification.confirm({
			message: lang.promotion_set_confirm,
			title: lang.set_promotion,
			buttonLabels: [lang.price_btn_confirm, lang.price_btn_cancel],
			onSuccess : function(result) {
				if (result.buttonIndex == 0) {// confirm
					save_data = {
						'product_id': $scope.product_id,
						'promotions': promotions,
						'promotion_start_dates': promotion_start_dates,
						'promotion_end_dates': promotion_end_dates
					};
					$http.post("/price/set/level/promotion", JSON.stringify(save_data)).then(
						function (response) {
							console.log(response);
							if (response.data.success === true) {
								// Show success toast
								DingTalkPC.device.notification.toast({
									icon: 'success', //icon样式，有success和error，默认为空 0.0.2
									text: lang.price_save_success, //提示信息
									duration: 2, //显示持续时间，单位秒，默认按系统规范[android只有两种(<=2s >2s)]
									delay: 2, //延迟显示，单位秒，默认0
									onSuccess : function(result) {},
									onFail : function(err) {}
								});
								$scope.level_saving = false;
							} else {
								// Show fail toast
								DingTalkPC.device.notification.toast({
									icon: 'error', //icon样式，有success和error，默认为空 0.0.2
									text: response.data.err_msg, //提示信息
									duration: 2, //显示持续时间，单位秒，默认按系统规范[android只有两种(<=2s >2s)]
									delay: 2, //延迟显示，单位秒，默认0
									onSuccess : function(result) {},
									onFail : function(err) {}
								});
								$scope.level_saving = false;
							}
							
						}, function (response) {
							// Show fail toast
							DingTalkPC.device.notification.toast({
								icon: 'error', //icon样式，有success和error，默认为空 0.0.2
								text: lang.price_save_fail, //提示信息
								duration: 2, //显示持续时间，单位秒，默认按系统规范[android只有两种(<=2s >2s)]
								delay: 2, //延迟显示，单位秒，默认0
								onSuccess : function(result) {},
								onFail : function(err) {}
							});
							$scope.level_saving = false;
						}
					);
				} else {
					$scope.level_saving = false;
					return;
				}
			}
		});
	}
	
	$scope.ajax_loading = false;
	$scope.required_discount = false;
	$scope.submit_discount = function () {
		$scope.required_discount = false;
		if ($scope.ajax_loading) return;
		$scope.ajax_loading = true;
		start_date = new Date($scope.dlg_promotion_start_date);
		end_date = new Date($scope.dlg_promotion_end_date);
		if (start_date >= end_date) {
			$scope.required_discount = true;
			$scope.ajax_loading = false;
			return;
		}
		
		if (isEdit) {
			editPromotion.promotion_price = $scope.dlg_promotion_price;
			editPromotion.promotion_start_date = $scope.dlg_promotion_start_date;
			editPromotion.promotion_end_date = $scope.dlg_promotion_end_date;
			
			$http.post('/price/edit/dealer/promotion', JSON.stringify(editPromotion)).then(
				function(response) {
					if (response.data.success) {
						$(".alert").hide();
						$(".alert-success").show();
						$(".alert-success").alert();
						window.setTimeout(function() {
							$(".alert").hide();
							$scope.ajax_loading = false;
							$('#discountinput').dialog('close');
							get_list($scope.type);
						}, 2000);
					} else {
						$(".alert").hide();
						$(".alert-danger").show();
						$(".alert-danger").html(response.data.err_msg);
						$(".alert-danger").alert();
						window.setTimeout(function() {
							$(".alert").hide();
							$scope.ajax_loading = false;
							$('#discountinput').dialog('close');
						}, 2000);
					}
				}
			);
		} else {
			save_data = {
				product_id: $scope.product_id,
				promotion_price: $scope.dlg_promotion_price,
				promotion_start_date: $scope.dlg_promotion_start_date,
				promotion_end_date: $scope.dlg_promotion_end_date,
				dealers: dealer_ary
			};
			$http.post('/price/set/dealer/promotion', JSON.stringify(save_data)).then(
				function(response) {
					if (response.data.success) {
						$(".alert").hide();
						$(".alert-success").show();
						$(".alert-success").alert();
						window.setTimeout(function() {
							$(".alert").hide();
							$scope.ajax_loading = false;
							$('#discountinput').dialog('close');
							get_list($scope.type);
						}, 2000);
					} else {
						$(".alert").hide();
						$(".alert-danger").show();
						$(".alert-danger").html(response.data.err_msg);
						$(".alert-danger").alert();
						window.setTimeout(function() {
							$(".alert").hide();
							$scope.ajax_loading = false;
							$('#discountinput').dialog('close');
						}, 2000);
					}
				}
			);
		}
	}
	
	$scope.onCancel = function () {
		$scope.ajax_loading = false;
		$('#discountinput').dialog('close');
	}
	
	$rootScope.route_status = 'price';
});

// Mobile price view controller only admin and dealer
dingdingApp.controller('priceViewController', function($scope, $rootScope, $route, $routeParams, $http, myDialogService) {
	if(typeof $routeParams.product_id == "undefined") {
		$scope.product_id = '0';
	} else {
		$scope.product_id = $routeParams.product_id;
	}

	if (user_priv == 'admin') {
		$http.get('product/get/item/' + $scope.product_id).then(
			function(response) {
				console.log(response.data);
				$scope.product = response.data.value;
				// Mobile dingding Menu
				if(is_mobile){
					//dd.ready(function() {
						// When back button closed
						// document.addEventListener('backbutton', function(e) {
						// 	e.preventDefault();
						// 	window.location = "#!/price";
						// }, false);
						backButtonUrl = "#!/price";

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
							title : $scope.product.name,// 一年延保卡
							onSuccess : function(result) {
							},
							onFail : function(err) {}
						});

						switch (user_priv) {
						case 'admin': // When user_priv is admin
							// Setup menus
							dd.biz.navigation.setMenu({
								backgroundColor : "#ffffff",
								textColor : "#000000",
								items : [
									{ // 定价 menu
										"id":"1",
										"text":lang.btn_edit
									},
									{ // 促销 menu
										"id":"2",
										"text":lang.btn_promo
									}
								],
								onSuccess: function(data) {
									if (data.id == '1') { // Set price
										window.location = "#!/price/edit/" + $scope.product_id;
										console.log(data);
									} else { // Set promotion
										window.location = "#!price/discount/select/" + $scope.product_id;
									}
								},
								onFail: function(err) {
									console.log(err);
								}
							});
							break;
						case 'dealer': // When user_priv is dealer
							// Set empty menu
							dd.biz.navigation.setRight({
								show: false,//控制按钮显示， true 显示， false 隐藏， 默认true
								control: true,//是否控制点击事件，true 控制，false 不控制， 默认false
								text: '发送',//控制显示文本，空字符串表示显示默认文本
								onSuccess : function(result) {
								},
								onFail : function(err) {}
							});
							break;
						}
						console.log("Setup the menus");
					//});
				}
				// PC Menu
				else{
					$rootScope.route_status = 'price';
				}
				$(".price_v_content").css("display", "block");
			}
		);
	}
	else {
		$http.get('price/get/dealer/' + $scope.product_id).then(
			function(response) {
				console.log(response.data);
				//$scope.product = response.data.value;
				$scope.promotion = response.data.promotion;
				$scope.product = response.data.product;
				$scope.price = response.data;

				// Mobile dingding Menu
				if(is_mobile){
					//dd.ready(function() {
						// When back button closed
						// document.addEventListener('backbutton', function(e) {
						// 	e.preventDefault();
						// 	window.location = "#!/price";
						// }, false);
						backButtonUrl = "#!/price";

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
							title : $scope.product.name,// 一年延保卡
							onSuccess : function(result) {
							},
							onFail : function(err) {}
						});

						switch (user_priv) {
						case 'admin': // When user_priv is admin
							// Setup menus
							dd.biz.navigation.setMenu({
								backgroundColor : "#ffffff",
								textColor : "#000000",
								items : [
									{ // 编辑 menu
										"id":"1",
										"text":lang.btn_edit
									},
								],
								onSuccess: function(data) {
									window.location = "#!/price/edit/" + $scope.product_id;
									console.log(data);
								},
								onFail: function(err) {
									console.log(err);
								}
							});
							break;
						case 'dealer': // When user_priv is dealer
							// Set empty menu
							dd.biz.navigation.setRight({
								show: false,//控制按钮显示， true 显示， false 隐藏， 默认true
								control: true,//是否控制点击事件，true 控制，false 不控制， 默认false
								text: '发送',//控制显示文本，空字符串表示显示默认文本
								onSuccess : function(result) {
								},
								onFail : function(err) {}
							});
							break;
						}
						console.log("Setup the menus");
					//});
				}
				// PC Menu
				else{
					$rootScope.route_status = 'price';
				}
				$(".price_v_content").css("display", "block");
			}
		);
	}

	
});

// Mobile price edit controller only admin
dingdingApp.controller('priceEditController', function($scope, $rootScope, $route, $routeParams, $http, myDialogService) {
	if(typeof $routeParams.product_id == "undefined") {
		$scope.product_id = '0';
	} else {
		$scope.product_id = $routeParams.product_id;
	}
	$scope.isSaving = false;

	$scope.required_purchase_price_level = [];
	$scope.required_limit_down = [];
	$scope.required_price_sku = false;
	$scope.required_sale_price = false;
	
	$scope.form_submit = function () {
		$scope.required_sale_price = false;
		$scope.required_price_sku = false;
		for (index in $scope.required_purchase_price_level) {
			$scope.required_purchase_price_level[index] = false;
			$scope.required_limit_down[index] = false;
		}

		if ($scope.isSaving)
			return;
		$scope.isSaving = true;
		
		if ($('#price_sku').val() == '') {
			$scope.required_price_sku = true;
			$('#price_sku').focus();
			$scope.isSaving = false;
			return;
		}
		
		for (index in $scope.required_purchase_price_level) {
			if ($('#purchase_price_level' + index).val() == '') {
				$scope.required_purchase_price_level[index] = true;
				$('#purchase_price_level' + index).focus();
				$scope.isSaving = false;
				return;
			}
			if ($('#limit_down_' + index).val() == '' || $('#limit_up_' + index).val() == '') {
				$scope.required_limit_down[index] = true;
				$('#limit_down_' + index).focus();
				$scope.isSaving = false;
				return;
			}
		}
		
		if ($('#sale_price').val() == '') {
			$scope.required_sale_price = true;
			$('#sale_price').focus();
			$scope.isSaving = false;
			return;
		}
		
		if (is_mobile) {
			dd.device.notification.confirm({
				message: lang.price_set_confirm,
				title: lang.set_price,
				buttonLabels: [lang.price_btn_confirm, lang.price_btn_cancel],
				onSuccess : function(result) {
					if (result.buttonIndex == 0) {// confirm
						isOver = false;
						if (($scope.product.price_sku > $scope.product.purchase_price_level[0]) ||
						($scope.product.purchase_price_level[$scope.product.purchase_price_level.length - 1] > $scope.product.sale_price)) {
							isOver = true;
						}
						for (i = 0; i < $scope.product.purchase_price_level.length - 1; i++) {
							if ($scope.product.purchase_price_level[i] > $scope.product.purchase_price_level[i + 1])
								isOver = true;
						}
						
						if (isOver) {
							// Show confirm dlg
							dd.device.notification.confirm({
								message: lang.price_set_low_alert,
								title: lang.set_price,
								buttonLabels: [lang.price_btn_continue, lang.price_btn_cancel],
								onSuccess : function(result) {
									if (result.buttonIndex == 0) {
										// Show loading
										dd.device.notification.showPreloader({
											text: lang.price_sending, //loading显示的字符，空表示不显示文字
											showIcon: true, //是否显示icon，默认true
											onSuccess : function(result) {},
											onFail : function(err) {}
										});
										save_data = {
											'product_id': $scope.product_id,
											'price_sku': $scope.product.price_sku,
											'purchase_price_level': $scope.product.purchase_price_level,
											'sale_price': $scope.product.sale_price,
											'order_limit_down_level': $scope.product.order_limit_down_level,
											'order_limit_up_level': $scope.product.order_limit_up_level
										};
										$http.post("/price/level/save", JSON.stringify(save_data)).then(
											function (response) {
												console.log(response);
												// Hide loading
												dd.device.notification.hidePreloader({
													onSuccess : function(result) {},
													onFail : function(err) {}
												});
												if (response.data.success === true) {
													// Show success toast
													dd.device.notification.toast({
														icon: 'success', //icon样式，有success和error，默认为空 0.0.2
														text: lang.price_save_success, //提示信息
														duration: 2, //显示持续时间，单位秒，默认按系统规范[android只有两种(<=2s >2s)]
														delay: 2, //延迟显示，单位秒，默认0
														onSuccess : function(result) {},
														onFail : function(err) {}
													});
													window.location = "#!/price/view/" + $scope.product_id;
												} else {
													// Show fail toast
													dd.device.notification.toast({
														icon: 'error', //icon样式，有success和error，默认为空 0.0.2
														text: lang.price_save_fail, //提示信息
														duration: 2, //显示持续时间，单位秒，默认按系统规范[android只有两种(<=2s >2s)]
														delay: 2, //延迟显示，单位秒，默认0
														onSuccess : function(result) {},
														onFail : function(err) {}
													});
													$scope.isSaving = false;
												}
											}, function(response) {
												// Hide loading
												dd.device.notification.hidePreloader({
													onSuccess : function(result) {},
													onFail : function(err) {}
												});
												$scope.isSaving = false;
											}
										);
									} else {
										$scope.isSaving = false;
									}
								},
								onFail : function(err) {
									$scope.isSaving = false;
								}
							});
						} else {
							// Show loading
							dd.device.notification.showPreloader({
								text: lang.price_sending, //loading显示的字符，空表示不显示文字
								showIcon: true, //是否显示icon，默认true
								onSuccess : function(result) {},
								onFail : function(err) {}
							});
							save_data = {
								'product_id': $scope.product_id,
								'price_sku': $scope.product.price_sku,
								'purchase_price_level': $scope.product.purchase_price_level,
								'sale_price': $scope.product.sale_price,
								'order_limit_down_level': $scope.product.order_limit_down_level,
								'order_limit_up_level': $scope.product.order_limit_up_level
							};
							$http.post("/price/level/save", JSON.stringify(save_data)).then(
								function (response) {
									console.log(response);
									// Hide loading
									dd.device.notification.hidePreloader({
										onSuccess : function(result) {},
										onFail : function(err) {}
									});
									if (response.data.success === true) {
										// Show success toast
										dd.device.notification.toast({
											icon: 'success', //icon样式，有success和error，默认为空 0.0.2
											text: lang.price_save_success, //提示信息
											duration: 2, //显示持续时间，单位秒，默认按系统规范[android只有两种(<=2s >2s)]
											delay: 2, //延迟显示，单位秒，默认0
											onSuccess : function(result) {},
											onFail : function(err) {}
										});
										window.location = "#!/price/view/" + $scope.product_id;
									} else {
										// Show fail toast
										dd.device.notification.toast({
											icon: 'error', //icon样式，有success和error，默认为空 0.0.2
											text: lang.price_save_fail, //提示信息
											duration: 2, //显示持续时间，单位秒，默认按系统规范[android只有两种(<=2s >2s)]
											delay: 2, //延迟显示，单位秒，默认0
											onSuccess : function(result) {},
											onFail : function(err) {}
										});
										$scope.isSaving = false;
									}
								}, function(response) {
									// Hide loading
									dd.device.notification.hidePreloader({
										onSuccess : function(result) {},
										onFail : function(err) {}
									});
									$scope.isSaving = false;
								}
							);
						}
					} else {
						$scope.isSaving = false;
					}
					console.log(result.buttonIndex);
				},
				onFail : function(err) {
					$scope.isSaving = false;
				}
			});
		} else {
			DingTalkPC.device.notification.confirm({
				message: lang.price_set_confirm,
				title: lang.set_price,
				buttonLabels: [lang.price_btn_confirm, lang.price_btn_cancel],
				onSuccess : function(result) {
					if (result.buttonIndex == 0) {// confirm
						isOver = false;
						if (($scope.product.price_sku > $scope.product.purchase_price_level[0]) ||
						($scope.product.purchase_price_level[$scope.product.purchase_price_level.length - 1] > $scope.product.sale_price)) {
							isOver = true;
						}
						for (i = 0; i < $scope.product.purchase_price_level.length - 1; i++) {
							if ($scope.product.purchase_price_level[i] > $scope.product.purchase_price_level[i + 1])
								isOver = true;
						}
						
						if (isOver) {
							// Show confirm dlg
							DingTalkPC.device.notification.confirm({
								message: lang.price_set_low_alert,
								title: lang.set_price,
								buttonLabels: [lang.price_btn_continue, lang.price_btn_cancel],
								onSuccess : function(result) {
									if (result.buttonIndex == 0) {
										save_data = {
											'product_id': $scope.product_id,
											'price_sku': $scope.product.price_sku,
											'purchase_price_level': $scope.product.purchase_price_level,
											'sale_price': $scope.product.sale_price,
											'order_limit_down_level': $scope.product.order_limit_down_level,
											'order_limit_up_level': $scope.product.order_limit_up_level
										};
										$http.post("/price/level/save", JSON.stringify(save_data)).then(
											function (response) {
												console.log(response);
												if (response.data.success === true) {
													// Show success toast
													DingTalkPC.device.notification.toast({
														icon: 'success', //icon样式，有success和error，默认为空 0.0.2
														text: lang.price_save_success, //提示信息
														duration: 2, //显示持续时间，单位秒，默认按系统规范[android只有两种(<=2s >2s)]
														delay: 2, //延迟显示，单位秒，默认0
														onSuccess : function(result) {},
														onFail : function(err) {}
													});
													window.location = "#!/price/view/" + $scope.product_id;
												} else {
													// Show fail toast
													DingTalkPC.device.notification.toast({
														icon: 'error', //icon样式，有success和error，默认为空 0.0.2
														text: lang.price_save_fail, //提示信息
														duration: 2, //显示持续时间，单位秒，默认按系统规范[android只有两种(<=2s >2s)]
														delay: 2, //延迟显示，单位秒，默认0
														onSuccess : function(result) {},
														onFail : function(err) {}
													});
													$scope.isSaving = false;
												}
												
											}, function (response) {
												// Show fail toast
												DingTalkPC.device.notification.toast({
													icon: 'error', //icon样式，有success和error，默认为空 0.0.2
													text: lang.price_save_fail, //提示信息
													duration: 2, //显示持续时间，单位秒，默认按系统规范[android只有两种(<=2s >2s)]
													delay: 2, //延迟显示，单位秒，默认0
													onSuccess : function(result) {},
													onFail : function(err) {}
												});
												$scope.isSaving = false;
											}
										);
									} else {
										$scope.isSaving = false;
									}
								},
								onFail : function(err) {
									$scope.isSaving = false;
								}
							});
						} else {
							save_data = {
								'product_id': $scope.product_id,
								'price_sku': $scope.product.price_sku,
								'purchase_price_level': $scope.product.purchase_price_level,
								'sale_price': $scope.product.sale_price,
								'order_limit_down_level': $scope.product.order_limit_down_level,
								'order_limit_up_level': $scope.product.order_limit_up_level
							};
							$http.post("/price/level/save", JSON.stringify(save_data)).then(
								function (response) {
									console.log(response);
									if (response.data.success === true) {
										// Show success toast
										DingTalkPC.device.notification.toast({
											icon: 'success', //icon样式，有success和error，默认为空 0.0.2
											text: lang.price_save_success, //提示信息
											duration: 2, //显示持续时间，单位秒，默认按系统规范[android只有两种(<=2s >2s)]
											delay: 2, //延迟显示，单位秒，默认0
											onSuccess : function(result) {},
											onFail : function(err) {}
										});
										window.location = "#!/price/view/" + $scope.product_id;
									} else {
										// Show fail toast
										DingTalkPC.device.notification.toast({
											icon: 'error', //icon样式，有success和error，默认为空 0.0.2
											text: lang.price_save_fail, //提示信息
											duration: 2, //显示持续时间，单位秒，默认按系统规范[android只有两种(<=2s >2s)]
											delay: 2, //延迟显示，单位秒，默认0
											onSuccess : function(result) {},
											onFail : function(err) {}
										});
										$scope.isSaving = false;
									}
								}
							);
						}
					} else {
						$scope.isSaving = false;
					}
					console.log(result.buttonIndex);
				},
				onFail : function(err) {
					$scope.isSaving = false;
				}
			});
		}
	}

	$http.get('product/get/item/' + $scope.product_id).then(
		function(response) {
			console.log(response.data);
			$scope.product = response.data.value;
			
			if ($scope.product.purchase_price_level == null) {
				$scope.product.purchase_price_level = [];
				$scope.product.order_limit_down_level = [];
				$scope.product.order_limit_up_level = [];
				for (i = 0; i < $scope.product.max_level; i++) {
					$scope.product.purchase_price_level.push(null);
					$scope.product.order_limit_down_level.push(null);
					$scope.product.order_limit_up_level.push(null);
				}
			}
			
			console.log($scope.product);
			for (i = 0; i < $scope.product.max_level; i++) {
				$scope.required_purchase_price_level.push(false);
				$scope.required_limit_down.push(false);
			}
			
			// Mobile dingding Menu
			if(is_mobile){
				backButtonUrl = "#!/price/view/" + $scope.product_id;

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

				// Setup title
				dd.biz.navigation.setTitle({
					title : $scope.product.name,// 一年延保卡
					onSuccess : function(result) {
					},
					onFail : function(err) {}
				});

				switch (user_priv) {
				case 'admin': // When user_priv is admin
					// Setup menus
					dd.biz.navigation.setMenu({
						backgroundColor : "#ffffff",
						textColor : "#000000",
						items : [
							{ // 完成 menu
								"id":"1",
								"text":lang.btn_complete
							},
						],
						onSuccess: function(data) {
							$("#save_submit_button").trigger( "click" );
							console.log(data);
						},
						onFail: function(err) {
							console.log(err);
						}
					});
					break;
				case 'dealer': // When user_priv is dealer
					// Set empty menu
					dd.biz.navigation.setRight({
						show: false,//控制按钮显示， true 显示， false 隐藏， 默认true
						control: true,//是否控制点击事件，true 控制，false 不控制， 默认false
						text: '发送',//控制显示文本，空字符串表示显示默认文本
						onSuccess : function(result) {
						},
						onFail : function(err) {}
					});
					break;
				}
				console.log("Setup the menus");
			}
			// PC Menu
			else{
				$rootScope.route_status = 'price';
			}
			$(".price_v_content").css("display", "block");
		}
	);

	// For calculate the diff days between two dates
	$scope.parseDate = function(str) {
		var mdy = str.split('-');
		return new Date(mdy[0], mdy[1]-1, mdy[2]);
	}

	$scope.dayDiff = function(first, second) {
		return Math.round((second-first)/(1000*60*60*24));
	}

	// Get the current date
	d = new Date();
	$scope.cur_date = d.getFullYear() + "-" + (d.getMonth() + 1) + "-" + d.getDate();
});

