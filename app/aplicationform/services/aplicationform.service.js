(function() {
	'use strict';

	angular.module('aplicationform').service('AplicationformService', ['$q', '$http', 'API', AplicationformService]);

	function AplicationformService($q, $http, API) {
		return {
			getQuestionsSection1: getQuestionsSection1
		};

		function getQuestionsSection1(seccion) {
			var sections1 = [];
			var sections = $q.defer();
			//$http.get('https://jsonplaceholder.typicode.com/users')
			$http.get(API.aplicationform.form)
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