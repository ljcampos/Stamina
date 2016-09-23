(function() {
	'use strict';

	angular.module('menthor').service('MenthorService', ['$q', '$http', MenthorService]);

	function MenthorService($q, $http) {
		return {
			getUsers: getUsers
		};

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
	}

	angular.module('menthor').service('MenthorServiceView', ['$q', '$http', MenthorServiceView]);
	function MenthorServiceView($q, $http) {
		return {
			getDataUser: getDataUser
		};

		function getDataUser(id) {
			var user = $q.defer();			
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
	}

	angular.module('menthor').service('MenthorServiceEdit', ['$q', '$http', MenthorServiceEdit]);
	function MenthorServiceEdit($q, $http) {
		return {
			getDataUser: getDataUser
		};

		function getDataUser(id) {
			var user = $q.defer();			
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
	}
	angular.module('menthor').service('MenthorServiceAdd', ['$q', '$http', MenthorServiceAdd]);
	function MenthorServiceAdd($q, $http) {
		return {
			addUser: addUser
		};

		function addUser(data) {
			var userDefer = $q.defer();			
			console.log('entrando al service');
			console.log(data)
			$http.post('http://www.stamina.dev/API/public/api/v1/usuario/', data)
	      	.success(function(response) {
	        	console.log(response);
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