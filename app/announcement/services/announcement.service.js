(function() {
	'use strict';

	angular.module('announcement').service('AnnouncementService', ['$q', '$http', AnnouncementService]);

	function AnnouncementService($q, $http) {
		return {
			getUsers: getUsers
		};

		function getUsers() {
			var users = $q.defer();
			$http.get('https://jsonplaceholder.typicode.com/users')
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