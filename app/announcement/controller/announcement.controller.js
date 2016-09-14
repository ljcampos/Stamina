(function() {
	'use strict';

	angular.module('announcement').controller('AnnouncementController', ['$scope', 'AnnouncementService', AnnouncementController]);

	function AnnouncementController($scope, AnnouncementService) {
		$scope.text = 'xsdfsf';
		$scope.userList = null;

		$scope.users = function() {
			AnnouncementService.getUsers()
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