/** @wordpress */
import {__} from '@wordpress/i18n'
import {InnerBlocks, RichText} from '@wordpress/block-editor'

/** Modules */
import PropTypes from 'prop-types'

/**
 * The edit function describes the structure of your block in the context of the editor.
 * This represents what the editor will render when the block is used.
 *
 * @see https://git.io/JfZJD
 *
 * @prop   {PropTypes.string} className
 * @prop   {PropTypes.bool}   isSelected
 * @prop   {PropTypes.func}   setAttributes
 * @return {WPElement}        Element to render.
 */
const edit = ({attributes, className, setAttributes}) => {
  const {text} = attributes

  /**
   * Generic attribute handler.
   *
   * @param  {string} attribute key
   * @param  {mixed}  attribute value
   * @return {void}
   */
  const setAttribute = (attr, value) => {
    setAttributes({[attr]: value})
  }

  /**
   * Return the block contents for rendering.
   */
  return (
    <div className={className}>
      <RichText
        placeholder={__('placeholder heading', 'acme-co')}
        tagName={'h2'}
        value={text || ''}
        onChange={value => setAttribute('text', value)}
      />

      <InnerBlocks />
    </div>
  )
}

edit.propTypes = {
  attributes: PropTypes.shape({
    text: PropTypes.string,
  }),
  className: PropTypes.string,
  isSelected: PropTypes.bool,
  setAttributes: PropTypes.func,
}

export {edit}
