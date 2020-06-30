const bud = require('@roots/budpack');

/*
 |--------------------------------------------------------------------------
 | Project configuration
 |--------------------------------------------------------------------------
 |
 | Add assets you wish to enqueue in the context of the WordPress admin
 | and editor interfaces.
 |
 */

bud.projectPath(__dirname)
  .srcPath('src')
  .distPath('dist')
  .alias({
    '@blocks': bud.src('blocks'),
    '@components': bud.src('components'),
  })
  .browserSync({
    enabled: true,
    proxy: 'acme.test',
  })

/*
 |--------------------------------------------------------------------------
 | Editor assets
 |--------------------------------------------------------------------------
 |
 | Add assets you to enqueue in the context of the WordPress admin
 | and editor interfaces.
 |
 */

bud.entry('editor', [
  bud.src('entry-editor.js'),
])

/*
 |--------------------------------------------------------------------------
 | Public assets
 |--------------------------------------------------------------------------
 |
 | Add assets to be enqueued on outward-facing site content in addition to
 | admin and editor interfaces.
 |
 */

bud.entry('public', [
  bud.src('entry-public.js'),
])

module.exports = bud
