<?php

if ( ! defined( 'ABSPATH' ) ) {
	die( 'You are not allowed to call this page directly.' );
}

/**
 * Contains helper function definitions used for Calendar View.
 *
 * @since 5.5.1
 */
class FrmViewsCalendarHelper {

	/**
	 * Returns true if the WordPress version is above or equal to 6.2.
	 * If this is unavailable, the year range will fall back to the +/- 5
	 * years range for calendar date range dropdown.
	 *
	 * @since 5.5.1
	 * @return bool
	 */
	public static function wp_version_supports_table_column_placeholders() {
		return version_compare( get_bloginfo( 'version' ), '6.2', '>=' );
	}

	/**
	 * Returns an array that has start and end years.
	 *
	 * @since 5.5.1
	 *
	 * @param array $event_dates        Event date fields.
	 * @param array $field_mapped_dates An array that contains event dates mapped to date fields.
	 * @param int   $year
	 * @param int   $form_id
	 * @return array
	 */
	public static function get_year_range_for_date_field( $event_dates, $field_mapped_dates, $year, $form_id ) {
		$start_year = '';
		$end_year   = '';
		$metas      = FrmDb::get_results( 'frm_item_metas', array( 'field_id' => $field_mapped_dates ), 'field_id,meta_value' );

		self::set_year_range_component( 'start_date', $start_year, $metas, $field_mapped_dates );
		self::set_year_range_component( 'end_date', $end_year, $metas, $field_mapped_dates );

		$create_or_updated_at_date = array_diff( $event_dates, $field_mapped_dates );
		if ( $create_or_updated_at_date ) { // if any of the event start or end dates is not mapped to a date field.
			self::maybe_update_years_using_entry_dates( $start_year, $end_year, $create_or_updated_at_date, $form_id );
		}

		if ( ! $start_year && $end_year ) {
			$start_year = $end_year; // If start year is not found from either of field/entry metas, fall back to end year.
		}

		if ( ! $end_year && $start_year ) {
			$end_year = $start_year; // If end year is not found from either of field/entry metas, fall back to start year.
		}

		return array(
			'start' => $start_year ? min( $start_year, $year ) : $year, // We need to make sure we always include the current year.
			'end'   => $end_year ? max( $end_year, $year ) : $year,
		);
	}

	/**
	 * Calculates the start/end years from item metas and set the value to $year_component.
	 *
	 * @since 5.5.1
	 * @param string $date               Either 'start_date' or 'end_date'.
	 * @param string $year_component     The variable to whom the calculated year is assigned to, passed by reference.
	 * @param array  $metas              Entry values for the date fields mapped to event date or event end date.
	 * @param array  $field_mapped_dates An array that contains event dates mapped to date fields.
	 * @return void
	 */
	private static function set_year_range_component( $date, &$year_component, $metas, $field_mapped_dates ) {
		$field_mapped_dates = array_map( 'intval', $field_mapped_dates );
		$component_metas    = array_filter(
			$metas,
			function ( $meta ) use ( $field_mapped_dates ) {
				return in_array( (int) $meta->field_id, $field_mapped_dates, true );
			}
		);

		if ( ! $component_metas ) {
			return;
		}

		$component_date_values = array_column( $component_metas, 'meta_value' );
		$component_timestamps  = array_map( 'strtotime', $component_date_values );

		if ( $component_timestamps ) {
			$year_component = 'start_date' === $date ? gmdate( 'Y', min( $component_timestamps ) ) : gmdate( 'Y', max( $component_timestamps ) );
		}
	}

	/**
	 * Checks Form entries created_at or updated_at years and use it to update the year range if needed.
	 *
	 * @since 5.5.1
	 *
	 * @param string $start_year
	 * @param string $end_year
	 * @param array  $create_or_updated_at_date An array that has at most one element with the value of either created_at/updated_at.
	 * @param int    $form_id
	 * @return void
	 */
	private static function maybe_update_years_using_entry_dates( &$start_year, &$end_year, $create_or_updated_at_date, $form_id ) {
		global $wpdb;

		$min_max = isset( $create_or_updated_at_date['start_date'] ) ? 'MIN' : 'MAX';
		$date    = reset( $create_or_updated_at_date );

		if ( 'MIN' === $min_max ) {
			$query = $wpdb->prepare( "SELECT YEAR(MIN(%i)) FROM {$wpdb->prefix}frm_items WHERE form_id=%d", $date, $form_id ); // phpcs:ignore WordPress.DB.PreparedSQLPlaceholders.UnsupportedIdentifierPlaceholder
		} else {
			$query = $wpdb->prepare( "SELECT YEAR(MAX(%i)) FROM {$wpdb->prefix}frm_items WHERE form_id=%d", $date, $form_id ); // phpcs:ignore WordPress.DB.PreparedSQLPlaceholders.UnsupportedIdentifierPlaceholder
		}

		$cache_key  = $date . '_year_for_form_' . $form_id;
		$entry_year = FrmDb::check_cache( $cache_key, 'frm_items', $query, 'get_var' );

		if ( 'MIN' === $min_max ) {
			$start_year = $start_year ? min( $start_year, $entry_year ) : $entry_year;
		} else {
			$end_year = $end_year ? max( $end_year, $entry_year ) : $entry_year;
		}
	}

	/**
	 * Returns min and max years from entries created_at dates.
	 *
	 * @since 5.5.1
	 * @param object $view
	 * @return object|null
	 */
	public static function get_range_from_db( $view ) {
		global $wpdb;

		$cache_key = 'year_range_for_form_created_at_' . $view->frm_form_id;
		$query     = $wpdb->prepare(
			"SELECT YEAR(MIN(%i)) as min_year, YEAR(MAX(%i)) as max_year FROM {$wpdb->prefix}frm_items WHERE form_id=%d", // phpcs:ignore WordPress.DB.PreparedSQLPlaceholders.UnsupportedIdentifierPlaceholder
			$view->frm_date_field_id ? $view->frm_date_field_id : 'created_at',
			$view->frm_edate_field_id ? $view->frm_edate_field_id : 'created_at',
			$view->frm_form_id
		);

		return FrmDb::check_cache( $cache_key, 'frm_items', $query, 'get_row' );
	}
}
