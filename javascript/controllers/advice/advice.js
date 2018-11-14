app.controller('PrescribeAdviceController', function($scope, $http, $modal, $rootScope, limitToFilter, $modalInstance) {
	

	$scope.adviceSettingData = {};
	$scope.selectedInvID = 0;
	$scope.advcieSettingData = [];
	$scope.adviceAdderData = {};
	$scope.invAdderData = {};
	$scope.addByName = false;
	
	$scope.doctorData = {};

    $scope.prescription = function () {
        $modalInstance.close(true);
    };
	
	$scope.adviceAdderData.lang = 0;

    $scope.getAdvcieName = function(term) {
        
    	var dataString = 'query=0'+ '&adviceName=' + term + '&lang=' + $scope.adviceAdderData.lang + '&type=' + $scope.doctorData.category;
        
        return $http({
            method: 'POST',
            url: "phpServices/advice/adviceService.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result) {
        	$scope.invNameData = result.data;
        	return limitToFilter($scope.invNameData, 10);
        });

        
       // return $scope.products;
      };
      
	  $scope.onSelectAdviceName = function(item, model, label){
		  $scope.adviceAdderData.advcieID = item.id;
		  $scope.addByName = true;
	  };
	  
	$scope.prepareDoctorSettingData = function (addAnother){
		
		if(!$scope.addByName){
			if(true){
				var dataString = 'query=2'+ '&adviceName=' + $scope.adviceAdderData.name + '&type=' + $scope.doctorData.category + '&pdf=' + $scope.adviceAdderData.pdf + '&lang=' + $scope.adviceAdderData.lang;

		        $http({
		            method: 'POST',
		            url: "phpServices/advice/adviceService.php",
		            data: dataString,
		            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		        }).success(function (result) {
		        	if(addAnother){
                        $scope.adviceAdderData = {};
                        $scope.adviceAdderData.lang = 0;
					}else{
                        $scope.addToDoctorPreference(result);
					}
		        });
			}else{
				alert("Please call admistrator to add Bangla Advice");
			}
			
			
			
		}else{
			
			$scope.addToDoctorPreference($scope.adviceAdderData.advcieID);
		}
	};
	
	$scope.addToDoctorPreference = function (adviceID){
		
		
		var displayOrder = 1;
		if($scope.advcieSettingData != undefined && $scope.advcieSettingData.length > 0){
			displayOrder = parseInt($scope.advcieSettingData[$scope.advcieSettingData.length -1].displayOrder) + 1;
		}
		
		var dataString = 'query=3'+ '&adviceID=' + parseInt(adviceID) + '&displayOrder=' + displayOrder;

        $http({
            method: 'POST',
            url: "phpServices/advice/adviceService.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (result) {
        	$scope.bringPrescribedAdvice();
        });
		
	};
	
	$scope.delAdviceFromSetting = function (adviceSettingID){
		
		var dataString = 'query=6'+ '&adviceSettingID=' + adviceSettingID;

        $http({
            method: 'POST',
            url: "phpServices/advice/adviceService.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (result) {
        	$scope.bringPrescribedAdvice();
        });
	};
	
	$scope.deciderAdvice = function (addedToPrescription,advice){
		
		advice.addedToPrescription = addedToPrescription;
		if(addedToPrescription){
			
			$scope.addAdviceToPresciption(advice.id);
			
	        
		}else{
			$scope.deleteAdviceFromPrescibtion(advice.id);
		}
	};
	
	$scope.addAdviceToPresciption = function (adviceId){
		
		var dataString = 'query=4'+ '&adviceID=' + parseInt(adviceId);

        $http({
            method: 'POST',
            url: "phpServices/advice/adviceService.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (result) {
        	$scope.bringPrescribedAdvice();
        });
	};
	
	$scope.deleteAdviceFromPrescibtion = function (adviceId){
		
		var dataString = 'query=5'+ '&adviceID=' + parseInt(adviceId);

        $http({
            method: 'POST',
            url: "phpServices/advice/adviceService.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (result) {
        	$scope.bringPrescribedAdvice();
        });
	};
	
	/*$scope.bringINVDetail = function (){
		
		
		var dataString = "query=1";

        $http({
            method: 'POST',
            url: "phpServices/inv/invService.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (result) {
        	$scope.invSettingData = result;
        	angular.forEach($scope.invSettingData, function(value, key) {
    			if(parseInt(value.prescribedInvID) > 0){
    				value.addedToPrescription = true;
    			}else{
    				value.addedToPrescription = false;
    			}
    		});
        });
	};*/
	

	
	/*$scope.prepareInvAdderData = function(invAdderData){
		
		if(!invAdderData.note){
			invAdderData.note = "";
		}
		
		if(invAdderData.addByTypeHead){
			$scope.addInvToPresciption(invAdderData.id, invAdderData.note);
			$scope.bringPrescribedInv();
		}else{
			
			var dataString = 'query=3'+ '&invName=' + invAdderData.name;

	        $http({
	            method: 'POST',
	            url: "phpServices/inv/invService.php",
	            data: dataString,
	            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
	        }).success(function (result) {
	        	$scope.addInvToPresciption(result, invAdderData.note);
	        	$scope.bringPrescribedInv();
	        });
	        
		}
	};*/
	
	$scope.bringPrescribedAdvice = function (){
		
		$scope.adviceAdderData = {};
		$scope.adviceAdderData.lang = 0;
		
		var dataString = "query=1";

        $http({
            method: 'POST',
            url: "phpServices/advice/adviceService.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (result) {
        	$scope.advcieSettingData = result;
        	angular.forEach($scope.advcieSettingData, function(value, key) {
    			if(parseInt(value.prescribedAdviceID) > 0){
    				value.addedToPrescription = true;
    			}else{
    				value.addedToPrescription = false;
    			}
    		});
        });
	};
	
	$scope.bringDoctorInfo = function (){
    	
        var dataString = "query=0";

        $http({
            method: 'POST',
            url: "phpServices/appointment/appointmentHelper.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (result) {
        	$scope.doctorData = result;
        	$rootScope.doctorData = $scope.doctorData;
        });
    };
    
    $scope.addAdvice = function (){
    		
    		var prescription = {};
    		var modalInstance = $modal.open({
    	        templateUrl: 'javascript/templates/advice/addAdviceModal.html',
    	        windowClass: 'fade in',
    	        
    	        controller: 'PrescribeAdviceController.AddAdvcieToDB',
    	        resolve: {
    	        	data: function () {
    	                return {
    	                	prescription
    	                };
    	            }
    	        },
    	        backdrop: 'static'
    	    });
    	    modalInstance.result.then(function(result) {
    	    	$scope.bringAdviceSettingData($scope.masterDiseaseData.diseaseID);
    	     });
    	    
    };
	
	  
	
	(function(){
		$scope.bringDoctorInfo();
		$scope.bringPrescribedAdvice();
    })()

	
});

app.controller('PrescribeAdviceController.AddAdvcieToDB', function($scope, $modalInstance, data, $http, $window, $location,limitToFilter) {
	
	$scope.postData = data;
	
	$scope.langSelector = 0;
	
	
	
	$scope.saveNewAdvice = function (){
		
		
			
			if(validator.validateForm("#validateReq","#lblMsg_modal",null)) {
				
			
				var dataString = "query=7" + "&adviceName=" + $scope.name + '&pdf=' + $scope.code + '&lang=' + $scope.langSelector;

		        $http({
		            method: 'POST',
		            url: "phpServices/advice/adviceService.php",
		            data: dataString,
		            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		        }).success(function (result) {
		        	$modalInstance.dismiss('cancel');
		        });
		        
			}else{
				$scope.error = true;
			}
		
    };
    
    

	
	$scope.cancel = function (){
		$modalInstance.dismiss('cancel');
	};
	
	
	
	
});