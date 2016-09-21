(function() {
	'use strict';

	angular.module('aplicationform').controller('AplicationformController', ['$scope', 'AplicationformService', AplicationformController]);

	function AplicationformController($scope, AplicationformService) {
		$scope.text = 'BASURA';
		$scope.questionsList = null;

		$scope.questionsSection1 = function() {
			AplicationformService.getQuestionsSection1(2)
			.then(function(response) {
				$scope.questionsList = response;
				console.log(response);
			})
			.catch(function(error) {
				console.log(error);
			});
		};
		angular.element(document).ready(function () {
			$scope.questionsSection1();
		});
	}
} ());