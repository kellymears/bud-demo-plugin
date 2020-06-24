/** @wordpress */
import {__} from '@wordpress/i18n'

import {
  BlockControls,
  MediaPlaceholder,
  MediaUpload,
} from '@wordpress/block-editor'

import {IconButton, Toolbar} from '@wordpress/components'

/** Modules */
import PropTypes from 'prop-types'

/**
 * Allowed media types
 * @const {array} ALLOWED_MEDIA_TYPES
 */
const ALLOWED_MEDIA_TYPES = ['image']

/**
 * Media
 *
 * @prop {string}   attribute     [default: 'image']
 * @prop {string}   className     [default: 'acme-co-image']
 * @prop {string}   icon          [default: 'camera']
 * @prop {function} setAttributes [required]
 * @prop {string}   title         [default: 'Image']
 * @prop {object}   value         [required]
 */
const Image = ({
  attribute,
  className,
  icon,
  setAttributes,
  title,
  value,
}) => {
  /**
   * Handle image selection.
   *
   * @param {object} value
   */
  const onSelectImage = value =>
    setAttributes({[`${attribute}`]: value})

  return !value ? (
    <MediaPlaceholder
      allowedTypes={ALLOWED_MEDIA_TYPES}
      multiple={false}
      labels={title ?? 'Add image'}
      className={className ? className : 'image-upload'}
      onSelect={onSelectImage}
    />
  ) : (
    <>
      <BlockControls>
        <Toolbar>
          <MediaUpload
            onSelect={onSelectImage}
            allowedTypes={ALLOWED_MEDIA_TYPES}
            value={value.id}
            render={({open}) => (
              <IconButton
                className="components-toolbar__control"
                label={__('Edit media', 'acme-co')}
                icon={icon}
                onClick={open}
              />
            )}
          />
        </Toolbar>
      </BlockControls>

      <img
        className={className}
        alt={value.alt ?? ''}
        src={value.url}
      />
    </>
  )
}

Image.propTypes = {
  attribute: PropTypes.string,
  className: PropTypes.string,
  value: PropTypes.shape({
    id: PropTypes.number,
    alt: PropTypes.string,
    url: PropTypes.string,
  }).isRequired,
  icon: PropTypes.string,
  title: PropTypes.string,
  setAttributes: PropTypes.func.isRequired,
}

Image.defaultProps = {
  attribute: 'image',
  className: 'acme-co-image',
  icon: 'camera',
  title: __('Image', 'acme-co'),
}

export default Image
