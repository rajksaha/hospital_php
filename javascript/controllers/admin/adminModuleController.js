app.controller('AdminModuleController', function($scope, $http, $modal, $rootScope, limitToFilter, $location) {
	
	$scope.diseaseList = [];	
    
	$scope.getdiseases = function(){  	
    	var dataString = "query=0";
        $http({
            method: 'POST',
            url: "phpServices/disease/diseaseHelper.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (result) {
        	$scope.diseaseList = result;
        });
    };
	
	
	$scope.deletediseases = function(disease_id, index){  
    	var dataString = "query=1&disease_id="+disease_id;
        $http({
            method: 'POST',
            url: "phpServices/disease/diseaseHelper.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (result) {
        	$scope.getdiseases();
        });
    };
	  
    $scope.editSypmtom = function(diseaseData){
    	
    	angular.forEach($scope.diseaseList, function(value, key) {
			value.otherEditMode = true;
		});
		
    	diseaseData.oterEditMode = false;
    	diseaseData.editMode = true;
    };
	

    $scope.savedisease = function(diseaseData){
    	
    	if(validator.validateForm("#validateReq","#lblMsg",null)) {
    		
    		var  dataString = "query=2" + '&disease_id=' + diseaseData.id + "&diseaseName=" +diseaseData.name;
            $http({
                method: 'POST',
                url: "phpServices/disease/diseaseHelper.php",
                data: dataString,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (result) {
            	$scope.getdiseases();
            });
            
    	}else{
    		$scope.error = true;
    		$scope.message = "";
    		$scope.succcess = false;
    	}
    	
    };


	$scope.inIt = function (){
		$scope.getdiseases();
		
	};
	
	(function(){
		$scope.inIt();
    })()

	
});