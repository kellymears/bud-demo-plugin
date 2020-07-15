/** @wordpress */
import {__} from '@wordpress/i18n'
import {registerBlockType} from '@wordpress/blocks'

/** acme-block components */
import {edit} from './containers/edit'
import {save} from './containers/save'
import {attributes} from './attributes.json'
import './editor.css'

/**
 * Registers a new block provided a unique name and an object defining its
 * behavior. Once registered, the block is made available as an option to any
 * editor interface where blocks are implemented.
 *
 * @param {string}             name
 * @param {BlockConfiguration} settings
 */
registerBlockType('acme-co/acme-block', {
  /**
   * The block title.
   * @type {string}
   */
  title: __('Acme Co. Block', 'acme-co'),

  /**
   * A short description of the block.
   * @type {string}
   */
  description: __('Short description of acme-block', 'acme-co'),

  /**
   * The block category.
   * @type {string}
   */
  category: 'common',

  /**
   * Setting `parent` lets a block require that it is only available when
   * nested within the specified blocks.
   * @type {string}
   */
  parent: null,

  /**
   * Searchable keywords for discovery.
   * @type {array}
   */
  keywords: ['test'],

  /**
   * Block styles
   * @see https://git.io/JfZTu
   * @type {BlockStyle}
   */
  styles: [
    {
      name: 'normal',
      label: 'Normal',
      isDefault: false,
    },
  ],

  /**
   * Extended support features
   * @type {Object}
   */
  supports: {
    /**
     * Anchors link directly to a specific block on a page. This
     * property adds a field to define an id for the block and a button to
     * copy the direct link.
     * @type {bool}
     */
    anchor: true,

    /**
     * Enable alignments.
     * Set to true to enable all.
     * @type {bool|array} {'left'|'center'|'right'|'wide'|'full'}
     */
    align: [],

    /**
     * Enable wide alignment.
     * Dependent on the align definition.
     * @type {bool}
     */
    alignWide: true,

    /**
     * This property adds a field to define a custom className
     * for the block wrapper.
     * @type {bool}
     */
    customClassName: true,

    /**
     * Allow a block's markup to be edited.
     * @type {bool}
     */
    html: true,

    /**
     * Set to false to hide the block from the inserter so that it can
     * only be inserted programmatically.
     * @type {bool}
     */
    inserter: true,

    /**
     * A non-multiple block can be inserted into each post, one time only.
     * @type {bool}
     */
    multiple: true,

    /**
     * Allows the block to be used as a reusable block.
     * @type {bool}
     */
    reusable: true,
  },

  /**
   * Block attributes.
   * @type {Object}
   */
  attributes,

  /**
   * Component to render in the editor.
   */
  edit,

  /**
   * Component to render to the database.
   */
  save,
})
