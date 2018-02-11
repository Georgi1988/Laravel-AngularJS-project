<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/home', function(){
	
	$request = Request();
	$login_info = $request->session()->get('total_info');
	
	if($login_info === null){
		
		if (mProvider::$view_prefix == 'mobile.') {
			if ($request->server('HTTP_ACCEPT_LANGUAGE') == 'en-US' || $request->server('HTTP_ACCEPT_LANGUAGE') == 'en-us') {
				$request->session()->put('site_local', 'en');
			}
			else {
				$request->session()->put('site_local', 'cn');
			}
		}
		return view(mProvider::$view_prefix.'login', [
			'home_title' => '',
			'c_categ' => 'overview'
		]);
		//return redirect('/');
	}
	
	$user = App\User::find($login_info['user_id']);

	if (null !== $user)
	    $user->role = 0;

	$dealer = App\Dealer::find($login_info['dealer_id']);
	
	if($dealer !== null){
		if($dealer->stock_check_date != date("Y-m-d")){
			App\Stock::checkDaily($login_info['dealer_id'], $dealer->stock_check_date);
		}
	}
	
	return view(mProvider::$view_prefix.'home', [
		'user_info' => $user,
		'dealer_info' => $dealer
	]);
});

//////////////////////
// First Login page //
//////////////////////
Route::get('/', function() {
	$request = Request();
	//return var_dump($request);
	//var_dump(mProvider::$view_prefix);
	if (mProvider::$view_prefix == 'mobile.') {
		if ($request->server('HTTP_ACCEPT_LANGUAGE') == 'en-US' || $request->server('HTTP_ACCEPT_LANGUAGE') == 'en-us') {
			$request->session()->put('site_local', 'en');
			// echo "en success";
		}
		else {
			$request->session()->put('site_local', 'cn');
			// echo "cn success";
		}
	}
 	return view(mProvider::$view_prefix.'login', [
		//'home_title' => trans('lang.home_title')."-".trans('lang.label_overview'),
		'home_title' => '',
		'c_categ' => 'overview'
	]);
});

/************************************
	Overview Package
************************************/
	// overview view template page
	Route::get(
		'/overview', 
		'OverviewController@view_index'
	)->name('overview');
	Route::get(
		'/overview/stock_info/{search}',
		'OverviewController@get_stock_info'
	)->name('overview');
	// pc overview[admin only] list page
	Route::get(
		'/overview/code', 
		'OverviewController@view_code_page'
	)->name('overview.code');
	// pc overview[admin only] machine code list info ajax response
	Route::get(
		'overview/machine_code/list/{itemcount}/{pagenum}', 
		'OverviewController@get_code_list'
	)->name('overview.code.list');
	// pc overview[admin only] machine code delete info ajax response
	Route::post(
		'overview/machine_code/delete', 
		'OverviewController@delete_code_items'
	)->name('overview.code.delete');
	// pc overview[admin only] machine code import info ajax response
	Route::post(
		'overview/machine_code/import', 
		'OverviewController@import_code_file'
	)->name('overview.code.import');
	// mobile overview[admin only] machine code insert ajax request
	Route::get(
		'overview/machine_code/insert/{code}', 
		'OverviewController@insert_code'
	)->name('overview.code.insert');


