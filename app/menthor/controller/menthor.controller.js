(function() {
	'use strict';

	angular.module('menthor').controller('MenthorController', ['$scope', 'MenthorService', MenthorController]);

	function MenthorController($scope, MenthorService) {
		$scope.userList = null;
		MenthorService.getUsers()
		.then(function(response) {
			$scope.userList = response.data;			
		})
		.catch(function(error) {
			console.log(error);
		});
	}

	angular.module('menthor').controller('MenthorControllerView', ['$scope', '$location','MenthorServiceView', MenthorControllerView]);
	function MenthorControllerView($scope,$location,MenthorServiceView){
		$scope.id=getIdLocation($location);
		$scope.dataUser=null;
		MenthorServiceView.getDataUser($scope.id)
		.then(function(response){
			console.log(response.data)
			$scope.dataUser=response.data;
		})
		.catch(function(error){
			console.log(error);
		})
	}

	angular.module('menthor').controller('MenthorControllerEdit', ['$scope', '$location','MenthorServiceEdit', MenthorControllerEdit]);
	function MenthorControllerEdit($scope,$location,MenthorServiceEdit){
		$scope.id=getIdLocation($location);
		$scope.user=null;
		MenthorServiceEdit.getDataUser($scope.id)
		.then(function(response){
			console.log(response.data)
			$scope.user=response.data;
		})
		.catch(function(error){
			console.log(error);
		})
	}

	angular.module('menthor').controller('MenthorControllerAdd', ['$scope','$state','$location','MenthorServiceAdd', MenthorControllerAdd]);
	function MenthorControllerEdit($scope,Sstate,$location,MenthorServiceAdd){
		$scope.add=function(){
			console.log('entrando al controlador')
			var nombre= separateName($scope.form.name);
			var data={
			'username':nombre[0],
	        'nombre' : nombre[0],
	        'paterno': nombre[1],
	        'materno': nombre[2],
	        'cargo' : $scope.form.cargo,
	        'descr' : $scope.form.description,
	        'email' : $scope.form.email,
	        'password': $scope.form.password,
	        'isMentor': 1,
	        'rol': 2}
	        console.log(data)
			MenthorServiceAdd.addUser(data)
			.then(function(response){
				console.log(response)
			})
			.catch(function(error){
				console.log(error);
			})
		}
		function separateName(name){
			var data= name.split(' ');
			console.log(data);
			return data;
		}
	}

	function getIdLocation($location){
		var id= $location.path().split('/');
		return id[3];
	}
} ());