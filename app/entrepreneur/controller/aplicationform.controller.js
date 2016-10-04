(function() {
	'use strict';
	angular.module('entrepreneur').controller('AplicationFormController', ['$scope', 'UniversityService', AplicationFormController]);

	function AplicationFormController($scope, UniversityService) {
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
				// $scope.btnSection1 = false;
				// $scope.btnSection2 = false;
				// -------------------
				activeTab(getTab(2));

			} else {
				console.log('llene todos los campos');
			}
		};

		$scope.saveSection2 = function() {
			var result = validateSection($scope.objSection2);
			console.log($scope.objSection2);

			// result === 11 falata los checkbox
			if (result === 10) {
				console.log('complete');
				// active the tab component
				activeTab(getTab(3));

			} else {
				console.log('llene todos los campos');
			}
		};

		$scope.saveSection3 = function() {
			var result = validateSection($scope.objSection3);
			console.log($scope.objSection3);

			if (result === 9) {
				console.log('complete');
				// active the tab component
				activeTab(getTab(4));

			} else {
				console.log('llene todos los campos');
			}
		};

		$scope.saveSection4 = function() {
			var result = validateSection($scope.objSection4);
			console.log($scope.objSection4);

			// result === 2 faltan los radio buttons
			if (result === 2) {
				console.log('complete');
				// active the tab component
				activeTab(getTab(5));

			} else {
				console.log('llene todos los campos');
			}
		};

		$scope.saveSection5 = function() {
			var result = validateSection($scope.objSection5);
			console.log($scope.objSection5);

			// result === 6 faltan los radio buttons y checkbox
			if (result === 4) {
				console.log('complete');
				// active the tab component
				activeTab(getTab(6));

			} else {
				console.log('llene todos los campos');
			}
		};

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

		$scope.next = function() {
			console.log('next');
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
			}/*, {
				'title': 'Sección #7',
				'target': '#tab_7',
				'targetId': 7,
				'class': 'disable',
				'subClass': 'disabledTab',
				//'current': false
		}*/
		];

		// $scope.isActiveTab = function(tab) {
		// 	// var result = currentTab();
		// 	// result.current = false;
		// 	// result.class = '';
		// 	// result.subClass = '';
		// 	// console.log(tab);
		// 	// tab.current = true;
		// 	// tab.class = 'active';
		// 	// tab.subClass = '';

		// 	return true;

		// 	/*aria-expanded="true"*/
		// };

		// function currentTab(tab) {
		// 	var result;
		// 	angular.forEach($scope.tabs, function(value, key) {
		// 		if (value.current) {
		// 			result = value;
		// 		}
		// 	});
		// 	return result;
		// }

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