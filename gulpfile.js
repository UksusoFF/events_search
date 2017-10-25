let gulp = require('gulp'),
    autoprefixer = require('gulp-autoprefixer'),
    concat = require('gulp-concat'),
    sass = require('gulp-sass'),
    browserify = require('browserify'),
    source = require('vinyl-source-stream'),
    uglify = require('gulp-uglify');

gulp.task('assetsJs', function() {
    return browserify(
        [
            'resources/assets/js/bootstrap.js'
        ], {
            insertGlobals: true,
        })
        .bundle()
        .pipe(source('app.js'))
        //.pipe(uglify())
        .pipe(gulp.dest('public/js'));
});

gulp.task('assetsSass', function() {
    gulp.src([
        'node_modules/font-awesome/fonts/fontawesome-webfont.*'])
        .pipe(gulp.dest('public/fonts/'));

    return gulp
        .src([
            'resources/assets/sass/bootstrap.scss'
        ])
        .pipe(sass({outputStyle: 'compressed'}))
        .pipe(concat('app.css'))
        .pipe(autoprefixer({
            remove: false,
            browsers: ['last 2 versions', 'ie >= 8', 'Firefox ESR'],
        }))
        .pipe(gulp.dest('public/css/'));
});

gulp.task('watch', function() {
    gulp.watch('resources/assets/js/**/*', ['assetsJs']);
    gulp.watch('resources/assets/sass/**/*', ['assetsSass']);
});

gulp.task('default', [
    'assetsJs',
    'assetsSass',
]);