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
      getUserById: getUserById,
      updateUser: updateUser,
      logout: logout,
      getUser: getUser,
      isAdmin: isAdmin,
      facebookSignin: facebookSignin,
      facebookSignup: facebookSignup,
      getFacebookUserById: getFacebookUserById,
      getFacebookPicture: getFacebookPicture
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

    function getUserById(id) {
      var users = $q.defer();
      $http.get('http://www.stamina.dev/API/public/api/v1/usuario/'+id+'/')
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

    function updateUser(id,datos) {
      var users = $q.defer();
      $http.post('http://www.stamina.dev/API/public/api/v1/usuario/'+id+'/update/',datos)
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

    function getFacebookUserById(id) {
      //http://www.stamina.dev/API/public/api/v1/usuario/facebook/
      var userDefer = $q.defer();

      $http.get('http://www.stamina.dev/API/public/api/v1/usuario/facebook/' + id)
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

    function facebookSignin() {
      var facebookUser = $q.defer();
      getFacebookUserStatus()
      .then(function(response) {
        console.log(response);
        facebookUser.resolve(getFacebookUserData(response));
      })
      .catch(function(error) {
        console.log(error);
        facebookUser.reject(error);
      });
      return facebookUser.promise;
    }

    function facebookSignup() {
      var facebookUser = $q.defer();
      getFacebookUserStatus()
      .then(function(response) {
        console.log(response);
        facebookUser.resolve(getFacebookUserData(response));
      })
      .catch(function(error) {
        console.log(error);
        //FBLogin();
        facebookUser.reject(error);
      });
      return facebookUser.promise;
    }

    function getFacebookUserStatus() {
      var facebookUser = $q.defer();
      FB.getLoginStatus(function(response) {
        // user has permissions and is logged
        if (response.status === 'connected') {
          facebookUser.resolve(getFacebookUserData(response));
        } else if (response.status === 'not_authorized') {
          // user is logged but hasn't permissions
          //facebookUser.reject(response);
          console.log('not_authorized');
          facebookUser.resolve(FBLogin());
        } else {
          // user is not logged
          console.log('not logged');
          facebookUser.resolve(FBLogin());
        }
      });
      return facebookUser.promise;
    }

    function FBLogin(response) {
      var facebookUser = $q.defer();
      FB.login(function(response) {
        console.log(response);
        if (response.authResponse) {
          console.log('paso');
          facebookUser.resolve(getFacebookUserData(response));
        } else {
          console.log('no paso');
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
          setFacebookPicture(response.picture.data.url);
        }
      });
      return facebookUser.promise;
    }

    function setFacebookPicture(picture) {
      $sessionStorage.picture = picture;
    }

    function getFacebookPicture() {
      return $sessionStorage.picture;
    }

    function sigin(credentials) {
      var userDefer = $q.defer();

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
