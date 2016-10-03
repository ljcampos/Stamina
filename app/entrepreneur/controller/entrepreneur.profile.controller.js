(function() {
	'use strict';
	angular.module('entrepreneur').controller('EntrepreneurProfileController', ['$scope', 'AnnouncementService', 'UserService', EntrepreneurProfileController]);
	function EntrepreneurProfileController($scope, AnnouncementService, UserService) {
		$scope.valEditInfoBasic		=	true;
		$scope.valSaveInfoBasic		=	false;
		$scope.valEditInfoContac	=	true;
		$scope.valSaveInfoContac	=	false;
		$scope.user 				=	UserService.getUser();
		$scope.datos 				=	{};

		$scope.init = function() {
			getDatos();
		};

		angular.element(document).ready(function() {
			$scope.init();
		});

		function getDatos() {
			UserService.getUserById($scope.user.data.roles[0].pivot.user_id)
			.then(function(response) {
				$scope.datos.nombre 		= response.data.nombre;
				$scope.datos.paterno 		= response.data.paterno;
				$scope.datos.materno 		= response.data.materno;
				$scope.datos.email 			= response.data.email;
			})
			.catch(function(error) {
				console.log(error);
			});
		}

		function saveUser(datos) {
			UserService.updateUser($scope.user.data.roles[0].pivot.user_id,datos)
			.then(function(response) {
				console.log(response);
			})
			.catch(function(error) {
				console.log(error);
			});
		}

		$scope.editInfoBasic = function(){
			$("#user_nombres").removeAttr("disabled");
			$("#user_apellido_pat").removeAttr("disabled");
			$("#user_apellido_mat").removeAttr("disabled");
			$("#user_nacimiento").removeAttr("disabled");
			$("#user_genero").removeAttr("disabled");
			$scope.valEditInfoBasic		=	false;
			$scope.valSaveInfoBasic		=	true;
		}

		$scope.editInfoContac = function(){
			$("#user_email").removeAttr("disabled");
			$("#user_telefono").removeAttr("disabled");
			$scope.valEditInfoContac	=	false;
			$scope.valSaveInfoContac	=	true;
		}

		$scope.saveInfoBasic = function(datos){
			console.log("Guardando en base de datos");
			saveUser(datos);
			$("#user_nombres").prop("disabled",true);
			$("#user_apellido_pat").prop("disabled",true);
			$("#user_apellido_mat").prop("disabled",true);
			$("#user_nacimiento").prop("disabled",true);
			$("#user_genero").prop("disabled",true);
			$scope.valEditInfoBasic		=	true;
			$scope.valSaveInfoBasic		=	false;
		}

		$scope.saveInfoContac = function(datos){
			console.log("Guardando en base de datos");
			saveUser(datos);
			$("#user_email").prop("disabled",true);
			$("#user_telefono").prop("disabled",true);
			$scope.valEditInfoContac	=	true;
			$scope.valSaveInfoContac	=	false;
		}
	}
} ());
