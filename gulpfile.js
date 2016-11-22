var project = "clone";

var jsPath = "assets/scripts/";
var theFiles = [ // 1st file loads first, 2nd, ect.
    // jsPath + "skip-link-focus-fix.js",
    jsPath + "fallbacks/modernizr-custom.js",
    jsPath + "fallbacks/object-fit-polyfill.js",
    jsPath + "navigation/nav-mobile.js",
    jsPath + "navigation/nav.js",
    jsPath + "navigation/nav-mobile-hide-button-on-scroll.js",
    // jsPath + "nav-dropdown-buttons.js",
    // jsPath + "popup-base.js",
    // jsPath + "popup-login.js",
    // jsPath + "visible-in-browser.js",
    jsPath + "prevent-empty-nav-redirect.js",
    jsPath + "vendors/bootstrap/util.js",
    jsPath + "vendors/bootstrap/carousel.js",
];

var theInlineFiles = [
    jsPath + "fixed-header.js"
];

var gulp = require("gulp"),
    browserSync = require("browser-sync").create(),
    autoprefixer = require("gulp-autoprefixer"),
    cssnano = require("gulp-cssnano"),
    uglify = require("gulp-uglify"),
    rename = require("gulp-rename"),
    concat = require("gulp-concat"),
    sass = require("gulp-sass"),
    sourcemaps = require("gulp-sourcemaps"),
    babel = require("gulp-babel"),
    plumber = require("gulp-plumber"),
    del = require('del');

gulp.task("sass", function () {
    gulp.src("assets/styles/**/*.scss")
        .pipe(sourcemaps.init({loadMaps: true}))
        .pipe(sass().on("error", sass.logError))
        .pipe(autoprefixer())
        .pipe(rename(project + ".min.css"))
        .pipe(sourcemaps.write(""))
        .pipe(gulp.dest("./dist"))
        .pipe(browserSync.stream({match: '**/*.css'}));
});

gulp.task("inline-sass", function () {
    gulp.src("./assets/styles/inline.scss")
        .pipe(sass())
        .pipe(autoprefixer())
        .pipe(cssnano({zindex: false}))
        .pipe(rename(project + ".inline.min.css"))
        .pipe(gulp.dest("./dist"));
});

gulp.task("production-sass", function () {
    gulp.src("./assets/styles/**/*.scss")
        .pipe(sass().on("error", sass.logError))
        .pipe(rename(project + ".min.css"))
        .pipe(gulp.dest("./dist"));
});

gulp.task("js", function () {
    gulp.src(theFiles)
        .pipe(plumber())
        .pipe(concat("output.min.js")) // concat pulls all our files together before minifying them
        .pipe(babel({
            presets: ["es2015"]
        }))
        .pipe(uglify())
        .pipe(rename(project + ".min.js"))
        .pipe(gulp.dest("./dist"))
});

gulp.task("inline-js", function () {
    gulp.src(theInlineFiles)
        .pipe(plumber())
        .pipe(concat("output.min.js")) // concat pulls all our files together before minifying them
        .pipe(babel({
            presets: ["es2015"]
        }))
        .pipe(uglify())
        .pipe(rename(project + ".inline.min.js"))
        .pipe(gulp.dest("./dist"))
});


gulp.task("clean:dist", function () {
    return del([
        "dist/**/*" // here we use a globbing pattern to match everything inside the `dist` folder
    ]);
});

gulp.task("browser-sync", function () {
    browserSync.init(["*"], {
        proxy: project + ".dev",
        root: [__dirname],
        open: {
            file: "index.php"
        }
    });

});

gulp.task("watch", ["browser-sync"], function () {
    gulp.watch("assets/styles/**/*.scss", ["sass"]);
    gulp.watch("./assets/scripts/**/*.js", ["js"]);
    gulp.watch("./assets/scripts/**/*.js", browserSync.reload);
    gulp.watch("**/*.php", browserSync.reload);
    gulp.watch("gulpfile.js").on("change", function () {
        process.exit(0)
    })
});

gulp.task("default", ["clean:dist", "production-sass", "inline-sass", "js", "inline-js"]);
