dingdingApp.config(function($routeProvider) {
	$routeProvider
	
	/********************************
		Overview       
			[manager, dealer, seller]
	********************************/
		// overview page {pc, mobile}   [manager, dealer, seller]
		.when("/", {
			templateUrl : base_url + 'overview',
			controller: 'overviewController',
		})
		.when("/overview", {
			templateUrl : base_url + 'overview',
			controller: 'overviewController',
		})
		// overview list page {pc}
		.when("/overview/list", {
			templateUrl : base_url + 'overview/list',
			controller: 'overviewController',
		})
		// overview code page {pc}
		.when("/overview/code", {
			templateUrl : base_url + 'overview/code',
			controller: 'overviewController',
		})
	

	/********************************
		Product       
			[manager, dealer, seller]
	********************************/
		.when("/product", {
			templateUrl : base_url + "product",
			controller: 'productController',
		})
		.when("/product/view/:product_id", {
			templateUrl : base_url + "product/view",
			controller: 'productController',
		})
		.when("/product/edit/:product_id", {
			templateUrl : base_url + "product/edit",
			controller: 'productController',
		})
		.when("/product/class/list", {				//product class page   [manager]
			templateUrl : base_url + "product/class",
			controller: 'productClassListController',
		})
		.when("/product/categ", {
			templateUrl : base_url + "product/categ",
			controller: 'productController',
		})
	
	
	/********************************
		Price       
			[manager, dealer]
	********************************/
	
		.when("/price", {							//list page		[admin, dealer]
			templateUrl : base_url + "price",
			controller: 'priceController',
		})
		.when("/price/view/:product_id", {			//view page		[admin, dealer]
			templateUrl : base_url + "price/view",
			controller: 'priceController',
		})
		.when("/price/edit/:product_id", {			//edit page		[admin, dealer]
			templateUrl : base_url + "price/edit",
			controller: 'priceController',
		})
		.when("/price/discount/select", {			//select page 	[admin]
			templateUrl : base_url + "price/discount/select",
			controller: 'priceController',
		})
		.when("/price/discount/preview", {			//preview page	[admin]
			templateUrl : base_url + "price/discount/preview",
			controller: 'priceController',
		})
	
	
	/********************************
		Stock       
			[manager, dealer, seller]
	********************************/		
	
		.when("/stock", {							//Stock list page   [manager, dealer, seller]
			templateUrl : base_url + "stock",
			controller: 'stockController',
		})
		.when("/stock/view/:product_id", {			//Stock view page   [manager, dealer, seller]
			templateUrl : base_url + "stock/view",
			controller: 'stockController',
		})
		
	
	/********************************
		Purchase (进货)
			[dealer]
	********************************/
		.when("/purchase", {
			templateUrl : base_url + "purchase",
			controller: 'purchaseController',
		})
		
	

	/********************************
		Generate (生成)
			[Manager]
	********************************/
		.when("/generate", {						//generate list page   [manager]
			templateUrl : base_url + "generate",
			//controller: 'generateController',
		})
		
	
	/********************************
		Order (订单)
			[Manager， dealer]
	********************************/
		.when("/order", {							//Order list page   [manager, dealer, seller]
			templateUrl : base_url + "order/type/1",
			controller: 'orderController',
		})
		.when("/order/type/:type", {				//Order list page   [manager, dealer, seller]
			templateUrl : function(attr){
				return base_url + "order/type/" + attr.type;
			},
			controller: 'orderController',
		})
		.when("/order/view/:order_id", {			//Order view page   [manager, dealer, seller]
			templateUrl : function(attr){
				return base_url + "order/view/" + attr.order_id;
			},
			controller: 'orderController',
		})
		
	
	/********************************
		Sales amount (销量)
			[Manager， dealer, seller]
	********************************/
		.when("/sales", {
			templateUrl : base_url + "sales/rank/product",
			controller: 'salesController',
		})
		.when("/sales/rank/product", {
			templateUrl : base_url + "sales/rank/product",
			controller: 'salesController',
		})
		.when("/sales/rank/income", {
			templateUrl : base_url + "sales/rank/income",
			controller: 'salesController',
		})
		.when("/sales/rank/sale", {
			templateUrl : base_url + "sales/rank/sale",
			controller: 'salesController',
		})
		.when("/sales/rank/dealer", {
			templateUrl : base_url + "sales/rank/dealer",
			controller: 'salesController',
		})
	
	
	/********************************
		Reward (红包)
			[Manager， dealer, seller]
	********************************/
	
		.when("/reward", {
			templateUrl : base_url + "reward/office/1",
			controller: 'rewardController',
		})
		.when("/reward/office/:type", {				//Reward list page   [manager, dealer]
			templateUrl : function(attr){
				return base_url + "reward/office/" + attr.type;
			},
			//controller: 'rewardOfficeController',
		})
	
	
	/********************************
		User (人员 和 经销商)
			[Manager， dealer]
	********************************/
		
		.when("/user/employee", {					//Dealerpoint employee list page   [dealer]
			templateUrl : base_url + "user/employee",
			controller: 'userEmployeeController',
		})
		.when("/user/dealer", {						//Dealerpoint list page [manager]
			templateUrl : base_url + "user/dealer",
			controller: 'userDealerController',
		})
		// .when("/user/dealer/:type", {				//Dealerpoint list page [manager]
		// 	templateUrl : base_url + "user/dealer",
		// 	controller: 'userDealerController',
		// })
		.when("/user/dealer/view/:dealer_id", {		//Dealerpoint view page [manager]
			templateUrl : function(attr){
				return base_url + "user/dealer/view/" + attr.dealer_id;
			},
			//controller: 'userDealerViewController',
		})

	
	/********************************
		Log 
			{pc}, [Manager]
	********************************/
		.when("/log", {
			templateUrl : base_url + "log",
			controller: 'logController',
		})
		
	/********************************
		Log 
			{pc}, [Manager]
	********************************/
		.when("/setting", {
			templateUrl : base_url + "setting",
			controller: 'settingController',
		})
		
		
	/********************************
		Message
			[Manager， dealer, seller]
	********************************/
		.when("/message", {
			templateUrl : base_url + "message"
		})
		
	.otherwise({
		redirectTo: '/start'
	});
});	