module.exports = function(grunt) {

	require('load-grunt-tasks')(grunt);

	grunt.initConfig({
		compass: {
			dist: {
				options: {
					config: 'config.rb'
				}
			}
		},
		imagemin: {
			dynamic: {
				files: [{
					expand: true,
					cwd: 'assets/raw/',
					src: ['**/*.{png,jpg,gif}'],
					dest: 'assets/img/'
				}]
			}
		},
		svgmin: {
			dist: {
				files: [{
					expand: true,
					cwd: 'assets/raw/svg',
					src: ['**/*.svg'],
					dest: 'assets/img/svg',
					ext: '.svg'
				}]
			}
		},
		watch: {
			php: {
				files: ['**/**.php'],
				options: {
					spawn: false,
					livereload: true
				}
			},
			js: {
				files: ['assets/js/*.js','!assets/js/*.min.js'],
				tasks: ['jshint','uglify','concat'],
				options: {
					spawn: false,
					livereload: true
				}
			},
			scss: {
				files: ['assets/scss/*.scss','assets/scss/**/*.scss'],
				tasks: ['compass'],
				options: {
					spawn: false,
					livereload: true
				}
			},
		}

	});

	grunt.registerTask('default', ['compass','imagemin','svgmin']);
}