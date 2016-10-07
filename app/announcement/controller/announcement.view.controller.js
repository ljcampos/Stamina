(function() {
	'use strict';
	angular.module('announcement').controller('AnnouncementViewController', ['$state', '$stateParams', '$scope', 'EntrepreneurannounceService', 'UserService', AnnouncementViewController]);
	function AnnouncementViewController($state, $stateParams, $scope, EntrepreneurannounceService, UserService) {
		$scope.prospectos 		= {};
		$scope.aplicaciones 	= {};
		$scope.aceptados 		= {};
		$scope.init = function() {
			getAnnouncementEntrepreneursProspectos($stateParams.id,1);
			//getAnnouncementEntrepreneursAplicaciones($stateParams.id,2);
			//getAnnouncementEntrepreneursAceptados($stateParams.id,3);
		};
		angular.element(document).ready(function() {
			$scope.init();
		});
		function getAnnouncementEntrepreneursProspectos(id,status) {
			EntrepreneurannounceService.getAnnouncementEntrepreneurs(id,status)
			.then(function(response) {
				console.log(response.data);
				$scope.prospectos = response.data;
			})
			.catch(function(error) {
				console.log(error);
			});
		}
		function getAnnouncementEntrepreneursAplicaciones(id,status) {
			EntrepreneurannounceService.getAnnouncementEntrepreneurs(id,status)
			.then(function(response) {
				console.log(response.data);
				$scope.aplicaciones = response.data;
			})
			.catch(function(error) {
				console.log(error);
			});
		}
		function getAnnouncementEntrepreneursAceptados(id,status) {
			EntrepreneurannounceService.getAnnouncementEntrepreneurs(id,status)
			.then(function(response) {
				console.log(response.data);
				$scope.aceptados = response.data;
			})
			.catch(function(error) {
				console.log(error);
			});
		}
	}
} ());