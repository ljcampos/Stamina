(function() {
  'use strict';
  angular.module('user').controller('UserController', ['$scope', '$state', 'UserService', UserController]);

  function UserController($scope, $`, UserService) {
    $scope.name = 'userName';
    $scope.usersList = null;
    $scope.email = '';
    $scope.password = '';
    $scope.header = 'title';

    $scope.error = false;
    $scope.success = false;

    $scope.form = {};
    $scope.userData = UserService.getUser();

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
          console.log(response.data.roles[0].rol_id);
          if (response.data.roles[0].rol_id === 3) {
            $state.go('entrepreneur.dashboard');
          } else {
            $state.go('admin.dashboard');
          }
          $scope.error = false;
        }
        else
          $scope.error = true;
      });
    };

    $scope.logout = function() {
      UserService.logout();
      $state.go('signin');
    };

    $scope.signup = function() {
      var data = {
        'username': $scope.form.name + $scope.form.lastname,
        'nombre': $scope.form.name,
        'paterno': $scope.form.lastname,
        'materno': $scope.form.firstname,
        'email': $scope.form.email,
        'password': $scope.form.password,
        'isMentor': 0,
        'rol': 3
      };
      UserService.sigup(data)
      .catch(function(error) {
        console.log(error);
        $scope.success = false;
      })
      .then(function(response) {
        console.log(response);
        $scope.success = true;
      });
    };


  }
}());
