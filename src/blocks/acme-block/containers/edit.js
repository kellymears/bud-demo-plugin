/** @wordpress */
import {__} from '@wordpress/i18n'

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
  /**
   * Return the block contents for rendering.
   */
  return <div className={className}>div</div>
}

edit.propTypes = {
  className: PropTypes.string,
  isSelected: PropTypes.bool,
  setAttributes: PropTypes.func,
}

export {edit}
