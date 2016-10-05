(function() {
	'use strict';

	angular.module('faq').controller('FaqController', ['$scope','$state', 'FaqService', FaqController]);

	function FaqController($scope, $state, FaqService) {
		//console.log('entrando/////')
		$scope.subir = function(file){
			var archivo= file;
			FaqService.uploadFile(archivo)
			.then(function(response) {
				//console.log(response);
			})
			.catch(function(error) {
				//console.log(error);
			});
		};
	}
} ());