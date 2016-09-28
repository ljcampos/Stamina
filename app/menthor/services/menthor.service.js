(function() {
	'use strict';

	angular.module('menthor').service('MenthorService', ['$q', '$http', MenthorService]);
	function MenthorService($q, $http) {
		return {
			getUsers : getUsers,
			getUser  : getUser,
			addUser  : addUser,
			uploadFile : uploadFile
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

	    function uploadFile(file,id){
			var userDefer = $q.defer();		
		   	var fd = new FormData();
	        fd.append('file', file);
	        //console.log(fd);
	        $http.post("API/public/api/v1/usuario/"+id+"/imagen/", fd, {
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined}
	        })
	        .success(function(response){
	        	//console.log('success uploadFile')
	        	userDefer.resolve(response);
	        })
	        .error(function(){
	        	//console.log('error uploadFile')
	        	userDefer.reject(error);
	        });
	        return userDefer.promise;
	    }
	}
} ());