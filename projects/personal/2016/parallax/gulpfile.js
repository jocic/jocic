/***********************************************************\
|* Website: https://www.djordjejocic.com                   *|
|* Author: Djordje Jocic <office@djordjejocic.com>         *|
|* ------------------------------------------------------- *|
|* Filename: gulpfile.js                                   *|
|* ------------------------------------------------------- *|
|* Copyright (C) 2018                                      *|
\***********************************************************/

/******************\
|* Core Variables *|
\******************/

var browserSync = require("browser-sync");

/******************\
|* GULP Variables *|
\******************/

var gulp        = require("gulp");
var sass        = require('gulp-sass')(require('sass'));
var concatenate = require("gulp-concat");
var uglify      = require("gulp-uglify");
var minifyCss   = require("gulp-minify-css");

/*****************\
|* Task: Default *|
\*****************/

exports.default = gulp.series(compileScripts, compileStyles, compileResources, appendScripts, appendStyles, watch);

/******************\
|* Tasks: Compile *|
\******************/

function compileScripts(cb) {
	
	// Scripts

	gulp.src([
		"src/scripts/**/*.js"
	])

	// Normal Version

	.pipe(concatenate("parallax.js"))
	.pipe(gulp.dest("dist/js"))
	.pipe(gulp.dest("demo/libraries/parallax/latest/js"))

	// Minified Version

	.pipe(concatenate("parallax.min.js"))
	.pipe(uglify())
	.pipe(gulp.dest("dist/js"))
	.pipe(gulp.dest("demo/libraries/parallax/latest/js"));
	
	cb();
}

function compileStyles(cb) {
	
	// Styles
	
	gulp.src([
		"src/styles/**/*.scss"
	])
	
	// Normal Version
	
	.pipe(concatenate("parallax.css"))
	.pipe(sass())
	.pipe(gulp.dest("dist/css"))
	.pipe(gulp.dest("demo/libraries/parallax/latest/css"))
	
	// Minified Version
	
	.pipe(concatenate("parallax.min.css"))
	.pipe(sass())
	.pipe(minifyCss())
	.pipe(gulp.dest("dist/css"))
	.pipe(gulp.dest("demo/libraries/parallax/latest/css"));
	
	cb();
}

function compileResources(cb) {
	
	// Images
	
	gulp.src([
		"src/images/**/*.png",
		"src/images/**/*.gif",
		"src/images/**/*.jpg",
		"src/images/**/*.jpeg"
	])
	
	.pipe(gulp.dest("dist/images"))
	.pipe(gulp.dest("demo/libraries/parallax/latest/images"));
	
	cb();
}

/**************************\
|* Tasks: Append Licenses *|
\**************************/

function appendScripts(cb) {
    
    // Append License
    
    gulp.src([
        "src/texts/js-license.txt",
        "dist/js/parallax.min.js"
    ])
	
    .pipe(concatenate("parallax.min.js"))
    .pipe(gulp.dest("dist/js"))
    .pipe(gulp.dest("demo/libraries/parallax/latest/js"));
	
	cb();
}

function appendStyles(cb) {
    
    // Append License
    
    gulp.src([
        "src/texts/css-license.txt",
        "dist/css/parallax.min.css"
    ])
    .pipe(concatenate("parallax.min.css"))
    .pipe(gulp.dest("dist/css"))
    .pipe(gulp.dest("demo/libraries/parallax/latest/css"))
	
	cb();
}

/***************\
|* Task: Watch *|
\***************/

function watch(cb) {
	
	gulp.watch("src/styles/**/*.scss", gulp.series(compileStyles, appendStyles));
	
	gulp.watch("src/scripts/**/*.js", gulp.series(compileScripts, appendScripts));
	
	cb();
}



