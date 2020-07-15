/**
 * Public scripts.
 */

/** @wordpress */
import domReady from '@wordpress/dom-ready'

/** css */
import './public.css'

domReady(() => {
  console.log('dom ready event.')
})
