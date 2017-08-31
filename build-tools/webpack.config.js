const config = require('../config.json');

const {resolve} = require('path');
const {join} = require('path');
const webpack = require('webpack');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const BabiliPlugin = require("babili-webpack-plugin");
const BabiliOptions = require("./babili.config");

const project = config.Project;
const TEST_SITE = 'http://' + config.DevSite;
const SRC_DIR = resolve(__dirname, '../assets/');
const THEME_DIR = resolve(__dirname, '../content/themes/' + project);
const PLUGIN_DIR = resolve(__dirname, '../content/plugins/');

const webpackInstance = options => {

    let ExtractCSS = new ExtractTextPlugin({
        filename: options.filename + '.min.css',
        // disable: false,
        // allChunks: true
    });

    let plugins = [
        ExtractCSS,
    ];

    if ('production' === process.env.NODE_ENV) {
        plugins.push(
            new BabiliPlugin(BabiliOptions)
        )
    }

    let js = {
        test: /\.js$/,
        exclude: /node_modules/,
        use: [
            {
                loader: 'babel-loader',
                options: {presets: ["es2015"]},
            }
        ],
    };

    let css = {
        test: /\.css$/, // or test: /\.(s*)css$/,
        use: ExtractCSS.extract({
            fallback: 'style-loader',
            use: [
                {
                    loader: 'css-loader',
                    options: {
                        sourceMap: true,
                    }
                },
                {
                    loader: 'postcss-loader',
                    options: {
                        config: {
                            path: resolve(__dirname)
                        }
                    }
                },
            ]
        })
    };

    return ({
        entry: options.entry,
        output: {
            filename: options.filename + '.min.js',
            path: options.output,
        },
        // context: SRC_DIR,
        devtool: 'inline-source-map', // or 'source-map'
        stats: {
            children: false, // Suppress excessive log from Extract Text Plugin.
        },
        module: {
            rules: [
                js,
                css,
            ],
        },
        plugins,

    })
};

const Theme = webpackInstance({
    'entry': join(SRC_DIR, '/public/index.js'),
    'filename': project,
    'output': join(THEME_DIR, '/dist/'),
});

const Crit = webpackInstance({
    'entry': join(SRC_DIR, '/public/index.js'),
    'filename': 'crit',
    'output': join(THEME_DIR, '/dist/'),
});

const Admin = webpackInstance({
    'entry': join(SRC_DIR, '/admin/index.js'),
    'filename': 'admin',
    'output': join(THEME_DIR, '/dist/'),
});

const CustomDashboard = webpackInstance({
    'entry': join(SRC_DIR, '/admin/index'),
    'filename': 'custom-dashboard',
    'output': join(PLUGIN_DIR, '/_mizner-custom-dashboard/dist'),
});

module.exports = [
    // Theme Files
    Theme,
    Crit,
    Admin,

    // Plugin Files
    CustomDashboard,

];
