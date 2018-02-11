

// Mobile product page controller
dingdingApp.controller('productController', function($scope, $rootScope, $http, $window, PagerService, $route, $routeParams, myDialogService) {
	
	g_newProduct = 0;
	if (!is_mobile)	set_product_badge(0);
	
	// Config variables
	$scope.pagenum = 1;
	$scope.typelist;
	$scope.itemcount_perpage = 6;
	if(is_mobile) $scope.itemcount_perpage = 8;
	$scope.search = {level1_type: '', level2_type: '', keyword: '', status: '', page_type: 'product'};
	
	
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
			// 	console.log('go to overview');
			// 	window.location = "#!/overview";
			// 	e.preventDefault();
			// }, false);
			//backButtonUrl = "#!/overview";
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
				title : lang.title_product,// 产品, 选择产品
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
						{ // +分类管理 menu
							"id":"1",
							"text":lang.title_product_type_manage
						},
					],
					onSuccess: function(data) {
						window.location = "#!/product/class/list";
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
		//});
	}
	// PC Menu
	else{
		$rootScope.route_status = 'product';
	}
	
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
	
	function get_page_list(pagenum, itemcount, search){
		$scope.loaded =  false;
		$scope.busy = true;
		$scope.no_data = false;
		$http.get('product/list/' + JSON.stringify(search) + '/' + itemcount + '/' + pagenum).then(
			function(response){
				$scope.busy = false;	// It is true when this is loading
				$scope.loaded =  true;
				if (is_mobile) {
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
					
					if ($scope.items.length == 0)
    					$scope.no_data = true;
				} else {					
					$scope.list_data = response.data.list;
					$scope.last_page = $scope.list_data.last_page;
					$scope.pagenation = PagerService.GetPager($scope.list_data.total, $scope.list_data.current_page, $scope.list_data.per_page, 10);
					
					if ($scope.list_data.data.length == 0)
    					$scope.no_data = true;
				}
			}
		);
	}

	$scope.setPage = function(pagenum){
		if(pagenum < 1) pagenum = 1;
		else if(pagenum > $scope.list_data.last_page) pagenum = $scope.list_data.last_page;
		get_page_list(pagenum, $scope.itemcount_perpage, $scope.search);
	}
	
	$scope.search_change = function(){
		get_page_list(1, $scope.itemcount_perpage, $scope.search);
	}
	
	$scope.search_type1 = function(type1){
		$scope.search.level1_type = type1;
		get_page_list(1, $scope.itemcount_perpage, $scope.search);
	}
	
});

