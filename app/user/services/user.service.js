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
      facebookSignin: facebookSignin,
      facebookSignup: facebookSignup
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
      var facebookUser = $q.defer();
      FB.getLoginStatus(function(response) {
        // user has permissions and is logged
        if (response.status === 'connected') {
          facebookUser.resolve(getFacebookUserData(response));
        } else if (response.status === 'not_authorized') {
          // user is logged but hasn't permissions
          facebookUser.reject(response);
        } else {
          // user is not logged
          console.log('not logged');
          //facebookFBLogin(response);
        }
      });
      return facebookUser.promise;
    }

    function facebookSignup() {
      return FBLogin();
    }

    function FBLogin() {
      var facebookUser = $q.defer();
      FB.login(function(response) {
        if (response.authResponse) {
          facebookUser.resolve(getFacebookUserData(response));
        } else {
          facebookUser.reject(response);
        }
      }, {scope: 'public_profile, email'});
      return facebookUser.promise;
    }

    function getFacebookUserData(response) {
      var facebookUser = $q.defer();
      FB.api('/me?fields=email,picture,first_name,last_name,middle_name,name,birthday,gender', function(response) {
        if (!response || response.error) {
          facebookUser.reject('Error occured');
        } else {
          facebookUser.resolve(response);
        }
      });
      return facebookUser.promise;
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
