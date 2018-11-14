app.controller('ResearchHomeController', function($scope, $http, $modal, $rootScope, limitToFilter, $location, $filter, $window) {
	$scope.changePage = function (page) {
		$scope.selectedPage = page;
		if(page == 1){
			$scope.pageName = "All Apointment List";
		}else if(page == 2){
            $scope.pageName = "Patient List";
		}else if(page == 3){
            $scope.pageName = "Next Day's Appointment List";
        }
        $scope.detailView = true;
    };	
});