module.exports = {
    parser: require('postcss-scss'),
    //syntax: require('postcss-safe-parser'),
    sourceMap: 'inline',
    // sourceMap: true,
    plugins: () => ([
        require('postcss-partial-import')(
            {prefix: '_', extension: '.css',}
        ),
        require("postcss-url")(),
        // require('autoprefixer')({
        //     browsers: 'last 2 versions'
        // }),
        require('postcss-cssnext')(),
        require('postcss-mixins')(),
        // require('cssnano')(),
        // require('reporter')(),
        require("postcss-browser-reporter")(),
        require("postcss-reporter")(),
    ]),
};