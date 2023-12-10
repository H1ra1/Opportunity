const gulp = require( 'gulp' );
const concatCss = require( 'gulp-concat-css' );
const cssNano = require( 'gulp-cssnano' )
const sass = require('gulp-sass')(require('sass'));

gulp.task('sass', function sassFunc(){
    return gulp.src( './src/wp-content/plugins/opportunity-auction-addons/assets/sass/*.scss' )
    .pipe(sass())
    .pipe(concatCss('oaa.min.css'))
    .pipe(gulp.dest('./src/wp-content/plugins/opportunity-auction-addons/assets/css'))
});

gulp.task('minify', function minifyFunc() {
    return gulp.src( './src/wp-content/plugins/opportunity-auction-addons/assets/css/oaa.min.css' )
    .pipe(cssNano())
    .pipe(gulp.dest('./src/wp-content/plugins/opportunity-auction-addons/assets/css'));
});

gulp.task('watch', function watchFunc() {
    gulp.watch( './src/wp-content/plugins/opportunity-auction-addons/assets/sass/*.scss', gulp.series( 'sass', 'minify' ) );
});