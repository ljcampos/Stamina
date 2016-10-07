(function() {
	'use strict';
	angular.module('announcement').controller('AnnouncementAnswersController', ['$state', '$stateParams', '$scope', 'ApplicationFormAnswer', 'UserService', AnnouncementAnswersController]);
	function AnnouncementAnswersController($state, $stateParams, $scope, ApplicationFormAnswer, UserService) {
		$scope.respuestas	= {};
		$scope.califF		= {};
		$scope.comentF		= {};
		$scope.init = function() {
			getAllAnswers($stateParams.id);
		};
		angular.element(document).ready(function() {
			$scope.init();
		});
		function getAllAnswers(id) {
			ApplicationFormAnswer.getAllAnswers(id)
			.then(function(response) {
				$scope.respuestas = response.data;
				//for (var i = 0; i < response.data.length; i++) {
					angular.forEach(response.data, function(value, key) {
						console.log(value.id_pregunta);
					});
				//}
			})
			.catch(function(error) {
				console.log(error);
			});
		}
	}
} ());