/******************************
	Product Package 	
******************************/
	//activation list page
	Route::get(						// Product list view page	{pc, mobile} [manager, dealer, seller]
		'/activation', 
		'ProductController@view_activelist'
	)->name('activation');
	Route::get(						// Product item view page	{pc, mobile} [manager, dealer, seller]
		'/activation/view',
		'ProductController@view_item'
	)->name('activation.view');

	////// Product active page [seller]
	Route::get(						// Product item activate page	{mobile} [seller]
		'/activation/active', 
		'ProductController@active'
	)->name('product.active');
	Route::get(						// Product item activate page	{mobile} [seller]
		'/activation/physicalactive', 
		'ProductController@physicalactive'
	)->name('product.physicalactive');
	
	//card activate
	Route::post(						// Product item activate page	{mobile} [seller]
		'/card/active', 
		'ProductController@card_active'
	)->name('card.active');

	Route::post(						// Product item activate page	{mobile} [seller]
		'/card/register', 
		'ProductController@card_register'
	)->name('card.register');

	////// Product list page
	Route::get(						// Product list view page	{pc, mobile} [manager, dealer, seller]
		'/product', 
		'ProductController@view_list'
	)->name('product');
	Route::get(						// Product list info request
		'/product/list/{search_json}/{itemcount}/{pagenum}', 
		'ProductController@get_list'
	)->name('product.list');
	Route::get(						// generate list(Product list) info request
		'/product/generatelist/{search_json}/{itemcount}/{pagenum}', 
		'ProductController@get_generatelist'
	)->name('product.generatelist');
	Route::get(						// Card list join product info request
		'/product/cardlist/{search_json}/{itemcount}/{pagenum}', 
		'ProductController@get_cardlist'
	)->name('product.cardlist');

	// Product item view page	{pc, mobile} [manager, dealer, seller]
	Route::get(
		'/product/view',
		'ProductController@view_item'
	)->name('product.view');
	// Product item info request
	Route::get(
		'/product/get/item/{product_id}', 
		'ProductController@get_item'
	)->name('product.list');
	Route::get(						// Product item each info request
		'/product/get/item/{product_id}/{type_list_require}', 
		'ProductController@get_item'
	)->name('product.list');
	Route::get(						// Product item each info request
		'/product/get/item/{product_id}/{type_list_require}/{dealer_list_require}', 
		'ProductController@get_item'
	)->name('product.list');
	
	// Product item each info request
	Route::get(
		'/product/get/registeritem/{product_id}/{card_id}', 
		'ProductController@get_registeritem'
	)->name('product.registeritem');
	Route::get(
		'/product/getcard/item/{card_id}', 
		'ProductController@get_carditem'
	)->name('product.registeritem');
	////// Product edit page
	Route::get(						// Product item edit view page	{pc, mobile} [manager]
		'/product/edit', 
		'ProductController@view_edit_item'
	)->name('product.view_edit_item');
	Route::post(						// Product item update/add request
		'/product/edit/{product_id}', 
		'ProductController@process_edit'
	)->name('product.process_edit');

	////// Product class page
	Route::get(						// Product class view page	{pc, mobile} [manager]
		'/product/class', 
		'ProductController@view_class'
	)->name('product.active');
	Route::get(						// Product class page list request
		'/product/get/class/list/{search_json}/{itemcount}/{pagenum}', 
		'ProductController@get_type_page'
	)->name('product.class.page');
	Route::get(						// Product class list info request
		'/product/get/class/all', 
		'ProductController@get_type_list'
	)->name('product.class.list');
	Route::get(						// Product class list info request
		'/product/get/class/item/{type_id}', 
		'ProductController@get_type_item'
	)->name('product.class.list');
	Route::post(						// Product item update/add request
		'/product/class/edit/item/{type_id}', 
		'ProductController@process_class_edit'
	)->name('product.process_class_edit');

	Route::get(			// Product item list and add inventory info request
		'/product/addlist/{search_json}/{itemcount}/{pagenum}', 
		'ProductController@get_addlist'
	)->name('product.addlist');
	
	Route::get(			// Product item list and add inventory info request
		'/product/activelist/{search_json}/{itemcount}/{pagenum}', 
		'ProductController@get_activelist'
	)->name('product.activelist');
	
	Route::get(						// Product item each info request
		'/product/get/item/{product_id}', 
		'ProductController@get_item'
	)->name('product.list');
	Route::get(						// Product item each info request
		'/product/get/item/{product_id}/{type_list_require}', 
		'ProductController@get_item'
	)->name('product.list');
	Route::get(						// Get all product list
		'/product/get/all', 
		'ProductController@get_all_list'
	)->name('product.get.all.list');



