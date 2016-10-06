(function() {
	'use strict';

	angular.module('faq').service('FaqService', ['$q', '$http','API', FaqService]);

	function FaqService($q, $http, API) {
		return {
			uploadFile: uploadFile,
		};

		function uploadFile(file) {
			var users = $q.defer();
			
			$http.post(API.faqs.upload,file)
			.success(function(response) {
				console.log(response);
				users.resolve(response);
			})
			.error(function(error) {
				console.log(error);
				users.reject(error);
			});
			return users.promise;
		}

	}
} ());