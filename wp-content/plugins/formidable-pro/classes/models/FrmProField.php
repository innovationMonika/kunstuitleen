<?php

if ( ! defined( 'ABSPATH' ) ) {
	die( 'You are not allowed to call this page directly.' );
}

class FrmProField {

	/**
	 * @param array $field_data
	 * @return array
	 */
	public static function create( $field_data ) {

		if ( $field_data['field_options']['label'] !== 'none' ) {
			$field_data['field_options']['label'] = '';
		}

		self::switch_in_section_field_option( $field_data );

		switch ( $field_data['type'] ) {
			case 'select':
				$width = FrmStylesController::get_style_val( 'auto_width', $field_data['form_id'] );
				$field_data['field_options']['size'] = $width;
				break;
			case 'divider':
				if ( ! empty( $field_data['field_options']['repeat'] ) ) {
					// Create the repeatable form.
					$field_data['field_options']['form_select'] = self::create_repeat_form( 0, array( 'parent_form_id' => $field_data['form_id'], 'field_name' => $field_data['name'] ) );
				}
				break;
			case 'file':
				$field_data['field_options']['restrict'] = 1;
				if ( ! $field_data['field_options']['ftypes'] ) {
					$field_data['field_options']['ftypes'] = array(
						'jpg|jpeg|jpe' => 'image/jpeg',
						'png'          => 'image/png',
						'gif'          => 'image/gif',
					);
				}
				break;
		}
		return $field_data;
	}

	/**
	 * Change the default in_section value to the ID of the section where a new field was dragged and dropped
	 *
	 * @since 2.0.24
	 *
	 * @param array $field_data
	 * @return void
	 */
	private static function switch_in_section_field_option( &$field_data ) {
		if ( in_array( $field_data['type'], array( 'divider', 'end_divider', 'form' ), true ) ) {
			return;
		}

		$ajax_action = FrmAppHelper::get_post_param( 'action', '', 'sanitize_title' );
		if ( 'frm_insert_field' === $ajax_action ) {
			$section_id = FrmAppHelper::get_post_param( 'section_id', 0, 'absint' );
			$field_data['field_options']['in_section'] = $section_id;
		}
	}

	/**
	 * @since 3.0
	 *
	 * @param array $settings
	 * @return array
	 */
	public static function skip_update_field_setting( $settings ) {
		unset( $settings['post_field'], $settings['custom_field'] );
		unset( $settings['taxonomy'], $settings['exclude_cat'] );
		return $settings;
	}

	/**
	 * @param array    $field_options
	 * @param stdClass $field
	 * @param array    $values
	 * @return array
	 */
	public static function update( $field_options, $field, $values ) {
		foreach ( $field_options['hide_field'] as $i => $f ) {
			if ( empty( $f ) ) {
				unset( $field_options['hide_field'][ $i ], $field_options['hide_field_cond'][ $i ] );
				if ( isset( $field_options['hide_opt'] ) && is_array( $field_options['hide_opt'] ) ) {
					unset( $field_options['hide_opt'][ $i ] );
				}
			}
			unset( $i, $f );
		}

		if ( $field->type === 'hidden' && ! empty( $field_options['required'] ) ) {
			$field_options['required'] = false;
		} elseif ( $field->type === 'file' ) {
			self::format_mime_types( $field_options, $field->id );
		}

		$field_options['custom_currency'] = ! empty( $field_options['custom_currency'] ) ? 1 : 0;
		if ( isset( $field_options['custom_decimals'] ) ) {
			$field_options['custom_decimals'] = absint( $field_options['custom_decimals'] );
		}

		$field_options = self::sanitize_custom_thousand_separator( $field_options );

		return $field_options;
	}

	private static function format_mime_types( &$options, $field_id ) {
		$file_options = isset( $options['ftypes'] ) ? $options['ftypes'] : array();
		if ( ! empty( $file_options ) ) {
			$mime_array = array();

			foreach ( $file_options as $file_option ) {
				$values = explode( '|||', $file_option );
				$mime_array[ $values[0] ] = $values[1];
			}
			$options['ftypes'] = $mime_array;
			$_POST['field_options'][ 'ftypes_' . $field_id ] = $mime_array;
		}
	}

