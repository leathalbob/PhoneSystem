module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    uglify: {
      options: {
        banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n',
	mangle: false
      },
      build: {
	expand: true,
	cwd: '../javascripts/src/',
	dest: '../javascripts/dest/',
        src: ['*.js','!*.min.js'],
	ext: '.min.js'
     }
    },

    imagemin: {
      png: {
        options: {
          optimizationLevel: 9
        },
	files: [
          {
            expand: true,
            cwd: '../images/src/',
            dest: '../images/dest/',
            src: ['*.png'],
            ext: '.png'
          }
        ]
      }
    },

    move: {
      images: {
        src: '../images/src/*',
        dest: '../images/orig/'
      }
    }

  });
	

  // Load plugins
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-imagemin');
  grunt.loadNpmTasks('grunt-move');

  // Register all the tasks
  grunt.registerTask('compressImages', ['imagemin','move:images']);
  grunt.registerTask('compressJs', ['uglify']);
  grunt.registerTask('default', ['uglify','imagemin','move:images']);  
};