/****************************
	Price Package
****************************/
	Route::get(						// Price list page	{pc, mobile} [manager, dealer]
		'/price', 
		'PriceController@index'
	)->name('price');
	Route::get(						// Price view page {pc, mobile} [manager, dealer]
		'/price/view', 
		'PriceController@view'
	)->name('price.view');
	Route::get(						// Price edit page {pc, mobile} [manager, dealer]
		'/price/edit', 
		'PriceController@edit'
	)->name('price.edit');
	Route::get(						// Price edit page by dealer level {pc, mobile} [manager]
		'/price/edit/detail', 
		'PriceController@edit_detail'
	)->name('price.edit.detail');
	Route::get(						// Price discount select page {pc, mobile} [manager, dealer]
		'/price/discount/select', 
		'PriceController@discount_select'
	)->name('price.discount.select');
	Route::get(						// Price discount input page {mobile} [manager]
		'/price/discount/input', 
		'PriceController@discount_input'
	)->name('price.discount.input');
	Route::get(						// Price discount edit page {pc, mobile} [manager]
		'/price/discount/edit', 
		'PriceController@discount_edit'
	)->name('price.discount.edit');
	Route::post(					// Purchase_price_level, sale_price_level save request {pc, mobile} [manager]
		'/price/level/save', 
		'PriceController@save_level_price'
	)->name('price.level.save');
	Route::post(					// Purchase_price, sale_price save request to Prices table {pc, mobile} [manager]
		'/price/set/level', 
		'PriceController@set_level_price'
	)->name('price.set.level');
	Route::get(					// Get the dealer's manager_name, stock of products list by dealer_level request {pc, mobile} [manager]
		'/price/get/manager/{product_id_list}',
		'PriceController@get_dealer_manager_stock'
	)->name('price.get.level.manager');
	Route::post(					// Set the promotion of product request by dealer_id{pc, mobile} [manager]
		'/price/set/dealer/promotion',
		'PriceController@set_dealer_promotion'
	)->name('price.set.dealer.promotion');
	Route::post(					// Edit the promotion of product request {pc, mobile} [manager]
		'/price/edit/dealer/promotion',
		'PriceController@edit_promotion'
	)->name('price.edit.dealer.promotion');
	Route::post(					// Remove the promotion of product request {pc, mobile} [manager]
		'/price/remove/dealer/promotion',
		'PriceController@remove_promotion'
	)->name('price.remove.dealer.promotion');
	Route::post(					// Set the promotion of product request by level{pc, mobile} [manager]
		'/price/set/level/promotion',
		'PriceController@set_level_promotion'
	)->name('price.set.level.promotion');
	Route::get(					// Get the purchase_price, wholesale_price, sale_price, promotion of product by dealer request {pc, mobile} [dealer]
		'/price/get/dealer/{product_id}',
		'PriceController@get_price_dealer'
	)->name('price.get.dealer');
	Route::get(					// Get the promotion list {pc, mobile} [admin]
		'/price/get/promotion/list/{product_id}/{itemcount}/{pagenum}',
		'PriceController@get_promotion_list'
	)->name('price.get.promotion.list');
	Route::get(					// Get the down dealer and promotion list of product by dealer request {pc, mobile} [dealer]
		'/price/get/downdealerwithpromotion/{product_id}/{dealer_id}',
		'PriceController@get_downdealerwithpromotion'
	)->name('price.get.downdealerwithpromotion');
	Route::get(					// Get the up dealer and promotion list of product by dealer request {pc, mobile} [dealer]
		'/price/get/updealerwithpromotion/{product_id}/{dealer_id}',
		'PriceController@get_updealerwithpromotion'
	)->name('price.get.updealerwithpromotion');
	Route::get(					// Get the dealer and promotion list of product by level request {pc, mobile} [dealer]
		'/price/get/levelpromotion/{product_id}',
		'PriceController@get_levelpromotion'
	)->name('price.get.levelpromotion');
	Route::get(					// Get the dealer and promotion list of product by search_name request {pc, mobile} [dealer]
		'/price/get/dealerpromotion/{product_id}/{search_name}',
		'PriceController@get_dealerpromotion'
	)->name('price.get.dealerpromotion');


/******************************
	Register Package
******************************/
	Route::get(						// register list view page	{mobile} [seller]
		'/register', 
		'PriceController@view_reg_list'
	)->name('register');
	
	Route::get(						// register edit page	{mobile} [seller]
		'/register/edit', 
		'PriceController@view_reg_edit'
	)->name('register.edit');
	
	Route::get(						// register agree view page	{PC} [admin]
		'/register/view_agree', 
		'RegisterController@view_reg_agree'
	)->name('register.view_agree');
	
	Route::get(						// register agree card view page	{PC} [admin]
		'/register/view_agree_item', 
		'RegisterController@view_reg_agree_item'
	)->name('register.view_reg_agree_item');
	
	Route::get(						// register card list to agree
		'/register/card_agree/list/{search_json}/{itemcount}/{pagenum}', 
		'RegisterController@list_card_agree'
	)->name('register.edit');
	
	Route::get(						// register card agree or disagree request
		'/register/card_agree/agree/item/{card_id}/{status}', 
		'RegisterController@agree_card_register'
	)->name('register.agree_card_register');
	
	Route::post(						// register card agree or disagree request
		'/register/card/agree/template', 
		'RegisterController@agree_card_template'
	)->name('register.agree_card_template');
	
	Route::get(						// register pending list download [admin]
		'/register/pending_list_down', 
		'RegisterController@pending_list_down'
	)->name('register.pending_list_down');


