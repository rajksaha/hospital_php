app.controller('SettingSelectionController', function($scope, $http, $modal, $rootScope, limitToFilter, $location, JsonService, $window) {
	$scope.changePage = function (page) {
		$scope.selectedPage = page;
		if(page == 1){
			$scope.pageName = "Create Template";
		}else if(page == 2){
            $scope.pageName = "Inv Category";
		}else if(page == 3){
            $scope.pageName = "Bangla Drug Advice";
        }else if(page == 4){
            $scope.pageName = "Default Follow-up";
        }else if(page == 5){
			$scope.pageName = "Database";
        }else if(page == 6){
           $scope.pageName = "Symptoms";
        }else if(page == 7){
           $scope.pageName = "Diseases";
        }else if(page == 8){
            $scope.pageName = "Administration";
        }
        $scope.detailView = true;
    };	
});