

// Mobile purchase controller only dealer
dingdingApp.controller('purchaseController', function($scope, $rootScope, $route, $routeParams, $http, $window, generateCardAdd, PagerService, myDialogService) {
	if(typeof $routeParams.type == "undefined") {
		$scope.type = '0';
	} else {
		$scope.type = $routeParams.type;
	}

	// Mobile dingding Menu
	if(is_mobile){
		//dd.ready(function() {
			// When back button closed
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

//			console.log("Setup the menus");
		//});
		
		$scope.sendData = [];
		$scope.purchaseMobileData = {
			card_types:{
				availableOptions: [
					{'val': 1, 'label': lang.physical_card},
					{'val': 0, 'label': lang.virtual_card},
					{'val': 2, 'label': lang.virtual_sp_card}
				],
				selectedOption: {'val': 1, 'label': lang.physical_card}
			},
			cards: "",
			price: 120,
			orderstatus: "0",
			productData: $scope.sendData
		};
		//insert each info
		$scope.insertitem = function(item, index){
//			console.log(item);
			var card = $(".cards:eq("+index+")").val();
			var card_type = $(".card_types:eq("+index+")").val();
			var card_min = $(".cards:eq("+index+")").attr("min");
			var card_max = $(".cards:eq("+index+")").attr("max");
			if (card > card_min-1 && card < card_max+1){
				var senditem = [];
				$(".numtooltip:eq("+index+")").css("display","none");
				item.cards = card;
				item.card_type = card_type;
				item.orderstatus = 0;
				senditem.push(item);
				generateCardAdd.multiOrderAdd(senditem).then(function(response){
					if(response.status == 200){				
//						console.log(response.data);
						//location.href= "#!order";	
						$("#successconfirm_dlg").modal({backdrop: 'static', keyboard: false});					
						$("#successconfirm_dlg .confirm").click(function () {
							$('#successconfirm_dlg').modal('toggle');
							$("#successconfirm_dlg").on("hidden.bs.modal", function () {
								$window.location.href = "#!stock";
							});
						});
					}else{
						myDialogService.alert({
							title: lang.product_save_title_fail,
							message: lang.save_message_fail,
							button: lang.close,
							animation: "fade",
							callback: function(){
							}
						});
					}
				});
//				console.log(senditem);
				
			}else{
				$(".cards:eq("+index+")").val("");
				$(".card_types:eq("+index+")").val("1");
				$(".cards:eq("+index+")").focus();
				$(".numtooltip:eq("+index+")").css("display","block");
			}
			/* generateCardAdd.multiOrderAdd(data).then(function(response){
				if(response.status == 200){
					$('.reg_success_modal').modal('toggle');
					$(".reg_success_modal").on("hidden.bs.modal", function () {
						location.href="#!order";
					});					
//					console.log(response.data);
				}else{
//					console.log(response.data);
				}
			}); */
		}
		//insert multi info
		$scope.ajax_loading = false;
		$scope.multi_insert = function(data){
			if($scope.ajax_loading === false){				
				$scope.ajax_loading = true;
				generateCardAdd.multiOrderAdd(data).then(function(response){					
					if(response.status == 200){
						$('.alert').css('display', 'none');
						$('.alert-success').css('display', 'block');						
						window.setTimeout(function() { 
							$(".alert-success").hide(200);
							$('.reg_success_modal').modal('toggle');
							$(".reg_success_modal").on("hidden.bs.modal", function () {
								location.href="#!order";
							});
						}, 3000);
//						console.log('saved!');
//						console.log(response.data);
					}else{
						$('.alert').css('display', 'none');
						$('.alert-danger').css('display', 'block');	
						$scope.ajax_loading = false;
						/* myDialogService.alert({
							title: lang.product_save_title_fail,
							message: lang.save_message_fail,
							button: lang.close,
							animation: "fade",
							callback: function(){
							}
						}); */
					}
				});
			}else{
				return false;
			}
			
		}
		//insert card, card_type in item object when ng-blur	
		
			
		$scope.cardcount = [];
		$scope.totalprice = 0;
		$scope.getData = function(index,item){	
			var card = parseInt($scope.cardcount[index]);
			var card_type = $(".card_types:eq("+index+")").val();
			var card_min = parseInt($(".cards:eq("+index+")").attr("min"));
			var card_max = parseInt($(".cards:eq("+index+")").attr("max"));
			
			$scope.totalprice = 0;
			for (var i=0;i<$scope.isRadio.length;i++){
				if($scope.isRadio[i] === true){
					if (parseInt($scope.cardcount[i])>0){
						$scope.totalprice = $scope.totalprice + parseInt($scope.items[i].viewprice)*parseInt($scope.cardcount[i]);					
					}
				}
			}
//			console.log(card);
			if((card < card_min) || (card > card_max) || isNaN(card)){
				$(".numtooltip:eq("+index+")").css("display","block");
				/* if((card > card_max) || isNaN(card)){
					$(".cards:eq("+index+")").val($(".cards:eq("+index+")").attr("max"));
				} */				
				$scope.buttonview = false;	
				return false;
			}else{
				$(".numtooltip:eq("+index+")").css("display","none");
				for (var i=0; i < $scope.sendData.length; i++) {				
					if ($scope.sendData[i].id === item.id) {
						$scope.sendData[i].cards = card;
						$scope.sendData[i].card_type = card_type;					
						$scope.sendData[i].orderstatus = '0';	
					}
					
				}			
			}
//			console.log($scope.cardcount);
			if(($scope.cardcount[i] != null && typeof $scope.cardcount[i] != "undefined") && $scope.totalprice > 0){
				$scope.buttonview = true;					
			}else{
				$scope.buttonview = false;
				
				//return false;
			}
			for(var i=0;i<$scope.isRadio.length;i++){
				var card_min_check = parseInt($(".cards:eq("+i+")").attr("min"));
				var card_max_check = parseInt($(".cards:eq("+i+")").attr("max"));
				if($scope.isRadio[i] === true){
					if(($scope.cardcount[i] < card_min_check) || ($scope.cardcount[i] > card_max_check) || isNaN($scope.cardcount[i])){						
						$scope.buttonview = false;	
						return false;
					}else{
						$scope.buttonview = true;
					}
				}				
			}
			
			
		}
		$scope.buttonview = false;
		$scope.isRadio = [];
		$scope.checkdata = function(item, index){	
			if(($scope.cardcount[index] != null && typeof $scope.cardcount[index] != "undefined") && $scope.totalprice > 0){
				$scope.buttonview = true;
			}else{
				$scope.buttonview = false;
			}	
			if($scope.items[index].viewprice == "0"){
				$scope.isRadio[index] = false;
				myDialogService.alert({
					title: lang.purchase_is_price_warning,
					message: lang.purchase_is_price,
					button: lang.close,
					animation: "fade",
					callback: function(){
					}
				});
				
				return false;
			}	
			
			if ($scope.isRadio[index] === true){
				//view when checked
				$(".card_types:eq("+index+")").removeAttr("disabled");	
				$(".cards:eq("+index+")").removeAttr("readonly");
				$(".numtooltip:eq("+index+")").css("display","block");
				$scope.sendData.push(item);
			}else{
				//visible when unchecked
				$(".card_types:eq("+index+")").attr("disabled","disabled");	
				$(".cards:eq("+index+")").attr("readonly","readonly");
				$(".card_types:eq("+index+")").val("1");
				$(".cards:eq("+index+")").val("");
				$(".numtooltip:eq("+index+")").css("display","none");
				for (var i=0; i < $scope.sendData.length; i++) {
					if ($scope.sendData[i].id === item.id) {
						$scope.sendData.splice(i,1);						
						i = $scope.sendData.length;						
					}
				}
				$scope.totalprice = 0;
				for (var i=0;i<$scope.isRadio.length;i++){
					if($scope.isRadio[i] === true){
						if (parseInt($scope.cardcount[i])>0){
							$scope.totalprice = $scope.totalprice + parseInt($scope.items[i].viewprice)*parseInt($scope.cardcount[i]);
						}
					}
				}
				for (var i=0;i<$scope.cardcount.length;i++){
					if(i == index){
						$scope.cardcount[index] = null;
					}
				}
				if($scope.totalprice > 0){
					$scope.buttonview = true;
				}else{
					$scope.buttonview = false;
				}
			}
			/* if(($scope.cardcount[index] != null && typeof $scope.cardcount[index] != "undefined") && $scope.totalprice > 0){
				$scope.buttonview = true;
			}else{
				$scope.buttonview = false;
			} */			
//			console.log($scope.sendData);
		}
//		console.log($scope.totalprice);
		generateCardAdd.getcateg().then(function(response){
			if(response.status == 200){					
//				console.log(response.data.level1_type);
				$scope.categitems = response.data.level1_type;	
			}else{
//				console.log(response);
			}
		});
		
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
			if($scope.pagenum > 0){			
				$http.get('product/addlist/' + JSON.stringify(search) + '/' + itemcount + '/' + pagenum).then(
					function(response){
						if (pagenum == 1){
							$scope.buttonview = false;
							$scope.totalprice = 0;
							delete $scope.items;
							$scope.items = [];
							$scope.sendData = [];
							$scope.isRadio = [];
							$scope.cardcount = [];
						}						
						
						var items = response.data.list.data;
						var lastpage = response.data.list.last_page;
						
						if(items.length > 0 && $scope.pagenum < lastpage){
							$scope.pagenum = $scope.pagenum + 1;						
						}else if($scope.pagenum == lastpage){
							$scope.pagenum = 0;
						}
						
						if(items.length == 0){
							$scope.nodata = true;
						}else{
							$scope.nodata = false;
						}
						
						for (var i = 0; i < items.length; i++) {
							if(items[i].price.purchase_price == null){
								items[i].price.purchase_price = 0;
							}
							if (items[i].price.promotion)
								items[i].viewprice = parseInt(items[i].price.promotion.promotion_price) * parseInt(items[i].price.purchase_price)/100;
							else
								items[i].viewprice = parseInt(items[i].price.purchase_price);
							$scope.items.push(items[i]);
							
						}		
//						console.log($scope.items);
						
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
		$rootScope.route_status = 'purchase';
		//heracles works
		$scope.pagenum = 1;
		$scope.itemcount = 5;
		$scope.search = {level1_type: '', level2_type: '', keyword: '', status: '1'};	
		
		$scope.checkitems = [];
		$scope.getid = function(item, index){
			if (item.price.purchase_price == null){
				$scope.checkstatus.status[item.id] = false;
				myDialogService.alert({
					title: lang.purchase_is_price_warning,
					message: lang.purchase_is_price,
					button: lang.close,
					animation: "fade",
					callback: function(){
					}
				});
				
				return false;
			}
			if (item.price.promotion)
				item.viewprice = parseInt(item.price.promotion.promotion_price) * parseInt(item.price.purchase_price)/100;
			else
				item.viewprice = parseInt(item.price.purchase_price);
			
			if($scope.checkstatus.status[item.id] === true){
				$scope.checkitems.push(item);
			}else if($scope.checkstatus.status[item.id] === false){
				for (var i=0; i < $scope.checkitems.length; i++) {	
					if ($scope.checkitems[i].id == item.id) {
						$scope.checkitems.splice(i,1);
						$scope.multicards[i] = "";
					}
				}
				for (var i=0; i < $scope.multicards.length; i++) {	
					$scope.multicards[i] = "";
				}
			}
//			console.log($scope.checkitems);
			
		}		
				
		$scope.multiPurchaseDlg = $( "#multipurchase" ).dialog({
			autoOpen: false,
			resizable: false,
			height: "auto",
			width: 740,
			modal: true,
		});	
		$scope.multiview = function(){
			
			var checkitem = {};
			var n = $scope.checkitems.length;
			if(n>0){		
				$scope.multiPurchaseDlg.dialog( "open" );
				
				$scope.purchaseFormMultiData = {
					card_types:{
						availableOptions: [
							{'val': 1, 'label': lang.physical_card},
							{'val': 0, 'label': lang.virtual_card},
							{'val': 2, 'label': lang.virtual_sp_card}
						],
						selectedOption: {'val': 1, 'label': lang.physical_card}
					},
					cards: "",
					price: "120",
					orderstatus: "0"
				};
				
//				console.log($scope.checkitems);
			}else{
				myDialogService.alert({
					// message: lang.gen_check_cardcount,
					message: lang.must_select_product,
					button: lang.close,
					animation: "fade",
					callback: function(){
					}
				});
			}
		}
		$scope.multi_total_price = 0;
		$scope.multicards = [];
		$scope.multi_total_count = function(item, index){
			$scope.multi_total_price = 0;
			var card = parseInt($(".cards").eq(index).val());
			var card_min = parseInt($(".cards:eq("+index+")").attr("min"));
			var card_max = parseInt($(".cards:eq("+index+")").attr("max"));
			$(".vaildnumber:eq("+index+")").css("display","none");
			$(".vaildrange:eq("+index+")").css("display","none");
			for(var i=0;i<$scope.checkitems.length;i++){
				if(typeof $scope.multicards[i] != "undefined"){
					$scope.multi_total_price = $scope.multi_total_price + parseInt($scope.checkitems[i].viewprice)*parseInt($scope.multicards[i]);
				}					
			}
			if((card < card_min) || (card > card_max)){
				$(".vaildrange:eq("+index+")").css("display","block");
				
				return false;
			}else{
				
			}
		}
		
		$scope.multiPurchaseCheckDlg = $( "#multipurchasecheck" ).dialog({
			autoOpen: false,
			resizable: false,
			height: "auto",
			width: 400,
			modal: true,
		});	
		$scope.ajax_loading = false;
		$scope.multi_send_data = function(){
			$scope.ajax_loading = false;
			var n = $( ".cards" ).length;
			for (var i=0;i<n;i++){
				var card_min = parseInt($(".cards:eq("+i+")").attr("min"));
				var card_max = parseInt($(".cards:eq("+i+")").attr("max"));
				var card = parseInt($( ".cards" ).eq(i).val());
				var card_type = parseInt($( ".card_type" ).eq(i).val());
				$(".vaildnumber:eq("+i+")").css("display","none");
				$(".vaildrange:eq("+i+")").css("display","none");
				if (isNaN(card)){
//					console.log(card);
					$(".cards:eq("+i+")").val("");
					$(".cards:eq("+i+")").focus();
					$(".vaildnumber:eq("+i+")").css("display","block");
					
					return false;
				}
				if(card < card_min){
//					console.log(card);
					$(".cards:eq("+i+")").val("");
					$(".cards:eq("+i+")").focus();
					$(".vaildrange:eq("+i+")").css("display","block");					
					return false;
				}
				if(card > card_max){
//					console.log(card);
					$(".cards:eq("+i+")").val("");
					$(".cards:eq("+i+")").focus();	
					$(".vaildrange:eq("+i+")").css("display","block");	
					return false;
				}
				$scope.checkitems[i].cards = card;
				$scope.checkitems[i].card_type = card_type;
				$scope.checkitems[i].orderstatus = $scope.purchaseFormMultiData.orderstatus;
			}
			if($scope.ajax_loading === false){	
				$scope.ajax_loading = true;
				generateCardAdd.multiOrderAdd($scope.checkitems).then(function(response){
					if(response.status == 200){
						$scope.multiPurchaseDlg.dialog( "close" );
						$scope.ajax_loading = false;		
						$scope.multiPurchaseCheckDlg.dialog( "open" );
						/* location.href="#!order";		
//						console.log(response.data); */
					}else{	
						$scope.ajax_loading = false;
						myDialogService.alert({
							title: lang.product_save_title_fail,
							message: lang.save_message_fail,
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
			$scope.mutliadddialogclose = function() {
				$scope.multiPurchaseCheckDlg.dialog( "close" );
				$window.location.href="#!order";
			}	
		}
		$scope.cancel_multipurchase = function() {
			$scope.multiPurchaseDlg.dialog( "close" );
			/* for (var i=0;i<$scope.items.length;i++){
				for (var j=0;j<$scope.checkitems.length;j++){
					if ($scope.checkitems[j].id === $scope.items[i].id){
//						console.log($scope.checkstatus.status.item);
						$scope.checkstatus.status[$scope.checkitems[j].id] = false;
					}
				}
			}
			$scope.checkitems = []; */
		}
		
		$scope.purchaseAddDlg = $( "#purchaseadd" ).dialog({
			autoOpen: false,
			resizable: false,
			height: "auto",
			width: 740,
			modal: true,
		});	
		
		$scope.purchaseCard = function(item) {
			
			$scope.min_order_val = item.min_order_val;
			$scope.max_order_val = item.max_order_val;
			
			$scope.totalprice = 0;
			if (item.price.promotion)
				viewprice = parseInt(item.price.promotion.promotion_price) * parseInt(item.price.purchase_price)/100;
			else
				viewprice = parseInt(item.price.purchase_price);
			$scope.purchaseFormData = {
				card_types:{
					availableOptions: [
						{'val': 1, 'label': lang.physical_card},
						{'val': 0, 'label': lang.virtual_card},
						{'val': 2, 'label': lang.virtual_sp_card}
					],
					selectedOption: {'val': 1, 'label': lang.physical_card}
				},
				cards: "",
				price: "120",
				orderstatus: "0",
				productData: item,
				viewprice : viewprice
			};	
			if(isNaN($scope.purchaseFormData.viewprice)){
				$scope.purchaseFormData.viewprice = 0;
			}		
			$scope.purchaseAddDlg.dialog( "open" );			
			
//			console.log($scope.purchaseFormData);
		};	
		
		$scope.countprice = function() {
			$scope.totalprice = 0;
			if (typeof $scope.purchaseFormData.service_cards != "undefined"){
				$scope.totalprice = parseInt($scope.purchaseFormData.viewprice) * parseInt($scope.purchaseFormData.service_cards);
//				console.log($scope.purchaseFormData.viewprice);
			}			
		}
		
		$scope.purchaseReturnDlg = $( "#purchasereturn" ).dialog({
			autoOpen: false,
			resizable: false,
			height: "auto",
			width: 740,
			modal: true,
		});
		$scope.purchaseCardReturn = function(item) {
			$scope.totalprice = 0;
			if (item.dealer_inventory > 0){
				if (item.price.promotion)
					viewprice = parseInt(item.price.promotion.promotion_price) * parseInt(item.price.purchase_price)/100;
				else
					viewprice = parseInt(item.price.purchase_price);
				$scope.purchaseFormData = {
					card_types:{
						availableOptions: [
							{'val': 1, 'label': lang.physical_card},
							{'val': 0, 'label': lang.virtual_card},
							{'val': 2, 'label': lang.virtual_sp_card}
						],
						selectedOption: {'val': 1, 'label': lang.physical_card}
					},
					cards: "",
					price: "120",
					orderstatus: "1",
					maxvalue:item.physical_inventory,
					productData: item,
					viewprice : viewprice
				};	
				if(isNaN($scope.purchaseFormData.viewprice)){
					$scope.purchaseFormData.viewprice = 0;
				}
				$scope.purchaseReturnDlg.dialog( "open" );
				
//				console.log($scope.purchaseFormData);
			}else{
				return false;
			}
		};
		$scope.maxvalue_control = function() {
			if($scope.purchaseFormData.card_types.selectedOption.val == 1){
				$scope.purchaseFormData.maxvalue = $scope.purchaseFormData.productData.physical_inventory;
			}else{
				$scope.purchaseFormData.maxvalue = $scope.purchaseFormData.productData.virtual_inventory;
			}
		}
		
		$scope.purchaseAddCheck = $( "#purchaseaddcheck" ).dialog({
			autoOpen: false,
			resizable: false,
			height: "auto",
			width: 400,
			modal: true,
		});
		
		$scope.purchaseReturnCheck = $( "#purchasereturncheck" ).dialog({
			autoOpen: false,
			resizable: false,
			height: "auto",
			width: 400,
			modal: true,
		});
		
		$scope.ajax_loading = false;
		$scope.submitForm = function(isValid) {					
			var data = {
				product_id: $scope.purchaseFormData.productData.id,
				service_card_code: $scope.purchaseFormData.productData.code,
				valid_period: $scope.purchaseFormData.productData.valid_period,
				service_card_type: $scope.purchaseFormData.card_types.selectedOption.val,
				service_cards: $scope.purchaseFormData.service_cards,
				orderstatus: $scope.purchaseFormData.orderstatus
			};
			
			if (isValid) {	
				if($scope.ajax_loading === false){	
					$scope.ajax_loading = true;
					generateCardAdd.orderAdd(data).then(function(response){						
						if(response.status == 200){
							if (data.orderstatus == '0'){	
								$scope.purchaseAddDlg.dialog( "close" );
								$scope.ajax_loading = false;
								$scope.purchaseAddCheck.dialog( "open" );
							}else if(data.orderstatus == '1'){
								$scope.purchaseReturnDlg.dialog( "close" );
								$scope.ajax_loading = false;
								$scope.purchaseReturnCheck.dialog( "open" );
							}
								
//							console.log(response.data);
						}else{
							$scope.ajax_loading = false;	
							myDialogService.alert({
								title: lang.product_save_title_fail,
								message: lang.save_message_fail,
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
		$scope.adddialogclose = function() {
			$scope.purchaseAddCheck.dialog( "close" );
			$window.location.href="#!order";
		}			
		$scope.returndialogclose = function() {
			$scope.purchaseReturnCheck.dialog( "close" );
			$window.location.href="#!order";
		}
		generateCardAdd.getcateg().then(function(response){
			if(response.status == 200){					
//				console.log(response.data.level1_type);
				var level1_select = {id: "", description: "--" + lang['title_type1_lavel'] + "--"};
				$scope.categ1items =response.data.level1_type;
				$scope.categ1items.unshift(level1_select);
				$scope.selectedData1= $scope.categ1items[0];
				
				var level2_select = {id: "", description: "--" + lang['title_type2_lavel'] + "--"};
				$scope.categ2items =response.data.level2_type;
				$scope.categ2items.unshift(level2_select);
				$scope.selectedData2= $scope.categ2items[0];
			}else{
//				console.log(response);
			}
		});
		$scope.nodata = false;
		$scope.get_page_list = function(pagenum, itemcount, search) {
			if($scope.pagenum > 0){			
				$http.get('product/addlist/' + JSON.stringify(search) + '/' + itemcount + '/' + pagenum).then(
					function(response){
//						console.log(response.data);
						$scope.items = [];
						var items = response.data.list.data;
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
			
		$scope.checkstatus = {status: {}};
		$scope.setPage = function(pagenum){	
			if(pagenum < 1) pagenum = 1;
			else if(pagenum > $scope.list_data.last_page) pagenum = $scope.list_data.last_page;
			$scope.get_page_list(pagenum, $scope.itemcount, $scope.search);	
			
/*
			setTimeout(function(){
				for (var i=0;i<$scope.items.length;i++){
					for (var j=0;j<$scope.checkitems.length;j++){
						if ($scope.checkitems[j] === $scope.items[i].id){
//							console.log($scope.checkstatus.status.item);
							$scope.checkstatus.status.item = true;
						}else{
							$scope.checkstatus.status.item = false;
						}
					}
				}
			}, 1000); */
			
/*
//			console.log($scope.items);

			if ($scope.checkids.length>0 && $scope.items.length>0){
				for (var i=0; i < $scope.checkids.length; i++) {
					for (var j=0; j < $scope.items.length; j++) {	
						if ($scope.items[j].id == $scope.checkids[i]) {
							document.getElementById("checkboxitem_"+$scope.checkids[i]).checked = true;
						}else{
							document.getElementById("checkboxitem_"+$scope.checkids[i]).checked = false;
						}
					}
				}
			} */	
		}
		
		$scope.search_change = function(){
			$scope.search.level1_type = $scope.selectedData1.id;
			$scope.search.level2_type = $scope.selectedData2.id;
			$scope.search.keyword = $scope.searchword;
			
			$scope.get_page_list(1, $scope.itemcount, $scope.search);
		}
		//alert("ok");
		$scope.get_page_list($scope.pagenum, $scope.itemcount, $scope.search);
	}
});
