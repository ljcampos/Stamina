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

    $scope.facebookLogin = function() {
      UserService.facebookSignin()
      .then(function(response) {
        UserService.sigin(response.email, 12345678)
        .then(function(response) {
          console.log(response);
          if (response.code === 1) {
            if (response.data.roles[0].rol_id === 3) {
              $state.go('entrepreneur.dashboard');
            }
            $scope.error = false;
          } else
            $scope.error = true;
        })
        .catch(function(error) {
          console.log(error);
        });
      })
      .catch(function(error) {
        if (error.status === 'not_authorized') {
          $state.go('signup');
        }
        console.log(error);
      });
    };

    $scope.facebookSignup = function() {
      var newUser = {};
      UserService.facebookSignup()
      .then(function(response) {
        console.log(response);
        newUser.username = response.name;
        newUser.nombre = response.name;
        newUser.paterno = response.first_name;
        newUser.materno = response.last_name;
        newUser.email = response.email;
        newUser.password = 12345678;
        newUser.isMentor = 0;
        newUser.type = 3;
        newUser.rol = 3;
        // create new user with facebook data
        UserService.sigup(newUser)
        .then(function(response) {
          console.log(response);
          $scope.success = true;
        })
        .catch(function(error) {
          console.log(error);
          $scope.success = false;
        });
      })
      .catch(function(error) {
        console.log(error);
      });
    };

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
        'type': 3,
        'rol': 3
      };
      UserService.sigup(data)
      .then(function(response) {
        console.log(response);
        $scope.success = true;
      })
      .catch(function(error) {
        console.log(error);
        $scope.success = false;
      });
    };


  }
}());
