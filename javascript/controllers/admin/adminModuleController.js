app.controller('AdminModuleController', function($scope, $http, $modal, $rootScope, limitToFilter, $location, $filter) {
	
	$scope.userProfileList = [];
    
	$scope.getUserProfileList = function(){
    	var dataString = "query=0";
        $http({
            method: 'POST',
            url: "phpServices/admin/adminModuleService.php",
            data: dataString,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (result) {
        	$scope.userProfileList = result;
        });
    };

	$scope.processEditor = function (datastring, userProfile) {

        $http({
            method: 'POST',
            url: "phpServices/admin/adminModuleService.php",
            data: datastring,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (result) {
            userProfile.accessList = $scope.processAccessList(result);
            var modalInstance = $modal.open({
                templateUrl: 'javascript/templates/admin/addNewUser.html',
                windowClass: 'fade in',
                size: 'lg',
                controller: 'AdminModuleController.UserProfileEditorController',
                resolve: {
                    data: function () {
                        return {
                            userProfile
                        };
                    }
                },
                backdrop: 'static'
            });
            modalInstance.result.then(function(result) {
                $scope.getUserProfileList();
            });
        });
    };


    $scope.addUserProfile = function(){
        var dataString = "query=5";
        var userProfile = {};
        userProfile.userID = null;
        $scope.processEditor(dataString, userProfile);
    };

    $scope.editUser = function(user){
        var dataString = "query=1&userId="+user.userID;
        $scope.processEditor(dataString, user);
    };

    $scope.processAccessList = function (accessList) {
        var reDesignedAccessList = [];
        angular.forEach(accessList, function(value, key) {
            if(value.accessType == 'MAIN'){
                value.subAccessList = $filter('filter')(accessList, {parentAccessID: value.accessID}, true);
                reDesignedAccessList.push(value);
            }
        });
        return reDesignedAccessList;
    };




	$scope.inIt = function (){
		$scope.getUserProfileList();
		
	};
	
	(function(){
		$scope.inIt();
    })()

	
});


app.controller('AdminModuleController.UserProfileEditorController', function($scope, $modalInstance, data, $http) {

    $scope.userProfile = data.userProfile;
    $scope.error = false;
    $scope.errorMessage = "";

    $scope.changeStatus = function (item) {

        if(item.haveAccess == 0){
            item.haveAccess = 1;
        }else{
            item.haveAccess = 0;
        }
    };

    $scope.save = function (){
        if(validator.validateForm("#validateReq","#lblMsg_modal",null)) {
            var entryData = $scope.userProfile;
            console.log(entryData);
            jQuery.post("phpServices/admin/userAdderService.php",  {json: JSON.stringify(entryData)}, function(data){
                console.log(data);
                if(data.trim() == '-1'){
                    $scope.error = true;
                    $scope.errorMessage = "Login name already exist, please select another login name";
                }else{
                    $modalInstance.close(null);
                }
            });
        }else{
            $scope.error = true;
        }


    };

    $scope.cancel = function (){
        $modalInstance.dismiss('cancel');
    };
});