/******************************
		Stock Package
******************************/
	
	// Stock list page view template {pc, mobile} [manager, dealer, seller]
	Route::get(
		'/stock', 
		'StockController@view_list'
	)->name('stock');
	
	// Stock list info ajax request
	Route::get(
		'/stock/list/{search_json}/{itemcount}/{pagenum}', 
		'StockController@get_list'
	)->name('stock.list');
	
	// Stock list page view template {pc, mobile} [manager, dealer, seller]
	Route::get(
		'/stock/product', 
		'StockController@view_list_byproduct'
	)->name('stock');
	
	// Stock list info ajax request
	Route::get(
		'/stock/list_product/{search_json}/{itemcount}/{pagenum}', 
		'StockController@get_list_product'
	)->name('stock.list_product');
	
	// Stock view page {pc, mobile} [manager, dealer, seller]
	Route::get(
		'/stock/view', 
		'StockController@view_item'
	)->name('stock.view');
	
	// Stock card info ajax requese page {pc, mobile} [manager, dealer, seller]
	Route::get(
		'stock/get/card_info/{card_id}', 
		'StockController@get_card_info'
	)->name('stock.card.info');
	
	// Stock product info ajax requese page {pc, mobile} [manager, dealer, seller]
	Route::get(
		'stock/get/product_info/{product_id}', 
		'StockController@get_product_info'
	)->name('stock.product.info');
	
	// Stock order purchase page view template {mobile}
	Route::get(
		'/stock/add', 
		'StockController@view_add'
	)->name('stock.add');
	// Stock order purchase page view template {mobile}
	Route::post(
		'stock/purchase', 
		'StockController@order_purchase'
	)->name('stock.purchase');
	// Stock Product info ajax requese page {mobile}
	Route::get(
		'stock/get/product_info/{product_id}', 
		'StockController@get_product_info'
	)->name('stock.product.info');
	Route::get(						// Stock return page
		'/stock/return', 
		'StockController@view_return'
	)->name('stock.return');
	Route::get(						// Stock setting page
		'/stock/setting', 
		'StockController@view_setting'
	)->name('stock.setting');

	// Download part
	Route::post(
		'/stock/card_import',
		'StockController@stock_card_import'
	)->name('stock.stock_card_import');

	// Download part
	Route::post(
		'/stock/download', 
		'StockController@stock_download'
	)->name('stock.stock_download');

	Route::get(
		'/stock/download_file/{search}', 
		'StockController@stock_download_file'
	)->name('stock.stock_download_file');
	
	Route::get(
		'download/storage/{filename}', 
		'StockController@stock_download_storage'
	)->name('stock.stock_download_storage');
	
	Route::get(
		'/stock/get_qr_code/{card_id}', 
		'StockController@stock_get_qr_code'
	)->name('stock.stock_get_qr_code');
	
	Route::get(
		'/stock/download_qr_code/{card_id}', 
		'StockController@stock_download_qr_code'
	)->name('stock.stock_get_qr_code');
	
	// Bulk register part
		// view bulk register page
	Route::get(
		'stock/bulk_register', 
		'StockController@view_bulk_register'
	)->name('stock.view_bulk_register');
		// bulk register file submit function
	Route::post(
		'stock/bulk_register/import', 
		'StockController@import_bulk_file'
	)->name('stock.bulk_register.import');
	
	
/******************************
	purchase Package
******************************/
	Route::get(						// purchase list page
		'/purchase', 
		'PurchaseController@index'
	)->name('purchase');

	Route::post(						// purchase order insert page
		'/purchase/insertorder', 
		'PurchaseController@insert_order'
	)->name('purchase.insert_order');
	Route::post(						// purchase order insert page
		'/purchase/multiinsertorder', 
		'PurchaseController@multi_insert_order'
	)->name('purchase.multi_insert_order');


