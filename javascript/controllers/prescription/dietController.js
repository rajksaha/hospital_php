app.controller('PrescriptionController.PrescribeDietController', function($scope, $http, $modalInstance, limitToFilter, $filter, record) {

    $scope.dietData = {};

    if(record.dietData.id){
        $scope.dietData = record.dietData;
    }else{
        $scope.dietData = {};
    }
    $scope.dietNameData = {};

    $scope.diagnosisNote = "";

    $scope.save = function(){

        if(validator.validateForm("#validateReq","#lblMsg_modal",null)) {

            var dataString = "";
            if($scope.dietData.id){

                dataString = "query=" + 3 + '&dietName=' + $scope.dietData.dietName + '&id=' + $scope.dietData.id;

            }else{
                dataString = "query=" + 2 + '&dietName=' + $scope.dietData.dietName;
            }

            $http({
                method: 'POST',
                url: "phpServices/diet/dietHelper.php",
                data: dataString,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (result) {
                $modalInstance.close();

            });
        }else{
            $scope.error = true;
        }
    };

    $scope.cancel = function(){
        $modalInstance.dismiss('cancel');
    };

    $scope.getDiet = function(term) {

        var dataString = "query=" + 0 + "&data=" + term;

        return $http({
            method: 'POST',
            url: "phpServices/diet/dietHelper.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result) {
            $scope.dietNameData = result.data;
            return limitToFilter($scope.dietNameData, 10);
        });
    };

    $scope.onSelectDisease = function(item, model, label){
        $scope.dietData.dietName = item.name;
    };


});