'use strict';

var gulp         = require('gulp');
var spritesmith  = require('gulp.spritesmith');
var concatCss    = require('gulp-concat-css');
var postcss      = require('gulp-postcss');
var sourcemaps   = require('gulp-sourcemaps');
var autoprefixer = require('autoprefixer');

var concat       = require('gulp-concat');

gulp.task('sprite', function() {
    var spriteData =
        gulp.src('./src/img/sprites/icons/*.png') // путь, откуда берем картинки для спрайта
            .pipe(spritesmith({
                imgName: '../img/icons.png',
                cssName: 'b-icon.css',
            }));

    spriteData.img.pipe(gulp.dest('./build/img/')); // путь, куда сохраняем картинку
    spriteData.css.pipe(gulp.dest('./src/css/')); // путь, куда сохраняем стили
});

gulp.task('build', function () {
    return gulp.src('./src/css/*.css')
        .pipe(concatCss("styles.css"))
        .pipe(postcss([ autoprefixer({ browsers: ['last 2 versions'] }) ]))
        .pipe(gulp.dest('build/css/'));
});

gulp.task('scripts', function() {
    return gulp.src('src/js/*.js')
        .pipe(concat('scripts.js'))
        .pipe(gulp.dest('build/js/'));
});


gulp.task('autoprefixer', function () {
    return gulp.src('./build/css/*.css')
        .pipe(sourcemaps.init())
        .pipe(postcss([ autoprefixer({ browsers: ['last 2 versions'] }) ]))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./build/css'));
});

gulp.task('watch', function () {

    gulp.watch('./src/css/*', function(event) {
        gulp.run('build');
    });

    gulp.watch('./src/img/sprites/icons/*', function(event) {
        gulp.run('sprite');
    });
})