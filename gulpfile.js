const gulp = require('gulp');
const gulp_babel = require('gulp-babel');
const gulp_concat = require('gulp-concat');
const gulp_order = require('gulp-order');
const gulp_sass = require('gulp-sass');
const gulp_group_media = require('gulp-group-css-media-queries');
const gulp_uglify = require('gulp-uglify');

gulp.task('sass', function () {
    return gulp.src(['./public/bem/blocks/**/*.sass', '!./public/bem/blocks/admin-*/*.sass'])
        .pipe(gulp_order([
            'public/bem/blocks/i-normalize/*.sass',
            'public/bem/blocks/i-font/**/*.sass',
            'public/bem/blocks/container/*.sass',
            'public/bem/blocks/header/*.sass',
            'public/bem/blocks/menu/*.sass',
            'public/bem/blocks/logo/*.sass',
            'public/bem/blocks/section-head/*.sass',
            'public/bem/blocks/main/*.sass',
            'public/bem/blocks/title/*.sass',
            'public/bem/blocks/section-portfolio/*.sass',
            'public/bem/blocks/portfolio-items/*.sass',
            'public/bem/blocks/footer/*.sass'
        ], { base: './' }))
        .pipe(gulp_concat('style.sass'))
        .pipe(gulp_sass())
        .pipe(gulp_group_media())
        .pipe(gulp.dest('./public/bundles/'));
});

gulp.task('js', function() {
   return gulp.src('./public/bem/blocks/**/*.js')
       .pipe(gulp_babel({
           presets: ['@babel/env']
       }))
       .pipe(gulp_concat('script.min.js'))
       .pipe(gulp_uglify())
       .pipe(gulp.dest('./public/bundles/'));
});

gulp.task('sass-admin', function () {
    return gulp.src(['./public/bem/blocks/admin-*/*.sass', './public/bem/blocks/i-*/**/*.sass'])
        .pipe(gulp_order([
            'i-normalize/*.sass',
            'i-font/**/*.sass',
            'admin-container/*.sass',
            'admin-header/*.sass',
            'admin-menu/*.sass',
            'admin-logo/*.sass',
            'admin-sidebar/*.sass',
            'admin-main/*.sass',
            'admin-content/*.sass',
            'admin-notification/*.sass',
        ]))
        .pipe(gulp_concat('style.admin.sass'))
        .pipe(gulp_sass())
        .pipe(gulp_group_media())
        .pipe(gulp.dest('./public/bundles/'));
});

gulp.task('js-admin', function() {
    return gulp.src('./public/bem/blocks/admin-*/*.js')
        .pipe(gulp_babel({
            presets: ['@babel/env']
        }))
        .pipe(gulp_concat('script.admin.min.js'))
        .pipe(gulp_uglify())
        .pipe(gulp.dest('./public/bundles/'));
});

gulp.task('watch-admin', function() {
    return gulp.watch('./public/bem/blocks/admin-*/*.{sass, js}', gulp.series('sass-admin', 'js-admin'));
});

gulp.task('watch', function () {
    return gulp.watch('./public/bem/blocks/**/*.{sass,js}', gulp.series('sass', 'js'));
});