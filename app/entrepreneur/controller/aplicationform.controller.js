(function() {
	'use strict';
	angular.module('entrepreneur').controller('AplicationFormController', ['$scope', 'UniversityService', '$filter', AplicationFormController]);

	function AplicationFormController($scope, UniversityService, $filter) {
		// buttons disables by default
		// $scope.btnSection1 = true;
		// $scope.btnSection2 = true;
		// $scope.btnSection3 = true;
		// $scope.btnSection4 = true;
		// $scope.btnSection5 = true;
		// $scope.btnSection6 = true;
		// $scope.btnSection7 = true;

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

		$scope.objSection3.team = {
			options: [
			{'id': '2','name' :'Elija una opción'},
				{'id':'0', 'name': 'Sí, tengo un equipo para el proyecto'},
				{'id': '1','name' :'No, tengo un equipo para el proyecto'}
			],
			selected: {'id': '2','name' :'Elija una opción'}
		};

		$scope.tabs = [{
				'title': 'Sección #1',
				'target': '#tab_1',
				'targetId': 1,
				'class': 'active',
				'subClass': '',
				//'current': true
			}, {
				'title': 'Sección #2',
				'target': '#tab_2',
				'targetId': 2,
				'class': 'disable',
				'subClass': 'disabledTab',
				//'current': false
			}, {
				'title': 'Sección #3',
				'target': '#tab_3',
				'targetId': 3,
				'class': 'disable',
				'subClass': 'disabledTab',
				//'current': false
			}, {
				'title': 'Sección #4',
				'target': '#tab_4',
				'targetId': 4,
				'class': 'disable',
				'subClass': 'disabledTab',
				//'current': false
			}, {
				'title': 'Sección #5',
				'target': '#tab_5',
				'targetId': 5,
				'class': 'disable',
				'subClass': 'disabledTab',
				//'current': false
			}, {
				'title': 'Sección #6',
				'target': '#tab_6',
				'targetId': 6,
				'class': 'disable',
				'subClass': 'disabledTab',
				//'current': false
		}];

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
			//$scope.objSection1.gender.selected = {'id': '0'};
		}

		$scope.saveSection = function(data, formNumber) {
			console.log(data, formNumber);
			var sizeComplete = false;
			var formDataComplete = false;
			var dataSize = getObjectSize(data);

			sizeComplete = validateFormSection(dataSize, formNumber);
			formDataComplete = validateFormData(data);

			// fomat the date
			// if ('birthdate' in data) {
			// 	var dateFormated = $filter('date')(data.birthdate, "dd-MM-yyyy");
			// 	data.birthdate = dateFormated;
			// 	console.log(data.birthdate);
			// }

			if (sizeComplete) {
				console.log('completo');
				if (formNumber < 6)
					activeTab(getTab(formNumber + 1));
			} else {
				console.log('no completo');
			}
		};

		$scope.$watch('birthdate', function (newValue) {
			$scope.objSection1.birthdate = $filter('date')(newValue, 'dd-MM-yyyy');
		});

		function getTab(targetId) {
			var result;
			angular.forEach($scope.tabs, function(value, key) {
				if (value.targetId === targetId) {
					result = value;
				}
			});
			return result;
		}

		function activeTab(tab) {
			tab.class = '';
			tab.subClass = '';
		}

		// $scope.next = function() {
		// 	console.log('next');
		// };

		// validate obj size
		function getObjectSize(data) {
			var size = 0;
			var i;

			for (i in data) {
				if (data.hasOwnProperty(i)) {
					size++;
				}
			}

			return size;
		}

		function validateFormData(data) {
			console.log('data', data);
		}

		function validateFormSection(dataSize, formNumber) {
			switch(formNumber) {
				case 1:
					if (dataSize === 10)
						return true;
					break;
				case 2:
					if (dataSize >= 11)
						return true;
					break;
				case 3:
					if (dataSize === 9)
						return true;
					break;
				case 4:
					if (dataSize === 4)
						return true;
					break;
				case 5:
					if (dataSize >= 6)
						return true;
					break;
				case 6:
					console.log(formNumber);
					if (dataSize === 2)
						return true;
					break;
				default:
					console.log('No existe el formulario.');
			}
		}

		angular.element(document).ready(function() {
			$scope.init();
		});
	}
})();