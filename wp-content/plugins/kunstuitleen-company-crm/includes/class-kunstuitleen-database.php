<?php
/**
 * Kunstuitleen Database 
 */
class Kunstuitleen_Database{

	/**
	 *  Kunstuitleen select
	 */
	public function kunstuitleen_select_where_id( $table_name, $user_id ){
		global $wpdb;
		$output = $table = '';
		if( !empty( $table_name ) && !empty( $user_id ) ) :
			$table = $wpdb->prefix . $table_name;
			$userid = "company_owner_id='$user_id'";
			$output = $wpdb->get_row( "SELECT * FROM " . $table . " WHERE " . $userid . "", ARRAY_A );
		endif;
		return $output;
	}

	/**
	 *  Kunstuitleen insert
	 */
	public function kunstuitleen_insert( $table_name, $column, $format = '' ){
		global $wpdb;
		$output = $table = '';
		$table = $wpdb->prefix . $table_name;
		if( !empty( $table ) && !empty( $column ) ) :
			$output = $wpdb->insert( $table, $column, $format );
		endif;
		//$output = $wpdb->insert_id;
		return $output;
	}

	/**
	 *  Kunstuitleen insert
	 */
	public function kunstuitleen_update( $table_name, $column, $where, $format = '', $where_format = '' ){
		global $wpdb;
		$output = $table = '';
		$table = $wpdb->prefix . $table_name;
		if( !empty( $table ) && !empty( $column ) && !empty( $where ) ) :
			$output = $wpdb->update( $table, $column, $where, $format, $where_format );
		endif;
		return $output;
	}
}
?>