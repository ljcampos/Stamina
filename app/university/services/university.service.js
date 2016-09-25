(function() {
	'use strict';

	angular.module('university').service('UniversityService', ['$q', '$http', UniversityService]);

	function UniversityService($q, $http) {
		return {
			getAllUniversities: getAllUniversities,
			addUniversity: addUniversity,
			addUserUniversity: addUserUniversity,
			getUsers: getUsers
		};

		function getAllUniversities() {
			var universityDefer = $q.defer();

			$http.get('http://www.stamina.dev/API/public/api/v1/universidad/')
			.success(function(response) {
				universityDefer.resolve(response);
			})
			.error(function(error) {
				universityDefer.reject(error);
			});

			return universityDefer.promise;
		}

		function addUniversity(data) {
			var universityDefer = $q.defer();
			$http.post('http://www.stamina.dev/API/public/api/v1/universidad/', data)
			.success(function(response) {
				universityDefer.resolve(response);
			})
			.error(function(error) {
				universityDefer.reject(error);
			});
			return universityDefer.promise;
		}

		function addUserUniversity(data) {
			var universityDefer = $q.defer();
			$http.post('http://www.stamina.dev/API/public/api/v1/usuario/', data)
			.success(function(response) {
				universityDefer.resolve(response);
			})
			.error(function(error) {
				universityDefer.reject(error);
				console.log(error);
			});
			return universityDefer.promise;
		}

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