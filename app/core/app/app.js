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

    // if (UserService.isLogged()) {
    //   return $state.go('admin.dashboard');
    //   event.preventDefault();
    // }
    if (requireLogin && !UserService.isLogged()) {
      event.preventDefault();
      $state.go('signin');
    } else {
      var userRole = toState.data.role;
      // if (userRole === 1) {
        $location.path('/');
      // }
      // else {
      //   $location.path('/emprendedor');
      // }
    }
  });

  // // Record previous state
  // $rootScope.$on('$stateChangeSuccess', function (event, toState, toParams, fromState, fromParams) {
  //   storePreviousState(fromState, fromParams);
  // });
  //
  // // Store previous state
  // function storePreviousState(state, params) {
  //   // only store this state if it shouldn't be ignored
  //   if (!state.data || !state.data.ignoreState) {
  //     $state.previous = {
  //       state: state,
  //       params: params,
  //       href: $state.href(state, params)
  //     };
  //   }
  // }
});

angular.element(document).ready(function () {
  angular.bootstrap(document, [config.moduleName]);
});
