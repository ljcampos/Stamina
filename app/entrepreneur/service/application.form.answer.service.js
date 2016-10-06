(function() {
	'use strict';
	angular.module('entrepreneur').service('ApplicationFormAnswer', ['$q', '$http', 'API', ApplicationFormAnswer]);

	function ApplicationFormAnswer($q, $http, API) {
		return {
			addSection: addSection
		};

		function addSection(data) {
			console.log(data);
		}
	}
}());