var path = require('path');
var Encore = require('@symfony/webpack-encore');
// require offline-plugin
var OfflinePlugin = require('offline-plugin');
// manifest plugin
var ManifestPlugin = require('webpack-manifest-plugin');

var commonChunk = require("webpack/lib/optimize/CommonsChunkPlugin");

Encore
    // directory where all compiled assets will be stored
    .setOutputPath('web/build/')
    // what's the public path to this directory (relative to your project's document root dir)
    .setPublicPath('/build')
    // empty the outputPath dir before each build
    .cleanupOutputBeforeBuild()
    // will output as web/build/vendor.js , main.js , sw.js 
    .addEntry('vendor', './web/assets/js/vendor.js')
    .addEntry('vue', './web/assets/js/vue.js')
    .addEntry("sw", './web/assets/js/sw.js')
    // will output as web/build/style.css
    .addStyleEntry('style', './web/assets/scss/style.scss')
    // allow sass/scss files to be processed
    .enableSassLoader()
    .enableSourceMaps(!Encore.isProduction())
    // create hashed filenames (e.g. app.abc123.css)
    //.enableVersioning()
    .enableVueLoader();


// fetch webpack config, then modify it!
var config = Encore.getWebpackConfig();
config.plugins.push(new commonChunk({
    name: 'chunck',
    async: true
}));
config.plugins.push(new ManifestPlugin({
    fileName: 'manifest.json',
    basePath: '/web/build/',
    seed: {
        "short_name": "SymfonyVue",
        "name": "SymfonyVue",
        "start_url": "/",
        "icons": [{
                "src": "/build/images/256.png",
                "sizes": "256x256",
                "type": "image/png"
            },
            {
                "src": "/build/images/512.png",
                "sizes": "512x512",
                "type": "image/png"
            }
        ],
        "background_color": "#FAFAFA",
        "theme_color": "#e10b0b",
        "display": "standalone",
        "orientation": "portrait",
        "gcm_sender_id": "314804067424"
    }
}));
// push offline-plugin it must be the last one to use 
config.plugins.push(new OfflinePlugin({
    "strategy": "changed",
    "responseStrategy": "cache-first",
    "publicPath": "/build/",
    "caches": {
        // offline plugin doesn't know about build folder 
        // if I added build in it , it will show something like : OfflinePlugin: Cache pattern [build/images/*] did not match any assets
        "main": [
            '*.json',
            '*.css', 
            '*.js',
            'img/*'
        ]
    },
    "ServiceWorker": {
        "events": !Encore.isProduction(),
        "entry": "./web/assets/js/sw.js",
        "cacheName": "SymfonyVue",
        "navigateFallbackURL": '/',
        "minify": !Encore.isProduction(),
        "output": "./../sw.js",
        "scope": "/"
    },
    "AppCache": null
}));

// export the final and modified configuration
module.exports = config;