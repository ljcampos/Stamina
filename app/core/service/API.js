(function() {
	'use strict';

	angular.module('core').service('API', ['$q', API]);

	function API($q) {
		var base = 'http://www.stamina.dev/API/public/api/v1/';

		return {
			'users': {
				'list': base + 'usuario/',
				'ById': base + 'usuario/:id/',
				'add': base + 'usuario/'
			},
			'auth': {
				'signin': base + 'usuario/auth/',
				'signup': base + 'usuario/'
			},
			'university': {
				'list': base + 'universidad/',
				'ById': base + 'universidad/:id/',
				'add': base + 'universidad/',
				'update': base + 'universidad/:id/update/',
				'delete': base + '...'
			},
			'announcement': {
				'list': base + 'convocatoria/',
				'ById': base + 'convocatoria/:id/',
				'add': base + 'convocatoria/',
				'update': base + 'convocatoria/:id/update/',
				'delete': base + 'convocatoria/:id/delete/'
			},
			'rol': {
				'list': base + 'roles/',
				'ById': base + 'roles/:id/',
				'add': base + 'roles/',
				'update': base + 'roles/:id/permisos/'
			},
			'rol_permission': {
				'list': base + 'roles/:id/permisos/',
				'add': base + 'roles/:id/permisos/',
				'delete': base + 'roles/:id/permisos/delete/'
			}
		};
	}
} ());