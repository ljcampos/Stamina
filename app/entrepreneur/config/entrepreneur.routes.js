(function() {
	'use strict';

	angular.module('entrepreneur').config(['$stateProvider', '$urlRouterProvider', EntrepreneurRoutesConfig]);

	function EntrepreneurRoutesConfig($stateProvider, $urlRouterProvider) {
		$stateProvider
		.state('entrepreneur.form', {
			url: '/formulario',
			templateUrl: 'app/entrepreneur/views/application.form.html',
			data: {
				requireLogin: true,
				role: 3
			}
		});
	}
} ());