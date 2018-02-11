
// Mobile sales rank product controller
dingdingApp.controller('salesRankProductController', function($scope, $rootScope, $http, PagerService, $route, $routeParams, myDialogService) {		

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
			// Setup title
			dd.biz.navigation.setTitle({
				title : lang.title_sales_amount,// 销量
				onSuccess : function(result) {
				},
				onFail : function(err) {}
			});

			// Setup menus
			/*dd.biz.navigation.setMenu({
				backgroundColor : "#ffffff",
				textColor : "#000000",
				items : [
					{ // 本周 menu
						"id":"0",
						"text":lang.menu_this_week
					},
					{ // 当月 menu
						"id":"1",
						"text":lang.menu_this_month
					},
					{ // 季度 menu
						"id":"2",
						"text":lang.menu_this_quater
					},
					{ // 一年 menu
						"id":"3",
						"text":lang.menu_this_year
					},
					{ // 自定义 menu
						"id":"4",
						"text":lang.menu_custom
					}
				],
				onSuccess: function(data) {
					switch (data.id) {
					case '0':
						// period this week
						break;
					case '1':
						// period this month
						break;
					case '2':
						// period this season
						break;
					case '3':
						// period this year
						break;
					case '4':
						// custom period
						break;
					}
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
	else{
		$rootScope.route_status = 'sales';
	}
	
	$scope.pagenum = 1;	
	$scope.itemcount_perpage = 6;
	if(is_mobile) $scope.itemcount_perpage = 12;
	$scope.search = {type: 1, start_date: '', end_date: ''};
	
	/*******************************
		start date, end date init
	*******************************/
	if(typeof $routeParams.search != "undefined") {
		search_option = JSON.parse(b64DecodeUnicode($routeParams.search));
		Object.keys(search_option).forEach(function(key) {
			if(typeof $scope.search[key] != "undefined") $scope.search[key] = search_option[key];
		});
	}
	
	if(!is_mobile && $scope.search.start_date == '' && $scope.search.end_date == ''){
		var curr = new Date;
		$scope.search.end_date = curr.getFullYear() + '-' + (curr.getMonth() + 1) + '-' + curr.getDate();
		var firstday = new Date(curr.setDate(curr.getDate() - curr.getDay()));
		$scope.search.start_date = firstday.getFullYear() + '-' + (firstday.getMonth() + 1) + '-' + firstday.getDate();
		if(is_mobile) $scope.search.start_date = (firstday.getFullYear() - 1) + '-' + (firstday.getMonth() + 1) + '-' + firstday.getDate();
	}
	
	/*******************************
		date picker part
	*******************************/
	if(!is_mobile){
		moment.locale('zh-cn'); 
		$(".weekpicker").daterangepicker({
			minDate: moment().subtract(3, 'years'),
			single: true,
			startDate: $scope.search.start_date,
			orientation: 'left',
			period: 'week'
		}, function (startDate, endDate, period) {
			$scope.search.type = 1;
			$scope.search_period(startDate.format("YYYY-MM-DD"), endDate.format("YYYY-MM-DD"));
		});
		$(".monthpicker").daterangepicker({
			minDate: moment().subtract(3, 'years'),
			single: true,
			startDate: $scope.search.start_date,
			orientation: 'left',
			period: 'month'
		}, function (startDate, endDate, period) {
			$scope.search.type = 2;
			$scope.search_period(startDate.format("YYYY-MM-DD"), endDate.format("YYYY-MM-DD"));
		});
		$(".quaterpicker").daterangepicker({
			minDate: moment().subtract(3, 'years'),
			single: true,
			startDate: $scope.search.start_date,
			orientation: 'left',
			period: 'quarter'
		}, function (startDate, endDate, period) {
			$scope.search.type = 3;
			$scope.search_period(startDate.format("YYYY-MM-DD"), endDate.format("YYYY-MM-DD"));
		});
		$(".yearpicker").daterangepicker({
			minDate: moment().subtract(3, 'years'),
			single: true,
			startDate: $scope.search.start_date,
			orientation: 'left',
			period: 'year'
		}, function (startDate, endDate, period) {
			$scope.search.type = 4;
			$scope.search_period(startDate.format("YYYY-MM-DD"), endDate.format("YYYY-MM-DD"));
		});
		$scope.search_period = function(start_date, end_date){
			$scope.search.start_date = start_date;
			$scope.search.end_date = end_date;
			location.href = "#!/sales/rank/product/search/" + b64EncodeUnicode(JSON.stringify($scope.search));
		}
		$scope.search_date = function(){
			location.href = "#!/sales/rank/product/search/" + b64EncodeUnicode(JSON.stringify($scope.search));
		}
	}
	
	/*******************************
		data load
	*******************************/
	$scope.nodata = false;
	function get_page_list(pagenum, itemcount, search){
		$scope.loaded =  false;
		$scope.busy = true;
		$http.get('sales/rank/product/list/' + JSON.stringify(search) + '/' + itemcount + '/' + pagenum).then(
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
					console.log($scope.items);
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
			}
		);
	}
	
	get_page_list($scope.pagenum, $scope.itemcount_perpage, $scope.search);
	
	$scope.setPage = function(pagenum){
		if(pagenum < 1) pagenum = 1;
		else if(pagenum > $scope.list_data.last_page) pagenum = $scope.list_data.last_page;
		get_page_list(pagenum, $scope.itemcount_perpage, $scope.search);
	}
});

