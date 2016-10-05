(function() {
	'use strict';

	angular.module('menthor').controller('MenthorController', ['$scope','$state', 'MenthorService', MenthorController]);

	function MenthorController($scope,$state, MenthorService) {
		$scope.menthorsList = {};
		$scope.init = function() {
			getMenthors();
		};
		angular.element(document).ready(function() {
			$scope.init();
		});
		function getMenthors() {
			MenthorService.getMenthors()
			.then(function(response) {
				$scope.menthorsList = response.data;
				console.log(response);
			})
			.catch(function(error) {
				console.log(error);
			});
		}
		$scope.getDataUsers=function(){
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
				$scope.user = response.data;
				//console.log(response.data)
			})
			.catch(function(error) {
				console.log(error);
			});
		}

		$scope.add = function(){
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
					$("#message").html('Mentor registrado correctamente');
					$("#message").attr('class','card-heading col-center alert alert-success').show().fadeOut(4000);
				})
				.catch(function(error) {
					console.log(error);
					$("#message").html('No se completo el proceso de registro');
					$("#message").attr('class','card-heading col-center alert alert-danger').show().fadeOut(4000);
			
				});
			}else{
				$("#message").html('Las contraseñas son diferentes. Inténtelo nuevamente');
				$("#message").attr('class','card-heading col-center alert alert-warning').show().fadeOut(4000);
			
			}
		}

		$scope.update = function(user){
			console.log('actualizado...')
		    MenthorService.updateUser($scope.id,user)
		    .then(function(response){
				$("#message").html('Mentor actualizado correctamente');
				$("#message").attr('class','card-heading col-center alert alert-success').show().fadeOut(4000);
			
		    })
		    .catch(function(error){	
		    	$("#message").html('Error all intentar actualizar al usuario');
				$("#message").attr('class','card-heading col-center alert alert-danger').show().fadeOut(4000);		    });
		}

		$scope.upload = function(photo){
			MenthorService.uploadFile($scope.id,photo)
			.then(function(response){
				//console.log(response);
				$("#message").html('Imagen guardada correctamente');
				$("#message").attr('class','card-heading col-center alert alert-success').show().fadeOut(4000);
			})
			.catch(function(error){
				console.log(error);
				$("#message").html('Error al subir la imagen');
				$("#message").attr('class','card-heading col-center alert alert-danger').show().fadeOut(4000);
			});
		}
	}
} ());