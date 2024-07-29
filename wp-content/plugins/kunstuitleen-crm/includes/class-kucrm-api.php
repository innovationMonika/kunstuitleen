<?php
class kucrm_api{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

     
		
	}

   /* api */
    public function kucrm_prediction_api($action, $method='GET', $api_data=array(), $headers=array()){
        $headers[] = '';
        $output = $response = '';
        //$build_query = build_query($api_data);
        /* api data pass params */
        $url = 'https://api.vedicastroapi.com/json/prediction/'.$action;
        $prepare_api_data = array();
        //$methods = array('POST', 'GET');
        $prepare_api_data = array(
                    'timeout'     => 45,
                    'redirection' => 5,
                    'httpversion' => '1.0',
                    'blocking'    => true,
                    'headers'     => $headers,
                    'body'        => $api_data,               
                    );
        
        if( $methods == 'GET' ) {
            $output = wp_remote_get($url, $prepare_api_data);
        } 
        elseif( $methods == 'POST' ) {
            $output = wp_remote_post($url, $prepare_api_data);
        }else{
            return array(
                        'code' => 201,
                        'body' => 'No method found.'
                         );
        }
       
        $response = array(
                    'code' => wp_remote_retrieve_response_code($output),
                    'body' => json_decode( wp_remote_retrieve_body($output), true )
                    );
        return $response;
    }
       

}
?>