// Mobile sales rank income controller
dingdingApp.controller('salesRankIncomeController', function($scope, $rootScope, $http, PagerService, $route, $routeParams, myDialogService) {		

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
			// Setup title
			dd.biz.navigation.setTitle({
				title : lang.title_sales_amount,// 销量
				onSuccess : function(result) {
				},
				onFail : function(err) {}
			});

			// Setup menus
			/*dd.biz.navigation.setMenu({
				backgroundColor : "#ffffff",
				textColor : "#000000",
				items : [
					{ // 本周 menu
						"id":"0",
						"text":lang.menu_this_week
					},
					{ // 当月 menu
						"id":"1",
						"text":lang.menu_this_month
					},
					{ // 季度 menu
						"id":"2",
						"text":lang.menu_this_quater
					},
					{ // 一年 menu
						"id":"3",
						"text":lang.menu_this_year
					},
					{ // 自定义 menu
						"id":"4",
						"text":lang.menu_custom
					}
				],
				onSuccess: function(data) {
					switch (data.id) {
					case '0':
						// period this week
						break;
					case '1':
						// period this month
						break;
					case '2':
						// period this season
						break;
					case '3':
						// period this year
						break;
					case '4':
						// custom period
						break;
					}
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
	else{
		$rootScope.route_status = 'sales';
	}
	
	
	$scope.pagenum = 1;	
	$scope.itemcount_perpage = 6;
	if(is_mobile) $scope.itemcount_perpage = 12;
	$scope.search = {type: 1, start_date: '', end_date: ''};
	
	/*******************************
		start date, end date init
	*******************************/
	if(typeof $routeParams.search != "undefined") {
		search_option = JSON.parse(b64DecodeUnicode($routeParams.search));
		Object.keys(search_option).forEach(function(key) {
			if(typeof $scope.search[key] != "undefined") $scope.search[key] = search_option[key];
		});
	}
	
	if(!is_mobile && $scope.search.start_date == '' && $scope.search.end_date == ''){
		var curr = new Date;
		$scope.search.end_date = curr.getFullYear() + '-' + (curr.getMonth() + 1) + '-' + curr.getDate();
		var firstday = new Date(curr.setDate(curr.getDate() - curr.getDay()));
		$scope.search.start_date = firstday.getFullYear() + '-' + (firstday.getMonth() + 1) + '-' + firstday.getDate();
		if(is_mobile) $scope.search.start_date = (firstday.getFullYear() - 1) + '-' + (firstday.getMonth() + 1) + '-' + firstday.getDate();
	}
	
	/*******************************
		date picker part
	*******************************/
	if(!is_mobile){
		moment.locale('zh-cn'); 
		$(".weekpicker").daterangepicker({
			minDate: moment().subtract(3, 'years'),
			single: true,
			startDate: $scope.search.start_date,
			orientation: 'left',
			period: 'week'
		}, function (startDate, endDate, period) {
			$scope.search.type = 1;
			$scope.search_period(startDate.format("YYYY-MM-DD"), endDate.format("YYYY-MM-DD"));
		});
		$(".monthpicker").daterangepicker({
			minDate: moment().subtract(3, 'years'),
			single: true,
			startDate: $scope.search.start_date,
			orientation: 'left',
			period: 'month'
		}, function (startDate, endDate, period) {
			$scope.search.type = 2;
			$scope.search_period(startDate.format("YYYY-MM-DD"), endDate.format("YYYY-MM-DD"));
		});
		$(".quaterpicker").daterangepicker({
			minDate: moment().subtract(3, 'years'),
			single: true,
			startDate: $scope.search.start_date,
			orientation: 'left',
			period: 'quarter'
		}, function (startDate, endDate, period) {
			$scope.search.type = 3;
			$scope.search_period(startDate.format("YYYY-MM-DD"), endDate.format("YYYY-MM-DD"));
		});
		$(".yearpicker").daterangepicker({
			minDate: moment().subtract(3, 'years'),
			single: true,
			startDate: $scope.search.start_date,
			orientation: 'left',
			period: 'year'
		}, function (startDate, endDate, period) {
			$scope.search.type = 4;
			$scope.search_period(startDate.format("YYYY-MM-DD"), endDate.format("YYYY-MM-DD"));
		});
		$scope.search_period = function(start_date, end_date){
			$scope.search.start_date = start_date;
			$scope.search.end_date = end_date;
			location.href = "#!/sales/rank/income/search/" + b64EncodeUnicode(JSON.stringify($scope.search));
		}
		$scope.search_date = function(){
			location.href = "#!/sales/rank/income/search/" + b64EncodeUnicode(JSON.stringify($scope.search));
		}
	}
	
	/*******************************
		data load
	*******************************/
	$scope.nodata = false;
	function get_page_list(pagenum, itemcount, search){
		$scope.loaded =  false;
		$scope.busy = true;
		$http.get('sales/rank/income/list/' + JSON.stringify(search) + '/' + itemcount + '/' + pagenum).then(
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
					console.log($scope.items);
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
			}
		);
	}
	
	get_page_list($scope.pagenum, $scope.itemcount_perpage, $scope.search);
	
	$scope.setPage = function(pagenum){
		if(pagenum < 1) pagenum = 1;
		else if(pagenum > $scope.list_data.last_page) pagenum = $scope.list_data.last_page;
		get_page_list(pagenum, $scope.itemcount_perpage, $scope.search);
	}
});

