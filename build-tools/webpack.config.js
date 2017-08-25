const config = require('../config.json');

const {resolve} = require('path');
const {join} = require('path');
const webpack = require('webpack');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const UglifyJSPlugin = require('uglifyjs-webpack-plugin');

const project = config.Project;
const TEST_SITE = 'http://' + config.DevSite;
const SRC_DIR = resolve(__dirname, '../assets/');
const THEME_DIR = resolve(__dirname, '../content/themes/' + project);
const PLUGIN_DIR = resolve(__dirname, '../content/plugins/');

// const StyleLintPlugin = require('stylelint-webpack-plugin');
// const stylelintRules = require("./stylelint.config.js");


// const postcssConfig = require("./postcss.config.js");

/**
 * Webpack Instance
 * @param options
 * @returns {{entry, output: {filename: string, path}, devtool: string, stats: {children: boolean}, module: {rules: [null,null]}, plugins: [null]}}
 */
const webpackInstance = options => {

    let ExtractCSS = new ExtractTextPlugin({
        filename: options.filename + '.min.css',
        // disable: false,
        // allChunks: true
    });

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
                {
                    test: /\.js$/,
                    exclude: /node_modules/,
                    use: [{
                        loader: 'babel-loader',
                        options: {presets: ["es2015", "babili"]},
                    }],
                },
                {
                    test: /\.(s*)css$/, // or test: /\.(s*)css$/,
                    use: ExtractCSS.extract({
                        fallback: 'style-loader',
                        use: [{
                            loader: 'css-loader',
                            options: {sourceMap: true}
                        }, {
                            loader: 'sass-loader'
                        },
                            // {
                            //     loader: 'postcss-loader',
                            //     options: postcssConfig,
                            // },
                        ]
                    })
                },
            ],
        },

        plugins: [
            ExtractCSS,
            // new StyleLintPlugin(stylelintRules),
        ],
    })
};

const Theme = webpackInstance({
    'entry': join(SRC_DIR, '/public/index'),
    'filename': project,
    'output': join(THEME_DIR, '/dist/'),
});

const Admin = webpackInstance({
    'entry': join(SRC_DIR, '/admin/index'),
    'filename': 'admin',
    'output': join(PLUGIN_DIR, '/_mizner-custom-dashboard/dist'),
});

module.exports = [
    Theme,
    // Admin,
];