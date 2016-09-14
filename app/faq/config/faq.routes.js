(function() {
  'use strict';
  angular.module('faq').config(['$stateProvider', '$urlRouterProvider', CoreRoutesConfig]);

  function CoreRoutesConfig($stateProvider, $urlRouterProvider) {

    $stateProvider
    .state('admin.faq.list', {
      url: '/faq',
      templateUrl: 'app/faq/views/faq.list.html',
      controller: 'FaqController'
    })
    .state('admin.faq.view', {
      url: '/faq/view',
      templateUrl: 'app/faq/views/faq.view.html'
    })
    .state('admin.faq.add', {
      url: '/faq/add',
      templateUrl: 'app/faq/views/faq.add.html'
    });
  }
} ());