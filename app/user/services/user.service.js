(function() {
  'use strict';

  angular.module('user').service('UserService', ['$q', '$http', '$localStorage', '$sessionStorage', UserService]);

  function UserService($q, $http, $localStorage, $sessionStorage) {
    return {
      getAllUsers: getAllUsers,
      sigin: sigin,
      sigup: sigup,
      getToken: getToken,
      isLogged: isLogged,
      logout: logout
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

    function sigin(email, password) {
      var userDefer = $q.defer();

      firebase.auth().signInWithEmailAndPassword(email, password)
      .catch(function(error) {
        console.log(error);
        userDefer.reject(error);
      })
      .then(function(response) {
        console.log(response);
        userDefer.resolve(response);
        setToken(response.uid);
      });

      return userDefer.promise;
    }

    function sigup(email, password) {
      console.log(email, password);
    }

    function logout() {
      $sessionStorage.$reset();
      $localStorage.$reset();
    }

    function getToken() {
      return $sessionStorage.token;
    }

    function setToken(token) {
      $sessionStorage.token = token;
      $localStorage.user = 'username';
    }

    function isLogged() {
      if (getToken() !== '' && getToken() !== null && getToken() !== undefined) {
        return true;
      }
      return false;
    }
  }
} ());
