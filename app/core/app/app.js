'use strict';
angular.module(config.moduleName, config.dependencies);

angular.module(config.moduleName).config(['$locationProvider', '$httpProvider',
function($locationProvider, $httpProvider) {
  $locationProvider.html5Mode(true).hashPrefix('!');
}]);

angular.module(config.moduleName).run(function ($rootScope, $state, $window, $location, UserService) {
  // $rootScope.$on('$locationChangeStart', function(event, next, current) {
  //   //console.log('paso');
  // });

  $rootScope.$on('$stateChangeStart', function (event, toState, toParams) {
    console.log('paso');
    var requireLogin = toState.data.requireLogin;
    console.log(UserService.isLogged());

    $window.fbAsyncInit = function() {
      FB.init({
        appId: '1089386854509032',
        status: true,
        cookie: true,
        xfbml: true,
        version: 'v2.4'
      });
    };

    // Load the SDK asynchronously
    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

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
