const config = require('./config.json');

const {resolve} = require('path');
const webpack = require('webpack');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const ExtractTextPlugin = require('extract-text-webpack-plugin');

const project = config.Project;
const TEST_SITE = 'http://' + config.DevSite;
const SRC_DIR = resolve(__dirname, 'src/');
const BUILD_DIR = resolve(__dirname, 'content/themes/' + project + '/dist/');

const ExtractCSS = new ExtractTextPlugin('thing.min.css');


const browserSyncConfig = {
    // browse to http://localhost:3000/ during development,
    // ./public directory is being served
    host: "localhost",
    proxy: TEST_SITE,
    files: ['./**/*.php'],
    tunnel: true,
    // root: [__dirname],
    open: {file: "index.php"}
};

const cssConfig = {
    fallback: 'style-loader',
    use: [
        'css-loader',
        {
            loader: 'postcss-loader',
            options: {
                sourceMap: 'inline',
                plugins: () => ([
                    require('autoprefixer')({
                        browsers: 'last 2 versions'
                    }),
                    require('precss')(),
                    require('cssnano')(),
                ]),
            },
        },
    ]
};

const webpackConfig = {
    entry: {
        // Inspired From: https://stackoverflow.com/questions/35903246/how-to-create-multiple-output-paths-in-webpack-config
        'plugin/index': SRC_DIR + '/scripts/index.js',
        'theme/index': SRC_DIR + '/scripts/index.js',
    },
    output: {
        // filename: project + '.min.js',
        filename: "[name].min.js",
        chunkFilename: "[name].min.js",
        // path: BUILD_DIR,
    },

    context: SRC_DIR,

    devtool: 'inline-source-map',

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
                test: /\.(s*)css$/,
                use: ExtractCSS.extract(cssConfig)
            },
        ],
    },

    plugins: [
        ExtractCSS,
        new BrowserSyncPlugin(browserSyncConfig)
    ],
};


module.exports = webpackConfig;