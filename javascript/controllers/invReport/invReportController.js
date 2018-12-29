app.controller('invReportController', function($scope, $http, $modal, $rootScope, limitToFilter, $location, $upload) {
	
	$scope.patientData = {};
	$scope.oldAppoinmentList =[];
	$scope.invReportList = [];
	$scope.appoinmentData ={};
	$scope.patientStateList = [];
	
	$scope.bringPatientInfo = function(){

		var dataString = "query=0";

        $http({
            method: 'POST',
            url: "phpServices/prescription/prescriptionHelperService.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (result) {
        	$scope.patientData = result;
        	$scope.bringPatientOldReport();
        });
	};

    
	$scope.bringPatientOldReport = function (){
    	
		var dataString = "query=0";

        $http({
            method: 'POST',
            url: "phpServices/invReports/invReportDateHelper.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (result) {
        	$scope.oldReportList = result;
        	if($scope.oldReportList.length > 0){
                $scope.appoinmentData.selector = $scope.oldReportList[0];
                $scope.getInvReports($scope.appoinmentData.selector.reportDate);
			}
        });
    };
    
    $scope.getInvReports = function(reportDate){
        $scope.prescriptionViewDate = reportDate;
    	var dataString = "query=1" + '&formattedDate=' + reportDate;
        $http({
            method: 'POST',
            url: "phpServices/invReports/invReportDateHelper.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (result) {
            $scope.showPrescriptionView = true;
        	$scope.invReportList = result;
            if($scope.invReportList){
                $scope.showLastUploadedPhoto($scope.invReportList[0]);
            }
        });
    };

    $scope.showLastUploadedPhoto = function (report) {
        var lastFile = report;
        if(lastFile.ext == 'pdf'){
            $scope.imageView = false;
            $scope.pdfView = true;
            $scope.imageLink = lastFile.reportLocation;
        }else{
            $scope.imageView = true;
            $scope.pdfView = false;
            $scope.imageLink = lastFile.reportLocation;
        }
    };


    $scope.addInvReport = function(){


        var modalInstance = $modal.open({
            templateUrl: 'javascript/templates/invReport/addNewReport.html',
            windowClass: 'center-modal',
            controller: 'invReportController.AddReportController',
            backdrop: 'static'
        });
        modalInstance.result.then(function(result) {
            $scope.bringPatientOldReport();
        });
    };

	$scope.inIt = function (){
		$scope.bringPatientInfo();
		
	};
	
	(function(){
		$scope.inIt();
    })()

	
});

app.controller('invReportController.AddReportController', function($scope, $modalInstance, $http, $upload, $filter) {

    $scope.invReportData = {};
    $scope.invReportData.reportDate = new Date();
    $scope.invReportData.file = null;
    $scope.error = false;
    $scope.errorMessage = "";

    $scope.onFileSelect = function($files){
        $scope.invReportData.file = $files[0];
        $scope.uploading = true;
        $scope.hasCsvError = false;
    };


    $scope.save = function (){

        if($scope.invReportData.reportDate && $scope.invReportData.file){
            var extensionKey = $scope.invReportData.file.name.split('.').pop().toLowerCase();
            var data = {};
            data.reportDate = $filter('date')($scope.invReportData.reportDate, "yyyy-MM-dd");
            data.extension = extensionKey;
            data.fileName = $scope.invReportData.file.name;
            $upload.upload({
                url : 'phpServices/invReports/saveReport.php',
                method: 'POST',
                data : data,
                file: $scope.invReportData.file,
                formDataAppender: function (formData, key, val) {
                    formData.append(key, val);
                    return formData;
                }
            }).then(function(result) {
                $modalInstance.close();
            }, function(result) {
                $modalInstance.close();
            }, function(evt) {
                $modalInstance.close();
            });

        }else{

        }



    }

    $scope.cancel = function (){
        $modalInstance.dismiss('cancel');
    };


});