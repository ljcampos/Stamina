(function() {
	'use strict';
	angular.module('entrepreneur').controller('MenthorsController', ['$scope', 'MenthorService', MenthorsController]);
	function MenthorsController($scope, MenthorService) {
		$scope.menthorsList = {};
		$scope.init = function() {
			getMenthors();
		};
		angular.element(document).ready(function() {
			$scope.init();
		});
		function getMenthors() {
			MenthorService.getMenthors()
			.then(function(response) {
				$scope.menthorsList = response.data;
				console.log(response);
			})
			.catch(function(error) {
				console.log(error);
			});
		}
	}
} ());