(function() {
	'use strict';
	angular.module('entrepreneur').controller('AplicationFormController', ['$scope', 'UniversityService', AplicationFormController]);

	function AplicationFormController($scope, UniversityService) {
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

		// default selected data
		$scope.objSection1.gender = {
			options: [
			{'id': '2','name' :'Elija una opción'},
				{'id':'0', 'name': 'masculino'},
				{'id': '1','name' :'femenino'}
			],
			selected: {'id': '2','name' :'Elija una opción'}
		};

		$scope.init = function() {
			loadData();
		};

		function loadData() {
			// UniversityService.getAllUniversities()
			// .then(function(response) {
			// 	$scope.data = response.data;
			// })
			// .catch(function(error) {
			// 	console.log(error);
			// });
			$scope.objSection1.gender.selected = {'id': '0'};
		}

		$scope.saveSection1 = function() {
			var result = validateSection($scope.objSection1);
			console.log($scope.objSection1);

			if (result === 10) {
				console.log('complete');
				$scope.btnSection1 = false;
				$scope.btnSection2 = false;
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

		angular.element(document).ready(function() {
			$scope.init();
		});
	}
})();