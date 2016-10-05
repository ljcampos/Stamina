(function() {
	'use strict';

	angular.module('university').controller('UniversityController', ['$state', '$scope', 'UniversityService', UniversityController]);

	function UniversityController($state, $scope, UniversityService) {
		$scope.university = [];

		$scope.universityList = null;

		$scope.init = function() {
			getUniversities();
		};

		angular.element(document).ready(function() {
			$scope.init();
		});

		function getUniversities() {
			UniversityService.getAllUniversities()
			.then(function(response) {
				$scope.universityList = response.data;
			})
			.catch(function(error) {
				//console.log(error);
			});
		}

		/* :::::::::::::::::::::::::::::::::: */

		$scope.addUniversity = function(university) {
			var data 	=	{};
			data.username 			=	university.email;
			data.email 				=	university.email;
			data.password 			=	university.pass;
			data.nombre 			=	university.nombre;
			data.paterno 			=	university.nombre;
			data.materno 			=	university.nombre;
			data.type 				=	4;
			data.isMentor 			=	0;
			data.inicio_servicio 	=	university.fecha_inicio;
			data.final_servicio 	=	university.fecha_final;
			
			UniversityService.addUserUniversity(data)
			.then(function(response) {
				//console.log(response);
				$state.go('admin.university.list');
			})
			.catch(function(error) {
				//console.log(error);
			});
		};
		$scope.deleteUniversity = function(id) {
			var r = confirm("¿Está seguro de que desea eliminar permanentemente el elemento especificado de la base de datos?");
			if(r){
				UniversityService.deleteUniversity(id)
				.then(function(response) {
					getUniversities();
				})
				.catch(function(error) {
					//console.log(error);
				});
				//console.log("CODIGO ELIMINAR");
			}
		};
	}
} ());