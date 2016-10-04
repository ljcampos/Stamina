(function() {
	'use strict';

	angular.module('entrepreneur').controller('PanelEntrepreneurController', ['$state', '$stateParams', '$scope', 'AnnouncementService', 'EntrepreneurannounceService', 'UserService', PanelEntrepreneurController]);

	function PanelEntrepreneurController($state, $stateParams, $scope, AnnouncementService, EntrepreneurannounceService, UserService){
		$scope.isApplied = false;
		$scope.user = UserService.getUser();
		$scope.init = function() {
			validAnnouncementApplied($scope.user.data.roles[0].pivot.user_id);
		};
		angular.element(document).ready(function() {
			$scope.init();
		});
		function validAnnouncementApplied(id_user) {
			AnnouncementService.validAnnouncementApplied(id_user) ///usuario/{usuario_id}/convocatorias/
			.then(function(response) {
				console.log(response);
				$scope.isApplied = false;
			})
			.catch(function(error) {
				console.log(error);
				$scope.isApplied = true;
			});
		}
	}
} ());