(function() {
	'use strict';

	angular.module('menthor').controller('MenthorController', ['$scope','$state', 'MenthorService', MenthorController]);

	function MenthorController($scope,$state, MenthorService) {
		$scope.getDataUsers=function(){
			console.log($state);
			$scope.userList = null;
			MenthorService.getUsers()
			.then(function(response) {
				$scope.userList = response.data;	
			})
			.catch(function(error) {
				console.log(error);
			});
		}

		$scope.getDataUser=function(){
			$scope.id= $state.params.id;
			$scope.user= null;
			MenthorService.getUser($scope.id)
			.then(function(response) {
				console.log("//////////////////////////...........")
				console.log(response)
				$scope.user = response.data;
				console.log("//////////////////////////...........")
			})
			.catch(function(error) {
				console.log(error);
			});
		}

		$scope.add=function(){
			var data={
			'username': $scope.form.name,
	        'nombre'  : $scope.form.name,
	        'paterno' : $scope.form.lastname,
	        'materno' : $scope.form.firstname,
	        'cargo'   : $scope.form.position,
	        'descr'   : $scope.form.description,
	        'email'   : $scope.form.email,
	        'password': $scope.form.password,
	        'type': 2,
	        'rol': 2}
	        $scope.success='';
	        if(angular.equals($scope.form.password,$scope.form.password2)){
				$scope.success = null;
				MenthorService.addUser(data)
				.then(function(response) {
					console.log('REGISTRADO:::::::::::')
					$state.go('admin.menthor.list');
				})
				.catch(function(error) {
					$scope.success='<strong class="mdi-alert-error">No se completo el proceso de grabado</strong>';
					console.log(error);
				});
			}else{
				$scope.success='Las contraseñas son diferentes. Inténtelo nuevamente';
			}
		}
	}
} ());