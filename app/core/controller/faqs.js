(function() {
	'use strict';

	angular.module('core').controller('FaqsController', ['$scope', FaqsController]);

	function FaqsController($scope) {
		$scope.test = 'titulo';

		$scope.click = function() {
			alert('hola');
		}
	}
} ());