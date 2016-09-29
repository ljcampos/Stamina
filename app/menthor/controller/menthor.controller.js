(function() {
	'use strict';

	angular.module('menthor').controller('MenthorController', ['$scope','$state','MenthorService', MenthorController]);

	function MenthorController($scope,$state, MenthorService) {

		$scope.getDataUsers=function(){
			$scope.userList = null;
			MenthorService.getUsers()
			.then(function(response) {
				$scope.userList = response.data;	
				//console.log(response);
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

		$scope.add=function(file){
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
					//console.log(response.code);
					//console.log(response.message);
					if(response.code==1){						
						$("#message").attr('class','float-label alert alert-success');	
						$("#message").html(response.message).fadeOut(6000).show().fadeOut(6000);
					}
					if(response.code==2){					
						$("#message").attr('class','float-label alert alert-warning');	
						$("#message").html('Ya existe un usuario asociado a la cuenta de correo').fadeOut(6000).show().fadeOut(6000);
					}			
				})
				.catch(function(error) {
					$("#message").attr('class','float-label alert alert-danger');	
					$("#message").html('¡Registro no completado, inténtelo nuevamente!').show().fadeOut(6000);			
					console.log(error);
				});
			}else{
				$("#message").attr('class','float-label alert alert-warning');	
				$("#message").html('¡Las contraseñas no coinciden, inténtelo nuevamente!').show().fadeOut(6000);	
			}
		}

		$scope.update=function (file){			
			$scope.uploadPic(file, $scope.id);
			console.log(file);
			console.log($scope.id)
		}

		$scope.uploadPic = function(file,id) {
	        //console.log('file is ' );
	        //console.log(myFile);
	        MenthorService.uploadFile(file,id)
			.then(function(response) {
				console.log('success');
				console.log(response);
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