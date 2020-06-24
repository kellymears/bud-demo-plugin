/**
 * Babel configuration
 */

module.exports = {
  presets: [
    ['@roots/budpack/babel-preset-bud', {
      makepot: './resources/languages/plugin.pot',
    }],
  ],
}
