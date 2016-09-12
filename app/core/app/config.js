'use strict';
var config = (function() {
  var moduleName = 'myApp';
  var dependencies = [
    'ui.router',
    'ngStorage'
  ];

  var addModule = function(moduleN, dependenciesN) {
    angular.module(moduleN, dependenciesN || []);
    angular.module(moduleName).requires.push(moduleN);
  };

  return {
    moduleName: moduleName,
    dependencies: dependencies,
    addModule: addModule
  };
})();