////////////////////////
//  Generate Package  //
////////////////////////
    Route::get(						// Generate list page
        '/generate',
        'GenerateController@index'
    )->name('generate');
    Route::get(						// Generate add page
        '/generate/add',
        'GenerateController@add'
    )->name('generate.add');
    Route::post(						// Generate post add page
        '/generate/add',
        'GenerateController@post_add'
    )->name('generate_post.add');
    // Get Products List api
    Route::get('/getProductsList/{beginNo}/{itemCntPerPage}',
        'GenerateController@get_product_list'
    )->name('generate_get_product.list');

	// Care rule part
    Route::get(						// Generate card rule list view page
        '/generate/card_rule',
        'GenerateController@view_card_rule'
    )->name('generate.view_card_rule');

    Route::get(						// Generate card rule list page
        '/generate/card_rule/list/{search_json}/{itemcount}/{pagenum}',
        'GenerateController@list_card_rule'
    )->name('generate.list_card_rule');

    Route::get(						// Generate card edit view page
        '/generate/card_rule/edit',
        'GenerateController@view_edit_card_rule'
    )->name('generate.view_edit_card_rule');

    Route::get(						// Generate card rule list page
        '/generate/card_rule/get/item/{rule_id}',
        'GenerateController@get_card_rule'
    )->name('generate.get_card_rule');

    Route::post(						// Generate card rule edit ajax
        '/generate/card_rule/edit/item/{rule_id}',
        'GenerateController@edit_card_rule'
    )->name('generate.edit_card_rule');

    Route::get(						// card rule delete package
        '/generate/card_rule/delete/item/{rule_id}',
        'GenerateController@delete_card_rule'
    )->name('generate.delete_card_rule');
	
	// Generate dictionary part
    Route::get(						// Generate dictionary list page
        '/generate/dictionary',
        'GenerateController@view_dictionary'
    )->name('generate.view_dictionary');
    Route::get(						// Generate dictionary list page
        '/generate/dictionary/get/list/{search_json}/{itemcount}/{pagenum}',
        'GenerateController@get_dictionary_list'
    )->name('generate.get_dictionary_list');
    Route::get(						// Generate dictionary list page
        '/generate/dictionary/delete/item/{id}',
        'GenerateController@delete_dictionary_item'
    )->name('generate.delete_dictionary_item');
    Route::get(						// Generate dictionary get item ajax
        '/generate/dictionary/get/item/{id}',
        'GenerateController@get_dictionary_item'
    )->name('generate.get_dictionary_item');
    Route::post(						// Generate dictionary set item ajax
        '/generate/dictionary/edit/item/{id}',
        'GenerateController@get_dictionary_edit'
    )->name('generate.get_dictionary_edit');

/////////////////////
//  Order Package  //
/////////////////////
    Route::get(						// Order list page
        '/order',
        'OrderController@index'
    )->name('order');
    Route::get(						// order list info request
        '/order/list/{search_json}/{itemcount}/{pagenum}',
        'OrderController@get_list'
    )->name('order.list');
    Route::get(						// Order view page
        '/order/view',
        'OrderController@view_item'
    )->name('order.view');
    Route::get(						// Order view item each info request
        '/order/get/item/{order_id}',
        'OrderController@get_item_by_id'
    )->name('order.get');
    Route::post(						// Order view item each info request
        '/order/agree/item/{order_code}',
        'OrderController@agree_item'
    )->name('order.agree_item');
	Route::get(						// Order refuse request
        '/order/refuse/item/{order_code}',
        'OrderController@refuse_item'
    )->name('order.refuse_item');

    Route::get(						// Order setting page
        '/order/setting',
        'OrderController@view_setting'
    )->name('order.setting');

    Route::post(
        '/order/create',
        'OrderController@create'
    )->name('order.create');
    Route::post(
        '/order/check_physical_card/each',
        'OrderController@check_each_pcard'
    )->name('order.check_each_pcard');
    Route::post(
        '/order/check_physical_card/file',
        'OrderController@check_file_pcard'
    )->name('order.check_file_pcard');
    //order import
    Route::post(
        '/order/fileupload',
        'OrderController@fileupload'
    )->name('order.fileupload');
    //order export
    Route::post(
        '/order/export',
        'OrderController@export'
    )->name('order.export');


