(function() {
	'use strict';

	angular.module('entrepreneur').controller('AnnouncementsAvailableController', ['$scope', 'AnnouncementService', AnnouncementsAvailableController]);

	function AnnouncementsAvailableController($scope, AnnouncementService) {
		$scope.text = 'xsdfsf';
		$scope.announcesList = {};
		$scope.init = function() {
			getAnnouncementsAvailable();
		};
		angular.element(document).ready(function() {
			$scope.init();
		});
		function getAnnouncementsAvailable() {
			AnnouncementService.getAnnouncementsAvailable()
			.then(function(response) {
				$scope.announcesList = response.data;
				console.log(response);
			})
			.catch(function(error) {
				console.log(error);
			});
		}
	}
} ());