
// Mobile generate controller only admin
dingdingApp.controller('generateController', function($scope, $rootScope, $route, $routeParams, $http, $window, generateCardAdd, PagerService, myDialogService) {
	if(typeof $routeParams.type == "undefined") {
		$scope.type = '0';
	} else {
		$scope.type = $routeParams.type;
	}
	
	// Mobile dingding Menu
	if(is_mobile){
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
				title : lang.title_select_card,// 选择服务卡
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
				
		generateCardAdd.getcateg().then(function(response){
			if(response.status == 200){					
				//console.log(response.data.level1_type);
				$scope.categitems = response.data.level1_type;	
			}else{
				console.log(response);
			}
		});
		$scope.items = [];
		$scope.activeMenu = '';
		$scope.view_by_categ = function(categ){
			$scope.activeMenu = categ;
			$scope.items = [];
			$scope.pagenum = 1;
			$scope.itemcount = 6;
			
			$scope.search = {level1_type: categ, level2_type: '', keyword: '', status: '1'};			
			$scope.get_page_list($scope.pagenum, $scope.itemcount, $scope.search);
		}
		$scope.nodata = false;
		
		$scope.get_page_list = function(pagenum, itemcount, search) {
			/* if (is_mobile) {
				if(pagenum == 1){
					delete $scope.items;
					$scope.items = [];
				}
			} */			
			if($scope.pagenum > 0){			
				$http.get('product/addlist/' + JSON.stringify(search) + '/' + itemcount + '/' + pagenum).then(
					function(response){
						console.log(response.data);
						if(pagenum == 1){
							delete $scope.items;
							$scope.items = [];
						}
						var items = response.data.list.data;
						$scope.dealers_1stlevel = response.data.dealers_1stlevel;
						var lastpage = response.data.list.last_page;
						
						if(items.length == 0){
							$scope.nodata = true;
						}else{
							$scope.nodata = false;
						}
						
						if(items.length > 0 && $scope.pagenum < lastpage){
							$scope.pagenum = $scope.pagenum + 1;						
						}else if($scope.pagenum == lastpage){
							$scope.pagenum = 0;
						}
						
						for (var i = 0; i < items.length; i++) {
							$scope.items.push(items[i]);
						}					
						
						return response.data.list;
					}
				);
			}
		}
		// Create the pageloader instance
		$scope.items = [];
		$scope.pagenum = 1;
		$scope.itemcount = 6;
		
        $scope.search = {level1_type: '', level2_type: '', keyword: '', status: '1'};
		// Scroll event listener
		$(window).on('scroll', function(){
			if( $(window).scrollTop() >= $(document).height() - $(window).height() ) {
				$scope.get_page_list($scope.pagenum, $scope.itemcount, $scope.search);
			}
		}).scroll();
	}
	// PC Menu
	else{
		if ($scope.$root && !$scope.$root.$$phase) {
			$scope.$apply();
		}
		$rootScope.route_status = 'generate';
		//heracles works
		$scope.purchaseAddManagerDlg = $( "#purchaseaddmanager" ).dialog({
			autoOpen: false,
			resizable: false,
			height: "auto",
			width: 740,
			modal: true,
		});
		$scope.purchaseAddManagerCheckDlg = $( "#purchaseaddmanagercheck" ).dialog({
			autoOpen: false,
			resizable: false,
			height: "auto",
			width: 400,
			modal: true,
		});
		$scope.generateCard = function(item) {
			//$scope.generateAddFormData.service_cards = "";
			//delete $scope.purchaseAddManagerDlg;
			
			$scope.purchaseAddManagerDlg.dialog( "open" );
			
			//heracles works
			//alert("ok");
			$scope.generateAddFormData = {};
			$scope.generateAddFormData = {
				product_id:item.id,
				service_card_name:item.name,
				service_card_code:item.code,
				valid_period: item.valid_period,
				service_typecode: item.service_type,
				service_card_types:{
					availableOptions: [
						{'val': 1, 'label': lang.physical_card},
						/* {'val': 0, 'label': lang.virtual_card} */
					],
					selectedOption: {'val': 1, 'label': lang.physical_card}
				},
				service_cards: "",
				card_rule: item.rule,
				send_dealer: '',
				/* card_rules:{
					availableOptions: [
						{'val': 0, 'label': 'DELL服务卡规则'}
					],
					selectedOption: {'val': 0, 'label': 'DELL服务卡规则'}
				} */
			};
			//console.log($scope.generateAddFormData);	
			
			// Card generate submit function 
			$scope.ajax_loading = false;
			$scope.submitForm = function(isValid) {	
				var data = {
					product_id: $scope.generateAddFormData.product_id,
					valid_period: $scope.generateAddFormData.valid_period,
					service_card_name: $scope.generateAddFormData.service_card_name,
					service_card_code: $scope.generateAddFormData.service_card_code,
					service_card_type: $scope.generateAddFormData.service_card_types.selectedOption.val,
					service_cards: $scope.generateAddFormData.service_cards,
					service_typecode: $scope.generateAddFormData.service_typecode,
					send_dealer: $scope.generateAddFormData.send_dealer,
					
					//card_rules: $scope.generateAddFormData.card_rules.selectedOption.val
				};	
					
				if (isValid) {
					
					$(".error_block").hide();
					if($scope.ajax_loading === false){
						$scope.ajax_loading = true;
						generateCardAdd.cardAdd(data).then(function(response){
							if(response.data.status == true){					
								$scope.purchaseAddManagerDlg.dialog( "close" );
								$scope.ajax_loading = false;
								
								$scope.purchaseAddManagerCheckDlg.dialog( "open" );
								console.log(response.data);
								
								/* location.href="#!stock"; */
							}else{
								$scope.ajax_loading = false;
								myDialogService.alert({
									title: lang.product_save_title_fail,
									// message: lang.gen_check_cardcount,
									message: response.data.err_msg,
									button: lang.close,
									animation: "fade",
									callback: function(){
										$(".error_block").show();
									}
								});
							}
								
						});  
					}else{
						return false;
					}
										
				}
			}
		};
		$scope.dialogclose = function() {
			$scope.purchaseAddManagerCheckDlg.dialog( "close" );
			$window.location.href="#!stock";
		}		
		
		$scope.pagenum = 1;
		$scope.itemcount = 5;
		$scope.search = {level1_type: '', level2_type: '', keyword: '', status: '1'};	
		
		generateCardAdd.getcateg().then(function(response){
			if(response.status == 200){					
				//console.log(response.data.level1_type);
				var level1_select = {id: "", description: "--" + lang['title_type1_lavel'] + "--"};
				$scope.categ1items =response.data.level1_type;
				$scope.categ1items.unshift(level1_select);
				$scope.selectedData1= $scope.categ1items[0];
				
				var level2_select = {id: "", description: "--" + lang['title_type2_lavel'] + "--"};
				$scope.categ2items =response.data.level2_type;
				$scope.categ2items.unshift(level2_select);
				$scope.selectedData2= $scope.categ2items[0];
			}else{
				console.log(response);
			}
		});
		$scope.nodata = false;
		$scope.get_page_list = function(pagenum, itemcount, search) {
			if($scope.pagenum > 0){			
				$http.get('product/addlist/' + JSON.stringify(search) + '/' + itemcount + '/' + pagenum).then(
					function(response){
						console.log(response.data);
						$scope.items = [];
						var items = response.data.list.data;
						$scope.dealers_1stlevel = response.data.dealers_1stlevel;
						$scope.list_data = response.data.list;
						
						if(items.length == 0){
							$scope.nodata = true;
						}else{
							$scope.nodata = false;
						}
						
						for (var i = 0; i < items.length; i++) {
							$scope.items.push(items[i]);
						}							
						
						$scope.pagenation = PagerService.GetPager($scope.list_data.total, $scope.list_data.current_page, $scope.list_data.per_page, 10);
						
						return response.data.list;
					}
				);
			}
		}
				
		$scope.setPage = function(pagenum){
			if(pagenum < 1) pagenum = 1;
			else if(pagenum > $scope.list_data.last_page) pagenum = $scope.list_data.last_page;
			$scope.get_page_list(pagenum, $scope.itemcount, $scope.search);
		}
		
		$scope.search_change = function(){
			$scope.search.level1_type = $scope.selectedData1.id;
			$scope.search.level2_type = $scope.selectedData2.id;
			$scope.search.keyword = $scope.searchword;
			
			$scope.get_page_list(1, $scope.itemcount, $scope.search);
		}
		
		$scope.get_page_list($scope.pagenum, $scope.itemcount, $scope.search);
	}
});



