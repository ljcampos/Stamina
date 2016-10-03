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
		})
		.state('entrepreneur.faqs', {
			url: '/faqs',
			templateUrl: 'app/entrepreneur/views/faqs.view.html',
			data: {
				requireLogin: true,
				role: 3
			}
		})
		.state('entrepreneur.announcements', {
			url: '/convocatorias',
			templateUrl: 'app/entrepreneur/views/announcements.available.html',
			controller: 'AnnouncementsAvailableController',
			data: {
				requireLogin: true,
				role: 3
			}
		})
		.state('entrepreneur.announcement', {
			url: '/convocatoria/:id',
			templateUrl: 'app/entrepreneur/views/announcement.view.html',
			controller: 'EntrepreneurAnnouncementController',
			data: {
				requireLogin: true,
				role: 3
			}
		})
		.state('entrepreneur.profile', {
			url: '/perfil',
			templateUrl: 'app/entrepreneur/views/entrepreneur.profile.html',
			controller: 'EntrepreneurProfileController',
			data: {
				requireLogin: true,
				role: 3
			}
		})
		.state('entrepreneur.menthors', {
			url: '/ponentes_y_mentores',
			templateUrl: 'app/entrepreneur/views/menthors.html',
			controller: 'MenthorsController',
			data: {
				requireLogin: true,
				role: 3
			}
		});
	}
} ());