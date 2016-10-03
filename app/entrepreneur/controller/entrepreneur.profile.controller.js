(function() {
	'use strict';
	angular.module('entrepreneur').controller('EntrepreneurProfileController', ['$scope', 'AnnouncementService', EntrepreneurProfileController]);
	function EntrepreneurProfileController($scope, AnnouncementService) {
		$scope.valEditInfoBasic		=	true;
		$scope.valSaveInfoBasic		=	false;
		$scope.valEditInfoContac	=	true;
		$scope.valSaveInfoContac	=	false;

		$scope.init = function() {
			getDatos();
		};
		angular.element(document).ready(function() {
			$scope.init();
		});
		function getDatos() {
			console.log("Toma tus Datos");
			/*AnnouncementService.getAnnouncementsAvailable()
			.then(function(response) {
				$scope.announcesList = response.data;
				console.log(response);
			})
			.catch(function(error) {
				console.log(error);
			});*/
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

		$scope.saveInfoBasic = function(){
			console.log("Guardando en base de datos");
			$("#user_nombres").prop("disabled",true);
			$("#user_apellido_pat").prop("disabled",true);
			$("#user_apellido_mat").prop("disabled",true);
			$("#user_nacimiento").prop("disabled",true);
			$("#user_genero").prop("disabled",true);
			$scope.valEditInfoBasic		=	true;
			$scope.valSaveInfoBasic		=	false;
		}

		$scope.saveInfoContac = function(){
			console.log("Guardando en base de datos");
			$("#user_email").prop("disabled",true);
			$("#user_telefono").prop("disabled",true);
			$scope.valEditInfoContac	=	true;
			$scope.valSaveInfoContac	=	false;
		}
	}
} ());