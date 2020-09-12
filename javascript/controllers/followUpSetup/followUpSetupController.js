app.controller('FollowUpSetupController', function($scope, $http, $modal, $rootScope, limitToFilter, $location) {
	
	

	$scope.invNameData = [];
	$scope.invData = {};
	$scope.invFollowUpChart = [];
	$scope.followUpChartData = [];
	$scope.recentStart = 0;
	$scope.recentEnd = 0;
	$scope.patientAppoinmentList = [];
	$scope.patientTypeId = null;
    $scope.followUpInvName = "";
    $scope.doctorTypeId = null;
	
	$scope.typeHeadSelected = false;
	
    $scope.getInvName = function(term) {
        
    	var dataString = 'query=0'+ '&invName=' + term;
        
        return $http({
            method: 'POST',
            url: "phpServices/inv/invCategoryService.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result) {
        	$scope.invNameData = result.data;
        	return limitToFilter($scope.invNameData, 10);
        });

        
       // return $scope.products;
      };

    $scope.getPatientType = function () {

        var dataString = "query=6" + "&doctorType=" + $scope.doctorTypeId;
        $http({
            method: 'POST',
            url: "phpServices/patient/patientTypeService.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (result) {
            $scope.patientTypeList = result;
        });
    };
      
	  $scope.onSelectInvName = function(item, model, label){
		  $scope.invData.id = item.id;
          $scope.followUpInvName = item.name;
		  $scope.typeHeadSelected = true;
	  };
	

	  $scope.addInvToFollowUp = function(followUpInvName){

          $scope.followUpInvName = "";
          $("#fInvName").val("");
          var dataString = 'query=11'+ '&invName=' + followUpInvName + "&patientTypeId=" + $scope.patientTypeId;;

	        $http({
	            method: 'POST',
	            url: "phpServices/inv/invCategoryService.php",
	            data: dataString,
	            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
	        }).success(function (result) {
                $scope.bringFollowUpChart($scope.patientTypeId);
	        });
	  };
	  
	  $scope.delete = function(id){
		  
		  var dataString = 'query=13'+ '&id=' + id;

	        $http({
	            method: 'POST',
	            url: "phpServices/inv/invCategoryService.php",
	            data: dataString,
	            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
	        }).success(function (result) {
	        	$scope.bringFollowUpChart($scope.patientTypeId);
	        });
	  };

	  $scope.bringFollowUpChart = function (patientTypeId) {

          $scope.followUpInvName = "";

          $scope.patientTypeId = patientTypeId;
          var dataString = 'query=12' + "&patientTypeId=" + patientTypeId;
          $http({
              method: 'POST',
              url: "phpServices/inv/invCategoryService.php",
              data: dataString,
              headers: {'Content-Type': 'application/x-www-form-urlencoded'}
          }).success(function (result) {
              $scope.followUpList = result;
          });
      };
	  
	  
	$scope.inIt = function (){

        var dataString = "query=5";
        $http({
            method: 'POST',
            url: "phpServices/patient/patientTypeService.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (result) {
            $scope.doctorTypeId = result;

            var dataString = "query=4" + "&doctorType=" + $scope.doctorTypeId;
            $http({
                method: 'POST',
                url: "phpServices/patient/patientTypeService.php",
                data: dataString,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (result) {
                $scope.patientTypeList = result;
            });
        });




	};

    $scope.managePatientType = function () {
        var data = {};
        data.patientTypeList = angular.copy($scope.patientTypeList);
        data.doctorTypeId = $scope.doctorTypeId;
        var patientTypeData = {};
        var modalInstance = $modal.open({
            templateUrl: 'javascript/templates/patient/patientType.html',
            windowClass: 'fade in',
            size: 'sm',
            controller: 'PatientTypeController',
            resolve: {
                record: function () {
                    return {
                        data
                    };
                }
            },
            backdrop: 'static'
        });
        modalInstance.result.then(function(result) {
            $scope.getPatientType();
        });
    };

	$scope.inIt();

	
});