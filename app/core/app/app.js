'use strict';
angular.module(config.moduleName, config.dependencies);

angular.module(config.moduleName).config(['$locationProvider', '$httpProvider',
function($locationProvider, $httpProvider) {
  $locationProvider.html5Mode(true).hashPrefix('!');
}]);

angular.module(config.moduleName).run(function ($rootScope, $state, $http, $location, UserService) {
  // $rootScope.$on('$locationChangeStart', function(event, next, current) {
  //   //console.log('paso');
  // });

  $rootScope.$on('$stateChangeStart', function (event, toState, toParams) {
    console.log('paso');
    var requireLogin = toState.data.requireLogin;

    if (requireLogin && !UserService.isLogged()) {
      event.preventDefault();
      $state.go('signin');
    } else if(UserService.isLogged()) {
      var rol = UserService.isAdmin();

      if (rol) {
        if (toState.data.role === 1 || toState.data.role === 2) {
          $location.state(toState.name);
        } else {
          $location.url('/');
        }
      } else {
        if (toState.data.role === 3) {
          $location.state(toState.name);
        } else {
          $location.url('/emprendedor');
        }
      }
    }
  });
});

angular.element(document).ready(function () {
  angular.bootstrap(document, [config.moduleName]);
});
