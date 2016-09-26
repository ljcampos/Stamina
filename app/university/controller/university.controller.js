(function() {
	'use strict';

	angular.module('university').controller('UniversityController', ['$state', '$scope', 'UniversityService', UniversityController]);

	function UniversityController($state, $scope, UniversityService) {
		$scope.university = [];
		$scope.dato = "dasdas";
		/*$scope.university.nombre		= null;
		$scope.university.fecha_inicio	= null;
		$scope.university.fecha_final	= null;
		$scope.university.logo			= null;
		$scope.university.username		= null;
		$scope.university.pass			= null;*/

		$scope.universityList = null;

		$scope.init = function() {
			console.log("dasdaskjd");
			//getUniversities();
		};

		angular.element(document).ready(function() {
			$scope.init();
		});

		function getUniversities() {
			UniversityService.getAllUniversities()
			.then(function(response) {
				console.log(response);
				$scope.universityList = response.data;
			})
			.catch(function(error) {
				console.log(error);
			});
		};

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
			
			UniversityService.addUserUniversity(data)
			.then(function(response) {
				console.log(response);
				$state.go('admin.university.list');
			})
			.catch(function(error) {
				console.log(error);
			});
		};
		/*$scope.deleteUniversity = function(id) {
			var r = confirm("¿Está seguro de que desea eliminar permanentemente el elemento especificado de la base de datos?");
			if(r){
				console.log("CODIGO ELIMINAR");
			}
		};*/
	}
} ());