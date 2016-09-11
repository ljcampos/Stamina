(function() {
	'use strict';

	angular.module('menthor').controller('MenthorController', ['$scope', 'MenthorService', MenthorController]);

	function MenthorController($scope, MenthorService) {
		$scope.text = 'xsdfsf';
		$scope.userList = null;

		$scope.users = function() {
			MenthorService.getUsers()
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