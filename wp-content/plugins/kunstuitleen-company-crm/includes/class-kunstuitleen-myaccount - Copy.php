<?php
/**
 * class kunstuitleen  
 */
class Kunstuitleen_My_Account{
    
    /**
     * Constructor  
     */
    public function __construct(){
    	add_action( 'init', array( $this, 'kunstuitleen_endpoint' ) );
    	//add_action( 'template_redirect', array( $this, 'kunstuitleen_template_redirect' ) );
    	add_shortcode( 'kunstuitleen-my-account', array( $this, 'kunstuitleen_my_account' ) );
    }

    /**
     * Kunstuitleen endpoint
     */
    public function kunstuitleen_endpoint(){    	
        add_rewrite_endpoint( 'account-overview', EP_PERMALINK | EP_PAGES );
        add_rewrite_endpoint( 'my-artworks', EP_PERMALINK | EP_PAGES );
        add_rewrite_endpoint( 'my-credits', EP_PERMALINK | EP_PAGES );
        add_rewrite_endpoint( 'my-purchase-invoicecs', EP_PERMALINK | EP_PAGES );
        add_rewrite_endpoint( 'my-rental-invoices', EP_PERMALINK | EP_PAGES );
        add_rewrite_endpoint( 'my-details', EP_PERMALINK | EP_PAGES );
    }

    /**
     * Kunstuitleen end point
     */
    //public function kunstuitleen_template_redirect(){  
        //$output = '';
       // $output .= do_shortcode('[kunstuitleen-my-account]');
      //  return $output;
    //}
    
    /**
     * Kunstuitleen get queryvar
     */
    public function kunstuitleen_get_query_vars(){
        global $wp_query; 
        $output = $menu_key = $get_query_vars = '';
        $menu = array_keys( $this->kunstuitleen_menu_link() );
        $get_query_vars_key = array_keys( $wp_query->query_vars );
        if( !empty( $menu ) ) :
            foreach( $menu as $menu_key => $menu_val) :
                if( in_array( $menu_val, $get_query_vars_key ) || ! is_singular() ) :
                    $output =  $menu_val;     
                endif;
            endforeach;
        endif;
        return $output;
    }

    /**
     * Kunstuitleen my account
     */
    public function kunstuitleen_my_account(){            
    	$output = $menu = $kunstuitleen_get_query_vars = $title = '';
        if( is_user_logged_in() ) :
            $menu = $this->kunstuitleen_menu_link();
            $kunstuitleen_get_query_vars = $this->kunstuitleen_get_query_vars();
            if( !empty( $kunstuitleen_get_query_vars ) ) :
                $title = $menu[$kunstuitleen_get_query_vars];
            else :
                $title = $menu['account-overview'];
            endif;
        	$output .= '<main class="flex-shrink-0">
    			        <div class="container mb-30px">';
                            if( !empty( $title ) ) :
    			                $output .= '<div class="row text-center">
    			                                <label class="h2 mr-jonas title"><strong>' . esc_html( $title ) . '</strong></label>
    			                            </div>';
                            endif;
    			 $output .= '<div class="row" style="margin-top: 40px;">
    			                <div class="col-md-12">';
    			                	$output .= $this->kunstuitleen_menu_wrapper();                                
    			                	$output .= $this->kunstuitleen_content_wrapper();                               
    			    $output .= '</div>
    			            </div>
    			        </div>
    			       </main>';
        endif;
    	return $output;
    }
	/**
	 * Kunstuitleen menu link
	 */
    public function kunstuitleen_menu_link(){
    	$output = '';
    	$output = array(
    			  'account-overview'      => esc_html__( 'Accountoverzicht', ''),
    			  'my-artworks'           => esc_html__( 'Mijn kunstwerken', ''),
    			  'my-credits'            => esc_html__( 'Mijn tegoeden', ''),
    			  'my-purchase-invoicecs' => esc_html__( 'Mijn aankoopfacturen', ''),
    			  'my-rental-invoices'    => esc_html__( 'Mijn huurfacturen', ''),
    			  'my-details'            => esc_html__( 'Mijn gegevens', ''),
    			  'log-out'               => esc_html__( 'Uitloggen', ''),
    	          );
    	return $output;
    }

