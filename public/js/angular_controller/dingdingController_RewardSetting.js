
// Mobile reward user controller only seller
dingdingApp.controller('rewardSettingViewController', function($scope, $rootScope, $route, $routeParams, $http, PagerService, myDialogService) {
    $scope.pagenum = 1;
    $scope.itemcount_perpage = 5;
	if(is_mobile) $scope.itemcount_perpage = 6;
	
	$scope.no_data = false;
	
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

		backButtonUrl = "#!/reward/office/list";

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
			title : lang.title_reward_setting,// 奖励设置
			onSuccess : function(result) {
			},
			onFail : function(err) {}
		});

		// Setup the menus
		switch (user_priv) {
		case 'admin': // When user_priv is admin
			// Setup menus
			dd.biz.navigation.setMenu({
				backgroundColor : "#ffffff",
				textColor : "#000000",
				items : [
					{ // 奖励规则添加 menu
						"id":"1",
						"text":lang.rew_red_rule_add_rule
					},
				],
				onSuccess: function(data) {
					window.location = "#!/reward/setting/edit/view";
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
		case 'seller': // When user_priv is seller
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

    function get_page_list(pagenum, itemcount) {
		if(is_mobile){
			if(pagenum == 1){
				delete $scope.items;
				$scope.items = [];
			}
		}
        $scope.no_data = false;
        $scope.loaded =  false;
        $scope.busy = true;

        $http.get('reward/setting/index/' + itemcount + '/' + pagenum).then(
            function (response){
                console.log(response.data);

                $scope.busy = false;	// It is true when this is loading
                $scope.loaded = true;
				if (is_mobile) {
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
				} else {
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
		get_page_list(pagenum, $scope.itemcount_perpage);
	}

    get_page_list($scope.pagenum, $scope.itemcount_perpage);

    $rootScope.route_status = 'reward';
	
	$scope.onEdit = function (item) {
		data = {
			'id': item.id,
			'redpacket_name': item.redpacket_name,
			'dealer_id': item.dealer_id,
			'dealer_name': item.dealer_name,
			'redpacket_start_date': item.redpacket_start_date,
			'redpacket_end_date': item.redpacket_end_date,
			'redpacket_type': item.redpacket_type,
			'product_id': item.product_id,
			'redpacket_rule': item.redpacket_rule,
			'redpacket_price': item.redpacket_price
		};
		console.log("#!/reward/setting/edit/view/" + JSON.stringify(data));
		
		window.location.href = "#!/reward/setting/edit/view/" + JSON.stringify(data);
	}
	
	$scope.level_saving = false;
	$scope.onRemove = function (id) {
		if ($scope.level_saving) return;
		$scope.level_saving = true;
		if (is_mobile) {			
			dd.device.notification.confirm({
				message: lang.rew_confirm_redpacket_remove,
				title: lang.title_reward_setting,
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
						$http.get("/reward/setting/remove/" + id).then(
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
		} else {
			DingTalkPC.device.notification.confirm({
				message: lang.rew_confirm_redpacket_remove,
				title: lang.title_reward_setting,
				buttonLabels: [lang.price_btn_confirm, lang.price_btn_cancel],
				onSuccess : function(result) {
					if (result.buttonIndex == 0) {// confirm
						$http.get("/reward/setting/remove/" + id).then(
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
	}
});


dingdingApp.controller('rewardSettingEditViewController', function($scope, $rootScope, $route, $routeParams, $http, PagerService, myDialogService) {
	if(typeof $routeParams.redpacket_setting == "undefined") {
		$scope.redpacket_setting = {};
		$scope.isEdit = false;
	} else {
		$scope.redpacket_setting = JSON.parse($routeParams.redpacket_setting);
		$scope.isEdit = true;
	}
	
    $rootScope.route_status = 'reward';
	
	$scope.no_data = false;
	
	// Mobile dingding Menu
	if(is_mobile){
		backButtonUrl = "#!/reward/setting/view";

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
			title : lang.title_reward_setting,// 奖励设置
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
		console.log("Setup the menus");
	}
	
	$http.get('/product/get/all').then(
		function(response) {
			console.log(response);
			$scope.products = response.data;
			$scope.redpacket_setting.product_id = $scope.products[0].id;
			console.log('select');
			
			console.log($scope.redpacket_setting.product_id);
			
			if ($scope.isEdit) {
				if ($scope.redpacket_setting.product_id != null)
					$scope.redpacket_setting.product_id = $scope.redpacket_setting.product_id
				dealer = {
					'id': $scope.redpacket_setting.dealer_id,
					'name': $scope.redpacket_setting.dealer_name
				};
				
				$scope.dealers = [];
				$scope.dealers.push(dealer);
			} else {
				$scope.dealer_id = 1;
				$scope.redpacket_setting.redpacket_type = 0;
				get_list();
			}
		}
	);
	
	function get_list() {
		$scope.no_data = false;	
		$scope.dealers = [];
		$http.get('price/get/downdealerwithpromotion/' + $scope.product_id + '/' + $scope.dealer_id).then(
			function(response) {
				console.log(1);
				console.log(response);
				$scope.dealers = response.data;
				
				if ($scope.dealers.length == 0) {
					$scope.no_data = true;
					$scope.redpacket_setting.dealer_id = null;
				} else {
					$scope.redpacket_setting.dealer_id = $scope.dealers[0].id;
				}
			}
		);	
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
					$scope.redpacket_setting.dealer_id = null;
				} else {
					$scope.redpacket_setting.dealer_id = $scope.dealers[0].id;
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
					$scope.redpacket_setting.dealer_id = null;
				} else {
					$scope.redpacket_setting.dealer_id = $scope.dealers[0].id;
				}
				console.log($scope.redpacket_setting.dealer_id);
			}
		);
	}

	$scope.ajax_loading = false;
	$scope.submit_redpacket_setting = function () {
		if ($scope.ajax_loading) return;
		$scope.ajax_loading = true;
		
		if ($scope.redpacket_setting.redpacket_name == null || $scope.redpacket_setting.redpacket_price == null || 
		$scope.redpacket_setting.redpacket_rule == null || $scope.redpacket_setting.redpacket_start_date == null ||
		$scope.redpacket_setting.redpacket_end_date == null || $scope.redpacket_setting.dealer_id == null) {
			$scope.ajax_loading = false;
			if (is_mobile) {
				// Show fail toast
				dd.device.notification.toast({
					icon: 'error', //icon样式，有success和error，默认为空 0.0.2
					text: lang.rew_required_redpacket_field, //提示信息
					duration: 2, //显示持续时间，单位秒，默认按系统规范[android只有两种(<=2s >2s)]
					delay: 2, //延迟显示，单位秒，默认0
					onSuccess : function(result) {},
					onFail : function(err) {}
				});
			}
			return;
		}
		
		start_date = new Date($scope.redpacket_setting.redpacket_start_date);
		end_date = new Date($scope.redpacket_setting.redpacket_end_date);
		if (start_date >= end_date) {
			$scope.ajax_loading = false;
			if (is_mobile) {
				// Show fail toast
				dd.device.notification.toast({
					icon: 'error', //icon样式，有success和error，默认为空 0.0.2
					text: lang.price_promotion_dateinput, //提示信息
					duration: 2, //显示持续时间，单位秒，默认按系统规范[android只有两种(<=2s >2s)]
					delay: 2, //延迟显示，单位秒，默认0
					onSuccess : function(result) {},
					onFail : function(err) {}
				});
			}
			return;
		}
		
		if (is_mobile) {
			dd.device.notification.confirm({
				message: lang.rew_confirm_redpacket_setting,
				title: lang.title_reward_setting,
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
						
						if ($scope.isEdit) {
							if ($scope.redpacket_setting.redpacket_type == 0)
								$scope.redpacket_setting.product_id = null;
							
							$http.post('/reward/setting/edit', JSON.stringify($scope.redpacket_setting)).then(
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
										window.location = "#!/reward/setting/view";
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
							if ($scope.redpacket_setting.redpacket_type == 0)
								$scope.redpacket_setting.product_id = null;
							
							$http.post('/reward/setting/add', JSON.stringify($scope.redpacket_setting)).then(
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
										window.location = "#!/reward/setting/view";
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
		} else {
			DingTalkPC.device.notification.confirm({
				message: lang.rew_confirm_redpacket_setting,
				title: lang.title_reward_setting,
				buttonLabels: [lang.price_btn_confirm, lang.price_btn_cancel],
				onSuccess : function(result) {
					if (result.buttonIndex == 0) {// confirm						
						if ($scope.isEdit) {
							if ($scope.redpacket_setting.redpacket_type == 0)
								$scope.redpacket_setting.product_id = null;
							
							$http.post('/reward/setting/edit', JSON.stringify($scope.redpacket_setting)).then(
								function(response) {
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
										$scope.ajax_loading = false;
										window.location = "#!/reward/setting/view";
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
										$scope.ajax_loading = false;
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
									$scope.ajax_loading = false;
								}
							);
						} else {
							if ($scope.redpacket_setting.redpacket_type == 0)
								$scope.redpacket_setting.product_id = null;
							
							$http.post('/reward/setting/add', JSON.stringify($scope.redpacket_setting)).then(
								function(response) {
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
										$scope.ajax_loading = false;
										window.location = "#!/reward/setting/view";
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
										$scope.ajax_loading = false;
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
	}
});
