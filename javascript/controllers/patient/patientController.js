app.controller('PatientController', function($scope, $http, $modal, $rootScope, limitToFilter, $location, $filter, $window) {
	
	$scope.numberOfAppointment = 0;
 	$scope.limit = 10;
	$scope.nextDate = "";	
 	$scope.addMoreToLimit = 10;
 	$scope.appointmentList = [];
 	$scope.doctorData = {};
 	$scope.followUpSearch = false;
 	$scope.patientName = "";
 	$scope.addAppointMentData = {};
 
 	$scope.numberOfPatient = 0;	
 	$scope.patientList = [];
	
	$scope.numberOfAppointedPatient = 0;	
 	$scope.appointmentNextList = [];
	
	
	$scope.bringAllNextAppointedPatient = function (){
		var today = new Date();
		var dd = today.getDate()+1;
		var mm = today.getMonth()+1; //January is 0!
		var yyyy = today.getFullYear();		
		if(dd<10) 		dd = '0'+dd;
		if(mm<10)		mm = '0'+mm;

		 $scope.nextDate = yyyy + '-' + mm + '-' + dd;
        var filteredDate = $filter('date')( $scope.nextDate, "yyyy-MM-dd");		
        var  dataString='filteredDate='+  filteredDate +'&query='+11;
        $http({
            method: 'POST',
            url: "phpServices/appointment/appointmentHelper.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (result) {
            $scope.appointmentNextList = result;
            $scope.numberOfAppointedPatient = $scope.appointmentNextList.length;
        });
    };



	$scope.bringByDatesing = function (appointmentDatesingle){
        var filteredDate = $filter('date')(appointmentDatesingle, "yyyy-MM-dd");
        var  dataString='filteredDate='+  filteredDate +'&query='+1;
        $http({
            method: 'POST',
            url: "phpServices/appointment/appointmentHelper.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (result) {
            $scope.appointmentList = result;
            $scope.numberOfAppointment = $scope.appointmentList.length;
        });
    };


    $scope.bringByDisease = function (Disease){
        var  dataString='filteredDate='+ Disease +'&query='+981;
        $http({
            method: 'POST',
            url: "phpServices/appointment/appointmentHelper.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (result) {
            $scope.appointmentList = result;
            $scope.numberOfAppointment = $scope.appointmentList.length;
			
			$scope.patientList = result;
            $scope.numberOfPatient = $scope.patientList.length;
			
            return limitToFilter($scope.patientCode, 10);
        });
    };


    $scope.bringByDiseaseShow = function(term) {
        var  dataString='data='+  term +'&query='+77;
        return $http({
            method: 'POST',
            url: "phpServices/appointment/appointmentHelper.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result) {
            $scope.patients = result.data;
            return limitToFilter($scope.patients, 10);
        });
        // return $scope.products;
    };


 	$scope.BringByPatientID = function(term) {
        var  dataString='data='+  term +'&query='+68;
        return $http({
            method: 'POST',
            url: "phpServices/appointment/appointmentHelper.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result) {
            $scope.patients = result.data;
            return limitToFilter($scope.patients, 10);
        });
        // return $scope.products;
    };

    $scope.bringByPatientAddd = function (PCode){
        var  dataString='filteredDate='+ PCode +'&query='+888;
        $http({
            method: 'POST',
            url: "phpServices/appointment/appointmentHelper.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (result) {
            $scope.appointmentList = result;
            $scope.numberOfAppointment = $scope.appointmentList.length;
            return limitToFilter($scope.patientCode, 10);
        });
    };


    $scope.bringShowDname = function(term) {
        var  dataString='data='+  term +'&query='+75;
        return $http({
            method: 'POST',
            url: "phpServices/appointment/appointmentHelper.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result) {
            $scope.patients = result.data;
            return limitToFilter($scope.patients, 10);
        });
        // return $scope.products;
    };
	
	$scope.bringShowType = function(term) {
        var  dataString='data='+  term +'&query='+12;
        return $http({
            method: 'POST',
            url: "phpServices/appointment/appointmentHelper.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result) {
            $scope.patients = result.data;
            return limitToFilter($scope.patients, 10);
        });
        // return $scope.products;
    };
	

	$scope.bringByPatientType = function (name){
        var  dataString='filteredDate='+ $.trim(name) +'&query='+13;
        $http({
            method: 'POST',
            url: "phpServices/appointment/appointmentHelper.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (result) {			
			$scope.patientList = result;
            $scope.numberOfPatient = $scope.patientList.length;
			return limitToFilter($scope.patientCode, 10);
        });
    };
	


    $scope.bringByPatientName = function (name){
        var  dataString='filteredDate='+ name +'&query='+999;
        $http({
            method: 'POST',
            url: "phpServices/appointment/appointmentHelper.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (result) {
            $scope.appointmentList = result;
            $scope.numberOfAppointment = $scope.appointmentList.length;
			
			$scope.patientList = result;
            $scope.numberOfPatient = $scope.patientList.length;
			
            return limitToFilter($scope.patientCode, 10);
        });
    };

		$scope.bringAllPatient = function(){
        var  dataString='query=14';
        $http({
            method: 'POST',
            url: "phpServices/appointment/appointmentHelper.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (result) {
            $scope.appointmentList = result;
            $scope.numberOfAppointment = $scope.appointmentList.length;
			
			$scope.patientList = result;
            $scope.numberOfPatient = $scope.patientList.length;
			
            return limitToFilter($scope.patientCode, 10);
        });
    };

    $scope.bringByDate = function (appointmentDate, end){
    	var filteredDate = $filter('date')(appointmentDate, "yyyy-MM-dd");
    	var endDate = $filter('date')(end, "yyyy-MM-dd");
    	var  dataString='filteredDate='+  filteredDate +'&endDate=' + endDate +'&query='+99;
        $http({
            method: 'POST',
            url: "phpServices/appointment/appointmentHelper.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (result) {
        	$scope.appointmentList = result;
        	$scope.numberOfAppointment = $scope.appointmentList.length;
        });
    };
    
    $scope.printPreview = function (appointmentData){
    	var  dataString = 'patientCode='+ appointmentData.patientCode  +'&patientID='+ appointmentData.patientID +'&appointmentID='+ appointmentData.appointmentID +'&query='+18;
        $http({
            method: 'POST',
            url: "phpServices/prescription/prescriptionHelperService.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (result) {
        	 $window.open("mpdf/" + $scope.doctorData.pdfPage + ".php", '_blank');
        	 
        });    	
    };
    
    $scope.addINAppointment  = function (patientCode){   	 
    	 var currentDate = new Date();
      	 var filteredDate = $filter('date')(currentDate, "yyyy-MM-dd");   	 
     	 var  dataString='doctorCode='+ $scope.doctorData.doctorCode +'&patientCode='+ patientCode +'&doctorID='+ $scope.doctorData.doctorID +'&query='+3 + '&filteredDate='+  filteredDate;
         $http({
            method: 'POST',
            url: "phpServices/appointment/appointmentHelper.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result) {
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
         }, function(error){
         	$location.path("/login");
         });
     };

	(function(){
		$scope.bringDoctorInfo();
		$scope.bringAllNextAppointedPatient();
    })()
	
});