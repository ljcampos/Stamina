(function() {
	'use strict';

	angular.module('faq').controller('FaqController', ['$scope', 'FaqService', FaqController]);

	function FaqController($scope, FaqService) {
		$scope.text = 'xsdfsf';
		$scope.userList = null;

		$scope.users = function() {
			FaqService.getUsers()
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