'use strict';
angular.module(config.moduleName, config.dependencies);

angular.module(config.moduleName).config(['$locationProvider', '$httpProvider',
function($locationProvider, $httpProvider) {
  $locationProvider.html5Mode({
    enabled: true,
    requireBase: true,
    rewriteLinks: true
  }).hashPrefix('!');
}]);

angular.module(config.moduleName).run(function ($rootScope, $state, $http, $location) {
  $rootScope.$on('$locationChangeStart', function(event, next, current) {
    console.log('paso');
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
