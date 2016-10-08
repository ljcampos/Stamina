module.exports = function(grunt) {
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		// Task's
		concat: {
			libs: {
				src: ['bower_components/angular/angular.js', 'bower_components/angular-ui-router/release/angular-ui-router.js', 'bower_components/ngstorage/ngStorage.js', 'bower_components/ng-file-upload/ng-file-upload.js'],
				dest: 'libs/libs.js'
			},
			app: {
				// 'app/core/app/app.js', 'app/*/*.js', 'app/**/*.js'
				src: ['app/core/app/config.js', 'app/core/app/app.js', 'app/*/*.js', 'app/**/*.js'],
				dest: 'scripts/modules.js'
			}
		},
		tags: {
			buildDev: {
				options: {
					scriptTemplate: '<script src="{{ path }}"></script>',
					//linkTemplate: '<link href="{{ path }}"/>',
					openTag: '<!-- start template tags -->',
					closeTag: '<!-- end template tags -->'
				},
				src: [
					'bower_components/angular/angular.js',
					'bower_components/angular-ui-router/release/angular-ui-router.js',
					'bower_components/ngstorage/ngStorage.js',
					'bower_components/ng-file-upload/ng-file-upload.js',
					'app/core/app/config.js',
					'app/core/app/app.js',
					'app/*/*.js',
					'app/**/*.js'
				],
				dest: 'index.html'
			},
			buildProd: {
				options: {
					scriptTemplate: '<script src="{{ path }}"></script>',
					//linkTemplate: '<link href="{{ path }}"/>',
					openTag: '<!-- start template tags -->',
					closeTag: '<!-- end template tags -->'
				},
				src: [
					'libs/libs.min.js',
					'scripts/modules.min.js'
				],
				dest: 'index.html'
			}
		},
		uglify: {
			js: {
				files: {
					'libs/libs.min.js': ['libs/libs.js'],
					'scripts/modules.min.js': ['scripts/modules.js']
				}
			}
		}
		// watch: {
		// 	options: {
		// 		livereload: true,
		// 		spawn: false
		// 	},
		// 	scripts: {
		// 		options: {
		// 			event: ['added', 'deleted', 'changed']
		// 		},
		// 		files: [
		// 			'app/core/app/config.js',
		// 			'app/core/app/app.js',
		// 			'app/*/*.js',
		// 			'app/**/*.js'
		// 		]
		// 		tasks: ['tags:buildConfig']
		// 	}
		// }

	});
	// Load plugin's
	grunt.loadNpmTasks('grunt-script-link-tags');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	//grunt.loadNpmTasks('grunt-contrib-watch');

	// Register tasks
	grunt.registerTask('default', ['tags:buildDev']);
	grunt.registerTask('prod', ['concat:libs', 'concat:app', 'uglify:js', 'tags:buildProd']);
}