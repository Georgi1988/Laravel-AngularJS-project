

// Mobile stock controller
dingdingApp.controller('stockByProductController', function($scope, $rootScope, $http, $location, PagerService, $route, $routeParams, myDialogService, dealerSelect) {
	if(typeof $routeParams.type == "undefined") {
		$scope.type = '0';
	} else {
		$scope.type = $routeParams.type;
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
				title : lang.title_stock,// 库存
				onSuccess : function(result) {
				},
				onFail : function(err) {}
			});

			switch (user_priv) {
			case 'admin': // When user_priv is admin
				// Setup menus
				dd.biz.navigation.setMenu({
					backgroundColor : "#ADD8E6",
					textColor : "#3399FF11",
					items : [
						{ // 设置 menu
							"id":"1",
							"text":lang.btn_setting
						},
					],
					onSuccess: function(data) {
						window.location = "#!/stock/setting/view/" + $scope.type;
						console.log(data);
					},
					onFail: function(err) {
						console.log(err);
					}
				});
				break;
			case 'dealer': // When user_priv is dealer
				// Setup menus
				dd.biz.navigation.setMenu({
					backgroundColor : "#ADD8E6",
					textColor : "#3399FF11",
					items : [
						{ // 设置 menu
							"id":"1",
							"text":lang.btn_setting
						},
					],
					onSuccess: function(data) {
						window.location = "#!/stock/setting/view/" + $scope.type;
						console.log(data);
					},
					onFail: function(err) {
						console.log(err);
					}
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
		//});
	}
	// PC Menu
	else{
		$rootScope.route_status = 'stock';
	}
	
	$scope.pagenum = 1;	
	$scope.itemcount_perpage = 6;
	if(is_mobile) $scope.itemcount_perpage = 12;
	
	$scope.search = {page_type: 1, dealer_id: '', product_type1: '', product_type2: '', card_code_keyword: '', card_type: 1};
	if(is_mobile){
		$scope.search.page_type = 1;
		$scope.search.product_type1 = '';
		$scope.search.card_type = '0';
	}
	
	if(typeof $routeParams.search != "undefined") {
		search_option = JSON.parse(b64DecodeUnicode($routeParams.search));
		Object.keys(search_option).forEach(function(key) {
			if(typeof $scope.search[key] != "undefined") $scope.search[key] = search_option[key];
		});
	}
	
	/*******************************
		data load
	*******************************/
	$scope.nodata = false;
	function get_page_list(pagenum, itemcount, search){
		$scope.loaded =  false;
		$scope.busy = true;
		$http.get('stock/list_product/' + JSON.stringify(search) + '/' + itemcount + '/' + pagenum).then(
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
					console.log(response);
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
		get_page_list(pagenum, $scope.itemcount_perpage, $scope.search);
	}
	
	$scope.view_product_stock = function(product_id){
		console.log(product_id);
		var link_search = $scope.search;
		link_search.product_id = product_id;
		location.href = "#!/stock/list/card/search/" + b64EncodeUnicode(JSON.stringify(link_search));
	}
	
	$scope.change_dealer = function(select_tag){
		$scope.search.dealer_id = $(select_tag).val();
		location.href = "#!/stock/search/" + b64EncodeUnicode(JSON.stringify($scope.search));
	}
	$scope.change_type1 = function(select_tag){
		$scope.search.product_type1 = $(select_tag).val();
		location.href = "#!/stock/search/" + b64EncodeUnicode(JSON.stringify($scope.search));
	}
	$scope.change_type1_val = function(val){
		$scope.search.product_type1 = val;
		location.href = "#!/stock/search/" + b64EncodeUnicode(JSON.stringify($scope.search));
	}
	$scope.change_type2 = function(select_tag){
		$scope.search.product_type2 = $(select_tag).val();
		location.href = "#!/stock/search/" + b64EncodeUnicode(JSON.stringify($scope.search));
	}
	$scope.search_card_code = function(){
		location.href = "#!/stock/search/" + b64EncodeUnicode(JSON.stringify($scope.search));
	}
	$scope.search_card_type = function(type){
		$scope.search.card_type = type;
		location.href = "#!/stock/search/" + b64EncodeUnicode(JSON.stringify($scope.search));
	}
	$scope.search_pagetype = function(page_type){
		$scope.search.page_type = page_type;
		location.href = "#!/stock/search/" + b64EncodeUnicode(JSON.stringify($scope.search));
	}
	
	$scope.show_search_panel = function(){
		//$(".search_modal").modal('toggle');
		$(".search_panel").fadeIn(200);
	}
	
	$scope.close_search_panel = function(){
		//$(".search_modal").modal('toggle');
		$(".search_panel").fadeOut(200);
	}
	
	$scope.show_download_panel = function(product_id, product_name){
		
		$scope.down_product_id = product_id;
		$scope.down_product_name = product_name;
		
		$(".download_modal").modal('toggle');
	}
	
	$scope.search_panel = function(){
		$scope.search.page_type = $("#srch_pagetype").val();
		//$scope.search.dealer_id = $("#srch_dealer").val();
		$scope.search.product_type1 = $("#srch_type1").val();
		$scope.search.product_type2 = $("#srch_type2").val();
		$scope.search.card_code_keyword = $("#srch_code").val();
		//$(".search_modal").modal('toggle');
		$scope.close_search_panel();
		location.href = "#!/stock/search/" + b64EncodeUnicode(JSON.stringify($scope.search));
		//console.log($("#srch_dealer").val());
	}
	
	/******************************
		Dealer select part
	******************************/
	$scope.user_selected_dealer = 0;
	//$scope.user_selected_dealer = $scope.search.dealer_id;
	$scope.select_dealer = function(dealer_id){
		dealerSelect.getList(dealer_id).then(
			function(response){
				console.log(response);
				$scope.dealer_info = response.data;
				$scope.user_selected_dealer = 0;
				$("#dealer_select").modal('toggle');
			}
		);
	}
	$scope.get_sub_dealer = function(dealer_id){
		dealerSelect.getList(dealer_id).then(
			function(response){
				$scope.dealer_info = response.data;
			}
		);
		$scope.user_selected_dealer = 0;
	}
	$scope.user_select_dealer = function(){
		$("#dealer_select").modal('toggle');
		$scope.search.dealer_id = $scope.user_selected_dealer;
		location.href = "#!/stock/search/" + b64EncodeUnicode(JSON.stringify($scope.search));
	}
	
	$scope.set_selected_dealer = function(dealer_id){
		console.log(dealer_id);
		$scope.user_selected_dealer = dealer_id;
	}
	/******************************
		The end of Dealer select part
	******************************/
	
	
	
	$scope.stock_download_byfile = function(){
		
		$scope.filedown_loading = true;
		
		var search_data = {
			product_id: $scope.down_product_id,
			product_type1: $scope.search.product_type1,
			product_type2: $scope.search.product_type2,
			card_code_keyword: $scope.search.card_code_keyword,
			card_type: $scope.search.card_type,
			page_type: $scope.search.page_type
		}
		
		if(!is_mobile){
			//location.href = "/stock/download_file/" + b64EncodeUnicode(JSON.stringify(search_data));
			$http.get("/stock/download_file/" + b64EncodeUnicode(JSON.stringify(search_data)) ).then(function (response) {
				
				$scope.filedown_loading = false;
				
				if(response.status == 200 && response.data.status){
					var filename = response.data.file;
					
					location.href = "/download/storage/" + b64EncodeUnicode(filename);
					//console.log("/download/storage/" + b64EncodeUnicode(filename));
				}else{
					if(!is_mobile){
						myDialogService.alert({
							title: lang.send_dlg_title_fail,
							message: lang.send_dlg_message_fail,
							button: lang.close,
							animation: "fade",
							callback: function(){
							}
						});	
					}else{
						$('.alert').css('display', 'none');
						$('.alert-danger').css('display', 'block');
					}			
				}
			}, function (response) {
				
				$scope.filedown_loading = false;
				
				if(!is_mobile){
					myDialogService.alert({
						title: lang.send_dlg_title_fail,
						message: lang.send_dlg_message_fail,
						button: lang.close,
						animation: "fade",
						callback: function(){
						}
					});
				}else{
					$('.alert').css('display', 'none');
					$('.alert-danger').css('display', 'block');
				}
				return response;
			});
		}else{
			dd.biz.cspace.saveFile({
				corpId: _config.corpId,
                url: "/stock/download_file/" + b64EncodeUnicode(JSON.stringify($scope.search)),
                name: "2017-10-20.xls",
                onSuccess: function(data) {
                 /* data结构
                 {"data":
                    [
                    {
                    "corpId": "", //公司id
                    "spaceId": "" //空间id
                    "fileId": "", //文件id
                    "fileName": "", //文件名
                    "fileSize": 111111, //文件大小
                    "fileType": "", //文件类型
                    }
                    ]
                 }
                 */
                },
                onFail: function(err) {
                    alert(JSON.stringify(err));
                }
            });
		}
	}

	$scope.down_product_id = '';
	$scope.down_product_name = '';
	
	var stockCardDlg = $( "#stockcard" ).dialog({
			autoOpen: false,
			resizable: false,
			height: "auto",
			width: 740,
			modal: true,
		});
	
	$scope.ajax_email_loading = false;
	$scope.submit_stockdownload = function(){
		
		//var mail_addr = $('#sendmail').val();
		var mail_addr = $scope.send_mail_addr;
		
		console.log("sadfsadf" + mail_addr);
		
		var data = {
			product_id: $scope.down_product_id,
			product_type1: $scope.search.product_type1,
			product_type2: $scope.search.product_type2,
			card_code_keyword: $scope.search.card_code_keyword,
			card_type: $scope.search.card_type,
			page_type: $scope.search.page_type,
			sendemail: mail_addr
		}
		
		if($scope.ajax_email_loading != false) return;
		$scope.ajax_email_loading = true;
		
		$http.post('/stock/download', data).then(function (response) {
			$scope.ajax_email_loading = false;
			//console.log(response.data);
			if(response.status == 200 && response.data.status){				
				if(!is_mobile){
					myDialogService.alert({
						title: lang.send_dlg_title,
						message: $('#send_success_message').val(),
						button: lang.close,
						animation: "fade",
						callback: function(){
							stockCardDlg.dialog( "close" );
						}
					});
				}else{
					$('.alert').css('display', 'none');
					$('.alert-success').css('display', 'block');
					window.setTimeout(function() { 
						$(".alert").hide(500);
						$(".download_modal").modal('toggle');
					}, 4000);
					console.log('saved!');
				}
			}else{
				if(!is_mobile){
					myDialogService.alert({
						title: lang.send_dlg_title_fail,
						message: lang.send_dlg_message_fail,
						button: lang.close,
						animation: "fade",
						callback: function(){
						}
					});	
				}else{
					$('.alert').css('display', 'none');
					$('.alert-danger').css('display', 'block');
				}			
			}
		}, function (response) {
			$scope.ajax_email_loading = false;
			if(!is_mobile){
				myDialogService.alert({
					title: lang.send_dlg_title_fail,
					message: lang.send_dlg_message_fail,
					button: lang.close,
					animation: "fade",
					callback: function(){
					}
				});
			}else{
				$('.alert').css('display', 'none');
				$('.alert-danger').css('display', 'block');
			}
			return response;
		});
	}
	
	$scope.download_dialog = function(product_id, product_name){
		
		$scope.down_product_id = product_id;
		$scope.down_product_name = product_name;
		
		stockCardDlg.dialog( "open" );
	}
	
	// Card import part
	var cardImportDlg = $( "#stock_card_import" ).dialog({
			autoOpen: false,
			resizable: false,
			height: "auto",
			width: 740,
			modal: true,
		});
	
	// Stock card template import function
	$scope.ajax_import_loading = false;
	$scope.submit_stock_import = function(){
		
		var formData = new FormData(document.getElementById("card_import_form"));
		
		if(!$("#card_import_file").val()){
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
		
		if ($scope.ajax_import_loading == false) {
			console.log("asdfasdf");
			$scope.ajax_import_loading = true;
			
			$http.post("/stock/card_import", formData, {
				transformRequest: angular.identity,
				headers: {'Content-Type': undefined}
			}).then(function (response, status, headers, config) {
				$scope.ajax_import_loading = false;
				
				if (response.status == 200 && response.data.status) {
					$scope.msg = response.data.msg;
					$(".alert-save-success").show();
					window.setTimeout(function() { 
						$(".alert-save-success").hide(300);
						history.back();
					}, 4000);
				} else {
					$scope.error_list = response.data.error_list;
					$(".alert-save-fail .error-text").html(response.data.err_msg);
					$(".alert-save-fail").show();
				}
			},function (data, status, headers, config) {
				$scope.ajax_import_loading = false;
				$(".alert-save-fail .error-text").html(lang.rg_fail_save);
				$(".alert-save-fail").show();
			});
		}
	}
	
	$scope.card_import_dialog = function(){
		$('.alert').hide();
		//$('#card_import_file').val("");
		bs_input_file_reset('#card_import_file');
		cardImportDlg.dialog( "open" );
	}
});


// Mobile stock controller
dingdingApp.controller('stockController', function($scope, $rootScope, $http, $location, PagerService, $route, $routeParams, myDialogService) {
	if(typeof $routeParams.type == "undefined") {
		$scope.type = '0';
	} else {
		$scope.type = $routeParams.type;
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
		//});
			// Setup title
			dd.biz.navigation.setTitle({
				title : lang.title_stock,// 库存
				onSuccess : function(result) {
				},
				onFail : function(err) {}
			});

			switch (user_priv) {
			case 'admin': // When user_priv is admin
				// Setup menus
				dd.biz.navigation.setMenu({
					backgroundColor : "#ADD8E6",
					textColor : "#3399FF11",
					items : [
						{ // 设置 menu
							"id":"1",
							"text":lang.btn_setting
						},
					],
					onSuccess: function(data) {
						window.location = "#!/stock/setting/view/" + $scope.type;
						console.log(data);
					},
					onFail: function(err) {
						console.log(err);
					}
				});
				break;
			case 'dealer': // When user_priv is dealer
				// Setup menus
				dd.biz.navigation.setMenu({
					backgroundColor : "#ADD8E6",
					textColor : "#3399FF11",
					items : [
						{ // 设置 menu
							"id":"1",
							"text":lang.btn_setting
						},
					],
					onSuccess: function(data) {
						window.location = "#!/stock/setting/view/" + $scope.type;
						console.log(data);
					},
					onFail: function(err) {
						console.log(err);
					}
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
		//});
	}
	// PC Menu
	else{
		$rootScope.route_status = 'stock';
	}
	
	$scope.pagenum = 1;	
	$scope.itemcount_perpage = 6;
	if(is_mobile) $scope.itemcount_perpage = 12;
	
	$scope.search = {dealer_id: '', page_type: 1, product_id: '', card_code_keyword: '', card_type: 1};
	if(is_mobile){
		$scope.search.page_type = '';
		$scope.search.card_type = '';
	}
	
	if(typeof $routeParams.search != "undefined") {
		search_option = JSON.parse(b64DecodeUnicode($routeParams.search));
		Object.keys(search_option).forEach(function(key) {
			if(typeof $scope.search[key] != "undefined") $scope.search[key] = search_option[key];
		});
	}
	
	console.log($scope.search);
	
	
	/*******************************
		data load
	*******************************/
	$scope.nodata = false;
	function get_page_list(pagenum, itemcount, search){
		$scope.loaded =  false;
		$scope.busy = true;
		$http.get('stock/list/' + JSON.stringify(search) + '/' + itemcount + '/' + pagenum).then(
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
		get_page_list(pagenum, $scope.itemcount_perpage, $scope.search);
	}
	
	$scope.change_type1 = function(select_tag){
		$scope.search.product_type1 = $(select_tag).val();
		location.href = "#!/stock/list/card/search/" + b64EncodeUnicode(JSON.stringify($scope.search));
	}
	$scope.change_type1_val = function(val){
		$scope.search.product_type1 = val;
		location.href = "#!/stock/list/card/search/" + b64EncodeUnicode(JSON.stringify($scope.search));
	}
	$scope.change_type2 = function(select_tag){
		$scope.search.product_type2 = $(select_tag).val();
		location.href = "#!/stock/list/card/search/" + b64EncodeUnicode(JSON.stringify($scope.search));
	}
	$scope.search_card_code = function(){
		location.href = "#!/stock/list/card/search/" + b64EncodeUnicode(JSON.stringify($scope.search));
	}
	$scope.search_card_type = function(type){
		$scope.search.card_type = type;
		location.href = "#!/stock/list/card/search/" + b64EncodeUnicode(JSON.stringify($scope.search));
	}
	$scope.search_pagetype = function(page_type){
		$scope.search.page_type = page_type;
		location.href = "#!/stock/list/card/search/" + b64EncodeUnicode(JSON.stringify($scope.search));
	}
	$scope.show_password = function(id){
		$("#real_password_" + id).attr("dd-hidden-val", $("#real_password_" + id).text());
		$("#real_password_" + id).text($("#real_password_" + id).attr("dd-val"));
		setTimeout(function(){
			$("#real_password_" + id).text($("#real_password_" + id).attr("dd-hidden-val"));
		}, 10000);
	}
	
	$scope.download_url = "";
	
	$scope.qr_loaded = false;
	$scope.get_qr_code = function(id){
		$scope.download_url = 'stock/download_qr_code/' + id;
		$scope.qr_loaded = false;
		$http.get('stock/get_qr_code/' + id).then(
			function(response){
				if(response.status == 200 && response.data.status){
					$("#qr_code_image").attr("src", response.data.img_code);
					console.log(response.data.img_code);
					$scope.qr_loaded = true;
					$(".qr_code_modal").modal();
					
				}else{
					
				}
			}
		);
	}
	
	$scope.download_qr_code = function(){
		location.href = $scope.download_url;
	}
	
});


// Mobile stock setting view controller only admin and dealer
dingdingApp.controller('stockSettingViewController', function($scope, $rootScope, $http, $route, $routeParams, myDialogService) {
	if(typeof $routeParams.type == "undefined") {
		$scope.type = '0';
	} else {
		$scope.type = $routeParams.type;
	}

	// Mobile dingding Menu
	if(is_mobile){
		//dd.ready(function() {
			// When back button closed
			// document.addEventListener('backbutton', function(e) {
			// 	e.preventDefault();
			// 	window.location = "#!/stock/" + $scope.type;
			// }, false);
			//backButtonUrl = "#!/stock/" + $scope.type;
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
		//});
			// Setup title
			dd.biz.navigation.setTitle({
				title : lang.title_stock_setting,// 库存设置
				onSuccess : function(result) {
				},
				onFail : function(err) {
					console.log(err);
				}
			});

			// Setup menus
			dd.biz.navigation.setMenu({
				backgroundColor : "#ADD8E6",
				textColor : "#3399FF11",
				items : [
					{ // 保存 menu
						"id":"1",
						"text":lang.btn_save
					},
				],
				onSuccess: function(data) {
					//window.location = "#!/stock/" + $scope.type;
					//console.log(data);
					$scope.form_submit();
				},
				onFail: function(err) {
					console.log(err);
				}
			});

			console.log("Setup the menus");
		//});
	}
	// PC Menu
	else{
		$rootScope.route_status = 'stock';
	}
	
	// Import options data list from server
	$http.get('setting/get/').then(
		function(response){
			if(response.status == 200){
				$scope.options = response.data;
				
				setTimeout(function(){
					$("input[class='switch']").bootstrapSwitch({
						onText: lang.use_on,
						offText: lang.use_off,
					});
				}, 100);
			}
		}
	);
	
	$(".alert").hide();
	
	// Save function
	$scope.form_submit = function(){		
		var formData = new FormData(document.getElementById("editForm"));		
		$.ajax({
			url: "setting/save",
			type: 'POST',
			data:  formData,
			contentType: false,
			cache: false,
			processData:false,
			success: function(result, textStatus, jqXHR)
			{
				console.log(result);
				try{
					var data = jQuery.parseJSON(result);
					if(data.status){
						$(".alert-success").show();
						$(".alert-success").alert();
						window.setTimeout(function() { 
							$(".alert-success").hide(300);
							window.location = "#!/stock/";// + $scope.type;
						}, 1500);
					}
				}catch(err){
					console.log(err);
					$(".alert-danger").show();
					$(".alert-danger").alert();
					window.setTimeout(function() { 
						$(".alert-danger").hide(300);
					}, 1500);
				}
				
			},
			error: function(jqXHR, textStatus, errorThrown) 
			{
				alert('Server error occured!\nError status: ' + textStatus);
			}          
		});
	}
});

// Mobile stock view controller
dingdingApp.controller('stockViewController', function($scope, $rootScope, $http, $route, $routeParams, myDialogService) {
	if(typeof $routeParams.card_id == "undefined") {
		$scope.card_id = '0';
	} else {
		$scope.card_id = $routeParams.card_id;
	}

	// Mobile dingding Menu
	if(is_mobile){
		//dd.ready(function() {
			// When back button closed
			/*document.addEventListener('backbutton', function(e) {
				e.preventDefault();
				//window.location = "#!/stock/";
				history.back();
			}, false);*/
			//backButtonUrl = "#!/stock";
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
		//});
			// Setup title
			dd.biz.navigation.setTitle({
				title : lang.title_stock,// 一年延保卡
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
		$rootScope.route_status = 'stock';
	}
	
	$scope.loaded =  false;
	$http.get(base_url + 'stock/get/card_info/' + $scope.card_id).then(
		function(response){
			if(response.status == 200 && response.data.status){
				$scope.card = response.data.card;
				$scope.loaded =  true;
			}
			$(".stock_v_content").css("display", "block");
		}
	);
});

// Mobile purchase add controller only dealer
dingdingApp.controller('stockAddController', function($scope, $rootScope, $http, $route, $routeParams, myDialogService) {
	if(typeof $routeParams.product_id == "undefined") {
		$scope.product_id = '0';
	} else {
		$scope.product_id = $routeParams.product_id;
	}
	
	$scope.card_type = "0";
	
	// Mobile dingding Menu
	if(is_mobile){
		//dd.ready(function() {
			// When back button closed
			// document.addEventListener('backbutton', function(e) {
			// 	e.preventDefault();
			// 	window.location = "#!/stock/view/" + $scope.product_id;
			// }, false);
			//backButtonUrl = "#!/stock/view/" + $scope.product_id;
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
		//});
			// Setup title
			dd.biz.navigation.setTitle({
				title : lang.title_stock_add,// 进货
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
		$rootScope.route_status = 'stock';
	}
	
	$scope.loaded =  false;
	$http.get(base_url + 'stock/get/product_info/' + $scope.product_id).then(
		function(response){
			if(response.status == 200 && response.data.status){
				$scope.product = response.data.product;
				$scope.order_info = response.data.order_info;
				$scope.loaded =  true;
			}
		}
	);
	
	$(".alert").hide();
	
	$scope.show_confirm = function(atag){
		if($(atag).attr("disabled") == "disabled") return;		
		$('#confirm_dlg').modal('show');
	}
	
	$scope.ajax_loading = false;
	$scope.order_purchase = function(){
		if($scope.ajax_loading === false){
			$scope.ajax_loading = true;
			$http.post(base_url + 'stock/purchase', {product_id: $scope.product.id, order_size:$scope.order_size, type: $scope.card_type, status: 0}).then(
				function(response){
					if(response.status == 200 && response.data.status){
						$('#confirm_dlg').modal('toggle'); 
						$("#confirm_dlg").on("hidden.bs.modal", function () {
							$(".alert-success").show();
							$(".alert-success").alert();
							window.setTimeout(function() { 
								$(".alert-success").hide(500);
								$scope.ajax_loading = false;
								window.location = "#!/order";
							}, 3000);
						});
					}else{
						$(".alert-danger").show();
						$(".alert-danger").alert();
						window.setTimeout(function() { 
							$(".alert-danger").hide(500);
							$scope.ajax_loading = false;
						}, 3000);
					}
				}
			);
		}else{
			return false;
		}	
	}
});

// Mobile stock return controller only dealer
dingdingApp.controller('stockReturnController', function($scope, $rootScope, $http, $route, $routeParams, myDialogService) {
	if(typeof $routeParams.product_id == "undefined") {
		$scope.product_id = '0';
	} else {
		$scope.product_id = $routeParams.product_id;
	}
	
	$scope.card_type = "0";

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
			
			dd.biz.navigation.setTitle({
				title : lang.title_stock_return,// 退货
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
		$rootScope.route_status = 'stock';
	}
	
	$scope.loaded =  false;
	$http.get(base_url + 'stock/get/product_info/' + $scope.product_id).then(
		function(response){
			if(response.status == 200 && response.data.status){
				$scope.product = response.data.product;
				$scope.order_info = response.data.order_info;
				$scope.loaded =  true;
			}
		}
	);
	
	$(".alert").hide();
	
	$scope.show_confirm = function(atag){
		if($(atag).attr("disabled") == "disabled") return;		
		$('#confirm_dlg').modal('show');
	}

	$scope.ajax_loading = false;
	$scope.order_return = function(){
		if($scope.ajax_loading === false){
			$scope.ajax_loading = true;
			$http.post(base_url + 'stock/purchase', {product_id: $scope.product.id, order_size:$scope.order_size, type: $scope.card_type, status: 1, code_list: $scope.valid_pcard_list}).then(
				function(response){
					if(response.status == 200 && response.data.status){
						$('#confirm_dlg').modal('toggle'); 
						$("#confirm_dlg").on("hidden.bs.modal", function () {
							$(".alert-return-success").show();
							$(".alert-return-success").alert();
							window.setTimeout(function() { 
								$(".alert-return-success").hide(600);
								$scope.ajax_loading = false;
								window.location = "#!/order";
							}, 5000);
						});
					}else{
						$(".alert-return-danger").show();
						$(".alert-return-danger").alert();
						window.setTimeout(function() { 
							$(".alert-return-danger").hide(600);
							$scope.ajax_loading = false;
						}, 5000);
					}
					
				},function(response){
					$(".alert-return-danger").show();
					$(".alert-return-danger").alert();
					window.setTimeout(function() { 
						$(".alert-return-danger").hide(600);
						$scope.ajax_loading = false;
					}, 5000);
					
				}
			);
		}else{
			return false;
		}
		
	}

	
	/********************************
		Physical card insert part
	********************************/

	$scope.valid_pcard_quantity = 0;
	$scope.valid_pcard_list = {};

	var check_each_card_loading = false;
	$scope.each_card_insert = function(){
		card_code = $("#each_card_code").val();
		if(card_code == "") $("#each_card_code").focus();
		
		if(typeof $scope.valid_pcard_list[card_code] != "undefined"){
			$('.alert').hide();
			$('.alert-pcard-code-invalid').show();						
			window.setTimeout(function() { 
				$(".alert-pcard-code-invalid").hide(500);
			}, 6000);
		}
		else{
			if(check_each_card_loading == false){
				check_each_card_loading = true;
				$http.post('/order/check_physical_card/each', {"product_id": $scope.product.id, "card_code" : card_code}).then(
					function (response) {
						if(response.data.status){ // If valid card
							$('.alert').hide();
							$('.alert-pcard-code-valid').show();						
							window.setTimeout(function() { 
								$(".alert-pcard-code-valid").hide();
							}, 3000);
							$("#each_card_code").val('');
							$scope.valid_pcard_list[card_code] = {code: card_code};
							
							window.setTimeout(function() { 
								var myDiv = document.getElementById("card_code_list");
								myDiv.scrollTop = myDiv.scrollHeight;
							}, 100);

							$scope.valid_pcard_quantity = Object.keys($scope.valid_pcard_list).length;
							
							console.log($scope.valid_pcard_list);
						}else{
							$('.alert').hide();
							$('.alert-pcard-code-invalid').show();						
							window.setTimeout(function() { 
								$(".alert-pcard-code-invalid").hide(200);
							}, 3000);
						}
						check_each_card_loading = false;
					}, function (response) {
						$('.alert').hide();
						$('.alert-pcard-code-invalid').show();						
						window.setTimeout(function() { 
							$(".alert-pcard-code-invalid").hide(500);
						}, 6000);
						check_each_card_loading = false;
					}
				);
			}
		}
		console.log(card_code);
	}
	
	$scope.import_result = {};
	$scope.import_card_insert = function(){
		
		var filename = $("#pcard_file_form input[name='pcard_file']").val();
		if(filename.length < 4){
			myDialogService.alert({
				title: lang.error,
				message: lang.err_nofile_select,
				button: lang.close,
				animation: "fade",
				callback: function(){
				}
			});
			return false;
		}
		
		var pcard_file_form = new FormData(document.getElementById("pcard_file_form"));
		$scope.cardtemp_loading = true;
		
		$http.post("/order/check_physical_card/file", pcard_file_form, {
			headers: { 'Content-Type': undefined },
			transformRequest: angular.identity
		}).then(function (response, status, headers, config) {
			
			$scope.cardtemp_loading = false;
			
			res_data = response.data;
			
			if(res_data.status){
				res_data.valid_code_list.forEach(function(card_code) {
					if(typeof $scope.valid_pcard_list[card_code] == "undefined"){ // if card is not inserted already
						$scope.valid_pcard_list[card_code] = {code: card_code}
						$scope.valid_pcard_quantity ++;
						
					}else{
						res_data.valid_cards_quantity --;
						res_data.exist_invalid_card = true;
						res_data.invalid_cards.push(card_code);
					}
				});
				$scope.import_result = res_data;
				
				$('.alert').hide();
				$('.alert-pcard-import-valid').show();						
				if(!res_data.exist_invalid_card){
					window.setTimeout(function() { 
						$(".alert-pcard-import-valid").hide(500);
					}, 6000);
				}
			}else{
				$('.alert').hide();
				$('.alert-pcard-import-invalid').html(res_data.err_msg);						
				$('.alert-pcard-import-invalid').show();						
				window.setTimeout(function() { 
					$(".alert-pcard-import-invalid").hide(500);
				}, 6000);
			}
		},function (data, status, headers, config) {
			$scope.cardtemp_loading = false;
			$('.alert').hide();
			$('.alert-pcard-import-invalid').show();						
			window.setTimeout(function() {
				$(".alert-pcard-import-invalid").hide(500);
			}, 6000);
			check_each_card_loading = false;
		});
	}
	
	$scope.remove_code = function(code){
		if(typeof $scope.valid_pcard_list[code] != "undefined"){
			delete  $scope.valid_pcard_list[code];
			$scope.valid_pcard_quantity = Object.keys($scope.valid_pcard_list).length;
		}
	}
	
	$scope.scan_barcode = function() {
		dd.biz.util.scan({
			type: 'barCode' , // type 为 all、qrCode、barCode，默认是all。
			onSuccess: function(data) {
				console.log(data);
				$("#each_card_code").val(data.text);
			},
			onFail : function(err) {
			}
		});
	}
	
	/*****************************************
		The end of Physical card insert part
	*****************************************/
	
});


// Mobile stock view controller
dingdingApp.controller('stockBulkRegisterController', function($scope, $rootScope, $http, $route, $routeParams, myDialogService) {
	
	if(typeof $routeParams.product_id == "undefined") {
		history.back();
	} else {
		$scope.product_id = $routeParams.product_id;
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
			title : lang.title_bulk_register,// 一年延保卡
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
	$http.get(base_url + 'stock/get/product_info/' + $scope.product_id).then(
		function(response){
			if(response.status == 200 && response.data.status){
				$scope.product = response.data.product;
				$scope.loaded =  true;
			}else{
				if(!is_mobile){
					DingTalkPC.device.notification.toast({
						type: "warning", //toast的类型 alert, success, error, warning, information, confirm
						text: response.data.err_msg, //提示信息
						duration: 2, //显示持续时间，单位秒，最短2秒，最长5秒
						delay: 0, //延迟显示，单位秒，默认0, 最大限制为10
						onSuccess : function(result) {
							history.back();
						},
						onFail : function(err) {}
					});
				}else{
					dd.device.notification.toast({
						type: "warning", //toast的类型 alert, success, error, warning, information, confirm
						text: response.data.err_msg, //提示信息
						duration: 2, //显示持续时间，单位秒，最短2秒，最长5秒
						delay: 0, //延迟显示，单位秒，默认0, 最大限制为10
						onSuccess : function(result) {
							history.back();
						},
						onFail : function(err) {}
					});
				}
			}
			$(".stock_v_content").css("display", "block");
		}
	);
	
	$scope.ajax_loading = false;
	// Bulk register template file upload submit
	$scope.import_bulk_register = function(){
		
		$(".alert").hide();
		$scope.invalide_cards = [];
		
		var formData = new FormData(document.getElementById("bulk_register_form"));
		
		if (!$("#bulk_register_file").val()) {
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
		
		if($scope.ajax_loading == false){
			$scope.ajax_loading = true;
			
			$http.post("stock/bulk_register/import", formData, {
				transformRequest: angular.identity,
				headers: {'Content-Type': undefined}
			}).then(function (response, status, headers, config) {
				$scope.ajax_loading = false;
				
				if(response.status == 200 && response.data.status){
					$scope.msg = response.data.msg;
					$(".alert-save-success").show();
					window.setTimeout(function() { 
						$(".alert-save-success").hide(300);
						history.back();
					}, 4000);
				}else{
					$scope.err_msg = response.data.err_msg;
					console.log($scope.err_msg);
					$scope.invalide_cards = response.data.invalid_cards;
					$(".alert-save-fail").show();
				}
			},function (data, status, headers, config) {
				$scope.ajax_loading = false;
				$scope.err_msg = lang.rg_fail_save;
				$(".alert-save-fail").show();
			});
		}
		
		return false;
	}
});