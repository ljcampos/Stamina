(function() {
	'use strict';
	angular.module('entrepreneur').service('ApplicationFormAnswer', ['$q', '$http', 'API', ApplicationFormAnswer]);

	function ApplicationFormAnswer($q, $http, API) {
		return {
			getAnswers: getAnswers,
			getAllAnswers: getAllAnswers,
			addSection: addSection
		};

		function getAllAnswers(id_emprendedor_convocatoria) {
			var answerDefer = $q.defer();
			$http.get(API.answer.update+"emprendedor/"+id_emprendedor_convocatoria+"/completo/")
			.success(function(response) {
				answerDefer.resolve(response);
			})
			.error(function(error) {
				answerDefer.reject(error);
			});
			return answerDefer.promise;
		}

		function getAnswers(id_emprendedor_convocatoria) {
			var answerDefer = $q.defer();
			$http.get(API.answer.update+"emprendedor/"+id_emprendedor_convocatoria+"/")
			.success(function(response) {
				answerDefer.resolve(response);
			})
			.error(function(error) {
				answerDefer.reject(error);
			});
			return answerDefer.promise;
		}

		function addSection(data) {
			var answerDefer = $q.defer();
			$http.post(API.answer.update+data.id_pregunta+"/update/"+data.id_emprendedor_convocatoria+"/", data)
			.success(function(response) {
				answerDefer.resolve(response);
			})
			.error(function(error) {
				answerDefer.reject(error);
			});
			return answerDefer.promise;
		}
	}
}());