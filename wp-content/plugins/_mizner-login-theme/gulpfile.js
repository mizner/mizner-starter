var theSite = "clone.dev"; //also a good idea to match your localhost url

var theProject = "custom-dashboard"; // Make sure this matches the project name in functions enqueues

var jsFilePath = "assets/scripts/";
var theFiles = orderJsFiles([
    // 1st file loads first, 2nd, ect.
    "main.js",
]);

// Provide the ability to simplify ordering scripts for concatenation.  See: var theFiles above
function orderJsFiles(arr) {
    return arr.map(function (str) {
        return jsFilePath + str
    })
}

var gulp = require("gulp");
var babel = require("gulp-babel");
var browserSync = require("browser-sync").create();
var autoprefixer = require("gulp-autoprefixer");
var cssnano = require("gulp-cssnano");
var uglify = require("gulp-uglify");
var rename = require("gulp-rename");
var concat = require("gulp-concat");
var sass = require("gulp-sass");
var sourcemaps = require("gulp-sourcemaps");
var plumber = require("gulp-plumber");

gulp.task("dashboard-sass", function () {
    gulp.src("./assets/styles/dashboard.scss")
        .pipe(sass()/*.on("error", sass.logError)*/)
        .pipe(plumber())
        .pipe(autoprefixer())
        .pipe(sourcemaps.init({loadMaps: true}))
        .pipe(sourcemaps.write(""))
        .pipe(rename(theProject + ".dashboard.min.css"))
        .pipe(gulp.dest("./dist"))
        .pipe(browserSync.stream())
});
gulp.task("login-sass", function () {
    gulp.src("./assets/styles/login.scss")
        .pipe(sass()/*.on("error", sass.logError)*/)
        .pipe(plumber())
        .pipe(autoprefixer())
        .pipe(sourcemaps.init({loadMaps: true}))
        .pipe(sourcemaps.write(""))
        .pipe(rename(theProject + ".login.min.css"))
        .pipe(gulp.dest("./dist"))
        .pipe(browserSync.stream())
});

gulp.task("sass-production", function () {
    gulp.src("./assets/styles/main.scss")
        .pipe(sass().on("error", sass.logError))
        .pipe(autoprefixer())
        .pipe(cssnano())
        .pipe(rename(theProject + ".min.css"))
        .pipe(gulp.dest("./dist"))
});


gulp.task("js", function () {
    gulp.src(theFiles)
        .pipe(plumber())
        .pipe(concat("output.min.js")) // concat pulls all our files together before minifying them
        .pipe(babel({
            presets: ["es2015"]
        }))
        .pipe(uglify())
        .pipe(rename(theProject + ".min.js"))
        .pipe(gulp.dest("./dist"))
});

gulp.task("browser-sync", function () {
    browserSync.init(["*"], {
        proxy: theSite,
        root: [__dirname],
        open: {
            file: "index.php"
        }
    });
});

gulp.task("watch", ["browser-sync"], function () {
    gulp.watch("./assets/styles/**/*.scss", ["dashboard-sass"]);
    gulp.watch("./assets/styles/**/*.scss", ["login-sass"]);
    gulp.watch("./assets/scripts/**/*.js", ["js"]);
    gulp.watch("./assets/scripts/**/*.js", browserSync.reload);
    gulp.watch("**/*.php", browserSync.reload);
    gulp.watch("gulpfile.js").on("change", function () {
        process.exit(0)
    })
});

gulp.task("default", ["sass", "js"]);

gulp.task("production", ["sass-production", "js"]);