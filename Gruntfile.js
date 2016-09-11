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
	//grunt.loadNpmTasks('grunt-contrib-watch');

	// Register tasks
	grunt.registerTask('default', ['tags:buildConfig']);

	// grunt.event.on('watch', function(action, filepath) {
	// 	if(grunt.file.isMatch(grunt.config('watch.styles.files'), filepath)) {
	// 		grunt.config('compass.dev.options.specify', [filepath]);
	// 	}
	// });

}