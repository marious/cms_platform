let mix = require('laravel-mix');

const path = require('path');
let directory = path.basename(path.resolve(__dirname));

const source = 'modules/plugins/' + directory;
const dist = 'public/vendor/core/plugins/' + directory;

mix
    .sass(source + '/resources/assets/sass/ecommerce-product-attributes.scss', dist + '/css')
    .sass(source + '/resources/assets/sass/ecommerce.scss', dist + '/css')
    .sass(source + '/resources/assets/sass/currencies.scss', dist + '/css')
    .js(source + '/resources/assets/js/customer.js', dist + '/js')
    .js(source + '/resources/assets/js/currencies.js', dist + '/js')
    .js(source + '/resources/assets/js/setting.js', dist + '/js')
    .js(source + '/resources/assets/js/store-locator.js', dist + '/js')
    .js(source + '/resources/assets/js/ecommerce-product-attributes.js', dist + '/js')
    .js(source + '/resources/assets/js/shipping.js', dist + '/js')
    .js(source + '/resources/assets/js/edit-product.js', dist + '/js')

    .copyDirectory(dist + '/css', source + '/public/css')
    .copyDirectory(dist + '/js', source + '/public/js');