// Mobile sales rank sale controller only dealer and seller
dingdingApp.controller('salesRankSaleController', function($scope, $rootScope, $http, PagerService, $route, $routeParams, myDialogService) {		

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
			// Setup title
			dd.biz.navigation.setTitle({
				title : lang.title_sales_amount,// 销量
				onSuccess : function(result) {
				},
				onFail : function(err) {}
			});

			// Setup menus
			/*dd.biz.navigation.setMenu({
				backgroundColor : "#ffffff",
				textColor : "#000000",
				items : [
					{ // 本周 menu
						"id":"0",
						"text":lang.menu_this_week
					},
					{ // 当月 menu
						"id":"1",
						"text":lang.menu_this_month
					},
					{ // 季度 menu
						"id":"2",
						"text":lang.menu_this_quater
					},
					{ // 一年 menu
						"id":"3",
						"text":lang.menu_this_year
					},
					{ // 自定义 menu
						"id":"4",
						"text":lang.menu_custom
					}
				],
				onSuccess: function(data) {
					switch (data.id) {
					case '0':
						// period this week
						break;
					case '1':
						// period this month
						break;
					case '2':
						// period this season
						break;
					case '3':
						// period this year
						break;
					case '4':
						// custom period
						break;
					}
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
	else{
		$rootScope.route_status = 'sales';
	}
	
	
	$scope.pagenum = 1;	
	$scope.itemcount_perpage = 6;
	if(is_mobile) $scope.itemcount_perpage = 12;
	$scope.search = {type: 1, start_date: '', end_date: ''};
	
	/*******************************
		start date, end date init
	*******************************/
	if(typeof $routeParams.search != "undefined") {
		search_option = JSON.parse(b64DecodeUnicode($routeParams.search));
		Object.keys(search_option).forEach(function(key) {
			if(typeof $scope.search[key] != "undefined") $scope.search[key] = search_option[key];
		});
	}
	
	if($scope.search.start_date == '' && $scope.search.end_date == ''){
		var curr = new Date;
		$scope.search.end_date = curr.getFullYear() + '-' + (curr.getMonth() + 1) + '-' + curr.getDate();
		var firstday = new Date(curr.setDate(curr.getDate() - curr.getDay()));
		$scope.search.start_date = firstday.getFullYear() + '-' + (firstday.getMonth() + 1) + '-' + firstday.getDate();
		if(is_mobile) $scope.search.start_date = (firstday.getFullYear() - 1) + '-' + (firstday.getMonth() + 1) + '-' + firstday.getDate();
	}
	
	/*******************************
		date picker part
	*******************************/
	if(!is_mobile){
		moment.locale('zh-cn'); 
		$(".weekpicker").daterangepicker({
			minDate: moment().subtract(3, 'years'),
			single: true,
			orientation: 'left',
			period: 'week'
		}, function (startDate, endDate, period) {
			$scope.search.type = 1;
			$scope.search_period(startDate.format("YYYY-MM-DD"), endDate.format("YYYY-MM-DD"));
		});
		$(".monthpicker").daterangepicker({
			minDate: moment().subtract(3, 'years'),
			single: true,
			orientation: 'left',
			period: 'month'
		}, function (startDate, endDate, period) {
			$scope.search.type = 2;
			$scope.search_period(startDate.format("YYYY-MM-DD"), endDate.format("YYYY-MM-DD"));
		});
		$(".quaterpicker").daterangepicker({
			minDate: moment().subtract(3, 'years'),
			single: true,
			orientation: 'left',
			period: 'quarter'
		}, function (startDate, endDate, period) {
			$scope.search.type = 3;
			$scope.search_period(startDate.format("YYYY-MM-DD"), endDate.format("YYYY-MM-DD"));
		});
		$(".yearpicker").daterangepicker({
			minDate: moment().subtract(3, 'years'),
			single: true,
			orientation: 'left',
			period: 'year'
		}, function (startDate, endDate, period) {
			$scope.search.type = 4;
			$scope.search_period(startDate.format("YYYY-MM-DD"), endDate.format("YYYY-MM-DD"));
		});
		$scope.search_period = function(start_date, end_date){
			$scope.search.start_date = start_date;
			$scope.search.end_date = end_date;
			location.href = "#!/sales/rank/sale/search/" + b64EncodeUnicode(JSON.stringify($scope.search));
		}
		$scope.search_date = function(){
			location.href = "#!/sales/rank/sale/search/" + b64EncodeUnicode(JSON.stringify($scope.search));
		}
	}
	
	/*******************************
		data load
	*******************************/
	$scope.nodata = false;
	function get_page_list(pagenum, itemcount, search){
		$scope.loaded =  false;
		$scope.busy = true;
		$http.get('sales/rank/sale/list/' + JSON.stringify(search) + '/' + itemcount + '/' + pagenum).then(
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
					console.log($scope.items);
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
			}
		);
	}
	
	get_page_list($scope.pagenum, $scope.itemcount_perpage, $scope.search);
	
	$scope.setPage = function(pagenum){
		if(pagenum < 1) pagenum = 1;
		else if(pagenum > $scope.list_data.last_page) pagenum = $scope.list_data.last_page;
		get_page_list(pagenum, $scope.itemcount_perpage, $scope.search);
	}
});

