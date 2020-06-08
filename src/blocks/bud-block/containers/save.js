/** @wordpress */
import {getBlockDefaultClassName} from '@wordpress/blocks'
import {InnerBlocks, RichText} from '@wordpress/block-editor'

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
  const className = getBlockDefaultClassName('roots/bud-block')
  const {text} = attributes

  return (
    <>
      {text && (
        <RichText.Content
          tagName={'h2'}
          className={`${className}__text`}
          value={text}
        />
      )}

      <InnerBlocks.Content />
    </>
  )
}

save.propTypes = {
  attributes: PropTypes.shape({
    text: PropTypes.string,
  }),
}

export {save}
