(function() {
	'use strict';

	angular.module('university').controller('UniversityDeleteController', ['$state', '$scope', 'UniversityService', UniversityDeleteController]);

	function UniversityDeleteController($state, $scope, UniversityService) {
		$scope.university				= [];
		
		$scope.init = function() {
			//getUniversities();
		};
		
		angular.element(document).ready(function() {
			$scope.init();
		});

		$scope.deleteUniversity = function(id) {
			var r = confirm("Press a button!");
			if (r === true) {
				//console.log("ELIMINAR");
			} else {
				//console.log("CANCELAR");
			}
		};

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
				//console.log(response);
				$state.go('admin.university.list');
			})
			.catch(function(error) {
				//console.log(error);
			});
		};
	}
} ());