// Mobile sales rank dealer controller only admin
dingdingApp.controller('salesRankDealerController', function($scope, $rootScope, $http, PagerService, $route, $routeParams, myDialogService) {		

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
			// Setup title
			dd.biz.navigation.setTitle({
				title : lang.title_sales_amount,// 销量
				onSuccess : function(result) {
				},
				onFail : function(err) {}
			});

			// Setup menus
			/*dd.biz.navigation.setMenu({
				backgroundColor : "#ffffff",
				textColor : "#000000",
				items : [
					{ // 本周 menu
						"id":"0",
						"text":lang.menu_this_week
					},
					{ // 当月 menu
						"id":"1",
						"text":lang.menu_this_month
					},
					{ // 季度 menu
						"id":"2",
						"text":lang.menu_this_quater
					},
					{ // 一年 menu
						"id":"3",
						"text":lang.menu_this_year
					},
					{ // 自定义 menu
						"id":"4",
						"text":lang.menu_custom
					}
				],
				onSuccess: function(data) {
					switch (data.id) {
					case '0':
						// period this week
						break;
					case '1':
						// period this month
						break;
					case '2':
						// period this season
						break;
					case '3':
						// period this year
						break;
					case '4':
						// custom period
						break;
					}
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
	else{
		$rootScope.route_status = 'sales';
	}
	
	
	$scope.pagenum = 1;	
	$scope.itemcount_perpage = 6;
	if(is_mobile) $scope.itemcount_perpage = 12;
	$scope.search = {type: 1, start_date: '', end_date: ''};
	
	/*******************************
		start date, end date init
	*******************************/
	if(typeof $routeParams.search != "undefined") {
		search_option = JSON.parse(b64DecodeUnicode($routeParams.search));
		Object.keys(search_option).forEach(function(key) {
			if(typeof $scope.search[key] != "undefined") $scope.search[key] = search_option[key];
		});
	}
	
	if($scope.search.start_date == '' && $scope.search.end_date == ''){
		var curr = new Date;
		$scope.search.end_date = curr.getFullYear() + '-' + (curr.getMonth() + 1) + '-' + curr.getDate();
		var firstday = new Date(curr.setDate(curr.getDate() - curr.getDay()));
		$scope.search.start_date = firstday.getFullYear() + '-' + (firstday.getMonth() + 1) + '-' + firstday.getDate();
		if(is_mobile) $scope.search.start_date = (firstday.getFullYear() - 1) + '-' + (firstday.getMonth() + 1) + '-' + firstday.getDate();
	}
	
	/*******************************
		date picker part
	*******************************/
	if(!is_mobile){
		moment.locale('zh-cn'); 
		$(".weekpicker").daterangepicker({
			minDate: moment().subtract(3, 'years'),
			single: true,
			startDate: $scope.search.start_date,
			orientation: 'left',
			period: 'week'
		}, function (startDate, endDate, period) {
			$scope.search.type = 1;
			$scope.search_period(startDate.format("YYYY-MM-DD"), endDate.format("YYYY-MM-DD"));
		});
		$(".monthpicker").daterangepicker({
			minDate: moment().subtract(3, 'years'),
			single: true,
			startDate: $scope.search.start_date,
			orientation: 'left',
			period: 'month'
		}, function (startDate, endDate, period) {
			$scope.search.type = 2;
			$scope.search_period(startDate.format("YYYY-MM-DD"), endDate.format("YYYY-MM-DD"));
		});
		$(".quaterpicker").daterangepicker({
			minDate: moment().subtract(3, 'years'),
			single: true,
			startDate: $scope.search.start_date,
			orientation: 'left',
			period: 'quarter'
		}, function (startDate, endDate, period) {
			$scope.search.type = 3;
			$scope.search_period(startDate.format("YYYY-MM-DD"), endDate.format("YYYY-MM-DD"));
		});
		$(".yearpicker").daterangepicker({
			minDate: moment().subtract(3, 'years'),
			single: true,
			startDate: $scope.search.start_date,
			orientation: 'left',
			period: 'year'
		}, function (startDate, endDate, period) {
			$scope.search.type = 4;
			$scope.search_period(startDate.format("YYYY-MM-DD"), endDate.format("YYYY-MM-DD"));
		});
		$scope.search_period = function(start_date, end_date){
			$scope.search.start_date = start_date;
			$scope.search.end_date = end_date;
			location.href = "#!/sales/rank/dealer/search/" + b64EncodeUnicode(JSON.stringify($scope.search));
		}
		$scope.search_date = function(){
			location.href = "#!/sales/rank/dealer/search/" + b64EncodeUnicode(JSON.stringify($scope.search));
		}
	}
	
	/*******************************
		data load
	*******************************/
	$scope.nodata = false;
	function get_page_list(pagenum, itemcount, search){
		$scope.loaded =  false;
		$scope.busy = true;
		$http.get('sales/rank/dealer/list/' + JSON.stringify(search) + '/' + itemcount + '/' + pagenum).then(
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
					console.log($scope.items);
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
			}
		);
	}
	
	get_page_list($scope.pagenum, $scope.itemcount_perpage, $scope.search);
	
	$scope.setPage = function(pagenum){
		if(pagenum < 1) pagenum = 1;
		else if(pagenum > $scope.list_data.last_page) pagenum = $scope.list_data.last_page;
		get_page_list(pagenum, $scope.itemcount_perpage, $scope.search);
	}
	
});