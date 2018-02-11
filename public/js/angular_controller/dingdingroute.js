dingdingApp.config(function($routeProvider) {
	
	$routeProvider
	
	/********************************
		Overview       
			[manager, dealer, seller]
	********************************/
		// overview page   {pc, mobile} [manager, dealer, seller]
		.when("/overview", {
			templateUrl : base_url + 'overview',
			controller: 'overviewController',
		})
		// overview search page   {pc, mobile} [manager, dealer]
		.when("/overview/search/:search", {
			templateUrl : base_url + 'overview',
			controller: 'overviewController',
		})
		// overview list page   {pc} [manager, dealer]
		.when("/overview/list", {
			templateUrl : base_url + 'overview/list',
			controller: 'overviewListController',
		})
		// overview code page   {pc} [manager, dealer]
		.when("/overview/code", {
			templateUrl : base_url + 'overview/code',
			controller: 'overviewCodeController',
		})
		// overview code page   {mobile} [manager, dealer]
		.when("/overview/code/:success/:code", {
			templateUrl : base_url + 'overview/code',
			controller: 'overviewCodeController',
		})
	
	
	
	/********************************
		Product       
			[manager, dealer, seller]
	********************************/	
		.when("/product", {							//list page   {pc, mobile}   [manager, dealer, seller]
			templateUrl : base_url + "product",
			controller: 'productController',
		})
		.when("/product/:type", {					//list type page   {pc, mobile}   [manager, dealer, seller]
			templateUrl : base_url + "product",
			controller: 'productController',
		})
		.when("/product/view/:product_id", {		//view page   {pc, mobile}   [manager, dealer, seller]
			templateUrl : base_url + "product/view",
			controller: 'productViewController',
		})
		.when("/product/edit/:product_id", {		//edit page   {pc, mobile}   [manager]
			templateUrl : base_url + "product/edit",
			controller: 'productEditController',
		})
		.when("/product/class/list", {				//product class page   {pc, mobile}   [manager]
			templateUrl : base_url + "product/class",
			controller: 'productClassListController',
		})
		.when("/activation", {							//list page   {pc, mobile}   [manager, dealer, seller]
			templateUrl : base_url + "activation",
			controller: 'productAcitvationListController',
		})
		.when("/activation/active", {							//list page   {pc, mobile}   [manager, dealer, seller]
			templateUrl : base_url + "activation/physicalactive",
			controller: 'productActiveController',
		})
		.when("/activation/active/:card_id", {		//activation page   {mobile}   [seller]
			templateUrl : base_url + "activation/active",
			controller: 'productActiveController',
		})
		.when("/activation/view/:product_id", {		//view page   {pc, mobile}   [manager, dealer, seller]
			templateUrl : base_url + "activation/view",
			controller: 'acivationViewController',
		})
	
	
	/********************************
		Price       
			[manager, dealer]
	********************************/	
		.when("/price", {							//list page   {pc, mobile}		[admin, dealer]
			templateUrl : base_url + "price",
			controller: 'priceController',
		})
		.when("/price/:type", {						//list page   {pc, mobile}		[admin, dealer]
			templateUrl : base_url + "price",
			controller: 'priceController',
		})
		.when("/price/view/:product_id", {			//view page   {pc, mobile}		[admin, dealer]
			templateUrl : base_url + "price/view",
			controller: 'priceViewController',
		})
		.when("/price/edit/:product_id", {			//edit page   {pc, mobile}		[admin, dealer]
			templateUrl : base_url + "price/edit",
			controller: 'priceEditController',
		})
		.when("/price/discount/select/:product_id", {			//select page   {pc, mobile} 	[admin]
			templateUrl : base_url + "price/discount/select",
			controller: 'priceDiscountSelectController',
		})
		.when("/price/discount/input/:product_id/:dealers", {	//input page   {mobile} 	[admin]
			templateUrl : base_url + "price/discount/input",
			controller: 'priceDiscountInputController',
		})
		.when("/price/discount/input/:product_id/:dealers/:promotion", {	//input page   {mobile} 	[admin]
			templateUrl : base_url + "price/discount/input",
			controller: 'priceDiscountInputController',
		})
		.when("/price/discount/edit/:product_id", {			//edit discount of one product page   {pc, mobile}	[admin]
			templateUrl : base_url + "price/discount/edit",
			controller: 'priceDiscountEditController',
		})
		
	
	/********************************
		Register       
			[seller]
	********************************/	
		.when("/register/", {						//Register list page   {mobile}   [seller]
			templateUrl : base_url + "register",
			controller: 'registerController',
		})
		.when("/register/card/agree", {					//Register agree page   {mobile}   [seller]
			templateUrl : base_url + "register/view_agree",
			controller: 'registerAgreeController',
		})
		.when("/register/card/agree/:search", {					//Register agree page   {mobile}   [seller]
			templateUrl : base_url + "register/view_agree",
			controller: 'registerAgreeController',
		})
		.when("/register/card/agree/view_item/:card_id", {		//Register view page   {mobile}   [seller]
			templateUrl : base_url + "register/view_agree_item",
			controller: 'registerItemController',
		})
		.when("/register/:type", {					//Register type page   {mobile}   [seller]
			templateUrl : base_url + "register",
			controller: 'registerController',
		})
		.when("/register/edit/:product_id/:card_id", {		//Register view page   {mobile}   [seller]
			templateUrl : base_url + "register/edit",
			controller: 'registerEditController',
		})
	
	
	/********************************
		Stock       
			[manager, dealer, seller]
	********************************/
		//Stock list page by product   {pc, mobile}   [manager, dealer, seller]
		.when("/stock", {
			templateUrl : base_url + "stock/product",
			controller: 'stockByProductController',
		})
		//Stock list page with search option   [manager, dealer, seller]
		.when("/stock/search/:search", {
			templateUrl : base_url + "stock/product",
			controller: 'stockByProductController',
		})
		//Stock list page   {pc, mobile}   [manager, dealer, seller]
		.when("/stock/list/card", {
			templateUrl : base_url + "stock",
			controller: 'stockController',
		})
		//Stock list page with search option   [manager, dealer, seller]
		.when("/stock/list/card/search/:search", {
			templateUrl : base_url + "stock",
			controller: 'stockController',
		})
		//Stock view page   {pc, mobile}   [manager, dealer, seller]
		.when("/stock/view/:card_id", {
			templateUrl : base_url + "stock/view",
			controller: 'stockViewController',
		})
		//Stock add page   [dealer]
		.when("/stock/add/:product_id", {
			templateUrl : base_url + "stock/add",
			controller: 'stockAddController',
		})
		//Stock return page   [dealer]
		.when("/stock/return/:product_id", {
			templateUrl : base_url + "stock/return",
			controller: 'stockReturnController',
		})
		//bulk register view page   {pc}   [dealer]
		.when("/stock/bulk_register/:product_id", {
			templateUrl : base_url + "stock/bulk_register",
			controller: 'stockBulkRegisterController',
		})
		//Stock setting page   [manager, dealer]
		.when("/stock/setting/view/:type", {
			templateUrl : base_url + "stock/setting",
			controller: 'stockSettingViewController'
		})
	
	
	/********************************
		Purchase (进货)
			[dealer]
	********************************/
		.when("/purchase", {						//Purchase list page   {pc, mobile}   [dealer]
			templateUrl : base_url + "purchase",
			controller: 'purchaseController',
		})
		.when("/purchase/:type", {					//Purchase list page   {pc, mobile}   [dealer]
			templateUrl : base_url + "purchase",
			controller: 'purchaseController',
		})
	
	
	/********************************
		Generate (生成)
			[Manager]
	********************************/	
		.when("/generate", {						//generate list page   [manager]
			templateUrl : base_url + "generate",
			controller: 'generateController',
		})
		/* .when("/generate/:type", {						//generate list page   [manager]
			templateUrl : base_url + "generate",
			controller: 'generateController',
		}) */
		.when("/generate/card_rule", {						//generate list page   [manager]
			templateUrl : base_url + "generate/card_rule",
			controller: 'generateRuleController',
		})
		.when("/generate/card_rule/edit/:rule_id", {						//generate list page   [manager]
			templateUrl : base_url + "generate/card_rule/edit",
			controller: 'generateRuleEditController',
		})
		.when("/generate/dictionary/:keyword", {						//generate list page   [manager]
			templateUrl : base_url + "generate/dictionary",
			controller: 'generateDictionaryController',
		})
		.when("/generate/add/:product_id", {					//generate list page   [manager]
			templateUrl : base_url + "generate/add",
			controller: 'generateAddController',
		})
	
	
	
	/********************************
		Order (订单)
			[Manager， dealer]
	********************************/
		.when("/order", {										//Order view page   [manager, dealer]
			templateUrl : base_url + "order",
			controller: 'orderController',
		})
		.when("/order/list/:search", {							//Order view page   [manager, dealer]
			templateUrl : base_url + "order",
			controller: 'orderController',
		})
		.when("/order/view/:order_id", {						//Order view page   [manager, dealer]
			templateUrl : base_url + "order/view",
			controller: 'orderViewController',
		})
		.when("/order/setting/view/:type", {					//Order setting page {mobile}   [manager, dealer]
			templateUrl : base_url + "order/setting",
			controller: 'orderSettingViewController',
		})
	
	
	/********************************
		Sales amount (销量)
			[Manager， dealer, seller]
	********************************/
		//Sales list page	{pc, mobile}   [manager, dealer, seller]
		.when("/sales", {
			templateUrl : base_url + "sales/rank/product",
			controller: 'salesRankProductController',
		})
		// Sales list view page template ranked by product	{pc, mobile} [manager, dealer, seller]
		.when("/sales/rank/product", {
			templateUrl : base_url + "sales/rank/product",
			controller: 'salesRankProductController',
		})
		// Sales list page ranked by product	{pc, mobile} [manager, dealer, seller]
		.when("/sales/rank/product/search/:search", {
			templateUrl : base_url + "sales/rank/product",
			controller: 'salesRankProductController',
		})
		
		// Sales list view page template ranked by income	{pc, mobile} [manager, dealer, seller]
		.when("/sales/rank/income", {
			templateUrl : base_url + "sales/rank/income",
			controller: 'salesRankIncomeController',
		})
		// Sales list page ranked by income	{pc, mobile} [manager, dealer, seller]
		.when("/sales/rank/income/search/:search", {
			templateUrl : base_url + "sales/rank/income",
			controller: 'salesRankIncomeController',
		})
		
		// Sales list view page template ranked by sale	{pc, mobile} [dealer, seller]
		.when("/sales/rank/sale", {
			templateUrl : base_url + "sales/rank/sale",
			controller: 'salesRankSaleController',
		})
		// Sales list page ranked by sale	{pc, mobile} [dealer, seller]
		.when("/sales/rank/sale/search/:search", {				
			templateUrl : base_url + "sales/rank/sale",
			controller: 'salesRankSaleController',
		})
		
		// Sales list  view page template ranked by dealer	{pc, mobile} [manager]
		.when("/sales/rank/dealer", {				
			templateUrl : base_url + "sales/rank/dealer",
			controller: 'salesRankDealerController',
		})
		// Sales list page ranked by dealer	{pc, mobile} [manager]
		.when("/sales/rank/dealer/search/:search", {				
			templateUrl : base_url + "sales/rank/dealer",
			controller: 'salesRankDealerController',
		})
	
	
	/********************************
		Reward (红包)
			[Manager， dealer, seller]
	********************************/	
		.when("/reward/user", {						//Reward list page   [seller]
			templateUrl : base_url + "reward/user",
			controller: 'rewardUserController',
		})
		.when("/reward/office/list", {				//Reward list page   [manager, dealer]
			templateUrl : base_url + "reward/office/list",
			controller: 'rewardOfficeController',
		})
		.when("/reward/office/list/search/:search", {				//Reward list page   [manager, dealer]
			templateUrl : base_url + "reward/office/list",
			controller: 'rewardOfficeController',
		})

        /********************************
         Reward Setting(红包设定)
         [Manager]
         ********************************/
        .when("/reward/setting/view", {
            templateUrl : base_url + "reward/setting/view",
            controller: 'rewardSettingViewController',
        })
        .when("/reward/setting/edit/view", {
            templateUrl : base_url + "reward/setting/edit/view",
            controller: 'rewardSettingEditViewController',
        })
		.when("/reward/setting/edit/view/:redpacket_setting", {
            templateUrl : base_url + "reward/setting/edit/view",
            controller: 'rewardSettingEditViewController',
        })
        .when("/reward/setting/index/:itemcount/:pagenum", {
            templateUrl : base_url + "reward/setting/index",
            controller: 'rewardSettingViewController',
        })

        /********************************
		User (人员 和 经销商)
			[Manager， dealer]
		********************************/
    	// Dealerpoint employee list page   [dealer]
		.when("/user/employee/:dealer_id", {
			templateUrl : base_url + "user/employee",
            controller: 'userEmployeeController',
		})
        // Dealerpoint list page [manager]
		.when("/user/dealer/:dealer_id", {
            templateUrl : base_url + "user/dealer",
			controller: 'userDealerController',
		})
		.when("/user/dealer/view/:dealer_id", {
			templateUrl : base_url + "user/dealer/view",
			controller: 'userDealerViewController',
		})
        // Dealerpoint view page [manager]
		.when("/user/dealer/detail/:dealer_id", {
			templateUrl : base_url + "user/dealer/detail",
			controller: 'userDealerDetailController',
		})
        // Dealerpoint view page [manager]
		.when("/user/dealer/edit/:method/:subject/:dealer_id", {
			templateUrl : base_url + "user/dealer/edit",
			controller: 'userDealerEditController',
		})
    	// Dealerpoint view page [manager]
		.when("/user/staff/detail/:user_id", {
			templateUrl : base_url + "user/staff/detail",
			controller: 'userStaffDetailController',
		})
        .when("/user/new/:dealer_id", {
            templateUrl : base_url + "user/new",
            controller: 'userNewController',
        })
        // Dealerpoint view page [manager]
        .when("/user/staff/edit/:user_id", {
            templateUrl : base_url + "user/staff/edit",
            controller: 'userStaffEditController',
        })
        // Dealerpoint view page [manager]
		.when("/user/staff/edit/:user_id", {
			templateUrl : base_url + "user/staff/edit",
			controller: 'userStaffEditController',
		})
	
	/********************************
		Log 
			{pc}, [Manager]
	********************************/
		.when("/log", {
			templateUrl : base_url + "log",
			controller: 'LogController',
		})
		
	/********************************
		Setting 
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
		// Message list page [manager, dealer, seller]
		.when("/message", {
			templateUrl : base_url + "message",
			controller: 'messageController',
		})
		// Message list page with search option   [manager, dealer, seller]
		.when("/message/search/:search", {
			templateUrl : base_url + "message",
			controller: 'messageController',
		})
        // Message list page of kind   [manager, dealer, seller]
		.when("/message/:type", {
			templateUrl: base_url + "message",
			controller: 'messageController',
		})
        // Message list page of kind   [manager, dealer, seller]
		.when("/message/view/:message_id", {
			templateUrl: base_url + "message/view",
			controller: 'messageViewController',
		})
	
	/*
	.when("/statistics/dealer", {
		templateUrl : base_url + "statistics/dealer"
	})
	.when("/statistics/sales", {
		templateUrl : base_url + "statistics/sales"
	})
	.when("/user/client", {
		templateUrl : base_url + "user/client"
	})
	.when("/user/dealer", {
		templateUrl : base_url + "user/dealer"
	})
	.when("/user/sales", {
		templateUrl : base_url + "user/sales"
	}) */
	.otherwise({
		redirectTo: '/overview'
	});
});