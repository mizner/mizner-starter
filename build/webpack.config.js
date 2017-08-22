const config = require('../config.json');

const {resolve} = require('path');
const {join} = require('path');
const webpack = require('webpack');
const ExtractTextPlugin = require('extract-text-webpack-plugin');

const project = config.Project;
const TEST_SITE = 'http://' + config.DevSite;
const SRC_DIR = resolve(__dirname, '../src/');
const BUILD_DIR = resolve(__dirname, '../content/themes/' + project + '/dist/');

const cssConfig = {
    fallback: 'style-loader',
    use: [
        {
            loader: 'css-loader',
            options: {
                sourceMap: true
            }
        },
        {
            loader: 'postcss-loader',
            options: {
                parser: require('postcss-scss'),
                //syntax: require('postcss-safe-parser'),
                sourceMap: 'inline',
                // sourceMap: true,
                plugins: () => ([
                    require('postcss-easy-import')({
                        prefix: '_',
                        extensions: '.pcss',
                    }),
                    require('autoprefixer')({
                        browsers: 'last 2 versions'
                    }),
                    require('precss')(),
                    require('cssnano')(),
                    // require('reporter')(),
                ]),
            },
        },
    ]
};

/**
 * Webpack Instance
 * @param options
 * @returns {{entry, output: {filename: string, path}, devtool: string, stats: {children: boolean}, module: {rules: [null,null]}, plugins: [null]}}
 */
const webpackInstance = options => {

    let ExtractCSS = new ExtractTextPlugin(options.filename + '.min.css');
    // let ExtractCSS = new ExtractTextPlugin({
    //     filename: options.filename + '.min.css',
    //     disable: false,
    //     allChunks: true
    // });


    return ({
        entry: options.entry,
        output: {
            filename: options.filename + '.min.js',
            path: options.output,
        },
        // context: SRC_DIR,
        devtool: 'inline-source-map',
        // devtool: 'source-map',
        stats: {
            children: false, // Suppress excessive log from Extract Text Plugin.
        },
        module: {
            rules: [
                {
                    test: /\.js$/,
                    use: [
                        'babel-loader',
                    ],
                    exclude: /node_modules/
                },
                {
                    // test: /\.(s*)css$/,
                    test: /\.(p*)css$/,
                    use: ExtractCSS.extract(cssConfig)
                },
            ],
        },

        plugins: [
            ExtractCSS,
        ],
    })
};

const Theme = webpackInstance({
    'entry': join(SRC_DIR, '/public/index'),
    'filename': project,
    'output': BUILD_DIR,
});

const Example = webpackInstance({
    'entry': join(SRC_DIR, '/admin/index'),
    'filename': 'admin',
    'output': join(BUILD_DIR, 'example'),
});

module.exports = [
    Theme,
    Example,
];