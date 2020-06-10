/** @wordpress */
import {getBlockDefaultClassName} from '@wordpress/blocks'

/** Modules */
import PropTypes from 'prop-types'

/**
 * The save function defines the way in which the different attributes should be combined
 * into the final markup, which is then serialized by the block editor into `post_content`.
 *
 * @see https://git.io/JfZJ9
 *
 * @return {WPElement} Element to render.
 */
const save = ({attributes}) => {
  const className = getBlockDefaultClassName('bud-demo-plugin/acme-block')

  return <>div</>
}

save.propTypes = {}

export {save}
