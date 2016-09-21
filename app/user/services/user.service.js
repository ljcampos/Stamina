(function() {
  'use strict';

  angular.module('user').service('UserService', ['$q', '$http', '$localStorage', '$sessionStorage', '$state', UserService]);

  function UserService($q, $http, $localStorage, $sessionStorage, $state) {
    return {
      getAllUsers: getAllUsers,
      sigin: sigin,
      sigup: sigup,
      getToken: getToken,
      isLogged: isLogged,
      logout: logout,
      getUser: getUser,
      isAdmin: isAdmin,
      facebookSignin: facebookSignin
    };

    function getAllUsers() {
      var users = $q.defer();
      $http.get('https://jsonplaceholder.typicode.com/users')
      .success(function(response) {
        console.log(response);
        users.resolve(response);
      })
      .error(function(error) {
        console.log(error);
        users.reject(error);
      });
      return users.promise;
    }

    function facebookSignin() {
      console.log('service');
      // FB.login(function(response){
      //   // Handle the response object, like in statusChangeCallback() in our demo
      //   // code.
      // }, {scope: 'public_profile,email'});
      FB.getLoginStatus(function(response) {
        if (response.status === 'connected') {
          console.log('Logged in.');
          FB.api('/me?fields=email,picture,first_name,last_name,middle_name,name,birthday,gender', function(response) {
            console.log('response ' , response);
          });
        } else if (response.status === 'not_authorized') {
          // The person is logged into Facebook, but not your app.
          //console.log('no not_authorized', response);
          //facebookFBLogin(response);
          if ($state.current.name !== 'signup') {
            $state.go('signup');
          } else {
            facebookFBLogin(response);
          }
        }
        else {
          console.log('not logged');
          facebookFBLogin(response);
        }
      });
    }

    function facebookFBLogin(response) {
      FB.login(function(response) {
        console.log('login', response);
        if (response.authResponse) {
          console.log('Welcome!  Fetching your information.... ');
          FB.api('/me', function(response) {
            console.log('response ' , response);
          });
        } else {
          console.log('User cancelled login or did not fully authorize.');
        }
      }, {scope: 'public_profile,email'});
    }

    function sigin(email, pwd) {
      var userDefer = $q.defer();

      var credentials = {
        'email': email,
        'pwd': pwd
      };

      $http.post('http://www.stamina.dev/API/public/api/v1/usuario/auth/', credentials)
      .success(function(response) {
        console.log(response);
        userDefer.resolve(response);
        setToken('sds561dsd', response);
      })
      .error(function(error) {
        console.log(error);
        userDefer.reject(error);
      });


      return userDefer.promise;
    }

    function sigup(data) {
      var userDefer = $q.defer();
      // http://www.stamina.dev/API/public/api/v1/usuario/
      console.log(data);
      $http.post('http://www.stamina.dev/API/public/api/v1/usuario/', data)
      .success(function(response) {
        console.log(response);
        userDefer.resolve(response);
      })
      .error(function(error) {
        console.log(error);
        userDefer.reject(error);
      });
      return userDefer.promise;
    }

    function logout() {
      $sessionStorage.$reset();
      $localStorage.$reset();
    }

    function getToken() {
      return $sessionStorage.token;
    }

    function setToken(token, user) {
      $sessionStorage.token = token;
      $localStorage.user = user;
    }

    function isLogged() {
      if (getToken() !== '' && getToken() !== null && getToken() !== undefined) {
        return true;
      }
      return false;
    }

    function getUser() {
      return $localStorage.user;
    }

    function isAdmin() {
      var user = getUser();
      if (user.data.roles[0].rol_id !== 3) {
        return true;
      }
      return false;
    }
  }
} ());