////////////////////////////
//  Sales amount Package  //
////////////////////////////
    Route::get(						// Sales amount product rank list page
        '/sales/rank/product',
        'SalesController@view_product'
    )->name('sales.product.view');
    Route::get(						// product list info request
        '/sales/rank/product/list/{search_json}/{itemcount}/{pagenum}',
        'SalesController@get_product_list'
    )->name('sales.product.list');
    Route::get(						// Sales amount income rank list page
        '/sales/rank/income',
        'SalesController@view_income'
    )->name('sales.income.view');
    Route::get(						// income list info request
        '/sales/rank/income/list/{search_json}/{itemcount}/{pagenum}',
        'SalesController@get_income_list'
    )->name('sales.income.list');
    Route::get(						// Sales amount sales rank list page
        '/sales/rank/sale',
        'SalesController@view_sale'
    )->name('sales.sale.view');
    Route::get(						// sales ranked by sale  list info request
        '/sales/rank/sale/list/{search_json}/{itemcount}/{pagenum}',
        'SalesController@get_sale_list'
    )->name('sales.sale.list');
    Route::get(						// Sales amount dealer rank list page
        '/sales/rank/dealer',
        'SalesController@view_dealer'
    )->name('sales.dealer.view');
    Route::get(						// dealer list info request
        '/sales/rank/dealer/list/{search_json}/{itemcount}/{pagenum}',
        'SalesController@get_dealer_list'
    )->name('sales.dealer.list');


////////////////////////////
//  Reward Package  	  //
////////////////////////////
	Route::get(						// Reward seller list page
		'/reward/user', 
		'RewardController@view_user'
	)->name('reward.user');
	Route::get(						// Reward dealerpoint list page
		'/reward/office/list', 
		'RewardController@view_office'
	)->name('reward.office');
	/* Route::get(						// Get Reward list request
		'/reward/get/list/{start_date}/{end_date}/{status}/{itemcount}/{pagenum}', 
		'RewardController@get_redpacket_list'
	)->name('reward.get.list'); */
	Route::get(						// Get Reward list request
		'/reward/get/list/{search_json}/{itemcount}/{pagenum}', 
		'RewardController@get_redpacket_list'
	)->name('reward.get.list');
	Route::get(						// Set Reward status request
		'/reward/set/status/{redpacket_id}', 
		'RewardController@set_redpacket_status'
	)->name('reward.set.status');
	Route::get(						// Set Reward require to admin
		'/reward/set/require/{redpacket_id}', 
		'RewardController@set_redpacket_require'
	)->name('reward.set.require');
	Route::get(						// Get Reward option request
		'/reward/get/option', 
		'RewardController@get_redpacket_option'
	)->name('reward.get.option');
	Route::get(						// Get Reward list of user request for only seller
		'/reward/get/user/{itemcount}/{pagenum}',
		'RewardController@get_user_redpacket'
	)->name('reward.get.user');

////////////////////////////
//  Reward Setting  	  //
////////////////////////////
    // Add by Sacred Zeus
    Route::get(						// Reward dealerpoint list page
        '/reward/setting/view',
        'RewardSettingController@redpacket_setting_view'
    )->name('reward.setting.view');
    Route::get(
        '/reward/setting/add/view',
        'RewardSettingController@redpacket_setting_add_view'
    )->name('reward.setting.add.view');
    Route::get(
        '/reward/setting/detail/view',
        'RewardSettingController@redpacket_setting_detail_view'
    )->name('reward.setting.detail.view');
    Route::get(
        '/reward/setting/edit/view',
        'RewardSettingController@redpacket_setting_edit_view'
    )->name('reward.setting.edit.view');
    Route::get(
        '/reward/setting/index/{itemcount}/{pagenum}',
        'RewardSettingController@index'
    )->name('reward.setting.index');
    Route::post(
        '/reward/setting/add',
        'RewardSettingController@add'
    )->name('reward.setting.add');
    Route::post(
        '/reward/setting/edit',
        'RewardSettingController@edit'
    )->name('reward.setting.edit');
	Route::get(
        '/reward/setting/remove/{id}',
        'RewardSettingController@remove'
    )->name('reward.setting.remove');

////////////////////////////
//    User Package  	  //
////////////////////////////
    Route::get(						                // Reward seller list page
        '/user/employee',
        'UserController@view_employee'
    )->name('user.employee');
    Route::get(						                // Reward dealer list page
        '/user/dealer',
        'UserController@view_dealer'
    )->name('user.dealer');
    Route::get(						                // Reward dealer view page
        '/user/dealer/view',
        'UserController@view_dealer_item'
    )->name('user.dealer.view');
