const gulp = require('gulp');
const sourcemaps = require('gulp-sourcemaps');
const postcss = require('gulp-postcss');
const cssnext = require('postcss-cssnext');
const precss = require('precss');
const rename = require('gulp-rename');

gulp.task('css', function() {
    return gulp
        .src('app/Resources/css/*.scss')
        .pipe(sourcemaps.init())
        .pipe(postcss([precss, cssnext]))
        .pipe(sourcemaps.write('.'))
        .pipe(rename('style.css'))
        .pipe(gulp.dest('web/css/'));
});

gulp.task('watch', function() {

    gulp.watch(['app/Resources/css/**/*'], ['css']);
});
gulp.task('default', ['css']);