// Mobile generate add controller only admin
dingdingApp.controller('generateAddController', function($scope, $rootScope, $route,  $location, $window, $routeParams, $templateCache, generateCardAdd, myDialogService) {
	if(typeof $routeParams.product_id == "undefined") {
		$scope.product_id = '0';
	} else {
		$scope.product_id = $routeParams.product_id;
	}

	// Mobile dingding Menu
	if(is_mobile){
			// When back button closed
			//backButtonUrl = "#!/generate";
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
				title : lang.title_gen_new,// 生成服务卡
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

			
		if($scope.product_id != '0'){
			var data = {
				product_id: $scope.product_id
			};
			
			generateCardAdd.getProductItem(data).then(function(response){
			
				console.log(response);
				
				if(response.status == 200){
					console.log(response.data);					
					$scope.generateAddFormData = {
						product_id:response.data.value.id,
						service_card_name:response.data.value.name,
						service_card_code:response.data.value.code,
						service_typecode: response.data.value.service_type,
						product_typestr_level1:response.data.value.typestr_level1,
						product_typestr_level2:response.data.value.typestr_level2,
						product_typestr_level3:response.data.value.typestr_level3,
						dealers_1stlevel:response.data.dealers_1stlevel,
						service_card_types:{
							availableOptions: [
								{'val': 1, 'label': lang.physical_card},
							],
							selectedOption: {'val': 1, 'label': lang.physical_card}
						},
						service_cards: "",
						card_rule: response.data.value.rule,
						send_dealer: '',
						image_url: response.data.value.image_url,
						valid_period: response.data.value.valid_period
					};
					
					$scope.ajax_loading = false;
					$scope.submitForm = function(isValid) {				
						var data = {
							product_id: $scope.generateAddFormData.product_id,
							valid_period: $scope.generateAddFormData.valid_period,
							service_card_name: $scope.generateAddFormData.service_card_name,
							service_card_code: $scope.generateAddFormData.service_card_code,
							service_card_type: $scope.generateAddFormData.service_card_types.selectedOption.val,
							service_cards: $scope.generateAddFormData.service_cards,
							service_typecode: $scope.generateAddFormData.service_typecode,
							send_dealer: $scope.generateAddFormData.send_dealer,
						};
						
						if (isValid) {
							if($scope.ajax_loading === false){	
								$scope.ajax_loading = true;
								generateCardAdd.cardAdd(data).then(function(response){
									if(response.data.status == true){				
										console.log($scope.generateAddFormData.service_cards);
										$(".reg_success_modal").modal({backdrop: 'static', keyboard: false});
										
										$(".reg_success_modal .confirm").click(function () {
											var modalInstance = $('.reg_success_modal').modal('toggle');
											$(".reg_success_modal").on("hidden.bs.modal", function () {
												//$window.location.href = "#!stock";
												location.href = "#!stock";
											});
										});
										//$location.path("/stock");
									}else{
										$scope.ajax_loading = false;
										myDialogService.alert({
											title: lang.product_save_title_fail,
											/* message: lang.gen_check_cardcount, */
											message: response.data.err_msg,
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
					}
				}else{
					console.log(response.data);
				}
				$(".generateadd").css("display", "block");
			});
		}
		
	}
	// PC Menu
	else{
		$rootScope.route_status = 'generate';
		
		// Create the pageloader instance
		$scope.items = [];
		$scope.pagenum = 1;
		$scope.itemcount = 6;
	}
	
	//alert("ok");
});



// Card code rule list controller
dingdingApp.controller('generateRuleController', function($scope, $rootScope, $http, $window, PagerService, myDialogService, $route, $routeParams) {
	
	g_newProduct = 0;
	if (!is_mobile)	set_product_badge(0);
	
	// Config variables
	$scope.pagenum = 1;
	$scope.typelist;
	
	$scope.itemcount_perpage = 12;
	if(is_mobile) $scope.itemcount_perpage = 12;
	
	$scope.search = {};
	
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
			title : lang.title_gen_card_rule, // Card rule
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
		}
		console.log("Setup the menus");
	}
	// PC Menu
	else{
		$rootScope.route_status = 'generate';
	}
	
	get_page_list($scope.pagenum, $scope.itemcount_perpage, $scope.search);
	
	function get_page_list(pagenum, itemcount, search){
		$scope.loaded =  false;
		$scope.busy = true;
		$scope.no_data = false;
		$http.get('generate/card_rule/list/' + JSON.stringify(search) + '/' + itemcount + '/' + pagenum).then(
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
		$scope.pagenum = pagenum;
		get_page_list(pagenum, $scope.itemcount_perpage, $scope.search);
	}
	
	
	
	$scope.item_delete =  function(id) {
		
		console.log(id);
		
		myDialogService.confirm({
			title: lang.del_confirm_title,
			message: lang.del_confirm_message,
			confirm_txt: lang.confirm,
			cancle_txt: lang.cancel,
			success_callback: function(){
				$http.get('/generate/card_rule/delete/item/' + id).then(
					function(response){
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
	
});


// Card code rule edit controller [admin]
dingdingApp.controller('generateRuleEditController', function($scope, $rootScope, PagerService, $http, $timeout, $route, $routeParams, myDialogService) {
	
	$scope.search = {};
	$scope.rule_id = $routeParams.rule_id;
	
	$scope.ajax_getdata_loading = true;
	
	// Initial variables
	$scope.password_type = 'n';
	
	$http.get('/generate/card_rule/get/item/' + $scope.rule_id).then(
		function(response){
			$scope.ajax_getdata_loading = false;
			ajax_data = response.data;
			if(ajax_data.status){
				$scope.data = ajax_data.data;
				
				if($scope.rule_id != 0){
					
					$scope.card_rulename = ajax_data.data.rule.rule_name;
					$scope.card_length = ajax_data.data.rule.card_code_length;
					$scope.card_rule_template_id = ajax_data.data.rule.template_id;
					
					$scope.passwd_length = ajax_data.data.rule.password_length.toString();
					$scope.password_type = ajax_data.data.rule.password_type.toString();
					
					if(ajax_data.data.rule.template_id == 1){
						$scope.form1_service_type = ajax_data.data.rule.length_info_json.service_type.value;
					}else{
						$scope.form1_service_type = '';
					}
					
					if(ajax_data.data.rule.template_id == 2){
						$scope.form2_custom = ajax_data.data.rule.length_info_json.custom.value;
					}else{
						$scope.form2_custom = '';
					}
					
					if(ajax_data.data.rule.template_id == 3){
						$scope.form3_card_type = ajax_data.data.rule.length_info_json.card_type.value;
					}else{
						$scope.form3_card_type = '';
					}
					
					if(ajax_data.data.rule.template_id == 4){
						$scope.form4_custom1 = ajax_data.data.rule.length_info_json.custom1.value;
						$scope.form4_custom2 = ajax_data.data.rule.length_info_json.custom2.value;
					}else{
						$scope.form4_custom1 = '';
						$scope.form4_custom2 = '';
					}
					
					if(ajax_data.data.rule.template_id == 5){
						$scope.form5_custom1 = ajax_data.data.rule.length_info_json.custom1.value;
						$scope.form5_custom2 = ajax_data.data.rule.length_info_json.custom2.value;
					}else{
						$scope.form5_custom1 = '';
						$scope.form5_custom2 = '';
					}
					
					if(ajax_data.data.rule.template_id == 6){
						$scope.form6_custom1 = ajax_data.data.rule.length_info_json.custom1.value;
						$scope.form6_custom2 = ajax_data.data.rule.length_info_json.custom2.value;
					}else{
						$scope.form6_custom1 = '';
						$scope.form6_custom2 = '';
					}
				}
			}
			else{
				myDialogService.alert({
					title: lang.loading_failed_title,
					message: lang.loading_failed_msg,
					button: lang.close,
					animation: "fade",
					callback: function(){
						history.back();
					}
				});
			}
		}, function(response){
			myDialogService.alert({
				title: lang.loading_failed_title,
				message: lang.loading_failed_msg,
				button: lang.close,
				animation: "fade",
				callback: function(){
					history.back();
				}
			});
		}
	);
	
	// Card rule save post function
	$scope.save_cardrule = function(){
		
		// Validation check part
		
		$scope.required_name = false;
		$scope.required_length = false;
		$scope.required_fieldtype = false;
		$scope.required_pwd_length = false;
		$scope.check_required = [];
		$scope.check_invalid = [];
		
		if(!$scope.card_rulename){
			$("#card_rule_name").focus();
			$scope.required_name = true;
			return;
		}
		if(!$scope.card_length){
			$scope.required_length = true;
			return;
		}
		if(!$scope.card_rule_template_id){
			$scope.required_fieldtype = true;
			return;
		}
		if(!$scope.passwd_length){
			$scope.required_pwd_length = true;
			return;
		}
		
		var manual_field = [];
		var rule_temp = jQuery.parseJSON($scope.data.template.rules_by_id[$scope.card_rule_template_id].length_info);
		Object.keys(rule_temp).forEach(function(key) {
			if(rule_temp[key].select == "manual"){
				manual_field.push(key);
			}
		});
		
		var total_check_status = true;
		
		console.log(manual_field);
		
		manual_field.forEach(function(element) {
			//console.log(element);
			
			var item_val = $(	"#card_rule_form_" + $scope.card_rule_template_id + " input[name='json_" + element + "'], " + 
								"#card_rule_form_" + $scope.card_rule_template_id + " textarea[name='json_" + element + "'], " + 
								"#card_rule_form_" + $scope.card_rule_template_id + " select[name='json_" + element + "']").val();
			
			//console.log(item_val);
			
			if(item_val == '' || typeof item_val == "undefined" || item_val == '?'){
				$scope.check_required[element] = true;
				total_check_status &= false;
			}else{
				var letterNumber = /^[0-9a-zA-Z]+$/;
				var patt = /^[0-9a-zA-Z]+$/;
				
				if(!patt.test(item_val) || item_val.toString().length != rule_temp[element].length)
				{  
					$scope.check_invalid[element] = true;
					total_check_status &= false;
				}
			}
		});
		
		if(total_check_status == false) return;
		
		// Submit part
		
		if($scope.ajax_rule_loading != true){
			$scope.ajax_rule_loading = true;
			$scope.ajax_save_disable = true;
			
			var formData = new FormData(document.getElementById("card_rule_form_" + $scope.card_rule_template_id));
			
			formData.append('rule_name', $scope.card_rulename);
			formData.append('rule_template_id', $scope.card_rule_template_id);
			
			console.log(formData);
			
			$http.post("/generate/card_rule/edit/item/" + $scope.rule_id, formData, {
				headers: { 'Content-Type': undefined },
				transformRequest: angular.identity
			}).then(function (response, status, headers, config) {
				
				if(response.status == 200 && response.data.status){
					$scope.ajax_rule_loading = false;
					$(".alert-save-success").html(response.data.msg);
					$(".alert-save-success").show();
					$timeout(function() {
						$(".alert-save-success").hide();
						history.back();
						$scope.ajax_save_disable = false;
					}, 1000);
				}else{
					$scope.ajax_save_disable = false;
					$scope.ajax_rule_loading = false;
					$scope.ajaxloading_reg_agree = false;
					$(".alert-save-fail").html(response.data.err_msg);
					$(".alert-save-fail").show();
				}
				
			},function (data, status, headers, config) {
				$scope.ajax_save_disable = false;
				$scope.ajax_rule_loading = false;
				$scope.ajaxloading_reg_agree = false;
				$('.alert-save-fail').html(lang.rg_fail_save);						
				$('.alert-save-fail').show();
			});
		}
	}
	
});



// PC, Mobile product class list page controller only admin
dingdingApp.controller('generateDictionaryController', function($scope, $rootScope, PagerService, myDialogService, $http, $route, $routeParams) {
	
	$scope.pagenum = 1;
	$scope.itemcount_perpage = 10;
	if(is_mobile) $scope.itemcount_perpage = 30;
	
	$scope.search = {};
	$scope.search.keyword = $routeParams.keyword;;
	
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
		
		backButtonUrl = "";
		
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
			title : lang.title_gen_card_rule,
			onSuccess : function(result) {
			},
			onFail : function(err) {}
		});
		console.log("Setup the menus");
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
		$http.get('generate/dictionary/get/list/' + JSON.stringify(search) + '/' + itemcount + '/' + pagenum).then(
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
	
	$scope.item_delete =  function(id) {
		
		console.log(id);
		
		myDialogService.confirm({
			title: lang.del_confirm_title,
			message: lang.del_confirm_message,
			confirm_txt: lang.confirm,
			cancle_txt: lang.cancel,
			success_callback: function(){
				$http.get('/generate/dictionary/delete/item/' + id).then(
					function(response){
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
	
	var item_edit_dialog = $( "#item_edit_dialog" ).dialog({
		autoOpen: false,
		resizable: false,
		height: "auto",
		width: 740,
		modal: true,
	});
	
	// open dictionary item edit dialog function
	$scope.item_info_edit;
	$scope.item_edit_id;
	$scope.open_edit_dialog = function(id){
		
		$(".alert").hide();
		$scope.required_description = false;
		$scope.required_value = false;
		$scope.required_format = false;
		
		$scope.item_edit_id = id;
		$http.get('/generate/dictionary/get/item/' + id).then(
			function(response){
				data = response.data;
				if(data.status){
					$scope.item = data.value;
					$scope.item.keyword = $scope.search.keyword;
					item_edit_dialog.dialog( "open" );
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
			item_edit_dialog.dialog( "close" );
		}else{
			$(".reg_success_modal").modal('toggle');
		}
	}
	
	// Product class edit save function
	$scope.ajax_request = 0;
	$scope.ajax_loading = false;
	$scope.save_item = function(){
		
		var item_description = $scope.item.description;
		var item_value = $scope.item.value;
		
		if(item_description.length < 1){
			$('#item_description').focus();
			$scope.required_description = true;
			return;
		}else{
			$scope.required_description = false;
		}
		
		if(item_value.length < 1){
			$('#item_value').focus();
			$scope.required_value = true;
			return;
		}else{
			$scope.required_value = false;
		}
		
		var reg = /^$/;
		if($scope.search.keyword == "dic_retail"){
			reg = /^\d{4}$/;
			$scope.value_pattern_sample = " 中国-翰林汇 1001";
		}else if($scope.search.keyword == "dic_area"){
			reg = /^\d{4}$/;
			$scope.value_pattern_sample = " 西北 9001";
		}else if($scope.search.keyword == "dic_province"){
			reg = /^\d{2}$/;
			$scope.value_pattern_sample = " 河北省 12";
		}else if($scope.search.keyword == "dic_card_type"){
			reg = /^\d{2}$/;
			$scope.value_pattern_sample = " 礼品卡 - 16";
		}else if($scope.search.keyword == "dic_service_type"){
			reg = /^\d{3}$/;
			$scope.value_pattern_sample = " 908";
		}
		
		console.log(reg);
		console.log(item_value);
		
		if(!reg.test(item_value)) { 
			$('#item_value').focus();
			$scope.required_format = true;
			return false; 
		}else{
			$scope.required_format = false;
		}
		
		if($scope.ajax_request == 0){
			$scope.ajax_request = 1;
			$scope.ajax_loading = true;
			$http.post('/generate/dictionary/edit/item/' + $scope.item.id, 
				{
					'keyword': $scope.item.keyword, 
					'description': $scope.item.description,
					'value': $scope.item.value, 
				}
			).then(
				function(response){
					$scope.ajax_loading = false;
					if(response.status == 200 && response.data.status){
						var data = response.data;
						
						$(".alert").hide();
						$(".alert-success").html(data.msg);
						$(".alert-success").show();
						
						window.setTimeout(function() { 
							$scope.ajax_request = 0;
							$scope.close_edit_dialog();
							$route.reload();
						}, 500);
					}else{
						$scope.ajax_request = 0;
						$(".alert").hide();
						$(".alert-danger").html(response.data.err_msg);
						$(".alert-danger").show();
						window.setTimeout(function() { 
							$(".alert").hide(300);
						}, 3000);
					}
				}, function(response){
					$scope.ajax_request = 0;
					$(".alert").hide();
					$(".alert-danger").html(lang.rg_fail_save);
					$(".alert-danger").show();
					window.setTimeout(function() { 
						$(".alert").hide(300);
					}, 3000);
				}
			);
		}else{
			return false;
		}
		
	}
	
});
