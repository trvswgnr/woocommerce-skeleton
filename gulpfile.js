'use strict';

var gulp = require('gulp'),
  merge = require('merge-stream'),
  $ = require('gulp-load-plugins')(),
  pug_php_filter = require('pug-php-filter'),
  pug_markdown_filter = require('jstransformer-markdown-it'),
  pugBEMify = require('pug-bemify');

// PROCESS CSS
var cssSrc = 'src/sass/**/*.scss',
  cssDest = 'assets/css',
  cssName = 'main';

var supported = [
  'last 2 versions',
  'safari >= 6',
  'ie >= 7',
  'ff >= 3',
  'ios 6',
  'opera 11',
  'android 4'
];

// PROCESS SASS
gulp.task('css', function () {

  var css = gulp.src([cssSrc])
    .pipe($.sourcemaps.init())
    .pipe($.sass())
    .pipe($.autoprefixer({
      browsers: supported,
      cascade: true
    }))
    .pipe($.rename(cssName + '.css'));

  // minify and clean css
  var min = css.pipe($.clone())
    .pipe($.cleanCss({
      compatibility: 'ie9',
      level: {
        1: {
          all: true,
          specialComments: 'none'
        },
        2: {
          all: true,
          restructureRules: false,
          mergeNonAdjacentRules: false
        }
      }
    }))
    .pipe($.rename(cssName + '.min.css'));

  // merge pipes and output separate files with sourcemaps
  return merge(css, min)
    .pipe($.sourcemaps.write('.'))
    .pipe(gulp.dest(cssDest));
});

// PROCESS JS
var jsSrc = 'src/js/**/*.js',
  jsDest = 'assets/js',
  jsName = 'main';

var jsImport = function () {
  var js = 'src/js/',
    src = [
      js + 'abstracts/globals.js',
      js + 'abstracts/functions.js',
      js + 'vendor/**/*.js',
      js + 'taw/**/*.js',
      js + 'other/**/*.js',
      js + 'modules/**/*.js'
    ]
  return src;
}();

gulp.task('js', function () {

  // combine all js files in folder, starting alphabetically
  var concat = gulp.src(jsImport)
    .pipe($.sourcemaps.init())
    .pipe($.concat(jsName + '.js'));

  // minify javascript file
  var ugly = concat.pipe($.clone())
    .pipe($.uglify())
    .pipe($.rename(jsName + '.min.js'))

  // merge pipes and output separate files with sourcemaps.
  return merge(concat, ugly)
    .pipe($.sourcemaps.write('.'))
    .pipe(gulp.dest(jsDest));
});

var pugSrc = './src/pug/**/*.pug';

// PROCESS PUG PHP
gulp.task('pug', function() {
  return gulp.src(pugSrc)
    .pipe( $.pug({
      filters: {
      php: pug_php_filter,
      md: pug_markdown_filter
      },
      plugins: [pugBEMify()]
    }))
    .pipe($.rename(function (path) {
      path.extname = ".php"
    }))
    .pipe(gulp.dest('./src/php'));

});

// WATCH folders and automatically process
gulp.task('watch', function () {
  gulp.watch(cssSrc, ['css']);
  gulp.watch(jsSrc, ['js']);
  gulp.watch(pugSrc, ['pug']);
});
