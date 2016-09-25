(function() {
	'use strict';

	angular.module('university').controller('UniversityController', ['$state', '$scope', 'UniversityService', UniversityController]);

	function UniversityController($state, $scope, UniversityService) {
		$scope.university				= [];
		/*$scope.university.nombre		= "dasdas";
		$scope.university.fecha_inicio	= null;
		$scope.university.fecha_final	= null;
		$scope.university.logo			= null;
		$scope.university.username		= null;
		$scope.university.pass			= null;*/

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
				console.log(response);
				$scope.universityList = response.data;
			})
			.catch(function(error) {
				console.log(error);
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
			
			UniversityService.addUserUniversity(data)
			.then(function(response) {
				console.log(response);
				$state.go('admin.university.list');
			})
			.catch(function(error) {
				console.log(error);
			});
		};
		/* :::::::::::::::::::::::::::::::::: */
		/*$scope.users = function() {
			UniversityService.getUsers()
			.then(function(response) {
				console.log("Controller: "+response);
				$scope.userList = response;
			})
			.catch(function(error) {
				console.log(error);
			});
		};*/
	}
} ());