	/**
	 * Sanitize the custom thousand separator as sanitizing has been disabled for this option.
	 * This is a special edge case because we do not want to trim the thousand separator.
	 *
	 * @since 5.5.6
	 *
	 * @param array $field_options
	 * @return array
	 */
	private static function sanitize_custom_thousand_separator( $field_options ) {
		if ( ! empty( $field_options['custom_thousand_separator'] ) ) {
			$field_options['custom_thousand_separator'] = strip_tags( $field_options['custom_thousand_separator'] );
		}
		return $field_options;
	}

	/**
	 * @param array $values
	 * @param array $atts {
	 *     @type bool $after True on the second run.
	 * }
	 * @return array
	 */
	public static function duplicate( $values, $atts = array() ) {
		global $frm_duplicate_ids;

		$is_second_run = isset( $atts['after'] ) ? $atts['after'] : false;

		if ( empty( $frm_duplicate_ids ) || empty( $values['field_options'] ) ) {
			if ( ! $is_second_run ) {
				self::mark_field_key_as_unprocessed( $values['field_key'] );
			}
			return $values;
		}

		// switch out fields from calculation or default values
		$switch_string = array( 'default_value', 'calc' );
		foreach ( $switch_string as $opt ) {
			if ( empty( $values['field_options'][ $opt ] ) && empty( $values[ $opt ] ) ) {
				continue;
			}

			$this_val = isset( $values[ $opt ] ) ? $values[ $opt ] : $values['field_options'][ $opt ];
			if ( is_array( $this_val ) ) {
				continue;
			}

			$ids = FrmProFieldsHelper::filter_keys_for_regex( $this_val, array_keys( $frm_duplicate_ids ) );
			if ( ! $ids ) {
				continue;
			}

			$ids = implode( '|', $ids );

			preg_match_all( '/\[(' . $ids . ')\]/s', $this_val, $matches, PREG_PATTERN_ORDER );
			unset( $ids );

			if ( ! isset( $matches[1] ) ) {
				unset( $matches );
				continue;
			}

			foreach ( $matches[1] as $val ) {
				if ( $is_second_run && in_array( $val, $frm_duplicate_ids ) ) {
					// The field id may have already been replaced.
					continue;
				}

				$this_val = str_replace( '[' . $val . ']', '[' . $frm_duplicate_ids[ $val ] . ']', $this_val );

				if ( isset( $values[ $opt ] ) ) {
					$values[ $opt ] = $this_val;
				} else {
					$values['field_options'][ $opt ] = $this_val;
				}
				unset( $val );
			}

			unset( $this_val, $matches );
		}

		// switch out field ids in conditional logic
		if ( ! empty( $values['field_options']['hide_field'] ) ) {
			foreach ( array( 'hide_field_cond', 'hide_opt', 'hide_field' ) as $logic ) {
				if ( isset( $values['field_options'][ $logic ] ) ) {
					FrmProAppHelper::unserialize_or_decode( $values['field_options'][ $logic ] );
				} else {
					$values['field_options'][ $logic ] = array();
				}
			}

			$processed = false;
			foreach ( $values['field_options']['hide_field'] as $k => $f ) {
				if ( $is_second_run && in_array( $f, $frm_duplicate_ids ) ) {
					// The field id may have already been replaced.
					continue;
				}

				if ( isset( $frm_duplicate_ids[ $f ] ) ) {
					$processed                                   = true;
					$values['field_options']['hide_field'][ $k ] = $frm_duplicate_ids[ $f ];
				}
				unset( $k, $f );
			}

			if ( ! $processed && ! $is_second_run ) {
				self::mark_field_key_as_unprocessed( $values['field_key'] );
			}

			unset( $processed );
		}

		self::switch_out_form_select( $frm_duplicate_ids, $values );
		self::switch_id_for_section_tracking_field_option( $frm_duplicate_ids, $values );
		self::switch_ids_for_lookup_settings( $frm_duplicate_ids, $values );

		return $values;
	}

