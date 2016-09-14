(function() {
	'use strict';

	angular.module('menthor').controller('MenthorController', ['$scope', 'MenthorService', MenthorController]);

	function MenthorController($scope, MenthorService) {
		$scope.userList = null;
		MenthorService.getUsers()
		.then(function(response) {
			$scope.userList = response;
		})
		.catch(function(error) {
			console.log(error);
		});
	}

	angular.module('menthor').controller('MenthorControllerView', ['$scope', '$location','MenthorServiceView', MenthorControllerView]);
	function MenthorControllerView($scope,$location,MenthorServiceView){
		$scope.id=getIdLocation($location);
		$scope.dataUser=null;
		MenthorServiceView.getDataUser($scope.id)
		.then(function(response){
			$scope.dataUser=response[0];
		})
		.catch(function(error){
			console.log(error);
		})
	}

	function getIdLocation($location){
		var id= $location.path().split('/');
		return id[3];
	}
} ());