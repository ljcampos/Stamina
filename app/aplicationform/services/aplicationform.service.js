(function() {
	'use strict';

	angular.module('aplicationform').service('AplicationformService', ['$q', '$http', AplicationformService]);

	function AplicationformService($q, $http) {
		return {
			getQuestionsSection1: getQuestionsSection1
		};

		function getQuestionsSection1(seccion) {
			var sections1 = [];
			var sections = $q.defer();
			//$http.get('https://jsonplaceholder.typicode.com/users')
			$http.get('http://www.stamina.dev/app/aplicationform/database/db.json')
			.success(function(response) {
				for (var i = 0; i < response.length; i++) {
					if (response[i].id_seccion == seccion) {sections1.push(response[i]);}
				}
				sections.resolve(sections1);
				//sections.resolve(response);
			})
			.error(function(error) {
				//console.log(error);
				sections.reject(error);
			});
			return sections.promise;
		}
	}
} ());