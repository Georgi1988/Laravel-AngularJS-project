/* angular.module('dingdingApp').service('productStorage', function($http){
	this.productStorage = function(){
		return $http.get('product/get').then(
			function(response){
				return response.data;
			});
	}
}); */


dingdingApp.service('myDialogService', function($http){
	
	//this.local_mode = true;
	this.local_mode = false;
	
	this.confirm = function(parameter) {
		if(this.local_mode == true){
			dialog.confirm({
				title: parameter.title,
				message: parameter.message,
				cancel: parameter.cancle_txt,
				button: parameter.confirm_txt,
				required: true,
				callback: function(value){
					if(value == true){
						if(parameter.success_callback != null)
							parameter.success_callback();
					}else{
						if(parameter.cancle_callback != null)
							parameter.cancle_callback();
					}
				}
			});
		}else{
			console.log(is_mobile);
			if(!is_mobile){
				DingTalkPC.device.notification.confirm({
					title: parameter.title,
					message: parameter.message,
					buttonLabels: [parameter.confirm_txt, parameter.cancle_txt],
					onSuccess : function(result) {
						if (result.buttonIndex == 0) {// confirm
							if(parameter.success_callback != null)
								parameter.success_callback();
						} else {
							if(parameter.cancle_callback != null)
								parameter.cancle_callback();
						}
					}
				});
			}else{
				dd.device.notification.confirm({
					title: parameter.title,
					message: parameter.message,
					buttonLabels: [parameter.confirm_txt, parameter.cancle_txt],
					onSuccess : function(result) {
						if (result.buttonIndex == 0) {// confirm
							if(parameter.success_callback != null)
								parameter.success_callback();
						} else {
							if(parameter.cancle_callback != null)
								parameter.cancle_callback();
						}
					},
					onFail : function(err) {
						if(parameter.fail_callback != null)
							parameter.fail_callback();
					}
				});
			}
		}
	}
	
	this.alert= function(parameter){
		if(this.local_mode == true){
			dialog.alert({
				title: parameter.title,
				message: parameter.message,
				button: parameter.button,
				animation: "fade",
				callback: function(value){
					if(parameter.callback != null)
						parameter.callback();
				}
			});			
		}else{
			console.log(is_mobile);
			if(!is_mobile){
				DingTalkPC.device.notification.alert({
					title: parameter.title,
					message: parameter.message,
					button: parameter.button,
					onSuccess : function() {
						if(parameter.callback != null)
							parameter.callback();
					},
					onFail : function(err) {}
				});
			}else{				
				dd.device.notification.alert({
					title: parameter.title,
					message: parameter.message,
					button: parameter.button,
					onSuccess : function() {
						if(parameter.callback != null)
							parameter.callback();
					},
					onFail : function(err) {}
				});
			}
		}
	}
});

dingdingApp.service('dealerSelect', function($http){
	this.getList = function(dealer_id){
		return $http.get('dealer/info/list/' + dealer_id).then(
			function(response){
				return response.data;
			});
	}
});

dingdingApp.service('orderData', function($http){
	this.page_list = function(type, page, search, reqire_products_list){
		return $http.get('order/list/' + type + '/' + page + '/' + search + '/' + reqire_products_list).then(
			function(response){
				return response.data;
			});
	}
	this.save_order = function(data){
		return $http.post('order/create', data).then(
			function(response){						
				return response.data;
			});
	}
});

