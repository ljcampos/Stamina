(function() {
	'use strict';
	angular.module('entrepreneur').controller('AplicationFormController', ['$scope', AplicationFormController]);

	function AplicationFormController($scope) {
		// buttons disables by default
		$scope.btnSection1 = true;
		$scope.btnSection2 = true;
		$scope.btnSection3 = true;
		$scope.btnSection4 = true;
		$scope.btnSection5 = true;
		$scope.btnSection6 = true;
		$scope.btnSection7 = true;

		// sections objects
		$scope.objSection1 = {};
		$scope.objSection2 = {};
		$scope.objSection3 = {};
		$scope.objSection4 = {};
		$scope.objSection5 = {};
		$scope.objSection6 = {};
		$scope.objSection7 = {};

		$scope.saveSection1 = function() {
			var result = validateSection($scope.objSection1);

			if (result === 10) {
				console.log('complete');
			} else {
				console.log('llene todos los campos');
			}
		};

		// validate obj size
		function validateSection(data) {
			var size = 0;
			var i;

			for (i in data) {
				if (data.hasOwnProperty(i)) {
					size++;
				}
			}

			return size;
		}
	}
})();