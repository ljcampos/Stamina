(function() {
	'use strict';
	angular.module('announcement').controller('AnnouncementViewController', ['$state', '$stateParams', '$scope', 'EntrepreneurannounceService', 'UserService', AnnouncementController]);
	function AnnouncementController($state, $stateParams, $scope, EntrepreneurannounceService, UserService) {
		$scope.text = 'xsdfsf';
		$scope.valores = {};
		$scope.init = function() {
			getAnnouncementEntrepreneurs($stateParams.id,1);
		};
		angular.element(document).ready(function() {
			$scope.init();
		});
		function getAnnouncementEntrepreneurs(id,status) {
			EntrepreneurannounceService.getAnnouncementEntrepreneurs(id,status)
			.then(function(response) {
				$scope.valores = response.data;
				console.log(response);
			})
			.catch(function(error) {
				//console.log(error);
			});
		}
	}
} ());