	/**
	 * Track the field keys that have not yet had replaced their conditional logic to replace after duplicate as they rely on a different field order.
	 *
	 * @param string $field_key
	 */
	private static function mark_field_key_as_unprocessed( $field_key ) {
		global $frm_unprocessed_duplicate_field_keys;
		if ( ! is_array( $frm_unprocessed_duplicate_field_keys ) ) {
			$frm_unprocessed_duplicate_field_keys = array();
		}
		$frm_unprocessed_duplicate_field_keys[] = $field_key;
	}

	/**
	 * Switch out field ids if selected in a Dynamic Field
	 *
	 * @since 2.0.25
	 * @param array $frm_duplicate_ids
	 * @param array $values
	 */
	private static function switch_out_form_select( $frm_duplicate_ids, &$values ) {
		if ( 'data' == $values['type'] && FrmField::is_option_true_in_array( $values['field_options'], 'form_select' ) ) {
			self::maybe_switch_field_id_in_setting( $frm_duplicate_ids, 'form_select', $values['field_options'] );
		}
	}

	/**
	 * Switch the in_section ID when a field is duplicated
	 *
	 * @since 2.0.25
	 * @param array $frm_duplicate_ids
	 * @param array $values
	 */
	private static function switch_id_for_section_tracking_field_option( $frm_duplicate_ids, &$values ) {
		if ( isset( $values['field_options']['in_section'] ) ) {
			self::maybe_switch_field_id_in_setting( $frm_duplicate_ids, 'in_section', $values['field_options'] );
		} else {
			$values['field_options']['in_section'] = 0;
		}
	}

	/**
	 * Switch the get_values_form, get_values_field, and watch_lookup IDs when a field is imported
	 *
	 * @since 2.01.0
	 * @param array $frm_duplicate_ids
	 * @param array $values
	 */
	private static function switch_ids_for_lookup_settings( $frm_duplicate_ids, &$values ) {
		if ( FrmField::is_option_true_in_array( $values['field_options'], 'get_values_field' ) ) {
			self::maybe_switch_field_id_in_setting( $frm_duplicate_ids, 'get_values_field', $values['field_options'] );
			self::maybe_switch_field_id_in_setting( $frm_duplicate_ids, 'watch_lookup', $values['field_options'] );
		}
	}

	/**
	 * Switch the field ID for a given setting if a new field ID exists
	 *
	 * @since 2.01.0
	 * @param array $frm_duplicate_ids
	 * @param string $setting
	 * @param array $field_options
	 */
	private static function maybe_switch_field_id_in_setting( $frm_duplicate_ids, $setting, &$field_options ) {
		$old_field_id = isset( $field_options[ $setting ] ) ? $field_options[ $setting ] : 0;

		if ( ! $old_field_id ) {
			return;
		}

		if ( is_array( $old_field_id ) ) {
			$field_options[ $setting ] = array();

			foreach ( $old_field_id as $old_id ) {
				if ( isset( $frm_duplicate_ids[ $old_id ] ) ) {
					$field_options[ $setting ][] = $frm_duplicate_ids[ $old_id ];
				} else {
					$field_options[ $setting ][] = $old_id;
				}
			}
		} else if ( isset( $frm_duplicate_ids[ $old_field_id ] ) ) {
			$field_options[ $setting ] = $frm_duplicate_ids[ $old_field_id ];
		}
	}

	public static function delete( $id ) {
		$field = FrmField::getOne( $id );
		if ( empty( $field ) ) {
			return;
		}

		// delete the form this repeating field created
		self::delete_repeat_field( $field );

		//TODO: before delete do something with entries with data field meta_value = field_id
	}

	public static function delete_repeat_field( $field ) {
		if ( ! FrmField::is_repeating_field( $field ) ) {
			return;
		}

		if ( isset( $field->field_options['form_select'] ) && is_numeric( $field->field_options['form_select'] ) && $field->field_options['form_select'] != $field->form_id ) {
			FrmForm::destroy( $field->field_options['form_select'] );
		}
	}

	/**
	 * @param stdClass $field
	 * @return bool
	 */
	public static function is_list_field( $field ) {
		return $field->type === 'data' && ( ! isset( $field->field_options['data_type'] ) || $field->field_options['data_type'] === 'data' || $field->field_options['data_type'] == '' );
	}

