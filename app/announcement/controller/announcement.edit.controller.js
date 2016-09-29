(function() {
	'use strcit';
	angular.module('announcement').controller('AnnouncementEditController', ['$scope', '$stateParams', 'AnnouncementService', AnnouncementEditController]);

	function AnnouncementEditController($scope, $stateParams, AnnouncementService) {
		$scope.announcement = {};
		$scope.init = function() {
			getAnnouncementById($stateParams.id);
		};

		function getAnnouncementById(id) {
			AnnouncementService.getAnnouncementById(id)
			.then(function(response) {
				console.log(response);
				$scope.announcement = response.data;
			})
			.catch(function(error) {
				console.log(error);
			});
		}

		angular.element(document).ready(function() {
			$scope.init();
		});
	}
})();