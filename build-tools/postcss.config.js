module.exports = (e) => {
    let exports = ({
        parser: 'postcss-scss',
        // syntax: 'postcss-safe-parser',
        // sourceMap: 'inline',
        sourceMap: true,
        plugins: {
            'postcss-partial-import': {
                prefix: '_',
                extension: '.css',
            },
            'postcss-cssnext': {
                browsers: [
                    'last 2 versions',
                    '> 5%',
                    'safari >= 9',
                    'ie >= 9'
                ],
            },
            'postcss-custom-media': {},
            'postcss-nesting': {},
            'postcss-mixins': {},


        },
    });

    if ('production' === process.env.NODE_ENV) {

        exports.plugins['postcss-discard-comments'] = {
            removeAll: true,
        };

        exports.plugins['cssnano'] = {
            autoprefixer: false,
            // discardComments: {removeAll: true} // removing in favor of postcss-discard-comments
        };

    }

    // {
    //     'cssnano': {
    //     autoprefixer: false,
    //     // discardComments: {
    //     //     removeAll: true
    //     // }
    //     }
    // }

    return exports;
};

