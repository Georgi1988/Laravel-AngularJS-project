

// Mobile order controller only admin and dealer
dingdingApp.controller('orderController', function($scope, $rootScope, $http, PagerService, $route, $routeParams, myDialogService) {
	
	$scope.pagenum = 1;

    $scope.itemcount_perpage = 6;
	if(is_mobile) $scope.itemcount_perpage = 12;
	
	$scope.search = {type: 1,  keyword: ''};
	if(is_mobile && user_priv == "dealer"){
		$scope.search.type = 4;
	}
	
	if ($scope.search.type == 1) {
		g_newOrder = 0; 
		if (!is_mobile)	set_order_badge(g_newPurchase, 0);
	}	
	if ($scope.search.type == 4) {
		g_newPurchase = 0; 
		if (!is_mobile)	set_order_badge(0, g_newOrder);
	}
	
	if(typeof $routeParams.search != "undefined") {
		search_option = JSON.parse(b64DecodeUnicode($routeParams.search));
		Object.keys(search_option).forEach(function(key) {
			if(typeof $scope.search[key]) $scope.search[key] = search_option[key];
		});
		console.log(search_option);
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
				title : lang.title_order,// 订单
				onSuccess : function(result) {
				},
				onFail : function(err) {}
			});

			// Setup menus
			/* dd.biz.navigation.setMenu({
				backgroundColor : "#ffffff",
				textColor : "#000000",
				items : [
					{ // 设置 menu
						"id":"1",
						"text":lang.btn_setting
					},
				],
				onSuccess: function(data) {
					window.location = "#!/order/setting/view/" + $scope.type;
					console.log(data);
				},
				onFail: function(err) {
					console.log(err);
				}
			}); */

			console.log("Setup the menus");
		//});
	}
	// PC Menu
	else{
		$rootScope.route_status = 'order';

		//order import
        $("#orderimport").css("display", "none");

		$scope.order_import = function(){
			console.log("import");
			$scope.orderimportDlg = $( "#orderimport" ).dialog({
				autoOpen: false,
				resizable: false,
				height: "auto",
				width: 740,
				modal: true,
			});
				
			$scope.orderimportDlg.dialog( "open" );
		}

		$scope.submit_import = function () {
			var formData = new FormData(document.getElementById("orderimport_form"));
		
			$.ajax({
				url: "order/fileupload",
				type: 'POST',
				data:  formData,
				mimeType:"multipart/form-data",
				contentType: false,
				cache: false,
				processData:false,
				success: function(result, textStatus, jqXHR)
				{
					try{
						var data = jQuery.parseJSON(result);
						if(data.status){
							$scope.orderimportDlg.dialog( "close" );
							$route.reload();
						}
					}catch(err){
						console.log(err);
						custom_alert('Server error occures!', "error");
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

		//order export
        $("#orderexport").css("display", "none");

        $scope.order_export = function(){
			console.log("export");
			$scope.exportDlg = $( "#orderexport" ).dialog({
				autoOpen: false,
				resizable: false,
				height: "auto",
				width: 740,
				modal: true,
			});
				
			$scope.exportDlg.dialog( "open" );
		}
		$scope.submit_export = function () {
			
			$http.post('order/export', $scope.sendemail).then(
				function (response) {
					console.log(response.data);
			}, function (response) {
					return response;
			});
		
		}
	}
	
	
	function get_page_list(pagenum, itemcount, search){
		$scope.loaded =  false;
		$scope.busy = true;
		$scope.no_data = false;
		$http.get('order/list/' + JSON.stringify(search) + '/' + itemcount + '/' + pagenum).then(
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
					var prices = response.data.price_list;
					for (var i = 0; i < items.length; i++) {
						$scope.items.push(items[i]);
					}

					if ($scope.items.length == 0)
    					$scope.no_data = true;
					
					Object.keys(prices).forEach(function(key) {
						$scope.prices[key] = prices[key];
					});
					
				}else{					
					$scope.list_data = response.data.list;
					$scope.last_page = $scope.list_data.last_page;
					$scope.pagenation = PagerService.GetPager($scope.list_data.total, $scope.list_data.current_page, $scope.list_data.per_page, 10);

					if ($scope.list_data.data.length == 0)
    					$scope.no_data = true;
				}
			}
		);
	}
	
	get_page_list($scope.pagenum, $scope.itemcount_perpage, $scope.search);
	
	$scope.search_type = function(type){
		/* if (type == 1) {
			g_newOrder = 0; 
			if (!is_mobile)	set_order_badge(g_newPurchase, 0);
		}	
		if (type == 4) {
			g_newPurchase = 0; 
			if (!is_mobile)	set_order_badge(0, g_newOrder);
		} */
		
		initialize_list();
		$scope.search.type = type;
		location.href = "#!/order/list/" + b64EncodeUnicode(JSON.stringify($scope.search));
		//get_page_list(1, $scope.itemcount_perpage, $scope.search);
	}
	
	$scope.search_keyword = function(keyword_tag){
		initialize_list();
		$scope.search.keyword = $(keyword_tag).val();
		get_page_list(1, $scope.itemcount_perpage, $scope.search);
	}
	
	$scope.setPage = function(pagenum){
		if(pagenum < 1) pagenum = 1;
		else if(pagenum > $scope.list_data.last_page) pagenum = $scope.list_data.last_page;
		get_page_list(pagenum, $scope.itemcount_perpage, $scope.search);
	}
	
	var initialize_list = function(){
		if(is_mobile){
			delete $scope.items;
			delete $scope.prices;
			$scope.items = [];
			$scope.prices = [];
		}else{
			delete $scope.list_data;
			$scope.list_data = [];
		}
	}
	
});

// Mobile order setting view controller only admin and dealer
dingdingApp.controller('orderSettingViewController', function($scope, $rootScope, $http, $route, $routeParams, myDialogService) {
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
			// 	window.location = "#!/order/type/" + $scope.type;
			// }, false);

			// Setup title
			dd.biz.navigation.setTitle({
				title : lang.title_order_setting,// 订单设置
				onSuccess : function(result) {
				},
				onFail : function(err) {}
			});

			// Setup menus
			dd.biz.navigation.setMenu({
				backgroundColor : "#ffffff",
				textColor : "#000000",
				items : [
					{ // 保存 menu
						"id":"1",
						"text":lang.btn_save
					},
				],
				onSuccess: function(data) {
					// window.location = "#!/order/" + $scope.type;
					// console.log(data);
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
		$rootScope.route_status = 'order';
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
							//window.location = "#!/order/type/" + $scope.type;
							history.back();
						}, 2000);
					}
				}catch(err){
					console.log(err);
					$(".alert-danger").show();
					$(".alert-danger").alert();
					window.setTimeout(function() { 
						$(".alert-danger").hide(300);
					}, 10000);
				}
				
			},
			error: function(jqXHR, textStatus, errorThrown) 
			{
				//alert('Server error occured!\nError status: ' + textStatus);
				console.log(textStatus);
				$(".alert-danger").show();
				$(".alert-danger").alert();
				window.setTimeout(function() { 
					$(".alert-danger").hide(300);
				}, 10000);
			}          
		});
	}
});

