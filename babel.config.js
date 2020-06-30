/**
 * Babel configuration.
 */
const {resolve} = require('path')

module.exports = {
  presets: [
    ['@roots/budpack/config/babel', {
      makepot: resolve(__dirname, 'resources/languages/plugin.pot'),
    }],
  ],
}
