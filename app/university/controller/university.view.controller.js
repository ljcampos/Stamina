(function() {
	'use strict';

	angular.module('university').controller('UniversityViewController', ['$state', '$stateParams', '$scope', 'UniversityService', UniversityViewController]);

	function UniversityViewController($state, $stateParams, $scope, UniversityService) {
		$scope.university = {};
		$scope.usuario_id = {};
		$scope.universidad_id = {};

		$scope.init = function() {
			getUniversityById($stateParams.id);
		};

		angular.element(document).ready(function() {
			$scope.init();
		});

		function getUniversityById(id) {
			UniversityService.getUniversityById(id)
			.then(function(response) {
				$scope.university = response.data;
			})
			.catch(function(error) {
				console.log(error);
			});
		}
	}
} ());