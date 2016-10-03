(function() {
	'use strict';

	angular.module('menthor').service('MenthorService', ['$q', '$http', MenthorService]);
	function MenthorService($q, $http) {
		return {
			getUsers : getUsers,
			getMenthors : getMenthors,
			getUser  : getUser,
			addUser  : addUser
		};

		function getMenthors() {
			var users = $q.defer();
			$http.get('http://www.stamina.dev/API/public/api/v1/usuarios/mentores/')
			.success(function(response) {
				users.resolve(response);
			})
			.error(function(error) {
				console.log(error);
				users.reject(error);
			});
			return users.promise;
		}

		function getUsers() {
			var users = $q.defer();
			var data={'type':2}
			$http.get('http://www.stamina.dev/API/public/api/v1/usuario/',data)
			.success(function(response) {
				users.resolve(response);
			})
			.error(function(error) {
				console.log(error);
				users.reject(error);
			});
			return users.promise;
		}

		function getUser(id){
			var data={'type':2}
			var user= $q.defer();
			$http.get('http://www.stamina.dev/API/public/api/v1/usuario/'+id+'/', data)
			.success(function(response) {
				user.resolve(response);
			})
			.error(function(error) {
				console.log(error);
				user.reject(error);
			});
			return user.promise;
		}

		function addUser(data) {
			var userDefer = $q.defer();			
			$http.post('http://www.stamina.dev/API/public/api/v1/usuario/', data)
	      	.success(function(response) {
	        	userDefer.resolve(response);
	      	})
	      	.error(function(error) {
	        	console.log(error);
	        	userDefer.reject(error);
	      	});
	      	return userDefer.promise;
	    }
	}
} ());