    /**
     * Kunstuitleen menu wrapper
     */
    public function kunstuitleen_menu_wrapper(){
    	$output = '';
    	$output .= '<div class="col-md-3" style="padding-right: 30px;">
                        <div class="row">
                            <div class="col-md-12">';
                            	$output .= $this->kunstuitleen_menu();
                 $output .= '</div>
                        </div>
                    </div>';
    	return $output;
    }    

    /**
	 * Kunstuitleen menu 
	 */
    public function kunstuitleen_menu(){
    	$output = $menu = $kunstuitleen_get_query_vars = $menu_class = '';
    	$menu = $this->kunstuitleen_menu_link();
        $kunstuitleen_get_query_vars = $this->kunstuitleen_get_query_vars();
    	if( !empty( $menu ) ) :
    		$output .= '<ul>';
    		foreach( $menu as $menu_link => $menu_name ) :
    			switch( $menu_link ) :	    			
	    			case 'log-out':
	    				$output .= '<li>
		                				<a href="' . esc_url( wp_logout_url( home_url() ) ) . '" class="btn">
		                					<label class="h5 mr-jonas"><strong>' . esc_html( $menu_name ) . '</strong></label>
		                				</a>
		                			</li>';
	    			break;
	    			default :
                        if( $menu_link == $kunstuitleen_get_query_vars ) :
                            $menu_class = 'class=active';
                        else :
                            $menu_class = '';
                        endif;
		                $output .= '<li ' . esc_attr( $menu_class ). '>
		                				<a href="' . esc_url( home_url('/kunstuitleen-my-account/' . $menu_link ) ) . '" class="btn">
		                					<label class="h5 mr-jonas"><strong>' . esc_html( $menu_name ) . '</strong></label>
		                				</a>
		                			</li>';
	            endswitch;
        	endforeach;
        	$output .= '</ul>';
        endif;
    	return $output;
    }

    /**
     * Kunstuitleen content wrapper
     */
    public function kunstuitleen_content_wrapper(){        
    	$output = $kunstuitleen_get_query_vars = '';     
        $kunstuitleen_get_query_vars = $this->kunstuitleen_get_query_vars();  
        $output .= '<div class="col-md-9 main">';
            switch( $kunstuitleen_get_query_vars ) :
                case 'account-overview':
                    $output .= $this->kunstuitleen_account_overview();
                break;
                case 'my-artworks':
                    $output .= $this->kunstuitleen_account_my_artworks();
                break;
                case 'my-credits':
                    $output .= $this->kunstuitleen_account_my_credits();
                break;
                case 'my-purchase-invoicecs':
                    $output .= $this->kunstuitleen_account_my_purchase_invoicecs();
                break;
                case 'my-rental-invoices':
                    $output .= $this->kunstuitleen_account_my_rental_invoices();
                break;
                case 'my-details':
                    $output .= $this->kunstuitleen_account_my_details();
                break;
                default:
                    $output .= $this->kunstuitleen_account_overview();
            endswitch;        
        $output .= '</div>';
    	return $output;
    }

