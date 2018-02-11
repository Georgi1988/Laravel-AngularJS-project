
// Mobile register controller only seller
dingdingApp.controller('registerController', function($scope, $rootScope, $route, $routeParams, $http, myDialogService) {
	if(typeof $routeParams.type == "undefined") {
		$scope.type = '0';
	} else {
		$scope.type = $routeParams.type;
	}
	// Config variables
	$scope.pagenum = 1;
	$scope.typelist;
	$scope.itemcount_perpage = 6;
	if(is_mobile) $scope.itemcount_perpage = 8;
	$scope.search = {level1_type: '', level2_type: '', keyword: '', status: ''};
	
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
	$scope.nodata = false;
	function get_page_list(pagenum, itemcount, search){
		$scope.loaded =  false;
		$scope.busy = true;
		$http.get('product/cardlist/' + JSON.stringify(search) + '/' + itemcount + '/' + pagenum).then(
			function(response){
				$scope.busy = false;	// It is true when this is loading
				$scope.loaded =  true;
				if(is_mobile){
					if(pagenum == 1){
						delete $scope.items;
						$scope.items = [];
					}
					var list_data = response.data.list;
					//console.log(list_data);
					$scope.last_page = list_data.last_page;
					$scope.pagenum = list_data.current_page;
					var items = list_data.data;
					if(items.length == 0){
						$scope.nodata = true;
					}else{
						$scope.nodata = false;
					}
					for (var i = 0; i < items.length; i++) {
						$scope.items.push(items[i]);
					}
				}
			}
		);
	}
	
	$scope.search_type1 = function(type1){
		$scope.search.level1_type = type1;
		get_page_list(1, $scope.itemcount_perpage, $scope.search);
	}
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
			backButtonUrl = "#!/overview";
			//backButtonUrl = "";

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
			// When back button closed
			// document.addEventListener('backbutton', function(e) {
			// 	e.preventDefault();
			// 	window.location = "#!/overview";
			// }, false);

			// Setup title
			dd.biz.navigation.setTitle({
				title : lang.title_register,// 已激活产品
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
		$rootScope.route_status = 'product';
	}
});

// Mobile register edit controller only seller
dingdingApp.controller('registerEditController', function($scope, $rootScope, $route, $routeParams, $http, $window, myDialogService) {
	if(typeof $routeParams.product_id == "undefined") {
		$scope.product_id = '0';
	} else {
		$scope.product_id = $routeParams.product_id;
	}
	
	if(typeof $routeParams.card_id == "undefined") {
		$scope.card_id = '0';
	} else {
		$scope.card_id = $routeParams.card_id;
	}
	
	$scope.loaded =  false;
	$http.get(base_url + 'product/get/registeritem/' + $routeParams.product_id + '/' + $routeParams.card_id).then(
		function(response){
			console.log(response.data.value);
			if(response.status == 200 && response.data.status){
				$scope.product = response.data.value;
				if($scope.product.carddata.customer != null){
					$scope.customer_name = $scope.product.carddata.customer.name;
					$scope.customer_phone = $scope.product.carddata.customer.link;
				}
				$scope.loaded =  true;
			}
			$(".reg_v_content").css("display", "block");
		}
	);

	$("#card_code").css("display", "none");
	$("#submit_btn").css("display", "none");

	$scope.onQRScan = function() {
		dd.biz.util.scan({
			type: 'all' , // type 为 all、qrCode、barCode，默认是all。
			onSuccess: function(data) {
				//console.log(data);
				//$scope.set_card_code(data.text);
				//$("#card_code").css("display", "block");
				//$("#card_code_val").text(data.text);
				$("#machine_code").val(data.text);
				//$("#submit_btn").css("display", "block");
			},
			onFail : function(err) {
			}
		});
	}
	
	// Mobile dingding Menu
	if(is_mobile){
		//dd.ready(function() {
			// When back button closed
			//backButtonUrl = "";
			backButtonUrl = "#!/register";

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
			// When back button closed
			// document.addEventListener('backbutton', function(e) {
			// 	e.preventDefault();
			// 	window.location = "#!/register";
			// }, false);

			// Setup title
			dd.biz.navigation.setTitle({
				title : lang.card_register,
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
			//console.log("Setup the menus");
		//});
	}
	// PC Menu
	else{
		$rootScope.route_status = 'product';
	}
		
	$scope.register = function(){	
	
		$scope.registerresult = false;
		$scope.machine_code = "";
		$scope.ajax_loading = false;
		$scope.phonecheck = false;		
		
		/* if(typeof $scope.customer_name == "undefined"){
			$("#user_name").focus();
			//$('.register_dlg').modal('toggle'); 
			
			return false;
		}
		if(typeof $scope.customer_phone == "undefined"){				
			$("#user_phone").focus();
			//$('.register_dlg').modal('toggle');
			
			return false;
		}*/
		
		if(typeof $scope.customer_phone != "undefined" && $scope.customer_phone.length > 0){
			
			var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/; 
			if(!myreg.test($scope.customer_phone)) { 
				$("#user_phone").focus();
				$scope.phonecheck = true;
				return false; 
			}
			
			if(typeof $scope.customer_name == "undefined" || $scope.customer_name == ""){
				$("#user_name").focus();
				return false;
			}
		}
		$scope.machine_code = $("#machine_code").val();
		if( !$("#machine_code").val()){
			$("#machine_code").focus();
			//$('.register_dlg').modal('toggle'); 
			
			return false;
		}
		if(typeof $scope.check_pass == "undefined"){
			$("#check_pass").focus();
			//$('.register_dlg').modal('toggle'); 
			
			return false;
		}
		if(typeof $scope.customer_name == "undefined"){
			$scope.customer_name = "";
		}
		if(typeof $scope.customer_phone == "undefined"){				
			$scope.customer_phone = "";
		}
		var data = {
			regit_name: $scope.customer_name,
			regit_phone: $scope.customer_phone,
			product_id: $scope.product_id,
			card_id: $scope.card_id,
			check_pass: $scope.check_pass,
			machine_code: $("#machine_code").val(),				
			status: 2
		}
		$scope.cardcode = "";
		if ($scope.ajax_loading === false){
			$scope.ajax_loading = true;
			$http.post('/card/register', data).then(function (response) {
				$scope.cardcode = response.data.cardcode;
				if (response.data.result == '1'){
					setTimeout(function(){ 
						$("#register_dlg").modal({backdrop: 'static', keyboard: false});					
						$("#register_dlg .confirm").click(function () {
							$('#register_dlg').modal('toggle');
							$("#register_dlg").on("hidden.bs.modal", function () {
								$window.location.href = "#!register";
							});
						});							
						
					}, 1000);
					$scope.ajax_loading = false;	
				} else if (response.data.result == '0'){
					myDialogService.alert({
						title: lang.product_save_title_fail,
						message: lang.rt_card_registered_title,
						button: lang.close,
						animation: "fade",
						callback: function(){
						}
					});
					$scope.ajax_loading = false;
				}else if (response.data.result == '2'){
					myDialogService.alert({
						title: lang.product_save_title_fail,
						message: lang.rt_machinecode_no_title,
						button: lang.close,
						animation: "fade",
						callback: function(){
						}
					});
					$scope.ajax_loading = false;
				}else if (response.data.result == '3'){
					myDialogService.alert({
						title: lang.product_save_title_fail,
						message: lang.rg_invalid_pass,
						button: lang.close,
						animation: "fade",
						callback: function(){
						}
					});
					$scope.ajax_loading = false;
				}
				
					
			}, function (response) {
				return response;
			});
		}else{
			return false;
		}			
	}
	
	$scope.show_pwd = false;
	$scope.show_password = function(){
		$scope.show_pwd = !$scope.show_pwd;
		
		if($scope.show_pwd === true){
			$("#check_pass").attr("type", "text");
		}else{
			$("#check_pass").attr("type", "password");
		}
		
		console.log("asdfasdfasdfasdf");
	}
});


// PC[admin] register agree controller only admin
dingdingApp.controller('registerAgreeController', function($scope, $rootScope, PagerService, $route, $routeParams, $http, $timeout, $window, myDialogService) {
	
	if(typeof $routeParams.product_id == "undefined") {
		$scope.product_id = '0';
	} else {
		$scope.product_id = $routeParams.product_id;
	}
	
	if(is_mobile){
		
		backButtonUrl = "#!/overview";
		
		// Scroll event listener
		$(window).on('scroll', function(){
			if( $(window).scrollTop() >= $(document).height() - $(window).height() ) {
				if($scope.loaded && $scope.pagenum < $scope.last_page){
					get_page_list(($scope.pagenum + 1), $scope.itemcount_perpage, $scope.search);
				}
			}
		}).scroll();
	}
	// PC Menu
	else{		
		$rootScope.route_status = 'register';
	}
	
	$scope.search = {page_type: 1, pagenum: 1};
	if(typeof $routeParams.search != "undefined") {
		search_option = JSON.parse(b64DecodeUnicode($routeParams.search));
		Object.keys(search_option).forEach(function(key) {
			if(typeof $scope.search[key] != "undefined") $scope.search[key] = search_option[key];
		});
	}
	
	if(!is_mobile) $scope.pagenum = $scope.search.pagenum;	
	else $scope.pagenum = 1;
	
	$scope.itemcount_perpage = 12;
	if(is_mobile) $scope.itemcount_perpage = 8;
	
	$scope.show_import_panel = false;
	
	/*******************************
		data load
	*******************************/
	$scope.nodata = false;
	function get_page_list(pagenum, itemcount, search){
		$scope.loaded =  false;
		$scope.busy = true;
		$http.get('register/card_agree/list/' + JSON.stringify(search) + '/' + itemcount + '/' + pagenum).then(
			function(response){
				$scope.busy = false;	// It is true when this is loading
				$scope.loaded =  true;
				if(is_mobile){
					if(pagenum == 1){
						delete $scope.items;
						delete $scope.prices;
						$scope.items = [];
						$scope.prices = [];
					}
					var list_data = response.data.list;
					$scope.last_page = list_data.last_page;
					$scope.pagenum = list_data.current_page;
					var items = list_data.data;
					if(items.length == 0){
						$scope.nodata = true;
					}else{
						$scope.nodata = false;
					}
					var prices = response.data.price_list;
					for (var i = 0; i < items.length; i++) {
						$scope.items.push(items[i]);
					}
					
					
				}else{	
					$scope.list_data = response.data.list;
					if($scope.list_data.data.length == 0){
						$scope.nodata = true;
					}else{
						$scope.nodata = false;
					}
					$scope.last_page = $scope.list_data.last_page;
					$scope.pagenation = PagerService.GetPager($scope.list_data.total, $scope.list_data.current_page, $scope.list_data.per_page, 10);
				}
				$scope.other_info = response.data.other_info;
			}
		);
	}
	
	get_page_list($scope.pagenum, $scope.itemcount_perpage, $scope.search);
	
	$scope.setPage = function(pagenum){
		if(pagenum < 1) pagenum = 1;
		else if(pagenum > $scope.list_data.last_page) pagenum = $scope.list_data.last_page;
		
		$scope.search.pagenum = pagenum;
		location.href = "#!/register/card/agree/" + b64EncodeUnicode(JSON.stringify($scope.search));
		
		//get_page_list(pagenum, $scope.itemcount_perpage, $scope.search);
	}
	
	$scope.search_pagetype = function(page_type){
		$scope.search.page_type = page_type;
		$scope.search.pagenum = 1;
		location.href = "#!/register/card/agree/" + b64EncodeUnicode(JSON.stringify($scope.search));
	}
	
	// Agree register template submit function
	$scope.ajaxloading_reg_agree = false;
	$scope.import_reg_agree_list = function(){
		
		var agree_register_form = new FormData(document.getElementById("agree_register_form"));
		
		if(!$("#agree_register_file").val()){
			$scope.required_file = true;
			return;
		}else{
			$scope.required_file = false;
		}
		
		$.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')	
            }
        });
		
		$('.alert').hide();
		
		if($scope.ajaxloading_reg_agree == false){
			$scope.ajaxloading_reg_agree = true;
			
			$http.post("/register/card/agree/template", agree_register_form, {
				headers: { 'Content-Type': undefined },
				transformRequest: angular.identity
			}).then(function (response, status, headers, config) {
				
				if(response.status == 200 && response.data.status){
					$(".alert-save-success").html(response.data.msg);
					$(".alert-save-success").show();
					$timeout(function() {
						$scope.ajaxloading_reg_agree = false;
						$(".alert-save-success").hide();
						$("#agree_register_file").val('');
						$scope.show_import_panel = false;
						$route.reload();
					}, 500);
				}else{
					$scope.ajaxloading_reg_agree = false;
					$(".alert-save-fail").html(response.data.err_msg);
					$(".alert-save-fail").show();
				}
				
			},function (data, status, headers, config) {
				$scope.ajaxloading_reg_agree = false;
				$('.alert-save-fail').html(lang.rg_fail_save);						
				$('.alert-save-fail').show();
				$timeout(function() {
					$(".alert-pcard-import-invalid").hide();
				}, 6000);
			});
			
		}
		
	}
	
});


