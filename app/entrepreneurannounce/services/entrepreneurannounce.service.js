(function() {
	'use strict';

	angular.module('faq').service('EntrepreneurannounceService', ['$q', '$http', EntrepreneurannounceService]);

	function EntrepreneurannounceService($q, $http) {
		return {
			suscribirse: suscribirse
		};

		function suscribirse(data) {
			var entrepreneurannounceDefer = $q.defer();
			$http.post('http://www.stamina.dev/API/public/api/v1/usuario/'+data.id_emprendedor+'/convocatoria/'+data.id_convocatoria+'/suscrip/', data)
			.success(function(response) {
				console.log(response);
				entrepreneurannounceDefer.resolve(response);
			})
			.error(function(error) {
				console.log(error);
				entrepreneurannounceDefer.reject(error);
			});
			return entrepreneurannounceDefer.promise;
		}
	}
} ());