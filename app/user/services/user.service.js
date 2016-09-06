(function() {
  'use strict';

  angular.module('user').service('UserService', ['$q', '$http', UserService]);

  function UserService($q, $http) {
    return {
      getAllUsers: getAllUsers
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
  }
} ());
