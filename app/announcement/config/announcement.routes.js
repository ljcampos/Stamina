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
      url: '/announcement/view/:id',
      controller: 'AnnouncementViewController',
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
    })
    .state('admin.announcement.answers', {
      url: '/announcement/answers/entrepreneur/:id',
      templateUrl: 'app/announcement/views/admin.answers.entrepreneur.html',
      controller: 'AnnouncementAnswersController',
      data: {
        requireLogin: true,
        role: 1
      }
    })
    .state('admin.announcement.edit', {
      url: '/announcement/edit/:id',
      templateUrl: 'app/announcement/views/announcement.edit.html',
      controller: 'AnnouncementEditController',
      data: {
        requireLogin: true,
        role: 1
      }
    });
  }
} ());