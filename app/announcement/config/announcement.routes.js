(function() {
  'use strict';
  angular.module('announcement').config(['$stateProvider', '$urlRouterProvider', CoreRoutesConfig]);

  function CoreRoutesConfig($stateProvider, $urlRouterProvider) {

    $stateProvider
    .state('admin.announcement.list', {
      url: '/announcement',
      templateUrl: 'app/announcement/views/announcement.list.html',
      controller: 'AnnouncementController',
      data: {
        requireLogin: true,
        role: 1
      }
    })
    .state('admin.announcement.view', {
      url: '/announcement/view',
      templateUrl: 'app/announcement/views/announcement.view.html',
      data: {
        requireLogin: true,
        role: 1
      }
    })
    .state('admin.announcement.add', {
      url: '/announcement/add',
      templateUrl: 'app/announcement/views/announcement.add.html',
      controller: 'AnnouncementAddController',
      data: {
        requireLogin: true,
        role: 1
      }
    });
  }
} ());