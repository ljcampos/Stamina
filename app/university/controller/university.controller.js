(function() {
	'use strict';

	angular.module('university').controller('UniversityController', ['$scope', 'UniversityService', UniversityController]);

	function UniversityController($scope, UniversityService) {
		$scope.text = 'xsdfsf';
		$scope.userList = null;

		$scope.users = function() {
			UniversityService.getUsers()
			.then(function(response) {
				console.log(response);
				$scope.userList = response;
			})
			.catch(function(error) {
				console.log(error);
			});
		};
	}
} ());