/*
    Route::get(						                // Reward dealer detail info view page
        '/user/dealer/detail',
        'UserController@view_dealer_detail'
    )->name('user.dealer.detail');
*/
    Route::get(						                // Reward dealer view page
        '/user/dealer/edit',
        'UserController@view_dealer_edit'
    )->name('user.dealer.edit');
    Route::get(						                // Get the detail of dealer with their info
        '/user/dealer/detail/{dealer_id}',
        'UserController@getDealerDetailInfo'
    )->name('user.dealer.detail.info');
    Route::get(						                // Get the detail of dealer with their info
        '/user/dealer/get/detail/{dealer_id}/{require_member}',
        'UserController@getDealerDetail'
    )->name('user.dealer.get.detail');
    Route::post(						            // Reward dealer view page
        '/user/dealer/save',
        'UserController@save_dealer_data'
    )->name('user.dealer.save');
    Route::post(						            // Post the detail of dealer with their info
        '/user/dealer/save/{method}/{subject}/{dealer_id}',
        'UserController@modifyOrCreateDealer'
    )->name('user.save.dealer');
    Route::get(						                // Reward staff detail info view page
        '/user/new',
        'UserController@newUser'
    )->name('user.new.user');
    Route::post(						            // Reward staff detail info view page
        '/user/new/{dealer_id}',
        'UserController@createNewUser'
    )->name('user.save.user');
    Route::get(						                // Reward staff detail info view page
        '/user/staff/detail',
        'UserController@view_staff_detail'
    )->name('user.dealer.view_staff_detail');
    Route::get(						                // Reward staff edit view page
        '/user/staff/edit',
        'UserController@view_staff_edit'
    )->name('user.dealer.view_staff_edit');
    Route::post(						            // Reward dealer view page
        '/user/staff/save',
        'UserController@save_staff_data'
    )->name('user.staff.save');
    Route::get(						// Staff detail info view page
        '/user/staff/get/detail/{user_id}',
        'UserController@getStaffDetail'
    )->name('user.dealer.getStaffDetail');
    Route::get(						// Get the list of dealers with their info
        '/user/dealer/get/list/{dealer_level}/{dealer_name}/{itemcount}/{pagenum}',
        'UserController@getDealerListWithInfo'
    )->name('user.dealer.get.list');
    Route::get(						// Get the list of dealers with dealer_id
        '/user/dealer/get/info/{dealer_id}/{dealer_name}/{itemcount}/{pagenum}',
        'UserController@getDealerInformationByID'
    )->name('user.dealer.get.list');
    Route::get(						// Get the list of dealers with their info
        '/user/dealer/get/child/{dealer_id}',
        'UserController@getChildDealerList'
    )->name('user.dealer.get.child');
    Route::get(						// Get the detail of dealer with their info
        '/user/dealer/get/detail/{dealer_id}',
        'UserController@getDealerDetail'
    )->name('user.dealer.get.detail');
    Route::post(						// Set the balance state of dealer to 1
        '/user/dealer/set/balance/{dealer_id}',
        'UserController@setBalanceState'
    )->name('user.dealer.set.balance');
    Route::post(						// Reward dealer view page
        '/user/dealer/import/{dealer_id}',
        'UserController@import_dealer_items'
    )->name('user.dealer.import');
    Route::get(						// Get the list of employee with their info
        '/user/employee/get/list/{user_name}/{itemcount}/{pagenum}',
        'UserController@getUserList'
    )->name('user.employee.get.list');
    Route::get(
        '/user/add_dealer',
        'UserController@add_new_dealer'
    )->name('user.add_new_dealer');
    Route::get(
        '/user/add_seller',
        'UserController@add_new_seller'
    )->name('user.add_new_seller');
    Route::get(
        'user/get/roles',
        'UserController@userGetRoles'
    )->name('user.get.roles');
	
    Route::get(
        'common/download/template/{template_type}',
        'CommonController@templateFileDownload'
    )->name('user.get.roles');


////////////////////////////
//    Log Package  	  //
////////////////////////////
    Route::get(						// log page {pc} [admin]
        '/log',
        'LogController@index'
    )->name('log');
    Route::get(						// log list page {pc} [admin]
        '/log/list/{search_json}/{itemcount}/{pagenum}',
        'LogController@get_list'
    )->name('log.list');
    Route::get(						// log operatetype list page {pc} [admin]
        '/log/operatetype_list',
        'LogController@get_operatetype_list'
    )->name('log.operatetype_list');


