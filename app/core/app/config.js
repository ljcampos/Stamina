var config = (function() {
  'use strict';
  var moduleName = 'myApp';
  var dependencies = [
    'ui.router',
    'ngStorage',
    'ngFileUpload'
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
