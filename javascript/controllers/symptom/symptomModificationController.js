app.controller('SymptomModificationController', function($scope, $http, $modal, $rootScope, limitToFilter, $location) {
	
	$scope.symptomList = [];	
    
	$scope.getSymptoms = function(){  	
    	var dataString = "query=0";
        $http({
            method: 'POST',
            url: "phpServices/symptom/symptomHelper.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (result) {
        	$scope.symptomList = result;
        });
    };
	
	
	$scope.deleteSymptoms = function(symptom_id, index){  
    	var dataString = "query=1&symptom_id="+symptom_id;
        $http({
            method: 'POST',
            url: "phpServices/symptom/symptomHelper.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (result) {
        	$scope.getSymptoms();
        });
    };
	  
    $scope.editSypmtom = function(symptomData){
    	
    	angular.forEach($scope.symptomList, function(value, key) {
			value.otherEditMode = true;
		});
		
    	symptomData.oterEditMode = false;
    	symptomData.editMode = true;
    };
	

    $scope.saveSymptom = function(symptomData){
    	
    	if(validator.validateForm("#validateReq","#lblMsg",null)) {
    		
    		var  dataString = "query=2" + '&symptom_id=' + symptomData.symptomID + "&symptomName=" +symptomData.name;
            $http({
                method: 'POST',
                url: "phpServices/symptom/symptomHelper.php",
                data: dataString,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (result) {
            	$scope.getSymptoms();
            });
            
    	}else{
    		$scope.error = true;
    		$scope.message = "";
    		$scope.succcess = false;
    	}
    	
    };


	$scope.inIt = function (){
		$scope.getSymptoms();
		
	};
	
	(function(){
		$scope.inIt();
    })()

	
});