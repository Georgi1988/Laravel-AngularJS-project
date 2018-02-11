
// Mobile reward user controller only seller
dingdingApp.controller('rewardUserController', function($scope, $rootScope, $route, $routeParams, $http, PagerService, myDialogService) {	
	// Config variables
	$scope.pagenum = 1;
	$scope.itemcount_perpage = 6;

	function get_page_list(pagenum, itemcount) {
		if(is_mobile){
			if(pagenum == 1){
				$scope.available = response.data.available;
				delete $scope.items;
				$scope.items = [];
			}
		}
		$scope.no_data = false;
		$scope.loaded =  false;
		$scope.busy = true;
		$http.get('reward/get/user/' + itemcount + '/' + pagenum).then(
			function(response){
				console.log(response);
				$scope.busy = false;	// It is true when this is loading
				$scope.loaded = true;
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
				}
			}
		);
	}

	get_page_list(1, $scope.itemcount_perpage);

	// Mobile dingding Menu
	if(is_mobile){
		// Scroll event listener
		$(window).on('scroll', function(){
			if( $(window).scrollTop() >= $(document).height() - $(window).height() ) {
				if($scope.loaded && $scope.pagenum < $scope.last_page){
					get_page_list(($scope.pagenum + 1), $scope.itemcount_perpage);
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
			// When back button closed
			// document.addEventListener('backbutton', function(e) {
			// 	e.preventDefault();
			// 	window.location = "#!/overview";
			// }, false);

			// Setup title
			dd.biz.navigation.setTitle({
				title : lang.title_reward,// 奖励
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
		$rootScope.route_status = 'reward';
	}
});

// Mobile reward office controller only admin and dealer
dingdingApp.controller('rewardOfficeController', function($scope, $rootScope, $route, $routeParams, $http, PagerService, myDialogService) {
	// Mobile dingding Menu
	if(is_mobile){
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

		// Scroll event listener
		$(window).on('scroll', function(){
			if( $(window).scrollTop() >= $(document).height() - $(window).height() ) {
				if($scope.loaded && $scope.pagenum < $scope.last_page){
					get_page_list(($scope.pagenum + 1), $scope.itemcount_perpage, $scope.status);
				}
			}
		}).scroll();

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

			// Setup title
			dd.biz.navigation.setTitle({
				title : lang.title_reward,// 奖励
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
						{ // 奖励设置 menu
							"id":"1",
							"text":lang.btn_reward_setting
						},
					],
					onSuccess: function(data) {
						window.location = "#!/reward/setting/view";
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
			}
			console.log("Setup the menus");
		//});
	}
	// PC Menu
	else{
		$rootScope.route_status = 'reward';
	}

	// Config variables
	$scope.pagenum = 1;
	
	$scope.search = {type: 0, start_date: '', end_date: '', pagenum: 1};
	/*******************************
		searchoption init
	*******************************/
	if(typeof $routeParams.search != "undefined") {
		search_option = JSON.parse(b64DecodeUnicode($routeParams.search));
		Object.keys(search_option).forEach(function(key) {
			if(typeof $scope.search[key] != "undefined") $scope.search[key] = search_option[key];
		});
	}
	
	if(is_mobile){
		$scope.pagenum = 1;
	}else{
		$scope.pagenum = $scope.search.pagenum;
	}
	
	$scope.itemcount_perpage = 10;
	if(is_mobile) $scope.itemcount_perpage = 12;

	get_page_list(1, $scope.itemcount_perpage, $scope.search);
	
	function get_page_list(pagenum, itemcount, search) {
		if(is_mobile){
			if(pagenum == 1){
				delete $scope.items;
				$scope.items = [];
			}
		}
		$scope.no_data = false;
		$scope.loaded =  false;
		$scope.busy = true;
	
		
		url = "reward/get/list/" + JSON.stringify(search) + "/" + itemcount + "/" + pagenum;
		
		$http.get(url).then(
			function(response){
				//console.log(response);
				$scope.busy = false;	// It is true when this is loading
				$scope.loaded = true;
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
					if(response.status && response.data.status){
						console.log($scope.list_data);
						$scope.last_page = $scope.list_data.last_page;
						$scope.pagenation = PagerService.GetPager($scope.list_data.total, $scope.list_data.current_page, $scope.list_data.per_page, 10);
						if ($scope.list_data.data.length == 0) {
							$scope.no_data = true;
						}
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

	$scope.onGive = function(redpacket_id, dealer_name, user_name, redpacket_price) {
		$scope.redpacket_id = redpacket_id;
		$scope.sel_dealer_name = dealer_name;
		$scope.sel_user_name = user_name;
		$scope.sel_redpacket_price = redpacket_price;
		console.log(redpacket_id);
		if (!is_mobile)
			confirmDlg.dialog( "open" );
	}

	confirmDlg = $( "#redpacket_set" ).dialog({
		autoOpen: false,
		resizable: false,
		height: "auto",
		width: 740,
		modal: true,
	});

	$scope.onOK = function() {
		$http.get('reward/set/status/' + $scope.redpacket_id).then(
			function(response) {
				console.log(response.data);
				//$scope.product = response.data.value;
				if (response.data.success == true) {
					if (is_mobile)
						$('.reg_success_modal').modal('toggle');
					else
						confirmDlg.dialog( "close" );
					get_page_list(1, $scope.itemcount_perpage, $scope.search);
				}
			}
		);
		
	}

	$scope.onCancel = function() {
		confirmDlg.dialog( "close" );
	}
	
	$scope.date_srch_cancle = function() {
		$scope.search.start_date = '';
		$scope.search.end_date = '';
		get_page_list(1, $scope.itemcount_perpage, $scope.search);
	}

	$scope.onType = function(type) {
		$scope.search.type = type;
		get_page_list(1, $scope.itemcount_perpage, $scope.search);
	}
	
	$scope.onInputDate = function() {
		get_page_list(1, $scope.itemcount_perpage, $scope.search);
	}
	
	$scope.onRequireApply = function(redpacket_id) {
		myDialogService.confirm({
			title: lang.confirm,
			message: lang.rew_require_redpacket,
			confirm_txt: lang.confirm,
			cancle_txt: lang.cancel,
			success_callback: function(){
				$http.get('reward/set/require/' + redpacket_id).then(
					function(response) {
						if (response.data.success == true) {
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

// Mobile reward user controller only admin
dingdingApp.controller('rewardOfficeSettingViewController', function($scope, $rootScope, $http, $route, $routeParams, myDialogService) {
	// Mobile dingding Menu
	if(is_mobile){
		//dd.ready(function() {
			// When back button closed
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
		//});	
			// When back button closed
			// document.addEventListener('backbutton', function(e) {
			// 	e.preventDefault();
			// 	window.location = "#!/reward/office/list";
			// }, false);

			// Setup title
			dd.biz.navigation.setTitle({
				title : lang.title_reward_setting,// 奖励设置
				onSuccess : function(result) {
				},
				onFail : function(err) {}
			});

			// Setup menus
			dd.biz.navigation.setMenu({
				backgroundColor : "#ADD8E6",
				textColor : "#3399FF11",
				items : [
					{ // 保存 menu
						"id":"1",
						"text":lang.btn_save,
					},
				],
				onSuccess: function(data) {
					// Save the result
					//console.log(data);
					//window.location = "#!/reward/office/" + $scope.type;
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
		$rootScope.route_status = 'reward';
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
							window.location = "#!/reward/office/list";
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