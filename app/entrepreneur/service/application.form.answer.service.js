(function() {
	'use strict';
	angular.module('entrepreneur').service('ApplicationFormAnswer', ['$q', '$http', 'API', ApplicationFormAnswer]);

	function ApplicationFormAnswer($q, $http, API) {
		return {
			addSection: addSection
		};

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