    /**
     * Kunstuitleen account overview
     */
    public function kunstuitleen_account_overview(){
    	$output = '';
    	$output = '<div class="row">
                        <label class="h4 mr-jonas"><strong>Mijn huidige kunstwerken</strong></label>
                    </div>
                    <div class="row current-artworks-headings">
                        <label class="h4 mr-jonas per-month"><strong>Total per maand € 00,00</strong></label>
                    </div>
                    <div class="row content d-lg-flex my-details">
                        <div class="col-md-4 img-view">
                            <div class="row">
                                <img class="img-responsive" src="images/large46121.jpg">
                            </div>
                        </div>
                        <div class="col-md-4 border">
                            <div class="row m0">
                                <label class="h4 mr-jonas"><strong>Status: Momenteel gehuurd</strong></label>
                            </div>
                            <div class="row m0">
                                <label class="h4 mr-jonas"><strong>Kees Smit</strong></label>
                            </div>
                            <div class="row m0">
                                <label class="h4 mr-jonas"><strong>Etage 1-Kamer 2-Rechterwand</strong></label>
                            </div>
                            <div class="row m0">
                                <label class="h4 mr-jonas"><strong>€ 00,00 per maand</strong></label>
                            </div>
                            <div class="row m0">
                                <p class="h5 mr-jonas"><i class="fa fa-info-circle"></i> &nbsp; € 00,00 per maand</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row m0">
                                <div class="col-md-7">
                                    <div class="row button">
                                        <button type="button" class="btn btn-default">Bekijk kunstwerk<i class="fa fa-angle-right"></i></button>
                                    </div>
                                    <div class="row button">
                                        <button type="button" class="btn btn-default">Kunst omruilen<i class="fa fa-refresh"></i></button>
                                    </div>
                                    <div class="row button">
                                        <button type="button" class="btn btn-default">Contact opnemen <i class="fa fa-angle-right"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row current-artworks">
                        <div class="col-md-5 view-artworks-btn">
                            <button type="button" class="btn btn-default h5"><strong>Bekijk mijn huidige kunstwerken</strong><i class="fa fa-angle-right"></i></button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9">
                            <label class="h3 mr-jonas"><strong>Mijn tegoeden</strong></label>
                        </div>
                        <div class="col-md-6 voucher-col">
                            <div class="row gift-cards">
                                <div class="col-md-12 inline-block">
                                    <div class="row flex">
                                        <div class="col-md-8">
                                            <div class="row">
                                                <p class="col-md-12 mr-jonas h4"><strong>Totaal aan cadeaubonnen</strong></p>
                                                <p class="col-md-12 mr-jonas h4"><strong>€ 100,00</strong></p>
                                                <p class="col-md-12 mr-jonas expire-date">Bijna aflopende bon:XXXX</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row voucher">
                                                <img src="images/6121218.png" class="img-responsive">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row"  id="label">
                                                <buttom class="btn btn-default btn-block text-center h5">
                                                    <strong class="mr-jonas">Bekijk al mijn cadeaubonnen</strong>
                                                </buttom>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row payment-overview">
                        <div class="col-md-9 payment-overview-heading">
                            <label class="h4 mr-jonas"><strong>Betalingsoverzicht aankopen</strong></label>
                        </div>
                        <div class="col-md-12 table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th scope="col" class="mr-jonas">Download factuur</th>
                                        <th scope="col" class="mr-jonas">Datum</th>
                                        <th scope="col" class="mr-jonas">Bedrag</th>
                                        <th scope="col" class="mr-jonas">Vervaldatum</th>
                                        <th scope="col" class="mr-jonas">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row" class="mr-jonas"><a href="#"><img class="img-responsive pdf" src="images/icons8-pdf-64.png">0000</a></th>
                                        <td class="mr-jonas"><strong>01-06-2020</strong></td>
                                        <td class="mr-jonas"><strong>€ 00,00</strong></td>
                                        <td class="mr-jonas"><strong>15-06-2020</strong></td>
                                        <td class="mr-jonas"><strong><i class="fa fa-check"></i>Betaald</strong></td>
                                        <td class="mr-jonas"><strong>Details<i class="fa fa-sign-in"></i></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- <div class="col-md-9">
                            <label class="h4 mr-jonas"><strong>Er zijn geen aankoopfacturen</strong></label>
                        </div> -->
                        <div class="col-md-6">
                            <button type="button" class="btn btn-default"><strong class="mr-jonas">Bekijk alle betalingen en aankoopfacturen</strong><i class="fa fa-angle-right"></i></button>
                        </div>
                    </div>
                    <div class="row rent-overview">
                        <div class="col-md-9">
                            <label class="h4 mr-jonas"><strong>Betalingsoverzicht huren</strong></label>
                        </div>
                        <div class="col-md-12 table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th scope="col" class="mr-jonas">Download factuur</th>
                                        <th scope="col" class="mr-jonas">Datum</th>
                                        <th scope="col" class="mr-jonas">Bedrag</th>
                                        <th scope="col" class="mr-jonas">Vervaldatum</th>
                                        <th scope="col" class="mr-jonas">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row" class="mr-jonas"><a href="#"><img class="img-responsive pdf" src="images/icons8-pdf-64.png">0000</a></th>
                                        <td class="mr-jonas"><strong>01-06-2020</strong></td>
                                        <td class="mr-jonas"><strong>€ 00,00</strong></td>
                                        <td class="mr-jonas"><strong>01-07-2020</strong></td>
                                        <td class="mr-jonas"><strong><i class="fa fa-check"></i>Geincasseerd</strong></td>
                                        <td class="mr-jonas"><strong>Details<i class="fa fa-sign-in"></i></strong></td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="mr-jonas"><a href="#"><img class="img-responsive pdf" src="images/icons8-pdf-64.png">0000</a></th>
                                        <td class="mr-jonas"><strong>01-06-2020</strong></td>
                                        <td class="mr-jonas"><strong>€ 00,00</strong></td>
                                        <td class="mr-jonas"><strong>01-07-2020</strong></td>
                                        <td class="mr-jonas"><strong><i class="fa fa-check"></i>Geincasseerd</strong></td>
                                        <td class="mr-jonas"><strong>Details<i class="fa fa-sign-in"></i></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-default"><strong class="mr-jonas">Bekijk alle betalingen en huurfacturen</strong><i class="fa fa-angle-right"></i></button>
                        </div>
                    </div>';
    	return $output;
    }

