module.exports = function(grunt) {
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		// Task's
		tags: {
			buildConfig: {
				options: {
					scriptTemplate: '<script src="{{ path }}"></script>',
					//linkTemplate: '<link href="{{ path }}"/>',
					openTag: '<!-- start template tags -->',
					closeTag: '<!-- end template tags -->'
				},
				src: [
					'app/core/app/config.js',
					'app/core/app/app.js',
					'app/*/*.js',
					'app/**/*.js'
				],
				dest: 'index.html'
			},
			buildMainFiles: {
				options: {
					scriptTemplate: '<script src="{{ path }}"></script>',
					//linkTemplate: '<link href="{{ path }}"/>',
					openTag: '<!-- start template tags -->',
					closeTag: '<!-- end template tags -->'
				},
				src: [
					//'app/core/*.js',
					//'!app/core/app/config.js',
					//'!app/core/app/app.js',
				],
				dest: 'index.html'
			},
			buildOthers: {
				options: {
					scriptTemplate: '<script src="{{ path }}"></script>',
					//linkTemplate: '<link href="{{ path }}"/>',
					openTag: '<!-- start template tags -->',
					closeTag: '<!-- end template tags -->'
				},
				src: [
					// 'app/**/*.js',
					'app/core/app/config.js',
					'app/core/app/app.js',
					//'app/core/core.js',
					// '!app/app.js',
					// '!app/config.js'
				],
				dest: 'index.html'
			}
		}

	});
	// Load plugin's
	grunt.loadNpmTasks('grunt-script-link-tags');

	// Register tasks
	grunt.registerTask('default', ['tags:buildConfig']);

}