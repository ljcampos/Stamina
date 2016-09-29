(function() {
	'use strict';

	angular.module('entrepreneur').controller('EntrepreneurAnnouncementController', ['$state', '$stateParams', '$scope', 'AnnouncementService', EntrepreneurAnnouncementController]);

	function EntrepreneurAnnouncementController($state, $stateParams, $scope, AnnouncementService) {
		$scope.text = 'xsdfsf';
		$scope.announce = {};
		$scope.init = function() {
			getAnnouncementById($stateParams.id);
			console.log("CONTROLLER");
		};
		angular.element(document).ready(function() {
			$scope.init();
		});
		function getAnnouncementById(id) {
			AnnouncementService.getAnnouncementById(id)
			.then(function(response) {
				$scope.announce = response.data;
				console.log(response);
			})
			.catch(function(error) {
				console.log(error);
			});
		}
	}
} ());