// PC, Mobile product class list page controller only admin
dingdingApp.controller('productClassListController', function($scope, $rootScope, PagerService, $http, $route, $routeParams, myDialogService) {
	
	$scope.pagenum = 1;
	$scope.itemcount_perpage = 10;
	if(is_mobile) $scope.itemcount_perpage = 30;
	$scope.search = {type_level: '1'};
	
	$scope.type_level = [
		{id: 1, description: lang['title_type1_lavel']}, 
		{id: 2, description: lang['title_type2_lavel']},
		{id: 3, description: lang['title_type3_lavel']}
	];
	
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
			// 	window.location = "#!/product";
			// }, false);
			//backButtonUrl = "#!/product";
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
				title : lang.title_product_type_manage_title,// 分类管理
				onSuccess : function(result) {
				},
				onFail : function(err) {}
			});
			// Setup menus
			dd.biz.navigation.setMenu({
				backgroundColor : "#ffffff",
				textColor : "#000000",
				items : [
					{ // +添加分类 menu
						"id":"1",
						"text":lang.title_product_type_add
					},
				],
				onSuccess: function(data) {
					// Modal dialog
					$scope.open_edit_dialog(0);
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
		$rootScope.route_status = 'product';
	}

	get_page_list($scope.pagenum, $scope.itemcount_perpage, $scope.search);
	
	// Show page items
	function get_page_list(pagenum, itemcount, search){
		$scope.loaded =  false;
		$scope.busy = true;
		$scope.no_data = false;
		$http.get('product/get/class/list/' + JSON.stringify(search) + '/' + itemcount + '/' + pagenum).then(
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

					if ($scope.items.length == 0)
    					$scope.no_data = true;
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
	
	// pagenation page function
	$scope.setPage = function(pagenum){
		if(pagenum < 1) pagenum = 1;
		else if(pagenum > $scope.list_data.last_page) pagenum = $scope.list_data.last_page;
		$scope.pagenum = pagenum;
		get_page_list(pagenum, $scope.itemcount_perpage, $scope.search);
	}
	
	$scope.search_change = function(){
		get_page_list(1, $scope.itemcount_perpage, $scope.search);
	}
	
	$scope.search_level = function(level){
		$scope.search.type_level = level;
		get_page_list(1, $scope.itemcount_perpage, $scope.search);
	}
	
	// open product class edit dialog function
	$scope.item_info_edit;
	$scope.item_edit_id;
	$scope.open_edit_dialog = function(id){
		
		$(".alert").hide();
		
		$scope.item_edit_id = id;
		$http.get('/product/get/class/item/' + id).then(
			function(response){
				data = response.data;
				if(data.status){
					$scope.item_info_edit = data.value;
					if(!$scope.item_info_edit.id) $scope.item_info_edit.id = 0;
					if(!$scope.item_info_edit.level) $scope.item_info_edit.level = "";
					if(!is_mobile){
						var productCategEditDlg = $( "#productcategedit" ).dialog({
							autoOpen: false,
							resizable: false,
							height: "auto",
							width: 740,
							modal: true,
						});
						productCategEditDlg.dialog( "open" );
					}else{
						$(".reg_success_modal").modal({backdrop: 'static', keyboard: false});
					}		
				}
				else{
					alert(lang.no_data);
				}
			}
		);
	}
	
	// Close product class edit dialog function
	$scope.close_edit_dialog = function(){
		$scope.item_edit_id = 0;
		if(!is_mobile){
			var productCategEditDlg = $( "#productcategedit" ).dialog({
				autoOpen: false,
				resizable: false,
				height: "auto",
				width: 740,
				modal: true,
			});
			productCategEditDlg.dialog( "close" );
		}else{
			$(".reg_success_modal").modal('toggle');
		}
	}
	
	// Product class edit save function
	$scope.ajax_request = 0;
	$scope.ajax_loading = false;
	$scope.save_class = function(){
		//console.log($scope.item_info_edit.id);
		$scope.ajax_request = 0;
		if($scope.ajax_request == 0){
			$scope.ajax_request = 1;
			$scope.ajax_loading = true;
			$http.post('/product/class/edit/item/' + $scope.item_info_edit.id, 
				{
					'level': $scope.item_info_edit.level, 
					'description': $scope.item_info_edit.description
				}
			).then(
				function(response){
					$scope.ajax_request = 2;
					$scope.ajax_loading = false;
					if(response.status == 200 && response.data.status){
						var data = response.data;
						
						$(".alert").hide();
						$(".alert-success").show();
						$(".alert-success").alert();
						
						window.setTimeout(function() { 
							$scope.close_edit_dialog();
							$scope.search.type_level = data.row_data.level;
							if(is_mobile){
								if($scope.item_info_edit.id == 0){
									get_page_list(1, $scope.itemcount_perpage, $scope.search); // refresh
								}
								for (var key in $scope.items) {
									if($scope.items[key].id == $scope.item_info_edit.id){
										$scope.items[key] = data.row_data;
									}
								}
								get_page_list(1, $scope.itemcount_perpage, $scope.search); // refresh
							}else{
								get_page_list($scope.pagenum, $scope.itemcount_perpage, $scope.search); // refresh
							}
						
						}, 2000);
					}else{
						$(".alert").hide();
						$(".alert-danger").show();
						$(".alert-danger").html(response.data.err_msg);
						$(".alert-danger").alert();
						window.setTimeout(function() { 
							$(".alert").hide(300);
						}, 10000);
					}
				}
			);
		}else{
			return false;
		}	
	}
	
});

// Mobile product view page controller
dingdingApp.controller('productViewController', function($scope, $rootScope, $http, $route, $routeParams, myDialogService) {
	if(typeof $routeParams.product_id == "undefined") {
		$scope.product_id = '0';
	} else {
		$scope.product_id = $routeParams.product_id;
	}
	
	$scope.loaded =  false;
	$http.get(base_url + 'product/get/item/' + $routeParams.product_id).then(
		function(response){
			if(response.status == 200 && response.data.status){
				$scope.product = response.data.value;
				$scope.loaded =  true;
			}
			$(".prod_v_content").css("display", "block");
		}
	);

	// Mobile dingding Menu
	if(is_mobile){
		//dd.ready(function() {
			// When back button closed
			// document.addEventListener('backbutton', function(e) {
			// 	e.preventDefault();
			// 	window.location = "#!/product";
			// }, false);
			//backButtonUrl = "#!/product";
			
			if(document.referrer == location.href)
				backButtonUrl = "#!/product";
			else
				backButtonUrl = "";
			
			// Only for iphone
			dd.biz.navigation.setLeft({
				control: true,//是否控制点击事件，true 控制，false 不控制， 默认false
				text: lang.label_back,//控制显示文本，空字符串表示显示默认文本
				onSuccess : function(result) {
					//window.location = "#!/product";
					//window.history.back();
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
				title : lang.title_product_view,// 一年延保卡
				onSuccess : function(result) {
				},
				onFail : function(err) {}
			});

			switch (user_priv) {
			case 'admin':
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
						// Modal dialog
						window.location = "#!/product/edit/" + $scope.product_id;
						console.log(data);
					},
					onFail: function(err) {
						console.log(err);
					}
				});
				break;
			case 'dealer':
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
			case 'seller':
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
		$rootScope.route_status = 'product';
	}
	
	
});

// Mobile product edit page controller only admin
dingdingApp.controller('productEditController', function($scope, $rootScope, $http, $window, $route, $routeParams, myDialogService) {
	if(typeof $routeParams.product_id == "undefined") {
		$scope.product_id = '0';
	} else {
		$scope.product_id = $routeParams.product_id;
	}
	
	// Mobile dingding Menu
	if(is_mobile){
		//dd.ready(function() {
			// When back button closed
			// document.addEventListener('backbutton', function(e) {
			// 	e.preventDefault();
			// 	window.location = "#!/product/view/" + $scope.product_id;
			// }, false);
			/* if($scope.product_id != 0)
				backButtonUrl = "#!/product/view/" + $scope.product_id;
			else
				backButtonUrl = "#!/product"; */
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
				title : lang.title_product_edit,// 产品编辑
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
					// Form submit
					//document.getElementById("editForm").submit();
					//$scope.form_submit();
					$("#save_submit_button").trigger( "click" );
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
		$rootScope.route_status = 'product';
	}
		
	$scope.loaded =  false;
	$http.get('product/get/item/' + $routeParams.product_id + '/1').then(
		function(response){
			if(response.status == 200 && response.data.status){
				$scope.product = response.data.value;
				$scope.type_list = response.data.type_list;
				$scope.loaded =  true;
				
				setTimeout(function(){
					$("input[class='switch']").bootstrapSwitch({
						onText: lang.use_on,
						offText: lang.use_off,
					});
				}, 300);
			}
			$(".prod_v_content").css("display", "block");
		}
	);
	
	$scope.change_image = function(logo_image){
		var reader = new FileReader();
		reader.onload = function(event) {
			$('#productImage').attr('src', event.target.result);
		}
		reader.readAsDataURL(logo_image.files[0]);
	}
		
	
	// Product Edit , Save function
	
	$scope.ajax_request = 0;
	$scope.ajax_loading = false;
	
	$scope.form_submit = function(){
		
		// Validation
		var image_file = $('input[name="image_file"]').val();
		var pro_name = $('input[name="product_name"]').val();
		var pro_code = $('input[name="product_code"]').val();
		var product_level1_id = $('select[name="product_level1_id"]').val();
		var product_level2_id = $('select[name="product_level2_id"]').val();
		var product_valid_period = $('select[name="product_valid_period"]').val();
		var product_price_sku = $('input[name="product_price_sku"]').val();
		var product_service_type = $('select[name="product_service_type"]').val();
		var product_description = $('textarea[name="product_description"]').val();
		var product_card_rule = $('select[name="product_card_rule"]').val();
		
		console.log(product_price_sku);
		
		var is_valid = true;
		
		if($scope.product_id == '0'){
			console.log($('input[name="image_file"]').val());
			if(image_file == ""){
				$scope.required_image = true;
				is_valid = false;
			}else
				$scope.required_image = false;
		}
		if(pro_name == "" && pro_name.length < 3){
			$scope.required_name = true;
			console.log("name error");
			is_valid = false;
		}else{
			$scope.required_name = false;
		}
		// product code check
		var patt = /^[0-9]+[\-]{1}[0-9]{3,}[\*]*[0-9]*$/;
		if(pro_code == "" && pro_code.length < 5){
			$scope.required_code = true;
			console.log("code error");
			is_valid = false;
		}else if(!patt.test(pro_code)){
			$scope.required_code = true;
			console.log("code error");
			is_valid = false;
		}else{
			$scope.required_code = false;
		}
		
		console.log(pro_code);
		
		if(product_level1_id == "" || typeof product_level1_id == "undefined"){
			$scope.required_level1 = true;
			console.log("name error");
			is_valid = false;
		}else{
			$scope.required_level1 = false;
		}
		if(product_level2_id == "" || typeof product_level2_id == "undefined"){
			$scope.required_level2 = true;
			console.log("name error");
			is_valid = false;
		}else{
			$scope.required_level2 = false;
		}
		if(product_valid_period == "" || typeof product_valid_period == "undefined"){
			$scope.required_valid_date = true;
			console.log("name error");
			is_valid = false;
		}else{
			$scope.required_valid_date = false;
		}
		if(product_price_sku == "" || typeof product_price_sku == "undefined" || isNaN(product_price_sku) || product_price_sku < 1){
			$scope.required_price = true;
			console.log("name error");
			is_valid = false;
		}else{
			$scope.required_price = false;
		}
		
		var myreg = /^\d{3}$/; 
		if(!myreg.test(product_service_type)) { 
			$scope.required_service_type = true;
			is_valid = false;
		}else{
			$scope.required_service_type = false;
		}
		// check card rule
		if(product_card_rule == "" || typeof product_card_rule == "undefined"){
			$scope.required_card_rule = true;
			console.log("name error");
			is_valid = false;
		}else{
			$scope.required_card_rule = false;
		}
		if(product_description == "" || product_description.length < 5){
			$scope.required_description = true;
			console.log("name error");
			is_valid = false;
		}else{
			$scope.required_description = false;
		}
		
		if(!is_valid) return;
		
		var formData = new FormData(document.getElementById("editForm"));
		//formData.append('image_file', document.getElementById("image_file").files[0]);
		if($scope.ajax_request == 0){
			$scope.ajax_request = 1;
			$scope.ajax_loading = true;
			$.ajax({
				url: "product/edit/" + $scope.product_id,
				type: 'POST',
				data:  formData,
				mimeType:"multipart/form-data",
				contentType: false,
				cache: false,
				processData:false,
				success: function(result, textStatus, jqXHR)
				{					
					$scope.ajax_request = 2;
					$scope.ajax_loading = false;
					try{
						var data = jQuery.parseJSON(result);
						if(data.status){	// Add / Edit Successfully Process
							console.log(data.db_id);
							
							var view_url = '#!/product/view/' + data.db_id;
							var price_url = '#!/price/edit/' + data.db_id;
							
							if(data.price_set){
								myDialogService.alert({
									title: lang.product_save_title,
									message: "“" + $scope.product.name + "” " + lang.product_save_message,
									button: lang.close,
									animation: "fade",
									callback: function(){
										history.back();
									}
								});
							}else{
								if(is_mobile){	// Mobile confirm dialog display
									$("#save_result_dlg").modal({backdrop: 'static', keyboard: false});
									$("#save_result_dlg .cancelbtn").click(function () {
										var modalInstance = $('#save_result_dlg').modal('toggle');
										$("#save_result_dlg").on("hidden.bs.modal", function () {
											//$window.location.href = view_url;
											history.back();
										});
									});
									$("#save_result_dlg .generalbtn").click(function () {
										$('#save_result_dlg').modal('toggle'); 
										$("#save_result_dlg").on("hidden.bs.modal", function () {
											$window.location.href = price_url;
										});
									});
								}else{	// PC confirm dialog display
									var product_save_dlg = $("#productsave").dialog({
										autoOpen: false,
										resizable: false,
										height: "auto",
										width: 740,
										modal: true,
									});
									product_save_dlg.dialog("open");
									$("#productsave .cancelbtn").click(function () {
										product_save_dlg.dialog("close");
										//$window.location.href = view_url;
										history.back();
									});
									$("#productsave .generalbtn").click(function () {
										product_save_dlg.dialog("close");
										$window.location.href = price_url;
									});
								}
							}
						} else {
							$scope.ajax_request = 0;
							$scope.ajax_loading = false;
							myDialogService.alert({
								title: lang.product_save_title_fail,
								message: data.err_msg,
								button: lang.close,
								animation: "fade",
								callback: function(){
								}
							});
						}
					}catch(err){
						console.log(err);
						$scope.ajax_request = 0;
						$scope.ajax_loading = false;
						myDialogService.alert({
							title: lang.product_save_title_fail,
							message: lang.product_save_message_fail,
							button: lang.close,
							animation: "fade",
							callback: function(){
							}
						});
					}
					
				},
				error: function(jqXHR, textStatus, errorThrown) 
				{
					$scope.ajax_request = 0;
					$scope.ajax_loading = false;
					myDialogService.alert({
						title: lang.product_save_title_fail,
						message: lang.product_save_message_fail,
						button: lang.close,
						animation: "fade",
						callback: function(){
						}
					});
				}          
			});
		}else{
			return false;
		}	
	}
});

// Mobile product page controller
dingdingApp.controller('productAcitvationListController', function($scope, $rootScope, $http, PagerService, $route, $routeParams, myDialogService) {
	
	// Config variables
	$scope.pagenum = 1;
	$scope.typelist;
	$scope.itemcount_perpage = 5;
	if(is_mobile) $scope.itemcount_perpage = 8;
	$scope.search = {level1_type: '', level2_type: '', keyword: '', status: 1};
	
	
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
			// 	console.log('go to overview');
			// 	e.preventDefault();
			// 	window.location = "#!/overview";
			// }, false);
			//backButtonUrl = "#!/overview";
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
				title : lang.activation_title,// 产品, 选择产品
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
						{ // +分类管理 menu
							"id":"1",
							"text":lang.title_product_type_manage
						},
					],
					onSuccess: function(data) {
						window.location = "#!/product/class/list";
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
		//});
	}
	// PC Menu
	else{
		$rootScope.route_status = 'product';
	}
	
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
	$scope.items = [];
	function get_page_list(pagenum, itemcount, search){
		$scope.loaded =  false;
		$scope.busy = true;
		$scope.no_data = false;
		$http.get('product/activelist/' + JSON.stringify(search) + '/' + itemcount + '/' + pagenum).then(
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
					if(items.length == 0){
						$scope.nodata = true;
					}else{
						$scope.nodata = false;
					}
					for (var i = 0; i < items.length; i++) {
						$scope.items.push(items[i]);
					}

					if ($scope.items.length == 0)
    					$scope.no_data = true;
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

	$scope.setPage = function(pagenum){
		if(pagenum < 1) pagenum = 1;
		else if(pagenum > $scope.list_data.last_page) pagenum = $scope.list_data.last_page;
		get_page_list(pagenum, $scope.itemcount_perpage, $scope.search);
	}
	
	$scope.search_change = function(){
		get_page_list(1, $scope.itemcount_perpage, $scope.search);
	}
	
	$scope.search_type1 = function(type1){
		$scope.search.level1_type = type1;
		get_page_list(1, $scope.itemcount_perpage, $scope.search);
	}
	
});
// Mobile product view page controller
dingdingApp.controller('acivationViewController', function($scope, $rootScope, $http, $route, $routeParams, myDialogService) {
	if(typeof $routeParams.product_id == "undefined") {
		$scope.product_id = '0';
	} else {
		$scope.product_id = $routeParams.product_id;
	}
	
	$scope.loaded =  false;
	$http.get(base_url + 'product/get/item/' + $routeParams.product_id).then(
		function(response){
			if(response.status == 200 && response.data.status){
				$scope.product = response.data.value;
				$scope.loaded =  true;
			}
		}
	);

	// Mobile dingding Menu
	if(is_mobile){
		//dd.ready(function() {
			// When back button closed
			// document.addEventListener('backbutton', function(e) {
			// 	e.preventDefault();
			// 	window.location = "#!/product";
			// }, false);
			//backButtonUrl = "#!/activation";
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
				title : lang.activation_title,// 一年延保卡
				onSuccess : function(result) {
				},
				onFail : function(err) {}
			});

			switch (user_priv) {
			case 'admin':
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
						// Modal dialog
						window.location = "#!/product/edit/" + $scope.product_id;
						console.log(data);
					},
					onFail: function(err) {
						console.log(err);
					}
				});
				break;
			case 'dealer':
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
			case 'seller':
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
		$rootScope.route_status = 'product';
	}
	
	
});
// Mobile product active page controller only seller
dingdingApp.controller('productActiveController', function($scope, $rootScope, $route, $routeParams, $http, $window, myDialogService) {
	$scope.onQRScan = function() {
		dd.biz.util.scan({
			type: 'barCode' , // type 为 all、qrCode、barCode，默认是all。
			onSuccess: function(data) {
				console.log(data);
				$("#check_code").val(data.text);
			},
			onFail : function(err) {
			}
		});
	}
	
	if(typeof $routeParams.card_id == "undefined") {
		$scope.card_id = '0';
		var menu_title = lang.ac_phy_card_title;
		
		//return false;
	} else {
		$scope.card_id = $routeParams.card_id;
		var menu_title = lang.ac_vir_card_title;
	}
	
	$scope.loaded =  false;
	$http.get(base_url + 'product/getcard/item/' + $scope.card_id).then(
		function(response){
			if(response.status == 200 && response.data.status){
				$scope.product = response.data.value;
				$scope.loaded =  true;
				console.log($scope.product);
			}
			$(".product_content").css("display", "block");
		}
	);
	// Mobile dingding Menu
	if(is_mobile){
		//dd.ready(function() {
			// When back button closed
			// document.addEventListener('backbutton', function(e) {
			// 	e.preventDefault();
			// 	window.location = "#!/product/view/" + $scope.product_id;
			// }, false);
			//backButtonUrl = "#!/overview";
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
				title : lang.menu_title,// 一年延保卡
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
		$scope.activeresult = false;
		$scope.ajax_loading = false;
		
		$scope.activation = function(){
			
			// invalidation check
			$scope.phonecheck = false;
			
			var user_name = $("#user_name").val();
			var user_phone = $("#user_phone").val();
			
			//console.log("sdfsdf");
			if (!$("#check_code").val()){
				$("#check_code").focus();
				return false;
			}
			
			if (user_phone.length > 1 || user_name.length > 1){
				var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/; 
				if(!myreg.test(user_phone)) { 
					$("#user_phone").focus();
					$scope.phonecheck = true;
					return false; 
				}
				
				if(user_name.length < 1){
					$("#user_name").focus();
					return false; 
				}
			}
			
			var data = {
				check_code: $("#check_code").val(),
				'user_name' : user_name,
				'user_phone' : user_phone,
				//check_pass: $("#check_pass").val(),
				/* card_id: $scope.card_id,
				product_id: $scope.product.id, */
				status: 1
			}
			if($scope.ajax_loading === false){				
				$scope.ajax_loading = true;
				$http.post('/card/active', data).then(function (response) {
					//console.log(response.data);
					if (response.data.status == '0'){	
						$("#activation_dlg").modal({backdrop: 'static', keyboard: false});					
						$("#activation_dlg .confirm").click(function () {
							var modalInstance = $('#activation_dlg').modal('toggle');
							$("#activation_dlg").on("hidden.bs.modal", function () {
								if(parseInt(response.data.card_id)>0){
									$window.location.href = "#!register/edit/"+ response.data.product_id + "/" + response.data.card_id;
								}else{
									$window.location.href = "#!overview";
								}
								$scope.ajax_loading = false;
							});
						});
					}else if(response.data.status == '1'){
						$scope.ajax_loading = false;
						myDialogService.alert({
							title: lang.product_save_title_fail,
							message: lang.ac_card_exist_title,
							button: lang.close,
							animation: "fade",
							callback: function(){
							}
						});
					}else if(response.data.status == '2'){
						$scope.ajax_loading = false;
						myDialogService.alert({
							title: lang.product_save_title_fail,
							message: lang.ac_card_avtivated_title,
							button: lang.close,
							animation: "fade",
							callback: function(){
							}
						});
					}						
						
				}, function (response) {
					return response;
				});
			}else{
				return false;
			}	
		}
	}
	// PC Menu
	else{
		$rootScope.route_status = 'product';
	}
});
