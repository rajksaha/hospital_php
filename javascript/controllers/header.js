app.controller('HeaderController', function($scope, $rootScope, $location, $timeout, $modal, $http) {
	
	$scope.doctorData = {};
	$scope.displayPresCription = true;
	$scope.dateString = new Date();
	
    $scope.bringDoctorInfo = function (){
    	
    	var page = $location.path();
    	
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

    $scope.searchAppointment = function (){
        var $rows = $('.panelChild>.ng-scope');
        var val = $.trim($('#searcheString').val()).replace(/ +/g, ' ').toLowerCase();
        $rows.show().filter(function() {
            var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
            return !~text.indexOf(val);
        }).hide();
    };
	
	 $scope.logout = function () {
		 
		 var dataString = "query=6";

	        $http({
	            method: 'POST',
	            url: "phpServices/appointment/appointmentHelper.php",
	            data: dataString,
	            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
	        }).success(function (result) {
	        	$location.path("/login");
	        });
	       
	 };

	 $scope.toggoleButton = function () {
		$rootScope.hideMenu = !$rootScope.hideMenu;
         $rootScope.$broadcast('event:hideMenu');
     };
    

    (function(){
		$scope.bringDoctorInfo();
    })()
});