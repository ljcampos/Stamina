(function() {
	'use strict';

	angular.module('menthor').service('MenthorService', ['$q', '$http', MenthorService]);
	function MenthorService($q, $http) {
		return {
			getUsers : getUsers,
			getUser  : getUser,
			addUser  : addUser
		};

		function getUsers() {
			var users = $q.defer();
			$http.get('http://www.stamina.dev/API/public/api/v1/usuario/?type=2')
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
			var user= $q.defer();
			$http.get('http://www.stamina.dev/API/public/api/v1/usuario/'+id+'/')
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