/******************************
	Message Package
******************************/
	// Message list page
	Route::get(						
		'/message', 
		'MessageController@index'
	)->name('message');
	// Message list info request
	Route::get(						
		'/message/list/{search_json}/{itemcount}/{pagenum}', 
		'MessageController@get_list'
	)->name('message');
	// Message view page
	Route::get(
		'/message/view', 
		'MessageController@view_item_page'
	)->name('message');
	// Message new check page
	Route::get(
		'/message/check/new', 
		'MessageController@check_new'
	)->name('message');
	// Message item info request
	Route::get(
		'/message/get/item/{message_id}', 
		'MessageController@get_item'
	)->name('product.list');
	// Message delete request
	Route::post(						
		'/message/delete', 
		'MessageController@delete_items'
	)->name('message');

	
    Route::get(
        '/dealer/info/list/{dealer_id}',
        'UserController@get_dealer_architecture'
    )->name('dealer.architecture');
	
////////////////////////////
//    Setting Package  	  //
////////////////////////////
	// pc user[admin] cleared page
    Route::get(
        '/setting',
        'SettingController@view_setting_page'
    )->name('setting');

    Route::get(
        '/setting/get',
        'SettingController@get_setting'
    )->name('setting.get');

    Route::post(
        '/setting/save',
        'SettingController@save_setting'
    )->name('setting.save');

// Language setting
    Route::get('/set_locale/{locale}',function($locale){
        $request = Request();
        $request->session()->put('site_local', $locale);
        return response()->json(['status' => true, 'locale' => $locale]);
    });

// User privillege for test
    Route::get('/set_pri/{priv}',function($priv) {
        $request = Request();
        $request->session()->put('site_priv', $priv);

        if ($priv == 'admin') {
            $request->session()->put(
                'total_info', array(
                    "authority" => 'admin',
                    "user_id" => 14,
                    "dealer_id" => 1,
                    "level" => 0,
                    "up_dealer" => null,
                    "down_dealers" => array(
                        array("id"=>33),
                        array("id"=>35),
                        array("id"=>40),
                    )
                )
            );
        } /* else if ($priv == 'dealer') {
            $request->session()->put(
                'total_info', array(
                    "authority" => 'dealer',
                    "user_id" => 13,
                    "dealer_id" => 35,
                    "level" => 1,
                    "up_dealer" => App\Dealer::find(1),
                    "down_dealers" => array(
                        array("id"=>36),
                    )
                )
            );
        } */ else if ($priv == 'dealer') {
            $request->session()->put(
                'total_info', array(
                    "authority" => 'dealer',
                    "user_id" => 52,
                    "dealer_id" => 34,
                    "level" => 2,
                    "up_dealer" => App\Dealer::find(33),
                    "down_dealers" => array(
                        array("id"=>1),
                    )
                )
            );
        }

        echo "<a href='".url("")."/set_pri/admin' style='".(($priv == 'admin')? 'color: red': '')."'>Admin</a><br>";
        echo "<a href='".url("")."/set_pri/dealer' style='".(($priv == 'dealer')? 'color: red': '')."'>dealer</a><br>";
        echo "<a href='".url("")."/set_pri/seller' style='".(($priv == 'seller')? 'color: red': '')."'>seller</a><br>";
	});
		
	// Dingding api call process
    Route::get('/dingapi', 'DingApiController@index')->name('dingapi');
    Route::post('/dingapi', 'DingApiController@index')->name('dingapi');

	// ChinaArea API call process
	Route::get('/cnarea/area/{id}', 'ChinaAreaController@getArea')->name('cnarea.get.area');
	Route::get('/cnarea/search/name', 'ChinaAreaController@getAreaIndexByName')->name('cnarea.get.search.name');
	Route::get('/cnarea/provinces', 'ChinaAreaController@getProvinceNames')->name('cnarea.get.provinces');
	Route::get('/cnarea/cities/{province_id}', 'ChinaAreaController@getCityNames')->name('cnarea.get.cities');
	Route::get('/cnarea/countries/{city_id}', 'ChinaAreaController@getCountryNames')->name('cnarea.get.countries');
	Route::get('/cnarea/towns/{country_id}', 'ChinaAreaController@getTownNames')->name('cnarea.get.towns');
	Route::get('/cnarea/areas/{province_id}/{city_id}/{country_id}/{town_id}', 'ChinaAreaController@getInitialAreas')->name('cnarea.get.init.areas');
	
	
	// for test
    Route::get('/test', function() {
		
		App\Message::save_message(array(
						"type" => "1",
						"tag_dealer_id" => 1,
						"tag_user_id" => null,
						"message" => "test message",
						"url" => "#!/order/view/1",
						"html_message" => "<p>first line</p><p>second line</p>",
						"table_name" => "order",
						"table_id" => "153",
					));
		
	});
