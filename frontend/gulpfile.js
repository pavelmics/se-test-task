var gulp = require("gulp")
    , replace = require('gulp-replace')
    , concat = require('gulp-concat')
    , uglify = require('gulp-uglify')
    , less = require('gulp-less')
    , minifyCSS = require('gulp-minify-css')
    , runSequence = require('run-sequence')
    , templateCache = require('gulp-angular-templatecache')
    , crypto = require('crypto');

var jsFiles = [
    'bower_components/jquery/dist/jquery.js'
    , 'bower_components/underscore/underscore.js'
    , 'bower_components/bootstrap/dist/js/bootstrap.js'
    , 'bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js'
    , 'bower_components/devbridge-autocomplete/dist/jquery.autocomplete.js'

    // angular
    , 'bower_components/angular/angular.js'
    , 'bower_components/angular-route/angular-route.js'
    , 'bower_components/angular-resource/angular-resource.js'

    // @link https://github.com/glaucocustodio/angular-initial-value
    , 'bower_components/angular-initial-value/dist/angular-initial-value.js'
    , 'bower_components/ng-table/dist/ng-table.js'

    , 'js/main.js'
    , 'js/app.js'
    , 'js/_all-templates.js' // скомпилированные angular шаблоны
    , 'js/app/**/*.js'
];

// build js
gulp.task('js', function() {
    gulp.src(jsFiles)
        .pipe(concat({path: 'main.js'}))
        //.pipe(uglify())
        .pipe(gulp.dest('../web/static'));
});

// build css
gulp.task('css', function() {
    gulp.src('./less/main.less')
        .pipe(less())
        .pipe(minifyCSS())
        .pipe(gulp.dest('../web/static'));
});

// @link https://github.com/miickel/gulp-angular-templatecache
gulp.task('ng-template', function () {
    gulp.src('js/**/*.html')
        .pipe(templateCache('_all-templates.js', {
            standalone: true
        }))
        .pipe(gulp.dest('js/'));
});

gulp.task('copy-fonts', function() {
    gulp.src('./bower_components/components-font-awesome/fonts/**/*.{ttf,woff,eof,svg,woff2}')
        .pipe(gulp.dest('../web/static/fonts'));
});

// Обновляет время сборги для файлов
gulp.task('update-build-version', function() {
    var versionHash = crypto.randomBytes(10).toString('hex').substr(0, 10);
    gulp.src('./staticHashes.php')
        .pipe(replace('@@build-hash', function() { return versionHash; }))
        .pipe(gulp.dest('../app'));
});

// watch task
gulp.task('watch', function() {
    runSequence('build');
    gulp.watch(['js/**/*', '!js/_all-templates.js'], { interval: 500 }, ['build'])
        .on('change', function (event) {
            console.log('Event type: ' + event.type);
        });
    gulp.watch('less/**/*', ['build']);

});

// build task
gulp.task('build', function() {
    runSequence('ng-template', ['js', 'css'], 'update-build-version');
});