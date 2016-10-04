(function() {
	'use strict';

	angular.module('university').service('UniversityService', ['$q', '$http', 'API', UniversityService]);

	function UniversityService($q, $http, API) {
		return {
			getAllUniversities: getAllUniversities,
			addUniversity: addUniversity,
			addUserUniversity: addUserUniversity,
			getUniversityById: getUniversityById,
			editUniversity: editUniversity,
			deleteUniversity: deleteUniversity,
			getUsers: getUsers
		};

		function getAllUniversities() {
			var universityDefer = $q.defer();
			$http.get(API.university.list)
			.success(function(response) {
				universityDefer.resolve(response);
				
			})
			.error(function(error) {
				universityDefer.reject(error);
				console.log(error);
			});
			return universityDefer.promise;
		}

		function addUniversity(data) {
			var universityDefer = $q.defer();
			$http.post(API.university.list.add, data)
			.success(function(response) {
				universityDefer.resolve(response);
			})
			.error(function(error) {
				universityDefer.reject(error);
			});
			return universityDefer.promise;
		}

		function getUniversityById(id) {
			var universityDefer = $q.defer();

			$http.get(API.university.ById.replace(':id',id))
			.success(function(response) {
				universityDefer.resolve(response);
				console.log(response);
			})
			.error(function(error) {
				universityDefer.reject(error);
				console.log(error);
			});

			return universityDefer.promise;
		}

		function editUniversity(id,data) {
			var universityDefer = $q.defer();
			$http.post(API.university.update.replace(':id', id),data)
			.success(function(response) {
				universityDefer.resolve(response);
				
			})
			.error(function(error) {
				universityDefer.reject(error);
				console.log(error);
			});
			return universityDefer.promise;
		}

		function deleteUniversity(id) {
			var universityDefer = $q.defer();
			$http.post(API.university.delete.replace(':id', id))
			.success(function(response) {
				universityDefer.resolve(response);
			})
			.error(function(error) {
				universityDefer.reject(error);
				console.log(error);
			});
			return universityDefer.promise;
		}

		function addUserUniversity(data) {
			var universityDefer = $q.defer();
			$http.post(API.user.list, data)
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