    /**
     * Kunstuitleen account my artwork
     */
    public function kunstuitleen_account_my_artworks(){
        $output = '';
        $output .= '<div class="row flex">
                        <div class="col-md-9">
                            <input type="text" class="form-control search" placeholder="&#xF002;  Zoek naar eerder geselecteerde kunst...">
                        </div>
                        <div class="col-md-3 align-self-center">
                            <button class="btn btn-default search-btn">Kies niew kunst<i class="fa fa-angle-right"></i></button>
                        </div>
                    </div>
                    <div class="row art-block">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-7">
                                        <div class="row">
                                            <label class="h4 mr-jonas"><strong>Mijn huidige kunstwerken</strong></label>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-3 text-right share-btn">
                                        <button class="btn btn-default" data-toggle="modal" data-target="#share-collegue"><i class="fa fa-share-alt"></i><label class="mr-jonas h4"><strong>Deel met collegas</strong></label></button>
                                    </div>
                                    <div class="col-md-2 delete-share">
                                        <button class="btn btn-default" data-toggle="modal" data-target="#delete-share"> <i class="fa fa-trash"></i></button>
                                    </div> -->
                                </div>
                            </div>
                            <div class="row current-artworks-headings">
                                <label class="h4 mr-jonas col-md-12 per-month"><strong>Total per maand € 00,00</strong></label>
                            </div>
                            <div class="row content d-lg-flex">
                                <div class="col-md-4 img-view">
                                    <div class="row">
                                        <img class="img-responsive" src="images/large46121.jpg">
                                    </div>
                                </div>
                                <div class="col-md-4 border">
                                    <div class="row m0">
                                        <label class="h4 mr-jonas"><strong>Status: Momenteel gehuurd</strong></label>
                                    </div>
                                    <div class="row m0">
                                        <label class="h4 mr-jonas"><strong>Kees Smit</strong></label>
                                    </div>
                                    <div class="row m0">
                                        <label class="h4 mr-jonas"><strong>Etage 1-Kamer 2-Rechterwand</strong></label>
                                    </div>
                                    <div class="row m0">
                                        <label class="h4 mr-jonas"><strong>€ 00,00 per maand</strong></label>
                                    </div>
                                    <div class="row m0">
                                        <p class="h5 mr-jonas"><i class="fa fa-info-circle"></i> Omruil mogelijk op 01-12-2020</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row m0">
                                        <div class="col-md-7">
                                            <div class="row button">
                                                <button type="button" class="btn btn-default">Bekijk kunstwerk<i class="fa fa-angle-right"></i></button>
                                            </div>
                                            <div class="row button">
                                                <button type="button" class="btn btn-default">Kunst omruilen<i class="fa fa-refresh"></i></button>
                                            </div>
                                            <div class="row button">
                                                <button type="button" class="btn btn-default">Contact opnemen <i class="fa fa-angle-right"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row content d-lg-flex">
                                <div class="col-md-4 img-view">
                                    <div class="row">
                                        <img class="img-responsive" src="images/large60427.jpg">
                                    </div>
                                </div>
                                <div class="col-md-4 border">
                                    <div class="row m0">
                                        <label class="h4 mr-jonas"><strong>Status: Momenteel gehuurd</strong></label>
                                    </div>
                                    <div class="row m0">
                                        <label class="h4 mr-jonas"><strong>Kees Smit</strong></label>
                                    </div>
                                    <div class="row m0">
                                        <label class="h4 mr-jonas"><strong>Etage 1-Kamer 2-Linkerwand -Hoog ophangen</strong></label>
                                    </div>
                                    <div class="row m0">
                                        <label class="h4 mr-jonas"><strong>€ 00,00 per maand</strong></label>
                                    </div>
                                    <div class="row m0">
                                        <p class="h5 mr-jonas"><i class="fa fa-info-circle"></i> Omruil mogelijk op 01-12-2020</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row m0">
                                        <div class="col-md-7">
                                            <div class="row button">
                                                <button type="button" class="btn btn-default">Bekijk kunstwerk<i class="fa fa-angle-right"></i></button>
                                            </div>
                                            <div class="row button">
                                                <button type="button" class="btn btn-default">Kunst omruilen<i class="fa fa-refresh"></i></button>
                                            </div>
                                            <div class="row button">
                                                <button type="button" class="btn btn-default">Contact opnemen <i class="fa fa-angle-right"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
        return $output;
    }

