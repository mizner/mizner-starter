const config = require('../config.json');
const browserSync = require('browser-sync');
const browserSyncConfig = {
    host: 'localhost',
    proxy: 'http://' + config.DevSite,
    files: [
        "content/themes/**/*.css",
        {
            match: [
                "content/**/*.php",
                "content/**/*.js"
            ],
            fn: function (event, file) {
                if (event === "change") {
                    browserSync.reload();
                }
            }
        }
    ]
};

browserSync(browserSyncConfig);