(function() {
	'use strict';
	angular.module('university').controller('UniversityEditController', ['$state', '$stateParams', '$scope', 'UniversityService', 'Upload', UniversityEditController]);
	function UniversityEditController($state, $stateParams, $scope, UniversityService, Upload) {
		$scope.university 		= {};
		$scope.usuario_id 		= {};
		$scope.universidad_id 	= {};
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
				$scope.university 		= response.data;
				$scope.usuario_id 		= response.data.user.usuario_id;
				$scope.universidad_id 	= response.data.universidad_id;
			})
			.catch(function(error) {
				//console.log(error);
			});
		}
		$scope.editUniversity = function(university, image) {
			var data 	=	{};	
			data.nombre 					=	university.nombre;
			data.email 						=	university.user.email;
			data.fecha_inicio_servicio 		=	university.fecha_inicio_servicio;
			data.fecha_final_servicio 		=	university.fecha_final_servicio;
			data.estado_id					=	1;
			data.usuario_id					=	$scope.usuario_id;
			data.file						=	image;
			// console.log(data);
			image.upload = Upload.upload({
				url: 'http://www.stamina.dev/API/public/api/v1/universidad/'+$stateParams.id+'/update/',
				method: 'POST',
				data: data
			})
			.then(function(res) {
				//console.log(res);
				$state.go('admin.university.list');
			})
			.catch(function(err) {
				//console.log(err);
			});
			UniversityService.editUniversity($stateParams.id,data)
			.then(function(response) {
				//console.log(response);
				$state.go('admin.university.list');
			})
			.catch(function(error) {
				//console.log(error);
			});
		};
	}
} ());