    /**
     * Kunstuitleen account my credits
     */
    public function kunstuitleen_account_my_credits(){
        $output = '';
        $output .= '<div class="row">
                        <label class="h4 mr-jonas text-capitalize"><strong>Mijn cadeaubonnen</strong></label>
                    </div>
                    <div class="row main-row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-9">
                                    <label class="col-md-12 mr-jonas h4"><strong>Totaal aan cadeaubonnen</strong></label>
                                    <label class="col-md-12 mr-jonas h4"><strong>€ 100.00</strong></label>
                                    <label class="col-md-12 mr-jonas  gift-cards">Bijna aflopende bon:XXXX</label>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <img src="images/icons8-voucher-80.png" class="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row text-center" id="label">
                                    <label class="h5 mr-jonas"><strong>Bekijk al mijn cadeaubonnen</strong></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <label class="col-md-12 mr-jonas h4 text-uppercase"><strong>op zoek naar een inspierend en persoonalijk kado? GEEF een kunst kadobn</strong></label>
                            </div>
                            <div class="row present">
                                <div class="col-md-12">
                                    <div class="row text-center" id="label">
                                        <label class="h5 mr-jonas"><strong>Geef iemand cadeau</strong></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row search-btn">
                        <div class="col-md-12">
                            <form>
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Voeg nieuw cadeaubon heir toe">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-primary">Voeg toe</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row table-gift-card table-responsive">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th scope="col" class="mr-jonas">Cadeaubonnummer</th>
                                    <th scope="col" class="mr-jonas">Wardee</th>
                                    <th scope="col" class="mr-jonas">Restwarde</th>
                                    <th scope="col" class="mr-jonas">Vervaldatum</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row" class="mr-jonas">0000</th>
                                    <td class="mr-jonas"><strong>€ 100,00</strong></td>
                                    <td class="mr-jonas"><strong>€ 100,00</strong></td>
                                    <td class="mr-jonas"><strong>15-06-2020</strong></td>
                                    <td class="mr-jonas"><strong>Details </strong><i class="fa fa-sign-in"></i></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="mr-jonas">0000</th>
                                    <td class="mr-jonas"><strong>€ 00,00</strong></td>
                                    <td class="mr-jonas"><strong>€ 00,00</strong></td>
                                    <td class="mr-jonas"><strong>10-06-2020</strong></td>
                                    <td class="mr-jonas"><strong>Details </strong><span class="fa fa-sign-in" data-toggle="modal" data-target="#myModal"></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>';
        return $output;
    }

    /**
     * Kunstuitleen account my purchase invoicecs
     */
    public function kunstuitleen_account_my_purchase_invoicecs(){
        $output = '';
        $output .= '<div class="row">
                        <div class="col-md-12">
                            <label class="h4 mr-jonas text-capitalize col-md-10"><strong>Overzicht van aankoopfacturen</strong></label>
                            <div class="col-md-2 select-year">
                                <select class="form-control">
                                <option>2020</option>
                                <option>2021</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row table-gift-card">
                        <div class="col-md-12">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th scope="col" class="mr-jonas">Download</th>
                                        <th scope="col" class="mr-jonas">Datum</th>
                                        <th scope="col" class="mr-jonas">Bedrag</th>
                                        <th scope="col" class="mr-jonas">Vervaldatum</th>
                                        <th class="mr-jonas">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row" class="mr-jonas"><a href="#" download><img src="images/icons8-pdf-64.png" class="img-responsive img-download">0000</a></th>
                                        <td class="mr-jonas"><strong>01-06-2020</strong></td>
                                        <td class="mr-jonas"><strong>€ 100,00 - € 100,00</strong></td>
                                        <td class="mr-jonas"><strong>15-06-2020</strong></td>
                                        <td class="mr-jonas summary" data-toggle="modal" data-target="#invoice-summary"><span class="fa fa-minus"></span><strong>Openstaand</strong></td>
                                        <td class="mr-jonas"><strong>Betalen<span class="fa fa-sign-in"></span></strong></td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="mr-jonas"><a href="#" download><img src="images/icons8-pdf-64.png" class="img-responsive img-download">0000</a></th>
                                        <td class="mr-jonas"><strong>01-06-2020</strong></td>
                                        <td class="mr-jonas"><strong>€ 00,00</strong></td>
                                        <td class="mr-jonas"><strong>15-06-2020</strong></td>
                                        <td class="mr-jonas"><span class="fa fa-check"></span><strong>Betaald</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>';
        return $output;
    }

