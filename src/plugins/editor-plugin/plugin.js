import {registerPlugin} from '@wordpress/plugins'

/**
 * Plugin: editor-plugin
 *
 * @param {string} name
 * @param {object} settings
 */
const editorPlugin = registerPlugin('editor-plugin', {
  render: () => {
    return null
  },
})

export default editorPlugin
