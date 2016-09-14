(function() {
  'use strict';
  angular.module('faq').config(['$stateProvider', '$urlRouterProvider', CoreRoutesConfig]);

  function CoreRoutesConfig($stateProvider, $urlRouterProvider) {

    $stateProvider
    .state('admin.faq.list', {
      url: '/faq',
      templateUrl: 'app/faq/views/faq.list.html',
      controller: 'FaqController',
      data: {
        requireLogin: true,
        role: 0
      }
    })
    .state('admin.faq.view', {
      url: '/faq/view',
      templateUrl: 'app/faq/views/faq.view.html',
      data: {
        requireLogin: true,
        role: 0
      }
    })
    .state('admin.faq.add', {
      url: '/faq/add',
      templateUrl: 'app/faq/views/faq.add.html',
      data: {
        requireLogin: true,
        role: 0
      }
    });
  }
} ());