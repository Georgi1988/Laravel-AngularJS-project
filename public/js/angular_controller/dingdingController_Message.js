
// Mobile message controller
dingdingApp.controller('messageController', function($scope, $rootScope, $http, PagerService, myDialogService, $route, $routeParams) {	
	
	// Config variables
	$scope.pagenum = 1;
	$scope.typelist;
	$scope.itemcount_perpage = 7;
	if(is_mobile) $scope.itemcount_perpage = 12;
	
	$scope.search = {type: '', keyword: ''};
	if(is_mobile) $scope.search = {type: '', keyword: ''};
	
	g_isNewMsg = false;
	
	if(typeof $routeParams.search != "undefined") {
		search_option = JSON.parse(b64DecodeUnicode($routeParams.search));
		Object.keys(search_option).forEach(function(key) {
			if(typeof $scope.search[key] != "undefined") $scope.search[key] = search_option[key];
		});
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
				title : lang.title_msg,// 通知
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

//			console.log("Setup the menus");
		//});
	}
	// PC Menu
	else{
		$(".emailalarm").css("display", "none");
		$rootScope.route_status = '';
	}
		
	get_page_list($scope.pagenum, $scope.itemcount_perpage, $scope.search);
	
	function get_page_list(pagenum, itemcount, search){
		$scope.loaded =  false;
		$scope.busy = true;
		$scope.no_data = false;
		$http.get('message/list/' + JSON.stringify(search) + '/' + itemcount + '/' + pagenum).then(
			function(response){
				$scope.busy = false;	// It is true when this is loading
				$scope.loaded =  true;
				if(is_mobile){
					if(pagenum == 1){
						delete $scope.items;
						$scope.items = [];
					}
					var list_data = response.data.list;
					$scope.unread_message = response.data.unread_message;
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

	$scope.setPage = function(pagenum){
		if(pagenum < 1) pagenum = 1;
		else if(pagenum > $scope.list_data.last_page) pagenum = $scope.list_data.last_page;
		get_page_list(pagenum, $scope.itemcount_perpage, $scope.search);
	}
	
	$scope.search_change = function(){
		get_page_list(1, $scope.itemcount_perpage, $scope.search);
	}
	
	$scope.search_type = function(type){
		$scope.search.type = type;
		get_page_list(1, $scope.itemcount_perpage, $scope.search);
	}
	
	messageInfoDlg = $( "#messageinfo" ).dialog({
		autoOpen: false,
		resizable: false,
		height: "auto",
		width: 740,
		modal: true,
	});
	
	$scope.view_message = function(message_html){
		$( "#messageinfo .message_content" ).html(message_html);
		messageInfoDlg.dialog( "open" );
	}
	
	$scope.close_dlg = function(){
		messageInfoDlg.dialog('close');
	}
	
	$scope.delete_selected = function(){
		var selected_list = [];
		$('input:checked.checkbox_list').each(function(index){
			selected_list[index] = $(this).val();
		});
		
		if(selected_list.length == 0){
			//custom_alert("Please select machine code to delete!", "Error");
			myDialogService.alert({
				title: lang.select_confirm_title,
				message: lang.successful_settle_balance,
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
				$http.post('message/delete', selected_list).then(
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

// Mobile message view controller
dingdingApp.controller('messageViewController', function($scope, $rootScope, $http, $route, $routeParams, myDialogService) {	
	if(typeof $routeParams.message_id == "undefined") {
		$scope.message_id = '0';
	} else {
		$scope.message_id = $routeParams.message_id;
	}

	// Mobile dingding Menu
	if(is_mobile){
		//dd.ready(function() {
			// When back button closed
			backButtonUrl = "#!/message";

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
			// 	window.location = "#!/message";
			// }, false);

			// Setup title
			dd.biz.navigation.setTitle({
				title : lang.title_msg_detail,// 通知详情
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

//			console.log("Setup the menus");
		//});
	}
	// PC Menu
	else{
		$rootScope.route_status = 'product';
	}
	
	
	$scope.loaded =  false;
	$http.get(base_url + 'message/get/item/' + $routeParams.message_id).then(
		function(response){
			if(response.status == 200 && response.data.status){
				$scope.item = response.data.value;
				$('.msg_content .content').html($scope.item.html_message);
				$scope.loaded =  true;
			}
		}
	);
});


// Mobile log view controller
dingdingApp.controller('logController', function($scope, $rootScope, $route, $routeParams, myDialogService) {
	if(!is_mobile) $rootScope.route_status = 'log';
});

// PC setting view controller
dingdingApp.controller('settingController', function($scope, $rootScope, $http, $route, $routeParams, myDialogService) {
	
	$scope.loaded =  false;
	
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
//				console.log(result);
				try{
					var data = jQuery.parseJSON(result);
					if(data.status){
						$('.alert').css('display', 'none');
						$('.alert-success').css('display', 'block');						
						window.setTimeout(function() { 
							$(".alert-success").hide(500);
						}, 6000);
//						console.log('saved!');
					}
				}catch(err){
//					console.log(err);
					alert('Server error occures!\n' + result);
					$('.alert').css('display', 'none');
					$('.alert-danger').css('display', 'block');
				}
				
			},
			error: function(jqXHR, textStatus, errorThrown) 
			{
				alert('Server error occured!\nError status: ' + textStatus);
			}          
		});
	}
});