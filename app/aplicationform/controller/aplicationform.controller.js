(function() {
	'use strict';

	angular.module('aplicationform').controller('AplicationformController', ['$scope', '$state','AplicationformService', AplicationformController]);

	function AplicationformController($scope,$state, AplicationformService) {
		$scope.text = 'BASURA';
		$scope.questionsList = null;

		$scope.questionsSection1 = function() {
			AplicationformService.getQuestionsSection1(2)
			.then(function(response) {
				$scope.questionsList = response;
				console.log(response);
			})
			.catch(function(error) {
				console.log(error);
			});
		};
		

		$scope.listaSecciones = null;		
		$scope.idSection = [];
		$scope.getSeccion= function(){
			AplicationformService.getSectionsPlataform()
			.then(function(response) {
				$scope.listaSecciones = response.data;
				for (var i = 0; i < Object.keys(response.data).length; i++) {
					$scope.idSection[i]= response.data[i].id;
					if(i==0){
						$scope.getQuestion(response.data[i].id); //mandamos a llamar sin dar click
					}
				}
			})
			.catch(function(error) {
				console.log(error);
			});
		}

		$scope.listaPreguntas = null;
		$scope.getQuestion= function(section){		
			AplicationformService.getQuestionsSection(section)
			.then(function(response) {
				$scope.listaPreguntas = response.data.preguntas;
			})
			.catch(function(error) {	
				console.log(error);
			});
		}
		
	}
} ());