// Mobile order view controller only admin and dealer
dingdingApp.controller('orderViewController', function($scope, $rootScope, $route, $http, $routeParams, myDialogService) {
	if(typeof $routeParams.order_id == "undefined") {
		$scope.order_id = '0';
	} else {
		$scope.order_id = $routeParams.order_id;
	}
	
	
	// Mobile dingding Menu
	if(is_mobile){
		//dd.ready(function() {
			// When back button closed
			//backButtonUrl = "#!/order";
			
			if(document.referrer == location.href)
				backButtonUrl = "#!/order";
			else
				backButtonUrl = "";

			// Only for iphone
			dd.biz.navigation.setLeft({
				control: true,//是否控制点击事件，true 控制，false 不控制， 默认false
				text: lang.label_back,//控制显示文本，空字符串表示显示默认文本
				onSuccess : function(result) {
					//window.location = "#!/order";
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
			// 	window.location = "#!/order";
			// }, false);

			// Setup title
			dd.biz.navigation.setTitle({
				title : lang.title_order_detail,// 订单详情
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
		$rootScope.route_status = 'order';
	}
	
	$scope.loaded = false;
	$http.get(base_url + 'order/get/item/' + $scope.order_id).then(
		function(response){
			if(response.status == 200 && response.data.status){
				$scope.order_set = response.data.order_set;
				$scope.dealer = response.data.dealer;
				$scope.additional_info = response.data.additional_info;
				$scope.total_count = 0;
				for (var i = 0; i < $scope.order_set.length; i++) {
					$scope.total_count += $scope.order_set[i].size;
				}			
			}
			$(".order_v_content").css("display", "block");
			$scope.loaded =  true;	
		}
	);
	
	$(".alert").hide();
	
	$scope.ajax_request = 0;
	$scope.ajax_loading = false;
	
	$scope.agree_order = function(){
		
		var order_status = $scope.order_set[0].status;
		if($scope.ajax_request == 0){
			$scope.ajax_request = 1;
			$scope.ajax_loading = true;
			$http.post(base_url + 'order/agree/item/' + $scope.order_set[0].code, {'code_list': $scope.valid_pcard_list}).then(
			function(response){
				$scope.ajax_request = 2;
				$scope.ajax_loading = false;
				if(response.status == 200 && response.data.status){
					if(is_mobile){
						$(".alert-save-success").show();
						$(".alert-save-success").alert();
						window.setTimeout(function() {
							$('.reg_success_modal').modal('toggle');
							$(".reg_success_modal").on("hidden.bs.modal", function () {
								if(order_status == 0){
									location.href = '#!/order/list/' + b64EncodeUnicode(JSON.stringify({"type":2}));
								}else if(order_status == 1){
									location.href = '#!/order/list/' + b64EncodeUnicode(JSON.stringify({"type":3}));
								}
							});
						}, 2000);
					}else{
						$('.alert').css('display', 'none');
						$('.alert-save-success').css('display', 'block');
						setTimeout(function(){
							if(order_status == 0){
								location.href = '#!/order/list/' + b64EncodeUnicode(JSON.stringify({"type":2}));
							}else if(order_status == 1){
								location.href = '#!/order/list/' + b64EncodeUnicode(JSON.stringify({"type":3}));
							}
						}, 2000);
					}
				}else{
					$scope.ajax_request = 0;
					$('.alert').css('display', 'none');
					if(typeof response.data.err_msg == "undefined" || response.data.err_msg == ""){
						$('.alert-save-fail').html(lang.rg_fail_save);
					}else{
						$('.alert-save-fail').html(response.data.err_msg);
					}
					$('.alert-save-fail').css('display', 'block');
				}
			},function(response){
				$scope.ajax_request = 0;
				$('.alert').css('display', 'none');
				$('.alert-save-fail').html(lang.rg_fail_save);
				$('.alert-save-fail').css('display', 'block');
			}
		);
			
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
				$http.post('/order/check_physical_card/each', {"product_id": $scope.order_set[0].product.id, "card_code" : card_code}).then(
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
		
		console.log(filename);
		
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
	
	
	/********************************
		Order Refuse
	********************************/
	
	$scope.ajax_request_refus = 0;
	$scope.ajax_loading_refus = false;
	
	$scope.refuse_order = function(){
		var order_status = $scope.order_set[0].status;
		if($scope.ajax_request_refus == 0){
			$scope.ajax_request_refus = 1;
			$scope.ajax_loading_refus = true;
			$http.get(base_url + 'order/refuse/item/' + $scope.order_set[0].code).then(
			function(response){
				$scope.ajax_request_refus = 2;
				$scope.ajax_loading_refus = false;
				if(response.status == 200 && response.data.status){
					if(is_mobile){
						$(".success_refused").show();
						$(".success_refused").alert();
						window.setTimeout(function() {
							$('.refusal_success_modal').modal('toggle');
							$(".refusal_success_modal").on("hidden.bs.modal", function () {
								if(order_status == 0){
									location.href = '#!/order/list/' + b64EncodeUnicode(JSON.stringify({"type":1}));
								}else if(order_status == 1){
									location.href = '#!/order/list/' + b64EncodeUnicode(JSON.stringify({"type":1}));
								}
							});
						}, 500);
					}else{
						//$('.alert').css('display', 'none');
						$('.success_refused').css('display', 'block');
						setTimeout(function(){
							if(order_status == 0){
								location.href = '#!/order/list/' + b64EncodeUnicode(JSON.stringify({"type":1}));
							}else if(order_status == 1){
								location.href = '#!/order/list/' + b64EncodeUnicode(JSON.stringify({"type":1}));
							}
						}, 500);
					}
				}else{
					console.log(err);
					//alert('Server error occures!\n' + result);
					//$('.alert').css('display', 'none');
					$('.fail_refus').css('display', 'block');
				}
			}
		);
			
		}
		
	}

});
