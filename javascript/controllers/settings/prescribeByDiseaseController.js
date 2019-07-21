app.controller('PrescribeByDiseaseController', function($scope, $http, $modal, $rootScope, limitToFilter, $filter) {
	
	
	$scope.masterDiseaseData = {};
	$scope.drugSettingList = [];
	$scope.invSettingList = [];
	$scope.advieSettingList = [];
	
	$scope.doctorData = {};

	$scope.diagnosisData = {};
	
	
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
    
	
	$scope.bringSettings = function (){
		var dataString = "query=" + 3 + '&diagnosisName=' + $scope.diagnosisData.diseaseName;
        $http({
            method: 'POST',
            url: "phpServices/prescriptionSetting/prescriptionSetting.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (result) {
        	
        	$scope.masterDiseaseData.diseaseID = parseInt(result);
        	
        	$scope.bringData();
        });
	};
	
	$scope.bringDrugSettingData = function (diseaseID){
		
		var dataString = "query=0" + "&diseaseID=" + diseaseID;

        $http({
            method: 'POST',
            url: "phpServices/prescriptionSetting/prescriptionSetting.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (result) {
        	$scope.drugSettingList = result;
        	 
        });
	};
	
	$scope.bringInvSettingData = function (diseaseID){
		
		var dataString = "query=1" + "&diseaseID=" + diseaseID;

        $http({
            method: 'POST',
            url: "phpServices/prescriptionSetting/prescriptionSetting.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (result) {
        	$scope.invSettingList = result;
        });
	};
	
	
	$scope.bringAdviceSettingData = function (diseaseID){
		
		var dataString = "query=2" + "&diseaseID=" + diseaseID;

        $http({
            method: 'POST',
            url: "phpServices/prescriptionSetting/prescriptionSetting.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (result) {
        	$scope.advieSettingList = result;
        	 
        });
	};
	
	$scope.delAdviceFromSetting = function (advciceSettingID){
		
		var dataString = "query=10" + "&advciceSettingID=" + advciceSettingID;

        $http({
            method: 'POST',
            url: "phpServices/prescriptionSetting/prescriptionSetting.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (result) {
        	$scope.bringAdviceSettingData($scope.masterDiseaseData.diseaseID);
        	 
        });
	};
	
	$scope.deleteInvFromSetting = function (invSettingID){
		
		var dataString = "query=11" + "&invSettingID=" + invSettingID;

        $http({
            method: 'POST',
            url: "phpServices/prescriptionSetting/prescriptionSetting.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (result) {
        	$scope.bringInvSettingData($scope.masterDiseaseData.diseaseID);
        	 
        });
	};
	
	$scope.deleteDrugsFromSetting = function (drugSettingID){
		
		var dataString = "query=12" + "&drugSettingID=" + drugSettingID;

        $http({
            method: 'POST',
            url: "phpServices/prescriptionSetting/prescriptionSetting.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (result) {
        	$scope.bringDrugSettingData($scope.masterDiseaseData.diseaseID);
        	 
        });
	};
	
	
	
	$scope.modalForDrugs = function(){
		
	var prescription = {};
		prescription.diseaseID = $scope.masterDiseaseData.diseaseID;
		prescription.doctorID = $scope.doctorData.doctorID;
	var modalInstance = $modal.open({
        templateUrl: 'javascript/templates/settings/addDrugModal.html',
        windowClass: 'fade in',
        
        controller: 'PrescribeSettingsController.AddDrugsToSettings',
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
    	$scope.bringDrugSettingData($scope.masterDiseaseData.diseaseID);
     });
    
	};
	
	$scope.modalForInv = function(){
		
		var prescription = {};
			prescription.diseaseID = $scope.masterDiseaseData.diseaseID;
			prescription.doctorID = $scope.doctorData.doctorID;
			prescription.invSettingList = $scope.invSettingList;
		var modalInstance = $modal.open({
	        templateUrl: 'javascript/templates/settings/addInvModal.html',
	        windowClass: 'fade in',
            size: 'lg',
            backdrop: 'static',
	        controller: 'PrescribeSettingsController.AddInvToSettings',
	        resolve: {
	        	data: function () {
	                return {
	                	prescription
	                };
	            }
	        }

	    });
	    modalInstance.result.then(function(result) {
	    	$scope.bringInvSettingData($scope.masterDiseaseData.diseaseID);
	     });
	    
		};
		
	$scope.modalForAdvice = function(){
		
		var prescription = {};
			prescription.diseaseID = $scope.masterDiseaseData.diseaseID;
			prescription.doctorID = $scope.doctorData.doctorID;
        	prescription.settingList = $scope.advieSettingList;
		var modalInstance = $modal.open({
	        templateUrl: 'javascript/templates/settings/addAdviceModal1.html',
	        windowClass: 'fade in',
            size: 'lg',
	        controller: 'PrescribeSettingsController.AddAdviceToSettings',
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
	
	$scope.getDisease = function(term) {
		
		var dataString = "query=" + 0 + "&data=" + term;
	    
	    return $http({
	        method: 'POST',
	        url: "phpServices/diagnosis/diagnosis.php",
	        data: dataString,
	        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
	    }).then(function(result) {
	    	$scope.diagnosisNameData = result.data;
	    	return limitToFilter($scope.diagnosisNameData, 10);
	    });
	};

	  $scope.onSelectDisease = function(item, model, label){
		  $scope.diagnosisData.diseaseName = item.name;
	  };
	
	$scope.bringData = function (){
		
		$scope.bringDrugSettingData($scope.masterDiseaseData.diseaseID);
    	$scope.bringInvSettingData($scope.masterDiseaseData.diseaseID);
    	$scope.bringAdviceSettingData($scope.masterDiseaseData.diseaseID);
    	$scope.diseaseSelected = true;
	};
	
	(function(){
		$scope.bringDoctorInfo();
    })()
	
});



app.controller('PrescribeSettingsController.AddInvToSettings', function($scope, $modalInstance, data, $http, $window, $location,limitToFilter, $filter) {
	
	$scope.postData = data;
	$scope.postData.note = "";




    $scope.bringInvCategory = function (){
        var dataString = "query=59";
        $http({
            method: 'POST',
            url: "phpServices/appointment/appointmentHelper.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (result) {
            $scope.invCategoryList = result;
            $scope.invCategoryList.push({name : "No Category", invCategoryID : 0});
        });
	};

    $scope.bringInvByCategory = function (invCategoryID) {
        var dataString = "query=60&invCategoryID=" + invCategoryID;
        $http({
            method: 'POST',
            url: "phpServices/appointment/appointmentHelper.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (result) {
            $scope.invCategoryDataList = result;
            if($scope.postData.prescription.invSettingList && $scope.postData.prescription.invSettingList.length > 0){
                angular.forEach($scope.postData.prescription.invSettingList, function(value, key) {
                    var data = $filter('filter')($scope.invCategoryDataList, {id: value.invID}, true);
                });
			}


        });
    };

	
	$scope.addToInvSetting = function (add, inv){

		if(!add){
            inv.addedToPrescription = false;
            if(inv.invSettingId){
                var dataString = "query=11" + "&invSettingId=" + inv.invSettingId;

                $http({
                    method: 'POST',
                    url: "phpServices/prescriptionSetting/prescriptionSetting.php",
                    data: dataString,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (result) {
                    inv.invSettingId = null;
                });
			}
		}else{
            inv.addedToPrescription = true;
            var dataString = "query=6" + '&diseaseID=' + $scope.postData.prescription.diseaseID + '&doctorID=' + $scope.postData.prescription.doctorID + "&invId=" + inv.id + "&note=" + $scope.postData.note;

            $http({
                method: 'POST',
                url: "phpServices/prescriptionSetting/prescriptionSetting.php",
                data: dataString,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (result) {
                inv.invSettingId = result;
            });
		}
    };

	$scope.cancel = function (){
        $modalInstance.close();
	};

    $scope.bringInvCategory();
	
	
});

app.controller('PrescribeSettingsController.AddAdviceToSettings', function($scope, $modalInstance, data, $http, $window, $location,limitToFilter, $filter) {
	
	$scope.postData = data;
	
	$scope.type = 0;

    $scope.addToAdviceSetting = function (add, advice){

        if(!add){
            advice.addedToPrescription = false;
            if(advice.settingId){
                var dataString = "query=10" + "&settingID=" + advice.settingId;

                $http({
                    method: 'POST',
                    url: "phpServices/prescriptionSetting/prescriptionSetting.php",
                    data: dataString,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (result) {
                    advice.settingId = null;
                });
            }
        }else{
            advice.addedToPrescription = true;
            var dataString = "query=7" + '&diseaseID=' + $scope.postData.prescription.diseaseID + '&doctorID=' + $scope.postData.prescription.doctorID + "&adviceID=" + advice.id;

            $http({
                method: 'POST',
                url: "phpServices/prescriptionSetting/prescriptionSetting.php",
                data: dataString,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (result) {
                advice.settingId = result;
            });
        }
    };
	
	$scope.saveNewAdviceSetting = function (){
		
		
			
			if(validator.validateForm("#validateReq","#lblMsg_modal",null)) {
				
			
				var dataString = "query=7" + '&diseaseID=' + $scope.postData.prescription.diseaseID + '&doctorID=' + $scope.postData.prescription.doctorID + "&adviceName=" + $scope.name;

		        $http({
		            method: 'POST',
		            url: "phpServices/prescriptionSetting/prescriptionSetting.php",
		            data: dataString,
		            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		        }).success(function (result) {
		        	$modalInstance.close();
		        });
		        
			}else{
				$scope.error = true;
			}
		
    };
    
    $scope.getAdvcieName = function(term) {
        
    	var dataString = 'query=9'+ '&queryString=' + term + '&lang=' + $scope.type;
        
        return $http({
            method: 'POST',
            url: "phpServices/prescriptionSetting/prescriptionSetting.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result) {
        	$scope.adviceNameData = result.data;
        	return limitToFilter($scope.adviceNameData, 10);
        });

        
       // return $scope.products;
      };
      
  $scope.onSelectAdviceName = function(item, model, label){
	  $scope.name = item.advice;
  };


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

            if($scope.postData.prescription.settingList && $scope.postData.prescription.settingList.length > 0){
                angular.forEach($scope.postData.prescription.settingList, function(value, key) {
                    var data = $filter('filter')($scope.advcieSettingData, {id: value.adviceID}, true);
                    if(data && data.length > 0){
                        data[0].settingId = value.id;
                        data[0].addedToPrescription =  true;
                    }else {
                        data[0].addedToPrescription = false;
                    }
                });
            }
        });
    };
    

	
	$scope.cancel = function (){
		$modalInstance.close();
	};

    (function(){
        $scope.bringPrescribedAdvice();
    })()
	
	
	
	
});