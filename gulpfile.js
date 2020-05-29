const gulp = require('gulp');
const gulp_concat = require('gulp-concat');
const gulp_order = require('gulp-order');
const gulp_sass = require('gulp-sass');

gulp.task('sass', function () {
    return gulp.src('./public/bem/blocks/**/*.sass')
        .pipe(gulp_concat('style.sass'))
        .pipe(gulp_sass())
        .pipe(gulp.dest('./public/bundles/'));
});

gulp.task('watch', function () {
    return gulp.watch('./public/bem/blocks/**/*.sass', gulp.task('sass'));
});