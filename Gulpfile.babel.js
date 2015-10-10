import gulp from 'gulp';
import sass from 'gulp-sass';
import minifycss from 'gulp-minify-css';
import minifyjs from 'gulp-minify';

let basePath = './Packages/Application/MaxS.RandomMovie';

let paths = {
    'private': basePath + '/Resources/Private/',
    'public': basePath + '/Resources/Public/'
};

gulp.task('MaxS.RandomMovie:compile:styles', () => {
  return gulp.src(paths.private + 'Styles/Main.scss')
    .pipe(sass())
    .pipe(minifycss())
    .pipe(gulp.dest(paths.public + 'Styles/'))
});

gulp.task('MaxS.RandomMovie:compile:scripts', () => {
  return gulp.src(paths.private + 'JavaScripts/App.js')
    .pipe(minifyjs())
    .pipe(gulp.dest(paths.public + 'JavaScripts/'))
});