// Admin registered card view controller
dingdingApp.controller('registerItemController', function($scope, $rootScope, $http, $route, $routeParams, myDialogService) {
	if(typeof $routeParams.card_id == "undefined") {
		$scope.card_id = '0';
	} else {
		$scope.card_id = $routeParams.card_id;
	}

	// Mobile dingding Menu
	if(is_mobile){
		backButtonUrl = "";

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
			title : lang.card_register,// 一年延保卡
			onSuccess : function(result) {
			},
			onFail : function(err) {}
		});

		console.log("Setup the menus");
	}
	// PC Menu
	else{
		$rootScope.route_status = 'stock';
	}
	
	$scope.loaded =  false;
	$http.get(base_url + 'stock/get/card_info/' + $scope.card_id).then(
		function(response){
			if(response.status == 200 && response.data.status){
				$scope.card = response.data.card;
				$scope.loaded =  true;
			}
			$(".register_v_content").css("display", "block");
		}
	);
	
	$scope.ajax_loading =  false;
	$scope.ajax_agree_loading = false;
	$scope.ajax_disagree_loading = false;
	
	// Agree function
	$scope.agree_register = function(){
		if($scope.ajax_loading == false){
			$(".alert").hide();
			$scope.ajax_loading = true;
			$scope.ajax_agree_loading = true;
			$http.get(base_url + 'register/card_agree/agree/item/' + $scope.card_id + "/true").then(
				function(response){
					$scope.ajax_agree_loading = false;
					if(response.status == 200 && response.data.status){
						$(".alert-success").html(response.data.msg);
						$(".alert-success").show();
						setTimeout(function(){			
							$(".alert-success").hide("300");
							history.back();
						}, 1000);
						
					}else{
						$scope.ajax_loading =  false;
						$scope.ajax_agree_loading = false;
						
						$(".alert-danger").html(response.data.err_msg);
						$(".alert-danger").show();
					}
				},function(response){
					$scope.ajax_loading =  false;
					$scope.ajax_agree_loading = false;

					$(".alert-danger").html(response.data.err_msg);
					$(".alert-danger").show();
				}
			);
		}
	}
	
	// Disagree function
	$scope.disagree_register = function(){
		if($scope.ajax_loading == false){
			$scope.ajax_loading = true;
			$scope.ajax_disagree_loading = true;
			$http.get(base_url + 'register/card_agree/agree/item/' + $scope.card_id + "/false").then(
				function(response){
					$scope.ajax_disagree_loading = false;
				
					if(response.status == 200 && response.data.status){
						$(".alert-success").html(response.data.msg);
						$(".alert-success").show();
						setTimeout(function(){			
							$(".alert-success").hide("300");
							history.back();
						}, 1000);
						
					}else{
						$scope.ajax_loading =  false;
						$scope.ajax_disagree_loading = false;
						
						$(".alert-danger").html(response.data.err_msg);
						$(".alert-danger").show();
					}
					
				},function(response){
					$scope.ajax_loading =  false;
					$scope.ajax_disagree_loading = false;

					$(".alert-danger").html(response.data.err_msg);
					$(".alert-danger").show();
				}
			);
		}
	}
});