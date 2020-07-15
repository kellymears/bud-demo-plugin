/**
 * This object contains a ton of tools to set up the build
 * for your application.
 */
const bud = require('@roots/budpack')

/**
 * Set project asset paths.
 */
bud
  .srcPath('src')
  .distPath('dist')

/**
 * Alias project directories.
 */
bud.alias({
  '@blocks': bud.src('blocks'),
  '@components': bud.src('components'),
})

/**
 * Live reload configuration.
 */
bud.sync({
  proxy: 'http://bud-sandbox.valet',
  port: 3010,
})

/**
 * Produce asset bundles.
 */
bud
  .bundle('editor', [
    bud.src('entry-editor.js'),
  ])
  .bundle('public', [
    bud.src('entry-public.js'),
  ])
  .dependencyManifest()
  .inlineManifest()
  .vendor()
  .hash();

/**
 * Configure transpilers.
 */
bud
  .babel(bud.preset('babel/preset-wp'))
  .postCss(bud.preset('postcss'))

/**
 * Export finalize configuration.
 */
module.exports = bud
