app.controller('FollowUpReportController', function($scope, $http, $modal, $rootScope, limitToFilter, $location, $filter, $window) {


    $scope.search = function () {

        var  dataString='appStart='+  $scope.startDate +'&endDate='+ $scope.endDate +'&patientTypeId='+ $scope.patientTypeId +'&patientCode='+ $scope.patientCode;

        /*return $http({
            method: 'POST',
            url: "excel/followUpReportExcel.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result) {
            console.log(result.data);
        });*/

        var param = { 'patientTypeId' : $scope.patientTypeId};
        OpenWindowWithPost("excel/followUpReportExcel.php", param);
    };

    function OpenWindowWithPost(url, params)
    {
        var form = document.createElement("form");
        form.setAttribute("method", "post");
        form.setAttribute("action", url);
        form.setAttribute("target", "_blank");
        for (var i in params)
        {
            if (params.hasOwnProperty(i))
            {
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = i;
                input.value = params[i];
                form.appendChild(input);
            }
        }
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }

    $scope.bringByPatientID = function(term) {
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

    $scope.getPatientType = function () {

        var dataString = "query=58" + "&doctorType=" + 1;
        $http({
            method: 'POST',
            url: "phpServices/appointment/appointmentHelper.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (result) {
            $scope.patientTypeList = result;
        });
    };

    $scope.setVal = function (val) {
        $scope.patientTypeId = val;
    };


    $scope.getPatientType();
});