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

    $scope.bringDoctorInfo = function (){
        var dataString = "query=2";

        $http({
            method: 'POST',
            url: "phpServices/admin/adminModuleService.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (result) {
            $scope.userAccessInfo = result;
            $rootScope.userAccessInfo = $scope.userAccessInfo;
        }, function(error){
            $location.path("/login");
        });
    };


    $scope.hasAccess = function(accessKey){
        if($scope.userAccessInfo){
            if($scope.userAccessInfo.userType == 'DOCTOR'){return true;}
            var temp = $filter('filter')($scope.userAccessInfo.accessList, {accessCode: accessKey}, true)[0];
            return temp == null ? false : true;
        }

    };

    $scope.hasAccessMenu = function(main){
        if($scope.userAccessInfo){
            if($scope.userAccessInfo.userType == 'DOCTOR'){return true;}
            var temp = $filter('filter')($scope.userAccessInfo.accessList, {parentAccessID: main}, true)[0];
            return temp == null ? false : true;
        }
    };

    (function(){
        $scope.bringDoctorInfo();
    })()
});