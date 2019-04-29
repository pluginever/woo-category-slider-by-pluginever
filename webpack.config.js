module.exports = {
    entry: {
        block: './src/index.js',
    },
    output: {
        path: __dirname,
        filename: "assets/js/wc-category-slider-block.js"
    },
    module: {
        rules: [
            {
                test: /\.(js|jsx)$/,
                use: {
                    loader: "babel-loader",
                    options: {
                        babelrc: false,
                        "presets": [
                            [ "@babel/preset-env", {
                                "modules": false,
                                "targets": {
                                    "browsers": [
                                        "last 2 Chrome versions",
                                        "last 2 Firefox versions",
                                        "last 2 Safari versions",
                                        "last 2 iOS versions",
                                        "last 1 Android version",
                                        "last 1 ChromeAndroid version",
                                        "ie 11"
                                    ]
                                }
                            } ]
                        ],
                        "plugins": [
                            [ "@babel/plugin-transform-react-jsx", {
                                "pragma": "wp.element.createElement"
                            } ],
                            "@babel/plugin-proposal-class-properties"
                        ]
                    },                    
                },
                exclude: /node_modules/
            }
        ]
    },
    resolve: {
        extensions: [ '.js', '.jsx' ],
    },
    mode: 'development',
    devtool: 'source-map',
}