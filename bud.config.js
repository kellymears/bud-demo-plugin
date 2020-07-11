const bud = require('@roots/budpack');

bud
  .srcPath('src')
  .distPath('dist')

bud.alias({
  '@blocks': bud.src('blocks'),
  '@components': bud.src('components'),
})
.sync({
  proxy: 'http://bud-sandbox.valet',
  port: 3010,
})

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

bud
  .babel(bud.preset('babel/preset-wp'))
  .postCss(bud.preset('postcss'))

module.exports = bud
