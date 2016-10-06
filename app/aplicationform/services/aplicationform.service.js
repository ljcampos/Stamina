(function() {
	'use strict';

	angular.module('aplicationform').service('AplicationformService', ['$q', '$http','API', AplicationformService]);

	function AplicationformService($q, $http, API) {
		return {
			getQuestionsSection1 : getQuestionsSection1,
			getSectionsPlataform : getSectionsPlataform,
			getQuestionsSection : getQuestionsSection
		};

		function getQuestionsSection1(seccion) {
			var sections1 = [];
			var sections = $q.defer();
			$http.get(API.aplicationform.list)
			//$http.get('http://www.stamina.dev/app/aplicationform/database/db.json')
			.success(function(response) {
				console.log('----------------------------------')
				console.log(response)
				for (var i = 0; i < response.length; i++) {
					if (response[i].id_seccion == seccion) {sections1.push(response[i]);}
				}
				sections.resolve(sections1);
				//sections.resolve(response);
			})
			.error(function(error) {
				console.log(error);
				sections.reject(error);
			});
			return sections.promise;
		}

		function getSectionsPlataform(){
			var sections = $q.defer();
			$http.get(API.aplicationform.list)
			.success(function(response) {
				sections.resolve(response);
			})
			.error(function(error) {
				console.log(error);
				sections.reject(error);
			});
			return sections.promise;
		}

		function getQuestionsSection(section){
			var sections = $q.defer();
			$http.get(API.aplicationform.listQuestion.replace(':id',section))
			.success(function(response) {
				sections.resolve(response);
			})
			.error(function(error) {
				console.log(error);
				sections.reject(error);
			});
			return sections.promise;
		}
	}
} ());