	/**
	* Create the form for a repeating section
	*
	* @since 2.0.12
	*
	* @param int $form_id
	* @param array $atts
	* @return int $form_id
	*/
	public static function create_repeat_form( $form_id, $atts ) {
		$form_values = array(
			'parent_form_id' => $atts['parent_form_id'],
			'name' => $atts['field_name'],
			'status' => 'published',
		);
		$form_values = FrmFormsHelper::setup_new_vars( $form_values );

		$form_id = (int) FrmForm::create( $form_values );

		return $form_id;
	}

	/**
	* Return all the field IDs for the fields inside of a section (not necessarily repeating) or an embedded form
	*
	* @since 2.0.13
	* @param array $field
	* @return array $children
	*/
	public static function get_children( $field ) {
		if ( FrmField::is_repeating_field( $field ) || $field['type'] == 'form' ) {
			// If repeating field or embedded form

			$repeat_id = isset( $field['form_select'] ) ? $field['form_select'] : $field['field_options']['form_select'];
			$children = FrmDb::get_col( 'frm_fields', array( 'form_id' => $repeat_id ) );

		} else {
			// If regular section

			$children = self::get_children_from_standard_section( $field );
		}

		return $children;
	}

	/**
	 * Get the field IDs within a regular section
	 *
	 * @since 2.0.25
	 * @param array $field
	 * @return array|null
	 */
	private static function get_children_from_standard_section( $field ) {
		$child_where = array( 'form_id' => $field['form_id'] );

		// Get minimum field order for children
		$min_field_order = $field['field_order'] + 1;
		$child_where['field_order>'] = $min_field_order;

		// Get maximum field order for children
		$where = array( 'form_id' => $field['form_id'], 'type' => array( 'end_divider', 'divider', 'break' ), 'field_order>' => $min_field_order );
		$end_divider_order = FrmDb::get_var( 'frm_fields', $where, 'field_order', array( 'order_by' => 'field_order ASC' ), 1 );
		if ( $end_divider_order ) {
			$max_field_order = $end_divider_order - 1;
			$child_where['field_order<'] = $max_field_order;
		}

		return FrmDb::get_col( 'frm_fields', $child_where );
	}

	/**
	* Get the entry ID from a linked field
	*
	* @since 2.0.15
	* @param int $linked_field_id
	* @param string $where_val
	* @param string $where_is
	* @return int $linked_id
	*/
	public static function get_dynamic_field_entry_id( $linked_field_id, $where_val, $where_is ) {
		$query = array(
			'field_id' => $linked_field_id,
			'meta_value' . FrmDb::append_where_is( $where_is ) => $where_val,
		);
		$linked_id = FrmDb::get_col( 'frm_item_metas', $query, 'item_id' );
		return $linked_id;
	}

	/**
	* Get the category ID from the category name
	*
	* @since 2.0.15
	* @param string $cat_name
	* @return int
	*/
	public static function get_cat_id_from_text( $cat_name ) {
		return get_cat_ID( $cat_name );
	}


	/**
	 * Check if the format option isset and true without a regular expression
	 *
	 * @since 2.02.06
	 * @param array|object $field
	 * @return bool
	 */
	public static function is_format_option_true_with_no_regex( $field ) {
		$has_non_regex_format = false;

		if ( is_array( $field ) ) {
			$has_non_regex_format = FrmField::is_option_true_in_array( $field, 'format' ) && strpos( $field['format'], '^' ) !== 0;
		} else {
			FrmField::is_option_true_in_object( $field, 'format' ) && strpos( $field->field_options['format'], '^' ) !== 0;
		}

		return $has_non_regex_format;
	}

	/**
	 * Get a list of field types that cannot be used in calculations.
	 *
	 * @since 4.0
	 * @return array
	 */
	public static function exclude_from_calcs() {
		$exclude = FrmField::no_save_fields();
		$exclude[] = 'toggle';
		$exclude[] = 'data|select';
		$exclude[] = 'data|radio';
		$exclude[] = 'data|checkbox';
		return $exclude;
	}
}
