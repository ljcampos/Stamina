(function() {
  'use strict';
  angular.module('user').controller('UserController', ['$scope', 'UserService', UserController]);

  function UserController($scope, UserService) {
    $scope.name = 'userName';
    $scope.usersList = null;

    angular.element(document).ready(function() {
			loadUsers();
		});

    function loadUsers() {
      UserService.getAllUsers()
      .then(function(response) {
        console.log(response);
        $scope.usersList = response;
      })
      .catch(function(error) {
        console.log(error);
      });
    }
  }
}());
