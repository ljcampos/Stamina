(function() {
	'use strict';

	angular.module('menthor').controller('MenthorController', ['$scope','$state','MenthorService', MenthorController]);

	function MenthorController($scope,$state, MenthorService) {

		$scope.getDataUsers=function(){
			$scope.userList = null;
			MenthorService.getUsers()
			.then(function(response) {
				$scope.userList = response.data;	
				console.log(response.data);		
			})
			.catch(function(error) {
				console.log(error);
			});
		}

		$scope.getDataUser=function(){
			console.log('controller un solo usuario')
			$scope.id= $state.params.id;
			$scope.user= null;
			MenthorService.getUser($scope.id)
			.then(function(response) {
				$scope.user = response.data;
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
	        'rol': 2};

	        if(angular.equals($scope.form.password,$scope.form.password2)){
				$scope.success = null;
				MenthorService.addUser(data)
				.then(function(response) {
					console.log(response);
					$("#message").attr('class','float-label alert alert-success');	
					$("#message").html('¡Registro éxitoso!').fadeOut(4000);						
					setTimeout(function(){ $state.go('admin.menthor.list'); }, 5000);
				})
				.catch(function(error) {
					$("#message").attr('class','float-label alert alert-danger');	
					$("#message").html('¡Registro no completado, inténtelo nuevamente!').show().fadeOut(6000);			
					console.log(error);
				});
			}else{
				$("#message").attr('class','float-label alert alert-warning');	
				$("#message").html('¡Las contraseñas son diferentes, inténtelo nuevamente!').show().fadeOut(6000);	
			}
		}

		$scope.uploadPic = function(myFile) {
	        //console.log('file is ' );
	        //console.log(myFile);
	        MenthorService.uploadFile(myFile,$scope.id)
			.then(function(response) {
				console.log('success');
				//console.log(response);
				$("#msj").attr('class','alert alert-success');	
				$("#msj").html('Imagen cargada correctamente').show().fadeOut(6000);
			})
			.catch(function(error) {
				console.log('fail');
				//console.log(error);				
				$("#msj").attr('class','alert alert-error');	
				$("#msj").html('Proceso no completado').show().fadeOut(6000);
			});
		  }

	}
} ());