(function() {
	'use strict';

	angular.module('entrepreneur').controller('EntrepreneurAnnouncementController', ['$state', '$stateParams', '$scope', 'AnnouncementService', 'EntrepreneurannounceService', 'UserService', EntrepreneurAnnouncementController]);

	function EntrepreneurAnnouncementController($state, $stateParams, $scope, AnnouncementService, EntrepreneurannounceService, UserService){
		$scope.text = 'xsdfsf';
		$scope.announce = {};
		$scope.user = UserService.getUser();
		$scope.init = function() {
			getAnnouncementById($stateParams.id);
			console.log("CONTROLLER");
		};
		angular.element(document).ready(function() {
			$scope.init();
		});
		function getAnnouncementById(id) {
			AnnouncementService.getAnnouncementById(id)
			.then(function(response) {
				$scope.announce = response.data;
				console.log(response);
			})
			.catch(function(error) {
				console.log(error);
			});
		}
		$scope.applyAnnouncement = function(id_announce, id_user){
			//console.log("announce:"+id_announce + " user:"+id_user);
			var data = {};
			data.id_emprendedor 	=	id_user;
			data.id_convocatoria 	=	id_announce;
			data.estatus		 	=	1;

			EntrepreneurannounceService.suscribirse(data)
			.then(function(response) {
				console.log(response);
			})
			.catch(function(error) {
				console.log(error);
			});
		}
	}
} ());