import {registerPlugin} from '@wordpress/plugins'

/**
 * Plugin: acme-plugin
 *
 * @param {string} name
 * @param {object} settings
 */
const acmePlugin = registerPlugin('acme-plugin', {
  render: () => {
    return null
  },
})

export default acmePlugin
