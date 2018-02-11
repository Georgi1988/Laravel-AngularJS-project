
// Mobile user dealer controller only admin
dingdingApp.controller('userDealerController', function($scope, $rootScope, $route, $routeParams, $http, PagerService, myDialogService) {
	
    $scope.dealer = { id:$routeParams.dealer_id };
    $scope.login_dealer_id = login_dealer_id;
    $scope.login_dealer_level = login_dealer_level;

    $scope.loaded = false;
	
	// Mobile dingding Menu
	if (is_mobile) {
		// Scroll event listener
		$(window).on('scroll', function(){
			if( $(window).scrollTop() >= $(document).height() - $(window).height() ) {
				if($scope.loaded && $scope.pagenum < $scope.last_page){
					get_page_list($scope.dealer.id, ($scope.pagenum + 1), $scope.itemcount_perpage, $scope.search);
				}
			}
		}).scroll();

		//dd.ready(function() {
			// When back button closed
			backButtonUrl = "#!/overview";

			// Only for iphone
			dd.biz.navigation.setLeft({
				control: true,						// 是否控制点击事件，true 控制，false 不控制， 默认false
				text: lang.label_back,				// 控制显示文本，空字符串表示显示默认文本
				onSuccess : function(result) {
					window.location = "#!/overview";
				},
				onFail : function(err) {}
			});
		//});	
			// When back button closed
			// document.addEventListener('backbutton', function(e) {
			// 	e.preventDefault();
			// 	window.location = "#!/overview";
			// }, false);

			// Setup title
			dd.biz.navigation.setTitle({
				title : lang.title_user,// 经销商
				onSuccess : function(result) {
				},
				onFail : function(err) {}
			});

			// Setup menus
			/*dd.biz.navigation.setMenu({
				backgroundColor : "#ADD8E6",
				textColor : "#3399FF11",
				items : [
					{ // 同步 menu
						"id":"1",
						"text":lang.btn_synchronize
					},
				],
				onSuccess: function(data) {
					
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

			console.log("Setup the menus");
		//});
	}
	// PC Menu
	else {
		$rootScope.route_status = 'user';
	}
	
	// Config variables
	$scope.pagenum = 1;
	$scope.itemcount_perpage = 5;

	if (is_mobile)
		$scope.itemcount_perpage = 6;

	$scope.search = {name: ''};

	function get_page_list(dealer_id, pagenum, itemcount, search) {
		if (is_mobile) {
			if (pagenum === 1) {
				delete $scope.lower_dealers;
				$scope.lower_dealers = [];
			}
		}

		$scope.no_data = false;
        $scope.loaded = false;
		$scope.busy = true;

		$http.get('user/dealer/get/info/' + dealer_id + '/' + JSON.stringify(search) + '/' + itemcount + '/' + pagenum).then (
			function (response) {
				console.log(response);
				$scope.busy = false;	// It is true when this is loading
				$scope.loaded = true;

				if (response.status) {
                    var result = response.data.result;

                    if (response.data.status) {
                        $scope.dealer = result.dealer;
                        $scope.users = result.users;
                        $scope.upper_dealer = result.upper_dealer;

                        if (is_mobile) {
                            var lower_dealers = result.lower_dealers;

                            for (var i = 0; i < lower_dealers.data.length; i++) {
                                $scope.lower_dealers.push(lower_dealers.data[i]);
                            }

							if ($scope.lower_dealers.length === 0) {
								$scope.no_data = true;
							}

							$scope.last_page = result.lower_dealers.last_page;
                            $scope.pagenum = result.lower_dealers.current_page;
                        } else {
                            $scope.lower_dealers = result.lower_dealers;

                            $scope.last_page = $scope.lower_dealers.last_page;
                            $scope.pagenation = PagerService.GetPager($scope.lower_dealers.total, $scope.lower_dealers.current_page, $scope.lower_dealers.per_page, 10);

							if ($scope.lower_dealers.data.length === 0) {
								$scope.no_data = true;
							}
						}
                    } else {
                        $scope.loaded = true;
                        custom_alert(response.error_message, "error");
                    }
                } else {
                    $scope.loaded = true;
                    custom_alert("Internet connection error!", "error");
				}
				
				
				$(".page_wrapper").css("display", "block");
				
				userLoadDlg = $( "#userload" ).dialog({
					autoOpen: false,
					resizable: false,
					height: "auto",
					width: 740,
					modal: true,
				});
			}
		);
	}

	// When pagination changed
	$scope.setPage = function(pagenum) {
		if (pagenum < 1) {
			pagenum = 1;
        } else if(pagenum > $scope.lower_dealers.last_page) {
			pagenum = $scope.lower_dealers.last_page;
        }

		get_page_list($scope.dealer.id, pagenum, $scope.itemcount_perpage, $scope.search);
	}
	// Update the page list's data when tab is changed in mobile
	$scope.search_type = function(level) {
		$scope.level = level;
		get_page_list($scope.dealer.id, 1, $scope.itemcount_perpage, $scope.search);
	}
	//
    $scope.onChangeDealer = function(dealer_id) {
		$scope.search.name = '';
        get_page_list(dealer_id, 1, $scope.itemcount_perpage, $scope.search);
	};

	// When input the search name
	$scope.onSearch = function() {
		get_page_list($scope.dealer.id, 1, $scope.itemcount_perpage, $scope.search);
	}

	get_page_list($scope.dealer.id, 1, $scope.itemcount_perpage, $scope.search);

    userLoadDlg = $( "#userload" ).dialog({
		autoOpen: false,
		resizable: false,
		height: "auto",
		width: 740,
		modal: true,
	});

    $( ".userloadbtn" ).click( function() {
		$(".alert-save-success").hide();
		$(".alert-save-fail").hide();
		
		userLoadDlg.dialog( "open" );
    });
	
	$scope.close_dlg_userload = function() {
		// console.log("close button click");
        userLoadDlg.dialog( "close" );
	}

	$scope.submit_import_dealer = function() {
		var formData = new FormData(document.getElementById("import_dealer_form"));
        $scope.loaded = false;
		$scope.import_errors = [];

		$.ajax({
			url: "user/dealer/import/" + $scope.dealer.id,
			type: 'POST',
			data:  formData,
			mimeType:"multipart/form-data",
			contentType: false,
			cache: false,
			processData:false,

			success: function(result, textStatus, jqXHR)
			{
                $scope.loaded = true;

				var data = jQuery.parseJSON(result);
				
				if (data.status) {
					$scope.msg = data.msg;
					$(".alert-save-success").show();
					
					window.setTimeout(function() { 
						$(".alert-save-success").hide(300);
					}, 4000);
				} else {
					$scope.err_msg = data.err_msg;
					console.log($scope.err_msg);
					$scope.import_errors = data.import_errors;
					$(".alert-save-fail").show();
				}
			},
			error: function(xhr, status, error) 
			{
				$scope.loaded = true;

				$scope.err_msg = lang.rg_fail_save;
				$(".alert-save-fail").show();

				window.setTimeout(function() { 
					$(".alert-save-success").hide(300);
				}, 4000);
			}
		});
		
		return false;
	}
	
	$scope.onBalance = function(dealer_id) {
		myDialogService.confirm({
			title: lang.confirm,
			message: lang.settle_confirm_message,
			confirm_txt: lang.confirm,
			cancle_txt: lang.cancel,
			success_callback: function() {				
				$http.post('user/dealer/set/balance/' + dealer_id).then(
					function(response) {
						console.log(response);
		
						if (response.data.success === true) {
							myDialogService.alert({
								title: lang.information,
								message: lang.successful_settle_balance,
								button: lang.close,
								animation: "fade",
							});
						
							angular.forEach($scope.lower_dealers, function(lower_dealer) {
								if (lower_dealer.id == dealer_id) {
									lower_dealer.total_unbalance = 0;
								}
							})
						}
					}
				);
			},
			cancle_callback: null,
			fail_callback: null
		});
    }

    $scope.call_phone = function(phone_number){
        if(is_mobile){
            console.log(phone_number);
            dd.biz.telephone.showCallMenu({
                phoneNumber: phone_number, // 期望拨打的电话号码
                code: '+86', // 国家代号，中国是+86
                showDingCall: true, // 是否显示钉钉电话
                onSuccess : function() {},
                onFail : function() {console.log('fail')}
            });
        }
    };

	function custom_alert( message, title ) {
		if (!title) {
            title = 'Alert';
        }

		if (!message) {
            message = 'No Message to Display.';
        }

		$('<div></div>').html( message ).dialog({
			title: title,
			resizable: false,
			modal: true
		});
	}

});

// Mobile user dealer view controller only admin
dingdingApp.controller('userDealerViewController', function($scope, $rootScope, $route, $routeParams, $http, myDialogService) {	
	if(typeof $routeParams.dealer_id === "undefined") {
		$scope.dealer_id = '0';
	} else {
		$scope.dealer_id = $routeParams.dealer_id;
	}

	// Mobile dingding Menu
	if(is_mobile){
		//dd.ready(function() {
			// When back button closed
			if (user_priv === 'admin') {
				// When back button closed
				backButtonUrl = "#!/user/dealer";

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
				
				// document.addEventListener('backbutton', function(e) {
				// 	e.preventDefault();
				// 	window.location = "#!/user/dealer";
				// }, false);
			}
			else {
				// When back button closed
				backButtonUrl = "#!/user/employee";

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
				
				// document.addEventListener('backbutton', function(e) {
				// 	e.preventDefault();
				// 	window.location = "#!/user/employee";
				// }, false);
			}
		//});
			// Setup title
			dd.biz.navigation.setTitle({
				title : lang.title_dealer_info,// 经销商信息
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
		//});
	}
	// PC Menu
	else{
		$rootScope.route_status = 'user';
	}
	
	$scope.loaded = false;
	$http.get('user/dealer/get/detail/' + $scope.dealer_id).then(
		function(response){
			$scope.dealer = response.data;
			$scope.loaded = true;
			$(".user_v_content").css("display", "block");
		}
	);

	$scope.onBalance = function() {
		myDialogService.confirm({
			title: lang.confirm,
			message: lang.settle_confirm_message,
			confirm_txt: lang.confirm,
			cancle_txt: lang.cancel,
			success_callback: function() {				
				$http.post('user/dealer/set/balance/' + $scope.dealer_id).then(
					function(response) {
						console.log(response);
		
						if (response.data.success === true) {
							myDialogService.alert({
								title: lang.information,
								message: lang.successful_settle_balance,
								button: lang.close,
								animation: "fade",
							});
						
							angular.forEach($scope.lower_dealers, function(lower_dealer) {
								if (lower_dealer.id == dealer_id) {
									lower_dealer.total_unbalance = 0;
								}
							})
						}
					}
				);
			},
			cancle_callback: null,
			fail_callback: null
		});
	}
	
	$scope.call_phone = function(phone_number){
		if(is_mobile){
			console.log(phone_number);
			dd.biz.telephone.showCallMenu({
				phoneNumber: phone_number, // 期望拨打的电话号码
				code: '+86', // 国家代号，中国是+86
				showDingCall: true, // 是否显示钉钉电话
				onSuccess : function() {},
				onFail : function() { console.log('fail'); }
			});
		}
	};
});

// Mobile user dealer detail view controller only admin
dingdingApp.controller('userDealerDetailController', function($scope, $rootScope, $route, $routeParams, $http, myDialogService) {
    if (typeof $routeParams.dealer_id == "undefined") {
        $scope.dealer_id = '0';
    } else {
        $scope.dealer_id = $routeParams.dealer_id;
    }

	// Mobile dingding Menu
	if(is_mobile){
		//dd.ready(function() {
			// When back button closed
			if (user_priv === 'admin') {
				// When back button closed
				backButtonUrl = "#!/user/dealer";

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
				
				// document.addEventListener('backbutton', function(e) {
				// 	e.preventDefault();
				// 	window.location = "#!/user/dealer";
				// }, false);
			}
			else {
				// When back button closed
				backButtonUrl = "#!/user/employee";

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
				
				// document.addEventListener('backbutton', function(e) {
				// 	e.preventDefault();
				// 	window.location = "#!/user/employee";
				// }, false);
			}
		//});
			// Setup title
			dd.biz.navigation.setTitle({
				title : lang.title_dealer_info,// 经销商信息
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
		//});
	}
	// PC Menu
	else{
		$rootScope.route_status = 'user';
	}
	
	$scope.loaded = false;
	$http.get('user/dealer/get/detail/' + $scope.dealer_id + '/require').then(
		function(response){
			$scope.dealer = response.data;
			$scope.loaded = true;
			$(".user_v_content").css("display", "block");
		}
	);

	$scope.onBalance = function() {
		myDialogService.confirm({
			title: lang.confirm,
			message: lang.settle_confirm_message,
			confirm_txt: lang.confirm,
			cancle_txt: lang.cancel,
			success_callback: function() {				
				$http.post('user/dealer/set/balance/' + $scope.dealer_id).then(
					function(response) {
						console.log(response);
		
						if (response.data.success === true) {
							myDialogService.alert({
								title: lang.information,
								message: lang.successful_settle_balance,
								button: lang.close,
								animation: "fade",
							});
						
							angular.forEach($scope.lower_dealers, function(lower_dealer) {
								if (lower_dealer.id == dealer_id) {
									lower_dealer.total_unbalance = 0;
								}
							})
						}
					}
				);
			},
			cancle_callback: null,
			fail_callback: null
		});
	}
	
	$scope.call_phone = function(phone_number){
		if(is_mobile){
			console.log(phone_number);
			dd.biz.telephone.showCallMenu({
				phoneNumber: phone_number, // 期望拨打的电话号码
				code: '+86', // 国家代号，中国是+86
				showDingCall: true, // 是否显示钉钉电话
				onSuccess : function() {

				},
				onFail : function() {
					console.log('fail');
				}
			});
		}
	};
});

// Mobile user dealer edit view controller only admin
dingdingApp.controller('userDealerEditController', function($scope, $rootScope, $route, $routeParams, $http, myDialogService) {
    $scope.method = $routeParams.method;
    $scope.subject = $routeParams.subject;
    $scope.dealer_id = $routeParams.dealer_id;
    $scope.login_dealer_level = login_dealer_level;

    $scope.loaded = true;

	// Mobile dingding Menu
	if (is_mobile) {
		//dd.ready(function() {
			// When back button closed
			if (user_priv === 'admin') {
				// When back button closed
				backButtonUrl = "";

				// Only for iphone
				dd.biz.navigation.setLeft({
					control: true,							// 是否控制点击事件，true 控制，false 不控制， 默认false
					text: lang.label_back,					// 控制显示文本，空字符串表示显示默认文本
					onSuccess : function(result) {
						window.location = "#!/user/dealer";
					},
					onFail : function(err) {}
				});
				
				// document.addEventListener('backbutton', function(e) {
				// 	e.preventDefault();
				// 	window.location = "#!/user/dealer";
				// }, false);
			}
			else {
				// When back button closed
				backButtonUrl = "";

				// Only for iphone
				dd.biz.navigation.setLeft({
					control: true,							// 是否控制点击事件，true 控制，false 不控制， 默认false
					text: lang.label_back,					// 控制显示文本，空字符串表示显示默认文本
					onSuccess : function(result) {
						window.location = "#!/user/employee";
					},
					onFail : function(err) {}
				});
				
				// document.addEventListener('backbutton', function(e) {
				// 	e.preventDefault();
				// 	window.location = "#!/user/employee";
				// }, false);
			}
		//});
			// Setup title
			dd.biz.navigation.setTitle({
				title : lang.title_dealer_info,				// 经销商信息
				onSuccess : function(result) {
				},
				onFail : function(err) {}
			});

			// Set empty menu
			dd.biz.navigation.setRight({
				show: false,								// 控制按钮显示， true 显示， false 隐藏， 默认true
				control: true,								// 是否控制点击事件，true 控制，false 不控制， 默认false
				text: '发送',								  // 控制显示文本，空字符串表示显示默认文本
				onSuccess : function(result) {
				},
				onFail : function(err) {}
			});

			console.log("Setup the menus");
		//});
	}
	// PC Menu
	else{
		$rootScope.route_status = 'user';
	}

    $scope.loaded = false;
	$http.get('user/dealer/detail/' + $scope.dealer_id).then(
		function (response) {
			if (response.status == 200 && response.data.status) {
                var result = response.data.result;

                if ($scope.method == 'new') {
                    $scope.dealer = { level : result.dealer.level + 1};
                } else {
                    $scope.dealer = result.dealer;
                    $scope.addinfo = result.addinfo;
                }

				$scope.corporations = result.dealer.corp_list;

                $scope.areas = result.areas;
                $scope.provinces = result.provinces;
                $scope.store_types = result.store_types;
                $scope.store_kinds = result.store_kinds;
                $scope.store_levels = result.store_levels;
                $scope.store_properties = result.store_properties;

                if (angular.isUndefined($scope.dealer.corporation)) $scope.dealer.corporation = '';
                if (angular.isUndefined($scope.dealer.name)) $scope.dealer.name = '';
                if (angular.isUndefined($scope.dealer.area)) $scope.dealer.area = '';
                if (angular.isUndefined($scope.dealer.province)) $scope.dealer.province = '';
                if (angular.isUndefined($scope.dealer.city)) $scope.dealer.city = '';
                if (angular.isUndefined($scope.dealer.link)) $scope.dealer.link = '';
                if (angular.isUndefined($scope.dealer.email)) $scope.dealer.email = '';

                if (angular.isUndefined($scope.dealer.president))
                	$scope.dealer.president = {};

                if (angular.isUndefined($scope.dealer.president.name)) $scope.dealer.president.name = '';
                if (angular.isUndefined($scope.dealer.president.link)) $scope.dealer.president.link = '';
                if (angular.isUndefined($scope.dealer.president.email)) $scope.dealer.president.email = '';

                if (angular.isUndefined($scope.addinfo))
                    $scope.addinfo = {};

                if (angular.isUndefined($scope.addinfo.dealer_kind)) $scope.addinfo.dealer_kind = '';
                if (angular.isUndefined($scope.addinfo.upper_dealer_name)) $scope.addinfo.upper_dealer_name = '';
                if (angular.isUndefined($scope.addinfo.upper_dealer_code)) $scope.addinfo.upper_dealer_code = '';
                if (angular.isUndefined($scope.addinfo.country)) $scope.addinfo.country = '';
                if (angular.isUndefined($scope.addinfo.city_level)) $scope.addinfo.city_level = '';
                if (angular.isUndefined($scope.addinfo.zone)) $scope.addinfo.zone = '';
                if (angular.isUndefined($scope.addinfo.town)) $scope.addinfo.town = '';
                if (angular.isUndefined($scope.addinfo.area_boss_name)) $scope.addinfo.area_boss_name = '';
                if (angular.isUndefined($scope.addinfo.shop_dealer_name)) $scope.addinfo.shop_dealer_name = '';
                if (angular.isUndefined($scope.addinfo.city_boss_name)) $scope.addinfo.city_boss_name = '';
                if (angular.isUndefined($scope.addinfo.city_boss_code)) $scope.addinfo.city_boss_code = '';
                if (angular.isUndefined($scope.addinfo.city_boss_address)) $scope.addinfo.city_boss_address = '';
                if (angular.isUndefined($scope.addinfo.business_kind)) $scope.addinfo.business_kind = '';
                if (angular.isUndefined($scope.addinfo.shop_kind)) $scope.addinfo.shop_kind = '';
                if (angular.isUndefined($scope.addinfo.shop_short_kind)) $scope.addinfo.shop_short_kind = '';
                if (angular.isUndefined($scope.addinfo.shop_property)) $scope.addinfo.shop_property = '';
                if (angular.isUndefined($scope.addinfo.shop_direction)) $scope.addinfo.shop_direction = '';
                if (angular.isUndefined($scope.addinfo.total_area_of_shop)) $scope.addinfo.total_area_of_shop = '';
                if (angular.isUndefined($scope.addinfo.shop_monthly_sales)) $scope.addinfo.shop_monthly_sales = '';
                if (angular.isUndefined($scope.addinfo.shop_communication_address)) $scope.addinfo.shop_communication_address = '';
                if (angular.isUndefined($scope.addinfo.shop_postal_code)) $scope.addinfo.shop_postal_code = '';
                if (angular.isUndefined($scope.addinfo.shop_boss_phone_number)) $scope.addinfo.shop_boss_phone_number = '';
                if (angular.isUndefined($scope.addinfo.receipt_address)) $scope.addinfo.receipt_address = '';
                if (angular.isUndefined($scope.addinfo.receipt_name)) $scope.addinfo.receipt_name = '';
                if (angular.isUndefined($scope.addinfo.receipt_phone_number)) $scope.addinfo.receipt_phone_number = '';
                if (angular.isUndefined($scope.addinfo.receipt_mobile_phone_number)) $scope.addinfo.receipt_mobile_phone_number = '';
                if (angular.isUndefined($scope.addinfo.cooperation_status)) $scope.addinfo.cooperation_status = '';
                if (angular.isUndefined($scope.addinfo.application_time)) $scope.addinfo.application_time = '';
                if (angular.isUndefined($scope.addinfo.apply_for_approval_time)) $scope.addinfo.apply_for_approval_time = '';
                if (angular.isUndefined($scope.addinfo.modify_approval_time)) $scope.addinfo.modify_approval_time = '';
                if (angular.isUndefined($scope.addinfo.cancel_cooperation_approval_time)) $scope.addinfo.cancel_cooperation_approval_time = '';
                if (angular.isUndefined($scope.addinfo.comment)) $scope.addinfo.comment = '';
                if (angular.isUndefined($scope.addinfo.cooperation_kind)) $scope.addinfo.cooperation_kind = '';
                if (angular.isUndefined($scope.addinfo.it_mall_whole_name)) $scope.addinfo.it_mall_whole_name = '';
                if (angular.isUndefined($scope.addinfo.it_mall_short_name)) $scope.addinfo.it_mall_short_name = '';
                if (angular.isUndefined($scope.addinfo.location_kind)) $scope.addinfo.location_kind = '';
                if (angular.isUndefined($scope.addinfo.area_of_dell)) $scope.addinfo.area_of_dell = '';
                if (angular.isUndefined($scope.addinfo.after_sales_service_point)) $scope.addinfo.after_sales_service_point = '';
                if (angular.isUndefined($scope.addinfo.last_renovated_time)) $scope.addinfo.last_renovated_time = '';
                if (angular.isUndefined($scope.addinfo.dell_pay)) $scope.addinfo.dell_pay = '';
                if (angular.isUndefined($scope.addinfo.use_decoration_fund)) $scope.addinfo.use_decoration_fund = '';
                if (angular.isUndefined($scope.addinfo.counter_number)) $scope.addinfo.counter_number = '';
                if (angular.isUndefined($scope.addinfo.snp_cabinet_number)) $scope.addinfo.snp_cabinet_number = '';
                if (angular.isUndefined($scope.addinfo.commitment_sales)) $scope.addinfo.commitment_sales = '';
                if (angular.isUndefined($scope.addinfo.shop_level)) $scope.addinfo.shop_level = '';
                if (angular.isUndefined($scope.addinfo.nobody_shop)) $scope.addinfo.nobody_shop = '';
                if (angular.isUndefined($scope.addinfo.platform_shop_rating)) $scope.addinfo.platform_shop_rating = '';
                if (angular.isUndefined($scope.addinfo.registration_hours)) $scope.addinfo.registration_hours = '';
                if (angular.isUndefined($scope.addinfo.registration_approval_hours)) $scope.addinfo.registration_approval_hours = '';
                if (angular.isUndefined($scope.addinfo.line_under_report)) $scope.addinfo.line_under_report = '';
                if (angular.isUndefined($scope.addinfo.township_level)) $scope.addinfo.township_level = '';
                if (angular.isUndefined($scope.addinfo.shop_image_url)) $scope.addinfo.shop_image_url = '';
                if (angular.isUndefined($scope.addinfo.process_status)) $scope.addinfo.process_status = '';
                if (angular.isUndefined($scope.addinfo.retail_manager_user_name)) $scope.addinfo.retail_manager_user_name = '';

                $(".user_v_content").css("display", "block");
            } else {

			}

            $scope.loaded = true;
        }
	)

    $scope.save_loading = false;
	$scope.dealer_info_save = function() {
		$scope.form_require_province = false;
		$scope.form_require_city = false;

		console.log($scope.dealer.name);

		if ($scope.dealer.name === '' || typeof $scope.dealer.name === 'undefined'){
			$scope.form_require_name = true;
			return;
		} else {
			$scope.form_require_name = false;
		}

		if ($scope.dealer.province === null || $scope.dealer.province === ""){
			$scope.form_require_province = true;
			return;
		}

		if (($scope.dealer.city === null || $scope.dealer.city === "") && Object.keys($scope.dealer.city_list).length > 0) {
			$scope.form_require_city = true;
			return;
		}
		
		var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/; 

		if (!myreg.test($scope.dealer.link)) {
			$("input[name='dealer_link']").focus();
			$scope.form_require_phone = true;
			return false; 
		} else {
			$scope.form_require_phone = false;
		}

        var post_data = { 'dealer_info' : $scope.dealer };

        if ($scope.subject == 'store') {
            post_data.add_info = $scope.addinfo;
        }

        if ($scope.save_loading === false) {
			$scope.save_loading = true;

			$http.post('user/dealer/save/' + $scope.method + '/' + $scope.subject + '/' + $scope.dealer_id, post_data).then(
				function (response) {
					if (response.status === 200 && response.data.status) {
						$('.alert-success').css('display', 'block');
						window.setTimeout(function() { 
							$(".alert").hide(500);
							$scope.save_loading = false;
							history.back();
						}, 2500);
					} else {
						$scope.save_loading = false;
						$('.alert-danger').html(response.data.err_msg);
						$('.alert-danger').css('display', 'block');
						window.setTimeout(function() { 
							$(".alert").hide(500);
						}, 20000);
					}
				}, function (response) {
					$scope.save_loading = false;
					$('.alert-danger').html(lang.err_save_fail);
					$('.alert-danger').css('display', 'block');

					window.setTimeout(function() { 
						$(".alert").hide(500);
					}, 20000);
				}
			);			
		}
	};

	$scope.call_phone = function(phone_number) {
		if (is_mobile){
			console.log(phone_number);
			dd.biz.telephone.showCallMenu({
				phoneNumber: phone_number, 				// 期望拨打的电话号码
				code: '+86', 							// 国家代号，中国是+86
				showDingCall: true, 					// 是否显示钉钉电话
				onSuccess : function() {},
				onFail : function() {console.log('fail');}
			});
		}
	}
	
	$scope.change_province = function() {
		var province = $scope.dealer.province;
		console.log(province);

		for (var k in $scope.dealer.area_array.province) {
			val = $scope.dealer.area_array.province[k];

			if(val.province_name === province){
				$scope.dealer.area = val.area;
				break;
			}
		}
		
		for (var k in $scope.dealer.area_array.province_city) {
			val = $scope.dealer.area_array.province_city[k];

			if (val.province_name === province){
				$scope.dealer.city_list = val.city;
				break;
			}
		}

		if (typeof $scope.dealer.city_list == "undefined") {
			$scope.dealer.city_list = [];
        }

		console.log($scope.dealer.city_list);
	}
});


// Mobile user employee controller only dealer
dingdingApp.controller('userEmployeeController', function($scope, $rootScope, $route, $routeParams, $http, PagerService, myDialogService) {
    $scope.dealer = { id:$routeParams.dealer_id };
    $scope.login_dealer_id = login_dealer_id;
    $scope.login_dealer_level = login_dealer_level;
    $scope.upper_dealer_id = upper_dealer_id;

    $scope.loaded = false;

    // Mobile dingding Menu
    if (is_mobile){
        // Scroll event listener
        $(window).on('scroll', function(){
            if( $(window).scrollTop() >= $(document).height() - $(window).height() ) {
                if($scope.loaded && $scope.pagenum < $scope.last_page){
                    get_page_list($scope.dealer.id, ($scope.pagenum + 1), $scope.itemcount_perpage, $scope.search);
                }
            }
        }).scroll();

        //dd.ready(function() {
        // When back button closed
        backButtonUrl = "#!/overview";

        // Only for iphone
        dd.biz.navigation.setLeft({
            control: true,						// 是否控制点击事件，true 控制，false 不控制， 默认false
            text: lang.label_back,				// 控制显示文本，空字符串表示显示默认文本
            onSuccess : function(result) {
                window.location = "#!/overview";
            },
            onFail : function(err) {}
        });
        //});
        // When back button closed
        // document.addEventListener('backbutton', function(e) {
        // 	e.preventDefault();
        // 	window.location = "#!/overview";
        // }, false);

        // Setup title
        dd.biz.navigation.setTitle({
            title : lang.title_user,// 经销商
            onSuccess : function(result) {
            },
            onFail : function(err) {}
        });

        // Setup menus
        /*dd.biz.navigation.setMenu({
            backgroundColor : "#ADD8E6",
            textColor : "#3399FF11",
            items : [
                { // 同步 menu
                    "id":"1",
                    "text":lang.btn_synchronize
                },
            ],
            onSuccess: function(data) {

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

        console.log("Setup the menus");
        //});
    }
    // PC Menu
    else {
        $rootScope.route_status = 'user';
    }

    // Config variables
    $scope.pagenum = 1;
    $scope.itemcount_perpage = 5;

    if (is_mobile)
        $scope.itemcount_perpage = 6;

    $scope.search = {name: ''};

    function get_page_list(dealer_id, pagenum, itemcount, search) {
        if (is_mobile) {
            if (pagenum === 1) {
                delete $scope.lower_dealers;
                $scope.lower_dealers = [];
            }
        }

        $scope.no_data = false;
        $scope.loaded = false;
        $scope.busy = true;

        $http.get('user/dealer/get/info/' + dealer_id + '/' + JSON.stringify(search) + '/' + itemcount + '/' + pagenum).then (
            function (response) {
                console.log(response);
                $scope.busy = false;	// It is true when this is loading
                $scope.loaded = true;

                if (response.status) {
                    var result = response.data.result;

                    if (response.data.status) {
                        $scope.dealer = result.dealer;
                        $scope.users = result.users;
                        $scope.upper_dealer = result.upper_dealer;

                        if (is_mobile) {
                            var lower_dealers = result.lower_dealers;

                            for (var i = 0; i < lower_dealers.data.length; i++) {
                                $scope.lower_dealers.push(lower_dealers.data[i]);
                            }

							if ($scope.lower_dealers.length === 0) {
								$scope.no_data = true;
							}

                            $scope.last_page = result.lower_dealers.last_page;
                            $scope.pagenum = result.lower_dealers.current_page;
                        } else {
                            $scope.lower_dealers = result.lower_dealers;

                            $scope.last_page = $scope.lower_dealers.last_page;
                            $scope.pagenation = PagerService.GetPager($scope.lower_dealers.total, $scope.lower_dealers.current_page, $scope.lower_dealers.per_page, 10);

							if ($scope.lower_dealers.data.length === 0) {
								$scope.no_data = true;
							}
						}
                    } else {
                        $scope.loaded = true;
                        custom_alert(response.error_message, "error");
                    }
                } else {
                    $scope.loaded = true;
                    custom_alert("Internet connection error!", "error");
                }
				
				$(".page_wrapper").css("display", "block");
            }
        );
    }

    // When pagination changed
    $scope.setPage = function(pagenum) {
        if (pagenum < 1) {
            pagenum = 1;
        } else if (pagenum > $scope.lower_dealers.last_page) {
            pagenum = $scope.lower_dealers.last_page;
        }

        get_page_list($scope.dealer.id, pagenum, $scope.itemcount_perpage, $scope.search);
    }
    // Update the page list's data when tab is changed in mobile
    $scope.search_type = function(level) {
        $scope.level = level;
        get_page_list($scope.dealer.id, 1, $scope.itemcount_perpage, $scope.search);
    }
    //
    $scope.onChangeDealer = function(dealer_id) {
        $scope.search.name = '';
        get_page_list(dealer_id, 1, $scope.itemcount_perpage, $scope.search);
    };

    // When input the search name
    $scope.onSearch = function() {
        get_page_list($scope.dealer.id, 1, $scope.itemcount_perpage, $scope.search);
    }

    get_page_list($scope.dealer.id, 1, $scope.itemcount_perpage, $scope.search);

    function custom_alert( message, title ) {
        if (!title) {
            title = 'Alert';
        }

        if (!message) {
            message = 'No Message to Display.';
        }

        $('<div></div>').html( message ).dialog({
            title: title,
            resizable: false,
            modal: true
        });
    }

    $scope.onBalance = function(dealer_id) {
		myDialogService.confirm({
			title: lang.confirm,
			message: lang.settle_confirm_message,
			confirm_txt: lang.confirm,
			cancle_txt: lang.cancel,
			success_callback: function() {				
				$http.post('user/dealer/set/balance/' + dealer_id).then(
					function(response) {
						console.log(response);
		
						if (response.data.success === true) {
							myDialogService.alert({
								title: lang.information,
								message: lang.successful_settle_balance,
								button: lang.close,
								animation: "fade",
							});
						
							angular.forEach($scope.lower_dealers, function(lower_dealer) {
								if (lower_dealer.id == dealer_id) {
									lower_dealer.total_unbalance = 0;
								}
							})
						}
					}
				);
			},
			cancle_callback: null,
			fail_callback: null
		});
    }

    $scope.call_phone = function(phone_number){
        if(is_mobile){
            console.log(phone_number);
            dd.biz.telephone.showCallMenu({
                phoneNumber: phone_number, 				// 期望拨打的电话号码
                code: '+86', 							// 国家代号，中国是+86
                showDingCall: true, 					// 是否显示钉钉电话
                onSuccess : function() {},
                onFail : function() {console.log('fail')}
            });
        }
    };
});

// Mobile user dealer detail view controller only admin
dingdingApp.controller('userStaffDetailController', function($scope, $rootScope, $route, $routeParams, $http, myDialogService) {	
	if(typeof $routeParams.user_id == "undefined") {
		$scope.user_id = '0';
	} else {
		$scope.user_id = $routeParams.user_id;
	}

	// Mobile dingding Menu
	if(is_mobile){
		//dd.ready(function() {
			// When back button closed
			if (user_priv === 'admin') {
				// When back button closed
				backButtonUrl = "";

				// Only for iphone
				dd.biz.navigation.setLeft({
					control: true,							// 是否控制点击事件，true 控制，false 不控制， 默认false
					text: lang.label_back,					// 控制显示文本，空字符串表示显示默认文本
					onSuccess : function(result) {
						window.location = "#!/user/dealer";
					},
					onFail : function(err) {}
				});
				
				// document.addEventListener('backbutton', function(e) {
				// 	e.preventDefault();
				// 	window.location = "#!/user/dealer";
				// }, false);
			}
			else {
				// When back button closed
				backButtonUrl = "";

				// Only for iphone
				dd.biz.navigation.setLeft({
					control: true,							// 是否控制点击事件，true 控制，false 不控制， 默认false
					text: lang.label_back,					// 控制显示文本，空字符串表示显示默认文本
					onSuccess : function(result) {
						window.location = "#!/user/employee";
					},
					onFail : function(err) {}
				});
				
				// document.addEventListener('backbutton', function(e) {
				// 	e.preventDefault();
				// 	window.location = "#!/user/employee";
				// }, false);
			}
		//});
			// Setup title
			dd.biz.navigation.setTitle({
				title : lang.title_staff,// 经销商信息
				onSuccess : function(result) {
				},
				onFail : function(err) {}
			});

			console.log("Setup the menus");
		//});
	}
	// PC Menu
	else{
		$rootScope.route_status = 'user';
	}
	
	$scope.loaded = false;
	$http.get('user/staff/get/detail/' + $scope.user_id).then(
		function(response){
			$scope.user = response.data;
			$scope.loaded = true;
			$(".user_v_content").css("display", "block");
		}
	);

	$scope.call_phone = function(phone_number){
		if(is_mobile){
			console.log(phone_number);
			dd.biz.telephone.showCallMenu({
				phoneNumber: phone_number, 					// 期望拨打的电话号码
				code: '+86', 								// 国家代号，中国是+86
				showDingCall: true, 						// 是否显示钉钉电话
				onSuccess : function() {},
				onFail : function() {console.log('fail')}
			})
		}
	}
});

// Mobile user dealer edit view controller only admin
dingdingApp.controller('userNewController', function($scope, $rootScope, $route, $routeParams, $http, myDialogService) {
    $scope.dealer_id = $routeParams.dealer_id;

    // Mobile dingding Menu
    if (is_mobile) {
        // When back button closed
        if (user_priv == 'admin') {
            // When back button closed
            backButtonUrl = "";

            // Only for iphone
            dd.biz.navigation.setLeft({
                control: true,								// 是否控制点击事件，true 控制，false 不控制， 默认false
                text: lang.label_back,						// 控制显示文本，空字符串表示显示默认文本
                onSuccess : function(result) {
                    window.location = "#!/user/dealer";
                },
                onFail : function(err) {}
            });
        } else {
            // When back button closed
            backButtonUrl = "";

            // Only for iphone
            dd.biz.navigation.setLeft({
                control: true,								// 是否控制点击事件，true 控制，false 不控制， 默认false
                text: lang.label_back,						// 控制显示文本，空字符串表示显示默认文本
                onSuccess : function(result) {
                    window.location = "#!/user/employee";
                },
                onFail : function(err) {}
            });
        }

        // Setup title
        dd.biz.navigation.setTitle({
            title : lang.title_add_user,					// 经销商信息
            onSuccess : function(result) {
            },
            onFail : function(err) {}
        });

        // Set empty menu
        dd.biz.navigation.setRight({
            show: false,									// 控制按钮显示， true 显示， false 隐藏， 默认true
            control: true,									// 是否控制点击事件，true 控制，false 不控制， 默认false
            text: '发送',									// 控制显示文本，空字符串表示显示默认文本
            onSuccess : function(result) {
            },
            onFail : function(err) {}
        });

        console.log("Setup the menus");
    } else { // PC Menu
        $rootScope.route_status = 'user';
    }

    $scope.loaded = false;
    $http.get('user/get/roles/').then(
        function(response) {
            $scope.roles = response.data.roles;
            $scope.loaded = true;

            $(".user_v_content").css("display", "block");
        }
    );

    $scope.save_loading = false;
    $scope.user_info_save = function() {
        var post_data = {
            "name" : $scope.user.name,
			"role_id" : $scope.user.role,
            "email" : $scope.user.email,
            "link" : $scope.user.link,
        };

        if ($scope.user.name == null || $scope.user.name == "" || $scope.user.name.length < 2) {
            $scope.form_require_name = true;
            $('input[name="user_name"]').focus();
            return;
        } else {
            $scope.form_require_name = false;
        }

        var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;

        if (!myreg.test($scope.user.link)) {
            $("input[name='user_link']").focus();
            $scope.form_require_phone = true;
            return false;
        } else {
            $scope.form_require_phone = false;
        }

        var myreg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

        if (!myreg.test($scope.user.email)) {
            $("input[name='user_email']").focus();
            $scope.form_require_email = true;
            return false;
        } else {
            $scope.form_require_email = false;
        }

        console.log($scope.user.name);

        if ($scope.save_loading == false) {
            $scope.save_loading = true;
            $http.post('user/new/' + $scope.dealer_id, post_data).then(
                function (response) {
                    if (response.status == 200 && response.data.status){
                        $('.alert-success').css('display', 'block');
                        window.setTimeout(function() {
                            $(".alert").hide(500);
                            $scope.save_loading = false;
                            history.back();
                        }, 2500);
                    } else {
                        $scope.save_loading = false;
                        $('.alert-danger').html(response.data.err_msg);
                        $('.alert-danger').css('display', 'block');
                        window.setTimeout(function() {
                            $(".alert").hide(500);
                        }, 20000);
                    }
                }, function (response) {
                    $scope.save_loading = false;
                    $('.alert-danger').html(lang.err_save_fail);
                    $('.alert-danger').css('display', 'block');

                    window.setTimeout(function() {
                        $(".alert").hide(500);
                    }, 20000);
                }
            );
        }
    }
});

// Mobile user dealer edit view controller only admin
dingdingApp.controller('userStaffEditController', function($scope, $rootScope, $route, $routeParams, $http, myDialogService) {
	if (typeof $routeParams.user_id == "undefined") {
		$scope.user_id = '0';
	} else {
		$scope.user_id = $routeParams.user_id;
	}

	// Mobile dingding Menu
	if (is_mobile) {
		// When back button closed
		if (user_priv == 'admin') {
			// When back button closed
			backButtonUrl = "";

			// Only for iphone
			dd.biz.navigation.setLeft({
				control: true,								// 是否控制点击事件，true 控制，false 不控制， 默认false
				text: lang.label_back,						// 控制显示文本，空字符串表示显示默认文本
				onSuccess : function(result) {
					window.location = "#!/user/dealer";
				},
				onFail : function(err) {}
			});
		} else {
			// When back button closed
			backButtonUrl = "";

			// Only for iphone
			dd.biz.navigation.setLeft({
				control: true,								// 是否控制点击事件，true 控制，false 不控制， 默认false
				text: lang.label_back,						// 控制显示文本，空字符串表示显示默认文本
				onSuccess : function(result) {
					window.location = "#!/user/employee";
				},
				onFail : function(err) {}
			});
		}
		
		// Setup title
		dd.biz.navigation.setTitle({
			title : lang.title_dealer_info,					// 经销商信息
			onSuccess : function(result) {
			},
			onFail : function(err) {}
		});

		// Set empty menu
		dd.biz.navigation.setRight({
			show: false,									// 控制按钮显示， true 显示， false 隐藏， 默认true
			control: true,									// 是否控制点击事件，true 控制，false 不控制， 默认false
			text: '发送',									// 控制显示文本，空字符串表示显示默认文本
			onSuccess : function(result) {
			},
			onFail : function(err) {}
		});

		console.log("Setup the menus");
	} else { // PC Menu
		$rootScope.route_status = 'user';
	}
	
	$scope.loaded = false;
	$http.get('user/staff/get/detail/' + $scope.user_id).then(
		function(response) {
			$scope.user = response.data;
			$scope.loaded = true;
			$(".user_v_content").css("display", "block");
		}
	);

	$scope.save_loading = false;
	$scope.user_info_save = function() {
		var post_data = {
			"id" : $scope.user.id,
			"name" : $scope.user.name,
			"email" : $scope.user.email,
			"link" : $scope.user.link,
		};
		
		if ($scope.user.name == null || $scope.user.name == "" || $scope.user.name.length < 2) {
			$scope.form_require_name = true;
			$('input[name="user_name"]').focus();
			return;
		} else {
			$scope.form_require_name = false;
		}
		
		var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;

		if (!myreg.test($scope.user.link)) {
			$("input[name='user_link']").focus();
			$scope.form_require_phone = true;
			return false; 
		} else {
			$scope.form_require_phone = false;
		}
		
		var myreg =  /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/; 

		if (!myreg.test($scope.user.email)) {
			$("input[name='user_email']").focus();
			$scope.form_require_email = true;
			return false; 
		} else {
			$scope.form_require_email = false;
		}
		
		console.log($scope.user.name);
		
		if ($scope.save_loading == false) {
			$scope.save_loading = true;
			$http.post('user/staff/save', post_data).then(
				function(response){
					if(response.status == 200 && response.data.status){
						$('.alert-success').css('display', 'block');
						window.setTimeout(function() { 
							$(".alert").hide(500);
							$scope.save_loading = false;
							history.back();
						}, 2500);
					}else{
						$scope.save_loading = false;
						$('.alert-danger').html(response.data.err_msg);
						$('.alert-danger').css('display', 'block');
						window.setTimeout(function() { 
							$(".alert").hide(500);
						}, 20000);
					}
				}, function(response) {
					$scope.save_loading = false;
					$('.alert-danger').html(lang.err_save_fail);
					$('.alert-danger').css('display', 'block');
					window.setTimeout(function() { 
						$(".alert").hide(500);
					}, 20000);
				}
			);			
		}
	}
});

