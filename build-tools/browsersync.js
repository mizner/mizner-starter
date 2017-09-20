const config = require('../config.json');
const bs = require("browser-sync").create();
const bsConfig = {
    host: 'localhost',
    proxy: 'http://' + config.DevSite,
    files: [
        "content/themes/**/*.css",
        {
            match: [
                "content/**/*.php",
                //  "content/**/*.js"
            ],
            fn: (event, file) => {
                // console.log(file);
                if (event === "change") {
                    bs.reload();
                }
            }
        }
    ]
};

bs.init(bsConfig);