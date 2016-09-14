(function() {
  'use strict';
  angular.module('announcement').config(['$stateProvider', '$urlRouterProvider', CoreRoutesConfig]);

  function CoreRoutesConfig($stateProvider, $urlRouterProvider) {

    $stateProvider
    .state('admin.announcement.list', {
      url: '/announcement',
      templateUrl: 'app/announcement/views/announcement.list.html',
      controller: 'AnnouncementController'
    })
    .state('admin.announcement.view', {
      url: '/announcement/view',
      templateUrl: 'app/announcement/views/announcement.view.html'
    })
    .state('admin.announcement.add', {
      url: '/announcement/add',
      templateUrl: 'app/announcement/views/announcement.add.html'
    });
  }
} ());