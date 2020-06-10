const {webpack, defaults} = require('./bud/build')

/**
 * Bud webpack configuration
 *
 * You should not need to change the webpack config
 * in order to use this framework as designed.
 *
 *  src
 *  ├── blocks
 *  │   └── [blockname]
 *  │       ├── editor.css
 *  │       ├── editor.js
 *  │       ├── public.css
 *  │       └── public.js
 *  └── plugins
 *      └── [pluginname]
 *          ├── plugin.js
 *          └── plugin.css
 */

module.exports = webpack(defaults)
