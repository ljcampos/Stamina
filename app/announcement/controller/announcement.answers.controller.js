(function() {
	'use strict';
	angular.module('announcement').controller('AnnouncementAnswersController', ['$state', '$stateParams', '$scope', 'ApplicationFormAnswer', 'UserService', AnnouncementAnswersController]);
	function AnnouncementAnswersController($state, $stateParams, $scope, ApplicationFormAnswer, UserService) {
		$scope.respuestas 		= {};
		
		$scope.init = function() {
			getAllAnswers($stateParams.id);
		};
		angular.element(document).ready(function() {
			$scope.init();
		});
		function getAllAnswers(id) {
			ApplicationFormAnswer.getAllAnswers(id)
			.then(function(response) {
				console.log(response.data);
			})
			.catch(function(error) {
				console.log(error);
			});
		}
	}
} ());