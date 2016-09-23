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
	function MenthorControllerAdd($scope,Sstate,$location,MenthorServiceAdd){
		console.log('entrando al controlador add')
		$scope.add=function(){
			console.log('entrando al controlador');
	 	    var data = {
		        'username': $scope.form.name,
		        'nombre' : $scope.form.name,
		        'paterno': $scope.form.lastname,
		        'materno': $scope.form.firstname,
		        'cargo'  : $scope.form.position,
			    'descr'  : $scope.form.description,
		        'email'  : $scope.form.email,
		        'password': $scope.form.pass,
		        'isMentor': 1,
		        'rol': 2,
			    'type':2
	      	};
	      	console.log('>>>>>>>>>>>>>>>>>>>>>>')
	        console.log(data)
	      	console.log('>>>>>>>>>>>>>>>>>>>>>>')
			MenthorServiceAdd.addUser(data)
			.then(function(response){
				$scope.succes=true;
			})
			.catch(function(error){
				$scope.succes=false;
			})
		}

		function comparePassword(){
			if($scope.form.pass!=null && $scope.form.pass!=''){
				if($scope.form.confirmpass!=null && $scope.form.confirmpass!=''){
					if($scope.form.pass==$scope.form.confirmpass){
						return true;
					}else{
						$scope.error=0;
					}
				}else{
					$scope.error=1;
				}
			}else{
				$scope.error=3;
			}		
			return false;
		}
	}

	function getIdLocation($location){
		var id= $location.path().split('/');
		return id[3];
	}
} ());