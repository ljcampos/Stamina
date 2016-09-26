(function() {
	'use strict';

	angular.module('university').controller('UniversityEditController', ['$state', '$stateParams', '$scope', 'UniversityService', UniversityEditController]);

	function UniversityEditController($state, $stateParams, $scope, UniversityService) {
		$scope.university = {};
		$scope.usuario_id = {};
		$scope.universidad_id = {};

		$scope.init = function() {
			//console.log($stateParams.id);
			getUniversityById($stateParams.id);
		};

		angular.element(document).ready(function() {
			$scope.init();
		});

		function getUniversityById(id) {
			UniversityService.getUniversityById(id)
			.then(function(response) {
				$scope.university = response.data;
				$scope.usuario_id = response.data.user.usuario_id;
				$scope.universidad_id = response.data.universidad_id;
			})
			.catch(function(error) {
				console.log(error);
			});
		}

		$scope.editUniversity = function(university) {
			var data 	=	{};
			
			data.nombre 		=	university.nombre;
			data.email 			=	university.email;
			data.estado_id		=	1;
			data.usuario_id		=	$scope.usuario_id;
			data.files			=	"dkashdjksah";

			UniversityService.editUniversity($stateParams.id,data)
			.then(function(response) {
				console.log(response);
				$state.go('admin.university.list');
			})
			.catch(function(error) {
				console.log(error);
			});
		};
	}
} ());