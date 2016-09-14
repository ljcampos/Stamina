(function() {
	'use strict';

	angular.module('menthor').service('MenthorService', ['$q', '$http', MenthorService]);

	function MenthorService($q, $http) {
		return {
			getUsers: getUsers
		};

		function getUsers() {
			var users = $q.defer();
			$http.get('https://jsonplaceholder.typicode.com/users')
			.success(function(response) {
				users.resolve(response);
			})
			.error(function(error) {
				console.log(error);
				users.reject(error);
			});
			return users.promise;
		}
	}

	angular.module('menthor').service('MenthorServiceView', ['$q', '$http', MenthorServiceView]);
	function MenthorServiceView($q, $http) {
		return {
			getDataUser: getDataUser
		};

		function getDataUser(id) {
			var user = $q.defer();
			$http.get('https://jsonplaceholder.typicode.com/users?id='+id)
			.success(function(response) {
				user.resolve(response);
			})
			.error(function(error) {
				console.log(error);
				user.reject(error);
			});
			return user.promise;
		}
	}

} ());