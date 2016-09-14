(function() {
  'use strict';
  angular.module('user').controller('UserController', ['$scope', '$state', 'UserService', UserController]);

  function UserController($scope, $state, UserService) {
    $scope.name = 'userName';
    $scope.usersList = null;
    $scope.email = '';
    $scope.password = '';
    $scope.header = 'title';

    $scope.error = false;

    angular.element(document).ready(function() {
			loadUsers();
		});

    function loadUsers() {
      // UserService.getAllUsers()
      // .then(function(response) {
      //   console.log(response);
      //   $scope.usersList = response;
      // })
      // .catch(function(error) {
      //   console.log(error);
      // });
    }

    $scope.login = function() {
      console.log($scope.email, $scope.password);
      UserService.sigin($scope.email, $scope.password)
      .catch(function(error) {
        console.log(error);
        $scope.error = true;
      })
      .then(function(response) {
        if (response.code === 1) {
          $state.go('admin.dashboard');
          $scope.error = false;
        }
        else
          $scope.error = true;
        //console.log($scope.email, $scope.password);
        //console.log('xdvd');
      });
    };

    $scope.logout = function() {
      UserService.logout();
      $state.go('signin');
    };


  }
}());