    /**
     * Kunstuitleen account my rental invoices
     */
    public function kunstuitleen_account_my_rental_invoices(){
        $output = '';
        $output .= '<div class="row">
                        <div class="col-md-12">
                            <label class="h3 mr-jonas text-capitalize col-md-10"><strong>Overzicht van huurfacturen</strong></label>
                            <div class="col-md-2">
                                <select class="form-control mr-jonas">
                                <option>2020</option>
                                <option>2021</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row table-gift-card">
                        <div class="col-md-5">
                            <button type="button" class="btn btn-default" data-toggle="collapse" data-parent="#accordion" href="#department1"><label class="mr-jonas h4"><strong>Afdeling 1</strong></label><i class="fa fa-chevron-up"></i></button>
                        </div>
                    </div>
                    <div id="department1" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <div class="row ">
                                <div class="col-md-12 table-responsive">
                                    <table class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="mr-jonas">Download Facturen</th>
                                                <th scope="col" class="mr-jonas">Datum</th>
                                                <th scope="col" class="mr-jonas">Bedrag</th>
                                                <th scope="col" class="mr-jonas">Vervaldatum</th>
                                                <th class="mr-jonas">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row" class="mr-jonas"><a href="#" download><img src="images/icons8-pdf-64.png" class="img-responsive img-download">0000</a></th>
                                                <td class="mr-jonas"><strong>01-07-2020</strong></td>
                                                <td class="mr-jonas"><strong>€ 00,00</strong></td>
                                                <td class="mr-jonas"><strong>15-07-2020</strong></td>
                                                <td class="mr-jonas summary"><span class="fa fa-minus"></span><strong>Storno</strong></td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="mr-jonas"><a href="#" download><img src="images/icons8-pdf-64.png" class="img-responsive img-download">0000</a></th>
                                                <td class="mr-jonas"><strong>01-06-2020</strong></td>
                                                <td class="mr-jonas"><strong>€ 00,00</strong></td>
                                                <td class="mr-jonas"><strong>15-06-2020</strong></td>
                                                <td class="mr-jonas"><span class="fa fa-check"></span><strong>Geincasseerd</strong></td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="mr-jonas"><a href="#" download><img src="images/icons8-pdf-64.png" class="img-responsive img-download">0000</a></th>
                                                <td class="mr-jonas"><strong>01-06-2020</strong></td>
                                                <td class="mr-jonas"><strong>€ 00,00</strong></td>
                                                <td class="mr-jonas"><strong>15-06-2020</strong></td>
                                                <td class="mr-jonas"><span class="fa fa-check"></span><strong>Geincasseerd</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row table-gift-card">
                        <div class="col-md-5">
                            <button type="button" class="btn btn-default" data-toggle="collapse" data-parent="#accordion" href="#department2"><label class="mr-jonas h4"><strong>Afdeling 2</strong></label><i class="fa fa-chevron-up"></i></button>
                        </div>
                    </div>
                    <div id="department2" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12 table-responsive">
                                    <table class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="mr-jonas">Download Facturen</th>
                                                <th scope="col" class="mr-jonas">Datum</th>
                                                <th scope="col" class="mr-jonas">Bedrag</th>
                                                <th scope="col" class="mr-jonas">Vervaldatum</th>
                                                <th class="mr-jonas">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row" class="mr-jonas"><a href="#" download><img src="images/icons8-pdf-64.png" class="img-responsive img-download">0000</a></th>
                                                <td class="mr-jonas"><strong>01-07-2020</strong></td>
                                                <td class="mr-jonas"><strong>€ 00,00</strong></td>
                                                <td class="mr-jonas"><strong>15-07-2020</strong></td>
                                                <td class="mr-jonas summary"><span class="fa fa-minus"></span><strong>Storno</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>';
        return $output;
    }