dingdingApp.service('PagerService', function(){
	this.GetPager = function(totalItems, currentPage, pageSize, pageCount) {
		// default to first page
		currentPage = currentPage || 1;

		// default page size is 10
		pageSize = pageSize || 10;

		// calculate total pages
		var totalPages = Math.ceil(totalItems / pageSize);
		var half = Math.round(pageCount / 2);
		
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

		var startPage, endPage;
		if (totalPages <= pageCount) {
			// less than pageCount total pages so show all
			startPage = 1;
			endPage = totalPages;
		} else {
			// more than 10 total pages so calculate start and end pages
			if (currentPage <= half) {
				startPage = 1;
				endPage = pageCount;
			} else if (currentPage + half > totalPages + 1) {
				startPage = totalPages - pageCount;
				endPage = totalPages;
			} else {
				startPage = currentPage - half + 1;
				endPage = currentPage + half- 1;
			}
		}

		// calculate start and end item indexes
		var startIndex = (currentPage - 1) * pageSize;
		var endIndex = Math.min(startIndex + pageSize - 1, totalItems - 1);

		// create an array of pages to ng-repeat in the pager control
		//var pages = _.range(startPage, endPage + 1);
		var pages = [];
		var index = 0;
		for(var i = startPage; i <= endPage; i++)
			pages[index++] = i;
		
		// return object with all pager properties required by the view
		return {
			totalItems: totalItems,
			currentPage: currentPage,
			pageSize: pageSize,
			totalPages: totalPages,
			startPage: startPage,
			endPage: endPage,
			startIndex: startIndex,
			endIndex: endIndex,
			pages: pages
		};
	}
});
angular.module('dingdingApp').factory('productStorage', function($http, $templateCache){
	//var TODO_DATA = 'TODO_DATA';  
	var storage = {
		get: function(){
		  return $http.get('product/get').then(function(response){
					return response.data;
				});
		}
	};
	//return response.data;	
	/*var storage = {
		products: products,
    
		_saveToLocalStorage: function(data){
		  localStorage.setItem(TODO_DATA, JSON.stringify(data));
		},
		
		_getFromLocalStorage: function(){
		  return JSON.parse(localStorage.getItem(TODO_DATA)) || [];
		},
		
		get: function(){
		  //angular.copy(storage._getFromLocalStorage(), storage.products);
		  return storage.products;
		} ,
    
		remove: function(todo){
		  var idx = storage.todos.findIndex(function(item){
			return item.id == todo.id;
		  });
		  
		  if(idx > -1){
			storage.todos.splice(idx,1);
			storage._saveToLocalStorage(storage.todos);
		  }
		},
		
		add: function(newTodoTitle){
		  var newTodo = {
			title: newTodoTitle,
			completed: true,
			createdAt: Date.now()
		  };
		  storage.todos.push(newTodo);
		  storage._saveToLocalStorage(storage.todos);
		},
		
		update: function(){
		  storage._saveToLocalStorage(storage.todos);
		}
  //};*/
  
  return storage;

}); 
angular.module('dingdingApp').service('generateCardAdd', function($http, $templateCache){
	this.cardAdd = function(data){		
		return $http.post('/generate/add', data/* JSON.stringify(data) */).then(function (response) {
			if (response.data)
				return response;
		}, function (response) {
			return response;
		});
	}
	this.orderAdd = function(data){		
		return $http.post('/purchase/insertorder', data).then(function (response) {
			if (response.data)
				return response;
		}, function (response) {
			return response;
		});
	}
	this.multiOrderAdd = function(data){		
		return $http.post('/purchase/multiinsertorder', data).then(function (response) {
			if (response.data)
				return response;
		}, function (response) {
			return response;
		});
	}
	this.getProductItem = function(data){
		return $http.get('product/get/item/' + data.product_id + "/0/1").then(function (response) {
			if (response.data)
				return response;
		}, function (response) {
			return response;
		});
	}	
	this.getcateg =  function(){
		return $http.get('product/get/class/all').then(
			function(response){		
				return response;
			}, function (response) {
				return response;		
			});
	}	
}); 

// Http config with X-CSRF-TOKEN header
dingdingApp.factory('httpRequestInterceptor', function () {
  return {
    request: function (config) {
      config.headers['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');
      return config;
    }
  };
});
dingdingApp.config(function ($httpProvider) {
  $httpProvider.interceptors.push('httpRequestInterceptor');
});

// pageloader constructor function to encapsulate HTTP and pagination logic
/*dingdingApp.factory('PageLoader', function($http) {
  var PageLoader = function(type, itemCntPerPage) {
    this.items = [];		// Items to display
    this.busy = false;	// It is true when this is loading
		this.after = 0;			// Item's begin number
		this.type = type;		// Item's type, e.g 'product'...
		this.itemCntPerPage;	// Item count per one page
	};

  PageLoader.prototype.nextPage = function() {
    if (this.busy) return;
    this.busy = true;
		console.log("scroll infinite");
		switch (this.type) {
		case 'product':
			$http({
				method: 'GET',
				url: '/getProductsList/' + this.after + '/' + this.itemCntPerPage
			}).then(function successCallback(response) {
					var data = response.data;
					var items = data;
					for (var i = 0; i < items.length; i++) {
						this.items.push(items[i]);
					}
					this.after = this.after + items.length;
					this.busy = false;
				}, function errorCallback(response) {
					
				}
			);
			break;
		}
  };

  return PageLoader;
});*/


