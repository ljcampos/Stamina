(function() {
	'use strict';

	angular.module('entrepreneur').controller('EntrepreneurAnnouncementController', ['$state', '$stateParams', '$scope', 'AnnouncementService', 'EntrepreneurannounceService', 'UserService', EntrepreneurAnnouncementController]);

	function EntrepreneurAnnouncementController($state, $stateParams, $scope, AnnouncementService, EntrepreneurannounceService, UserService){
		$scope.text = 'xsdfsf';
		$scope.announce = {};
		$scope.isApplied = false;
		$scope.user = UserService.getUser();
		$scope.init = function() {
			validAnnouncementApplied($scope.user.data.roles[0].pivot.user_id);
			getAnnouncementById($stateParams.id);
		};
		angular.element(document).ready(function() {
			$scope.init();
		});
		function validAnnouncementApplied(id_user) {
			AnnouncementService.validAnnouncementApplied(id_user) ///usuario/{usuario_id}/convocatorias/
			.then(function(response) {
				console.log(response);
				$scope.isApplied = false;
				/*if(response.data.legth<0){
					$scope.isApplied = false;
				} else $scope.isApplied = true;*/
			})
			.catch(function(error) {
				console.log(error);
				$scope.isApplied = true;
			});
		}
		function getAnnouncementById(id) {
			AnnouncementService.getAnnouncementById(id)
			.then(function(response) {
				$scope.announce = response.data;
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
				$state.go('entrepreneur.form');
			})
			.catch(function(error) {
				console.log(error);
			});
		}
	}
} ());