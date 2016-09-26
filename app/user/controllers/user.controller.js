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

    $scope.init = function() {
      if (UserService.isLogged()) {
        if (UserService.getFacebookPicture() !== undefined)
          $scope.facebookImage = UserService.getFacebookPicture();
        else
          $scope.facebookImage = 'images/a0.jpg';
      }
    };

    angular.element(document).ready(function() {
			$scope.init();
		});

    function facebookPicture() {
      console.log('picture');
      UserService.getFacebookPicture()
      .then(function(response) {
        console.log(response);
        $scope.facebookImage.url = response.data.url;
      })
      .catch(function(error) {
        console.log(error);
        $scope.facebookImage.url = 'images/a0.jpg';
      });
    }

    $scope.facebookLogin = function() {
      // facebook login
      UserService.facebookSignin()
      .then(function(fbResponse) {
        // check if the facebook user is registred
        UserService.getFacebookUserById(fbResponse.id)
        .then(function(userResponse) {
          console.log(userResponse);
          // facebook user data
          var credentials = {
            'email': fbResponse.email,
            'facebookId': fbResponse.id
          };
          // login into webpage
          UserService.sigin(credentials)
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
          // login not correct
          .catch(function(loginError) {
            console.log(loginError);
          });
        })
        // user isn't registred
        .catch(function(userError) {
          console.log(userError);
          console.log(fbResponse);

          var newUser = {};
          newUser.username = fbResponse.name;
          newUser.nombre = fbResponse.name;
          newUser.paterno = fbResponse.first_name;
          newUser.materno = fbResponse.last_name;
          newUser.email = fbResponse.email;
          newUser.facebookId = fbResponse.id;
          newUser.isMentor = 0;
          newUser.type = 3;
          // create new user with facebook data
          UserService.sigup(newUser)
          .then(function(response) {
            console.log(response);
            // $scope.success = true;

            var credentials = {
              'email': fbResponse.email,
              'facebookId': fbResponse.id
            };
            // login into webpage
            UserService.sigin(credentials)
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
            // login not correct
            .catch(function(loginError) {
              console.log(loginError);
            });

          })
          .catch(function(error) {
            console.log(error);
            // $scope.success = false;
          });

        });
      })
      // facebook user error
      .catch(function(FbError) {
        // if (error.status === 'not_authorized') {
        //   $state.go('signup');
        // }
        console.log(FbError);
      });
    };

    $scope.facebookSignup = function() {
      var newUser = {};
      UserService.facebookSignup()
      .then(function(FbResponse) {
        console.log(FbResponse);

        UserService.getFacebookUserById(FbResponse.id)
        .then(function(userResponse) {
          console.log(userResponse);

          var credentials = {
            'email': FbResponse.email,
            'facebookId': FbResponse.id
          };
          // login into webpage
          UserService.sigin(credentials)
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
          // login not correct
          .catch(function(loginError) {
            console.log(loginError);
          });
        })
        .catch(function(userError) {
          console.log(userError);
          newUser.username = FbResponse.name;
          newUser.nombre = FbResponse.name;
          newUser.paterno = FbResponse.first_name;
          newUser.materno = FbResponse.last_name;
          newUser.email = FbResponse.email;
          newUser.facebookId = FbResponse.id;
          newUser.isMentor = 0;
          newUser.type = 3;
          // create new user with facebook data
          UserService.sigup(newUser)
          .then(function(response) {
            console.log(response);
            $scope.success = true;

            var credentials = {
              'email': FbResponse.email,
              'facebookId': FbResponse.id
            };
            // login into webpage
            UserService.sigin(credentials)
            .then(function(response) {
              console.log(response);
              if (response.code === 1) {
                if (response.data.roles[0].rol_id === 3) {
                  $scope.facebookImage = fbResponse.picture.data.url;
                  $state.go('entrepreneur.dashboard');
                }
                $scope.error = false;
              } else
                $scope.error = true;
            })
            // login not correct
            .catch(function(loginError) {
              console.log(loginError);
            });
          })
          .catch(function(error) {
            console.log(error);
            $scope.success = false;
          });
        });

      })
      .catch(function(FbError) {
        console.log(FbError);
      });
    };

    $scope.login = function() {
      console.log($scope.email, $scope.password);
      var credentials = {
        'email': $scope.email,
        'pwd': $scope.password
      };
      UserService.sigin(credentials)
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
      })
      .catch(function(error) {
        console.log(error);
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
        'type': 3
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
