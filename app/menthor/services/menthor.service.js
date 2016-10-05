(function() {
	'use strict';

	angular.module('menthor').service('MenthorService', ['$q', '$http', 'API', MenthorService]);
	function MenthorService($q, $http, API) {
		return {
			getUsers : getUsers,
			getMenthors : getMenthors,
			getUser  : getUser,
			addUser  : addUser,
			updateUser : updateUser,
			uploadFile : uploadFile
		};

		function getMenthors() {
			var users = $q.defer();
			$http.get(API.menthor.list)
			.success(function(response) {
				users.resolve(response);
			})
			.error(function(error) {
				//console.log(error);
				users.reject(error);
			});
			return users.promise;
		}

		function getUsers() {
			var users = $q.defer();
			$http.get(API.user.list+'?type=2')
			.success(function(response) {
				users.resolve(response);
			})
			.error(function(error) {
				//console.log(error);
				users.reject(error);
			});
			return users.promise;
		}

		function getUser(id){
			var user= $q.defer();
			$http.get(API.user.list +id+'/')
			.success(function(response) {
				user.resolve(response);
			})
			.error(function(error) {
				//console.log(error);
				user.reject(error);
			});
			return user.promise;
		}

		function addUser(data) {
			var userDefer = $q.defer();
			$http.post(API.user.list, data)
	      	.success(function(response) {
	        	userDefer.resolve(response);
	      	})
	      	.error(function(error) {
	        	//console.log(error);
	        	userDefer.reject(error);
	      	});
	      	return userDefer.promise;
	    }

	    function updateUser(id,data){
	    	var userDefer= $q.defer();
	    	//console.log(data);
	    	$http.post(API.menthor.update.replace(':id',id), data)
	    	.success(function(response){
	    		userDefer.resolve(response);
	    	})
	    	.error(function(error){
	    		userDefer.reject(error);
	    	});
	    	return userDefer.promise;
	    }

	    function uploadFile(id,file){
	    	var fd = new FormData();
	    	fd.append('file',file);
	    	var userDefer= $q.defer();
	    	$http.post(API.menthor.upload.replace(':id', id), fd,{
	    		transformRequest: angular.identity, headers: {'Content-Type': undefined}
	    	})
	    	.success(function(response){
	    		userDefer.resolve(response);
	    		//console.log(response);
	    	})
	    	.error(function(error){
	    		//console.log(error);
	    		userDefer.reject(error);
	    	});
	    	return userDefer.promise;
	    }
	}
} ());