    /**
     * Kunstuitleen account my details
     */
    public function kunstuitleen_account_my_details(){
        $output = '';
        $output .= ' <div class="row company-details">
                        <div class="col-md-12">
                            <div class="row">
                                <label class="h4 mr-jonas col-md-12"><strong>Bedrijfsgegevens</strong></label>
                            </div>
                            <div class="row">
                                <label class="h5 mr-jonas col-md-12"><strong>Bedrijfsname</strong></label>
                            </div>
                            <div class="row">
                                <label class="h5 mr-jonas col-md-12"><strong>Straatnaam</strong></label>
                            </div>
                            <div class="row">
                                <label class="h5 mr-jonas col-md-12"><strong>Postcode en plaatsnaam</strong></label>
                            </div>
                            <div class="row">
                                <label class="h5 mr-jonas col-md-12"><strong>Email@adres.nl</strong></label>
                            </div>
                        </div>
                    </div>
                    <div class="row information">
                        <div class="col-md-9">
                            <div class="row">
                                <label class="h4 mr-jonas col-md-12"><strong>Persoonlijke gegevens</strong></label>
                            </div>
                            <div class="row">
                                <label class="h5 mr-jonas col-md-12"><strong>Voornaam en Acheternaam</strong></label>
                            </div>
                            <div class="row">
                                <label class="h5 mr-jonas col-md-12"><strong>Straatnaam</strong></label>
                            </div>
                            <div class="row">
                                <label class="h5 mr-jonas col-md-12"><strong>Postcode en plaatsnaam</strong></label>
                            </div>
                            <div class="row">
                                <label class="h5 mr-jonas col-md-12"><strong>Email@adres.nl</strong></label>
                            </div>
                        </div>
                        <div class="col-md-3 img-col">
                            <div class="row">
                                <img class="img-responsive" src="images/icons8-user-96.png">
                            </div>
                        </div>
                    </div>
                    <div class="row desired-deatils">
                        <div class="col-md-12 box-shadow">
                            <div class="row mt-15px">
                                <label class="col-md-12 h5 mr-jonas"><strong>Heir vind je alles om je gegevens bij te werken indien gewenst</strong></label>
                            </div>
                            <div class="row mt-15px">
                                <div class="col-md-4">
                                    <button class="btn btn-default"><label class="h4 mr-jonas"><strong>Bedrijfsgegevens</strong></label><i class="fa fa-angle-right"></i></button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mt-15px">
                                    <button class="btn btn-default"><label class="mr-jonas h4"><strong>Persoonlijke gegevens</strong></label><i class="fa fa-angle-right"></i></button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mt-15px">
                                    <button class="btn btn-default"><label class="h4 mr-jonas"><strong>Betaalgegevens</strong></label><i class="fa fa-angle-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 box-shadow">
                            <div class="row account-management">
                                <div class="col-md-9 ">
                                    <div class="row mt-40px">
                                        <label class="col-md-12 h4 mr-jonas"><strong>Beheer van accounts</strong></label>
                                    </div>
                                    <div class="row mt-15px">
                                        <div class="col-md-12">
                                            <label class="col-md-12 h5 mr-jonas"><strong>Heir vind je alle sub accounts om deze te kunnen beheren en aan te maken.</strong></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mt-15px">
                                            <button class="btn btn-default"><label class="h4 mr-jonas"><strong>Beheer accounts</strong></label><i class="fa fa-angle-right"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 grp-img-col mt-40px">
                                    <div class="row">
                                        <img class="img-responsive" src="images/group.png">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-15px">
                        <div class="col-md-12 box-shadow">
                            <div class="row account-management">
                                <div class="col-md-9 ">
                                    <div class="row mt-40px">
                                        <label class="col-md-12 h4 mr-jonas"><strong>Account bescherming</strong></label>
                                    </div>
                                    <div class="row mt-15px">
                                        <div class="col-md-12">
                                            <label class="col-md-12 h5 mr-jonas"><strong>Heir vind je alles om je account veilig te houden</strong></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mt-15px">
                                            <button class="btn btn-default"><label class="h4 mr-jonas"><strong>Beheer accounts</strong></label><i class="fa fa-angle-right"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 grp-img-col mt-40px">
                                    <div class="row">
                                        <img class="img-responsive" src="images/icons8-lock-512.png">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
        return $output;
    }
}
?>