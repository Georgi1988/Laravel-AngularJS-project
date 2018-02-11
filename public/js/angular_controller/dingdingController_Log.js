// Mobile user employee controller only dealer
dingdingApp.controller('LogController', function($scope, $rootScope, $route, $routeParams, $http, PagerService, myDialogService) {	
	$rootScope.route_status = 'log';
	
	$scope.pagenum = 1;
	$scope.itemcount = 5;
	
	
	
	
	$scope.search = {
		operate_type: $scope.selectedData, 
		start_date: $scope.start_date, 
		end_date: $scope.end_date
	};	
	$scope.nodata = false;
	$scope.get_page_list = function(pagenum, itemcount, search) {
		if($scope.pagenum > 0){			
			$http.get('log/list/' + JSON.stringify(search) + '/' + itemcount + '/' + pagenum).then(
				function(response){
					console.log(response.data);
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
		
	$scope.get_operatetype_list = function() {
		if($scope.pagenum > 0){			
			$http.get('log/operatetype_list').then(
				function(response){
					
					var level1_select = {'operation_kind': "", 'val': "", 'label': "--" + lang['l_operation_type'] + "--"};
					$scope.operatetype_list = response.data;
					$scope.operatetype_list.unshift(level1_select);
					$scope.selectedData= level1_select;	
					$scope.selectlist_type = {
						availableOptions: $scope.operatetype_list,
						selectedOption: $scope.selectedData
					}
					console.log($scope.operatetype_list[0]);
					
					return response.data.list;
				}
			);
		}
	}
	
	$scope.get_operatetype_list();
	$scope.setPage = function(pagenum){
		$scope.search = {
			operate_type: $scope.selectlist_type.selectedOption.val, 
			start_date: $scope.start_date, 
			end_date: $scope.end_date
		};
		if(pagenum < 1) pagenum = 1;
		else if(pagenum > $scope.list_data.last_page) pagenum = $scope.list_data.last_page;
		$scope.get_page_list(pagenum, $scope.itemcount, $scope.search);
	}
	
	$scope.search_change = function(){
		$scope.search = {
			operate_type: $scope.selectlist_type.selectedOption.val, 
			start_date: $scope.start_date, 
			end_date: $scope.end_date
		};
		
		$scope.get_page_list(1, $scope.itemcount, $scope.search);
	}
	
	$scope.get_page_list($scope.pagenum, $scope.itemcount, $scope.search);
	
});
