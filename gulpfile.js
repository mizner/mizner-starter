const project = "starter";

const theFiles = [
    // 1st file loads first, 2nd, ect.
    "polyfills/promise.min.js",
    "polyfills/modernizr-custom.js",
    "polyfills/object-fit-polyfill.js",
    "skip-link-focus-fix.js",
    "header/fixed-header.js",
    "header/navigation/navigation.js",
    "header/navigation/navigation-mobile.js",
    "header/navigation/navigation-mobile-hide-button-on-scroll.js",
    "popup-base.js",
    "popup-login.js",
    // "visible-in-browser.js",
    "header/navigation/prevent-empty-nav-redirect.js",
    "call-to-action-form-popup.js",
    // jQuery Add-ons
    "vendors/jquery-smooth-scroll.js", /* @todo: rewrite this in vanilla */
];

const fileArray = theFiles.map(function (file) {
    return "assets/scripts/" + file;
});

const gulp = require("gulp"),
    bs = require("browser-sync").create(),
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

gulp.task("sass", () => {
    gulp.src("./assets/styles/**/*.scss")
        .pipe(sourcemaps.init())
        .pipe(sass().on("error", sass.logError))
        .pipe(autoprefixer())
        .pipe(sourcemaps.write())
        .pipe(rename(project + ".min.css"))
        .pipe(gulp.dest("./dist"))
        .pipe(bs.stream())
});

gulp.task("js", () => {
    gulp.src(fileArray)
        .pipe(plumber())
        .pipe(sourcemaps.init())
        .pipe(concat("output.min.js")) // concat pulls all our files together before minifying them
        .pipe(sourcemaps.write())
        .pipe(babel({
            presets: ["es2015"]
        }))
        .pipe(uglify())
        .pipe(rename(project + ".min.js"))
        .pipe(gulp.dest("./dist"))
        .pipe(bs.stream())
});

gulp.task("production-sass", () => {
    gulp.src("assets/styles/**/*.scss")
        .pipe(sass().on("error", sass.logError))
        .pipe(autoprefixer())
        .pipe(cssnano())
        .pipe(rename(project + ".min.css"))
        .pipe(gulp.dest("./dist"));
});

gulp.task("browser-sync", () => {
    bs.init(["*"], {
        proxy: project + ".dev",
        root: [__dirname],
        open: {
            file: "index.php"
        }
    });
});

gulp.task("clean:dist", () => {
    return del([
        "dist/**/*" // here we use a globbing pattern to match everything inside the `dist` folder
    ]);
});

gulp.task("watch", ["browser-sync"], () => {
    gulp.watch("assets/styles/**/*.scss", ["sass"]);
    gulp.watch("./assets/scripts/**/*.js", ["js"]);
    gulp.watch("**/*.php", bs.reload);
    gulp.watch("gulpfile.js").on("change", function () {
        process.exit(0)
    })
});

gulp.task("production", [
    "clean:dist",
    "production-sass",
    "js"
]);

gulp.task("default", [
    "clean:dist",
    "sass",
    "js"
]);