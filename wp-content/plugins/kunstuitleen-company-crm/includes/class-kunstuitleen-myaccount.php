<?php

/**
 * class kunstuitleen
 */
class Kunstuitleen_My_Account
{

    /**
     * Constructor
     */
    public function __construct()
    {
        add_action('init', array($this, 'kunstuitleen_endpoint'));
        add_shortcode('kunstuitleen-my-account', array($this, 'kunstuitleen_my_account'));
        add_shortcode('kunstuitleen-my-account-top-menu', array(
            $this,
            'kunstuitleen_account_page_top_menu'
        ));
        add_action('wp_ajax_kunstuitleen_company_details_form_ajax', array(
            $this,
            'kunstuitleen_company_details_form_ajax'
        ));
        add_action('wp_ajax_nopriv_kunstuitleen_company_details_form_ajax', array($this, 'kunstuitleen_company_details_form_ajax'));
        flush_rewrite_rules();

        /**
         * Ajax call
         */
        add_action('wp_ajax_kucrm_company_artwork_ajax', array($this, 'kucrm_company_artwork_ajax'));
        add_action('wp_ajax_nopriv_kucrm_company_artwork_ajax', array($this, 'kucrm_company_artwork_ajax'));
    }

    /**
     * Kunstuitleen endpoint
     */
    public function kunstuitleen_endpoint()
    {
        add_rewrite_endpoint('account-overview', EP_PERMALINK | EP_PAGES);
        add_rewrite_endpoint('my-artworks', EP_PERMALINK | EP_PAGES);
        add_rewrite_endpoint('my-credits', EP_PERMALINK | EP_PAGES);
        add_rewrite_endpoint('my-purchase-invoicecs', EP_PERMALINK | EP_PAGES);
        add_rewrite_endpoint('my-rental-invoices', EP_PERMALINK | EP_PAGES);
        add_rewrite_endpoint('my-details', EP_PERMALINK | EP_PAGES);
        add_rewrite_endpoint('create-new-account', EP_PERMALINK | EP_PAGES);
        add_rewrite_endpoint('edit-account', EP_PERMALINK | EP_PAGES);
        add_rewrite_endpoint('manage-account', EP_PERMALINK | EP_PAGES);
        add_rewrite_endpoint('create-company-account', EP_PERMALINK | EP_PAGES);
    }

    /**
     * Kunstuitleen get previous page url
     *
     * @since    1.0.0
     */
    public function kunstuitleen_get_previous_page_url()
    {
        $output = '';
        if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) :
            $output = $_SERVER['HTTP_REFERER'];
        else :
            $output = '#';
        endif;
        return $output;
    }

    /**
     * Kunstuitleen get previous page url
     *
     * @since    1.0.0
     */
    public function kunstuitleen_get_previous_pageurl($end_point = '')
    {
        $output = $static_page_slug = $kunstuitleen_get_query_vars = $menu_link = '';
        $static_page_slug = $this->kunstuitleen_page_slug();
        $kunstuitleen_get_query_vars = $this->kunstuitleen_get_query_vars();
        if (!empty($end_point)) :
            $menu_link = $kunstuitleen_get_query_vars . '/' . $end_point;
        else :
            $menu_link = $kunstuitleen_get_query_vars;
        endif;
        if (!empty($menu_link)) :
            $output = $this->Kunstuitleen_url($base_url = '', $menu_link, $static_page_slug);
        endif;
        return $output;
    }

    /**
     * Kunstuitleen get previous page url
     *
     * @since    1.0.0
     */
    public function kunstuitleen_anchor_url($args)
    {
        $output = '';
        if (!empty($args)) :
            $class = !empty($args['class']) ? esc_attr($args['class']) : 'btn btn-default kunstuitleen-url';
            $icon = !empty($args['icon']) ? $args['icon'] : '';
            if (!empty($icon)) :
                $output = '<a href="' . esc_url($args['url']) . '" class="' . esc_attr($class) . '">' . esc_html($args['title']) . '<i class="fa ' . esc_attr($icon) . '"></i></a>';
            else :
                $output = '<a href="' . esc_url($args['url']) . '" class="' . esc_attr($class) . '">' . esc_html($args['title']) . '</a>';
            endif;
        endif;
        return $output;
    }


    /**
     * Kunstuitleen get queryvar
     */
    public function kunstuitleen_get_query_vars()
    {
        global $wp_query;
        $output = $menu_key = $get_query_vars = '';
        $menu = array_keys($this->kunstuitleen_menu_link());
        $get_query_vars_key = array_keys($wp_query->query_vars);
        if (!empty($menu)) :
            foreach ($menu as $menu_key => $menu_val) :
                if (in_array($menu_val, $get_query_vars_key) || !is_singular()) :
                    $output = $menu_val;
                endif;
            endforeach;
        endif;
        return $output;
    }

    /**
     * Kunstuitleen get queryvar child
     */
    public function kunstuitleen_get_query_var_child($args)
    {
        global $wp_query;
        $output = '';
        if (!empty($args)) :
            $output = $wp_query->query_vars[$args];
        endif;
        return $output;
    }

    /**
     * Kunstuitleen top title
     */
    public function kunstuitleen_top_title($args)
    {
        $output = '';
        if (!empty($args)) :
            $output = '<div class="form-title">
                            <h2 class="roboto"><strong>' . esc_attr($args['title']) . '</strong></h2>
                        </div>';
        endif;
        return $output;
    }

    /**
     * kunstuitleen account page top menu
     */
    public function kunstuitleen_account_page_top_menu($atts)
    {
        $output = $menu = '';
        $atts = shortcode_atts(array(
            'title' => '',
            'class' => '',
        ), $atts, 'bartag');
        $menu = $this->kunstuitleen_menu();
        $title = $this->kunstuitleen_top_title($atts);
        $output .= $title;
        $output .= '<div class="row ' . esc_attr($atts['class']) . '" style="margin-top: 22px;">';
        $output .= $menu;
        $output .= '</div>';
        return $output;
    }

    /**
     * Kunstuitleen my account
     */
    public function kunstuitleen_my_account()
    {
        $output = $menu = $kunstuitleen_get_query_vars = $kunstuitleen_get_query_var_child = $kunstuitleen_sub_menu_link = $title = '';
        if (is_user_logged_in()) :
            $menu = $this->kunstuitleen_menu_link();
            $kunstuitleen_get_query_vars = $this->kunstuitleen_get_query_vars();
            $kunstuitleen_get_query_var_child = $this->kunstuitleen_get_query_var_child($kunstuitleen_get_query_vars);
            $kunstuitleen_sub_menu_link = $this->kunstuitleen_sub_menu_link($kunstuitleen_get_query_vars, $kunstuitleen_get_query_var_child);
            if (!empty($kunstuitleen_sub_menu_link)) :
                $title = $kunstuitleen_sub_menu_link;
            elseif (!empty($kunstuitleen_get_query_vars) && empty($kunstuitleen_sub_menu_link)) :
                $title = $menu[$kunstuitleen_get_query_vars];
            else :
                $title = $menu['account-overview'];
            endif;
            $output .= '<main class="flex-shrink-0 kunstuitleen-main-account">
                        <div class="container mb-30px kunstuitleen-account_group">';
            if (!empty($title)) :
                $output .= '<div class="row text-center">
                                                <label class="h2 roboto title"><strong>' . esc_html($title) . '</strong></label>
                                            </div>';
            endif;
            $output .= '<div class="row account_main_menu" style="margin-top: 40px;">
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
    public function kunstuitleen_menu_link()
    {
        $output = '';
        $output = array(
            'account-overview' => esc_html__('Accountoverzicht', 'kunstuitleen-company-crm'),
            'my-artworks' => esc_html__('Mijn kunstwerken', 'kunstuitleen-company-crm'),
            'my-credits' => esc_html__('Mijn tegoeden', 'kunstuitleen-company-crm'),
            'my-purchase-invoicecs' => esc_html__('Mijn aankoopfacturen', 'kunstuitleen-company-crm'),
            'my-rental-invoices' => esc_html__('Mijn huurfacturen', 'kunstuitleen-company-crm'),
            'my-details' => esc_html__('Mijn gegevens', 'kunstuitleen-company-crm'),
            'log-out' => esc_html__('Uitloggen', 'kunstuitleen-company-crm'),
        );
        return $output;
    }

    /**
     * Kunstuitleen sub menu link
     */
    public function kunstuitleen_sub_menu_link($parent_menu, $child_menu)
    {
        $output = '';
        if (!empty($parent_menu) && !empty($child_menu)) :
            switch ($parent_menu):
                case 'account-overview':
                    $output = '';
                    break;
                case 'my-artworks':
                    $output = '';
                    break;
                case 'my-credits':
                    $output = '';
                    break;
                case 'my-purchase-invoicecs':
                    $output = '';
                    break;
                case 'my-rental-invoices':
                    $output = '';
                    break;
                case 'my-details':
                    if (!empty($child_menu)) :
                        switch ($child_menu):
                            case 'create-new-account':
                                $output = esc_html__('Maak Niew Account', 'kunstuitleen-company-crm');
                                break;
                            case 'edit-account':
                                $output = esc_html__('Bewerking Account', 'kunstuitleen-company-crm');
                                break;
                            case 'manage-account':
                                $output = esc_html__('Beheer Accounts', 'kunstuitleen-company-crm');
                                break;
                        endswitch;
                    endif;
                    break;
            endswitch;
        endif;
        return $output;
    }

    /**
     * Kunstuitleen menu wrapper
     */
    public function kunstuitleen_menu_wrapper()
    {
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
     * Kunstuitleen url
     */
    public function kunstuitleen_page_slug()
    {
        $output = '';
        $output = 'kunstuitleen-my-account';
        return $output;
    }

    /**
     * Kunstuitleen my account url
     */
    public function kunstuitleen_my_account_url()
    {
        $output = $static_page_slug = '';
        $static_page_slug = $this->kunstuitleen_page_slug();
        $output = kunstuitleen_url($base_url = '', $enpoint = '', $static_page_slug);
        return $output;
    }

    /**
     * Kunstuitleen url
     */
    public function kunstuitleen_url($base_url = '', $enpoint = '', $static_page_slug = '')
    {
        $output = '';
        if (!empty($base_url) && !empty($enpoint) && empty($static_page_slug)) :
            $output = esc_url($base_url . $enpoint);
        elseif (empty($base_url) && !empty($enpoint) && empty($static_page_slug)) :
            $output = home_url('/' . $enpoint);
        elseif (empty($base_url) && !empty($enpoint) && !empty($static_page_slug)) :
            $output = home_url('/' . $static_page_slug . '/' . $enpoint);
        endif;
        return $output;
    }

    /**
     * Kunstuitleen menu
     */
    public function kunstuitleen_menu()
    {
        $output = $menu = $kunstuitleen_get_query_vars = $menu_class = $static_page_slug = '';
        $menu = $this->kunstuitleen_menu_link();
        $kunstuitleen_get_query_vars = $this->kunstuitleen_get_query_vars();
        $static_page_slug = $this->kunstuitleen_page_slug();
        if (!empty($menu)) :
            $i = 0;
            $output .= '<ul class="kunstuitleen-menu">';
            foreach ($menu as $menu_link => $menu_name) :
                switch ($menu_link):
                    case 'log-out':
                        $output .= '<li>
                                        <a href="' . esc_url(wp_logout_url(home_url())) . '" class="btn">
                                            <label class="h5 roboto"><strong>' . esc_html($menu_name) . '</strong></label>
                                        </a>
                                    </li>';
                        break;
                    default:
                        if ($menu_link == $kunstuitleen_get_query_vars && !empty($kunstuitleen_get_query_vars)) :
                            $menu_class = 'class=active';
                        else :
                            $menu_class = '';
                        endif;
                        $output .= '<li ' . esc_attr($menu_class) . '>
                                        <a href="' . esc_url($this->kunstuitleen_url($base_url = '', $menu_link, $static_page_slug)) . '" class="btn">
                                            <label class="h5 roboto"><strong>' . esc_html($menu_name) . '</strong></label>
                                        </a>
                                    </li>';
                endswitch;
                $i++;
            endforeach;
            $output .= '</ul>';
        endif;
        return $output;
    }

    /**
     * Kunstuitleen content wrapper
     */
    public function kunstuitleen_content_wrapper()
    {
        $output = $kunstuitleen_get_query_vars = $kunstuitleen_get_query_var_child = '';
        $kunstuitleen_get_query_vars = $this->kunstuitleen_get_query_vars();
        $kunstuitleen_get_query_var_child = $this->kunstuitleen_get_query_var_child($kunstuitleen_get_query_vars);
        $output .= '<div class="col-md-9 main main_account_group">';
        switch ($kunstuitleen_get_query_vars):
            case 'account-overview':
                $output .= $this->kunstuitleen_account_overview();
                break;
            case 'my-artworks':
                if (!empty($kunstuitleen_get_query_var_child)) :
                    $output .= $this->kunstuitleen_content_child_wrapper($kunstuitleen_get_query_vars, $kunstuitleen_get_query_var_child);
                else :
                    $output .= $this->kunstuitleen_account_my_artworks();
                endif;
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
                if (!empty($kunstuitleen_get_query_var_child)) :
                    $output .= $this->kunstuitleen_content_child_wrapper($kunstuitleen_get_query_vars, $kunstuitleen_get_query_var_child);
                else :
                    $output .= $this->kunstuitleen_account_my_details();
                endif;
                break;
                /*case 'manage-account':
                    $output .= $this->kunstuitleen_account_my_details_manage_account();
                break;*/
            default:
                $output .= $this->kunstuitleen_account_overview();
        endswitch;
        $output .= '</div>';
        return $output;
    }

    /**
     * Kunstuitleen content child wrapper
     */
    public function kunstuitleen_content_child_wrapper($args, $child)
    {
        $output = '';
        if (!empty($args)) :
            switch ($args):
                case 'account-overview':
                    $output .= '';
                    break;
                case 'my-artworks':
                    if (!empty($child)) :
                        switch ($child):
                            case 'my-inventory':
                                $output .= $this->kucrm_company_rent_agreement_inventory();
                                break;
                        endswitch;
                    endif;
                    $output .= '';
                    break;
                case 'my-credits':
                    $output .= '';
                    break;
                case 'my-purchase-invoicecs':
                    $output .= '';
                    break;
                case 'my-rental-invoices':
                    $output .= '';
                    break;
                case 'my-details':
                    if (!empty($child)) :
                        switch ($child):
                            case 'create-new-account':
                                $output .= $this->kunstuitleen_account_my_details_create_new_account();
                                break;
                            case 'create-company-account':
                                $output .= $this->kunstuitleen_account_my_details_create_company_account();
                                break;
                            case 'edit-account':
                                $output .= $this->kunstuitleen_account_password_update();
                                break;
                            case 'manage-account':
                                $wp_get_current_user = '';
                                $wp_get_current_user = wp_get_current_user();
                                if (in_array('subscriber', $wp_get_current_user->roles)) :
                                    $output .= $this->kunstuitleen_account_my_details_edit_account();
                                else :
                                    $output .= $this->kunstuitleen_account_my_details_manage_account();
                                endif;
                                break;
                        endswitch;
                    endif;
                    break;
            endswitch;
        endif;
        return $output;
    }

    /**
     * Kunstuitleen account overview
     */
    public function kunstuitleen_account_overview()
    {
      
        $data = getSaleInvoice();
        $data = json_decode($data, true);
        $invoice = array();
        if (count($data) > 0) {
            foreach ($data as $key => $row) {
                $invoice[$key] = $row;
            }
        }
        $rows6 = array();
        if (count($invoice) > 0) {
            foreach ($invoice as $key => $row) {
                $rows6 = $row;
                break;
            }
        }
        $data1 = getRentInvoice();
        $data1 = json_decode($data1, true);
        $invoice1 = array();
        if (count($data1) > 0) {
            foreach ($data1 as $key => $row) {
                $invoice1[$key] = $row;
            }
        }
        $rows1 = array();
        if (count($invoice1) > 0) {
            foreach ($invoice1 as $key => $row) {
                $rows1 = $row;
                break;
            }
        }
        
        $data2 = getCredits();
        $data2 = json_decode($data2, true);
        $rows9 = array();
        
        if (count($data2) > 0) {
            foreach ($data2 as $key => $row) {
                $rows9[$key] = $row;
            }
        }
        
        $total_card_amount = 0;
        if (count($rows9) > 0) {
            foreach ($rows9 as $row) {
                $total_card_amount += $row["card_amount"];
            }
        }

        $savings = getPrivateSavings();
        $savings = json_decode($savings, true);
        isset($savings['total_savings']) ? $total_savings = $savings['total_savings'] : $total_savings = 0;

        $data3 = getRentAgreement();
        $data3 = json_decode($data3, true);
        $agreement = array();
        if (count($data3) > 0) {
            foreach ($data3 as $key => $row) {
                $agreement[$key] = $row;
                break;
            }
        }
        $rows7 = array();
        if (count($agreement) > 0) {
            foreach ($agreement as $key => $row) {
                $rows7 = $row;
                break;
            }
        }
  
        $output = '';
        $output .= '<div class="col-md-12" style="margin-left:0px;padding-left:0px;">
        <label class="h4 roboto"><strong>Mijn tegoeden</strong></label>
    </div>
    <div class="row main-row mb-3">
                        <div class="col-md-6">
                            <div class="account_page_first inline-block box-shadow">
                                <div class="row">
                                    <div class="col-md-9">
                                    <label class="col-md-12 roboto h4"><strong>Totaal aan spaartegoed</strong></label>
                                    <label class="col-md-12 roboto h4"><strong>€ ' . $total_savings . '</strong></label>

                                    </div>
                                    <div class="col-md-3">
                                        <div class="row">
                                        <img src="' . esc_url(KUCRM_COMPANY_URL . 'public/images/savings_FILL0_wght400_GRAD0_opsz48.svg') . '" class="img-responsive">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row text-center" id="label">
                                            <label class="h5 mr-jonas"><strong>Geef iemand cadeau</strong></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="account_page_first inline-block box-shadow">
                            <div class="row">
                            <div class="col-md-9">
                                <label class="col-md-12 mr-jonas h4"><strong>Totaal aan cadeaubonnen</strong></label>
                                <label class="col-md-12 roboto h4"><strong>€ ' . $total_card_amount . '</strong></label>

                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                <img src="' . esc_url(KUCRM_COMPANY_URL . 'public/images/voucher_img.svg') . '" class="img-responsive">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="row text-center" id="label">
                                    <label class="h5 mr-jonas"><strong>Bekijk al mijn cadeaubonnen</strong></label>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>';
        $output .= '
                    <div class="row " style="margin-top:250px;">
                        <div class="col-md-9 payment-overview-heading p0 mt-3">
                            <label class="h4 roboto"><strong>Betalingsoverzicht van huurfacturen</strong></label>
                        </div>
                    </div>
                <div class="rentAgreementTab" id="rentAgreementTab">';
                $output .= ' <div id="key" class="panel-collapse collapse in">
                    <div class="panel-body p0">
                        <div class="row ">
                            <div class="col-md-12 table-responsive kunstuitleen-table p0">
                                <table class="table table-borderless">
                                    <thead>
                                                <tr>
                                                    <th scope="col" class="roboto"style="font-size:14px; font-weight:bold;">Huurovereenkomst</th>
                                                    <th scope="col" class="roboto" style="font-size:14px; font-weight:bold;">start datum</th>
                                                    <th scope="col" class="roboto" style="font-size:14px; font-weight:bold;">Totaal gehuurde kunst</th>
                                                    <th scope="col" class="roboto" style="font-size:14px; font-weight:bold;">Totaal galeriewaarde</th>
                                                    <th scope="col" class="roboto" style="font-size:14px; font-weight:bold;">Totaal huur</th>
                                                    <th scope="col" class="roboto" style="font-size:14px; font-weight:bold;"></th>

                                                </tr>
                                            </thead>
                                            <tbody>';
                if (count($rows7) > 0) {
                    foreach ($rows7 as $row3) {
                        $output .= '<tr>
                                                    <td class="roboto" style="font-size:14px; font-weight:bold;">' . $row3['id'] . '</td>
                                                    <td class="roboto" style="font-size:14px; font-weight:bold;">' . date('d-m-Y', strtotime($row3['start_date'])) . '</td>
                                                    <td class="roboto" style="font-size:14px; font-weight:bold;"> ' . $row3['total_art_rented'] . '</td>
                                                    <td class="roboto" style="font-size:14px; font-weight:bold;">&euro; ' . $row3['total_gallery_price_art_rented'] . '</td>
                                                    <td class="roboto" style="font-size:14px; font-weight:bold;">&euro; ' . $row3['total_rent'] . '</td>
                                                    <td>
                                                    </td>
                                                </tr>';
                    }
                } else {
                    $output .= '<tr>
                                                <td colspan="5" class="roboto"><strong>Geen aankoopfacturen gevonden</strong></td>
                                            </tr>';
                }
                $output .= '</tbody>
                                        </table>
                                    </div>
                                </div>
                                </div>
                                </div>';

        $output .= '
                    </div>
                    <div class="col-md-6 px-md-3 p0" style=" margin-bottom:40px;">
                    <a href="' . esc_url($this->kunstuitleen_url($base_url = '', 'my-artworks', $this->kunstuitleen_page_slug())) . '" >
                    <button type="button" class="btn btn-default"><strong class="roboto">Bekijk alle betalingen en aankoopfacturen </strong><i class="fa fa-angle-right"></i></button></a>
                    </div>

                    <div class="row payment-overview"  >
                        <div class="col-md-9 payment-overview-heading p0">
                            <label class="h4 roboto"><strong>Betalingsoverzicht aankopen</strong></label>
                        </div>
                        <div class="col-md-12 table-responsive kunstuitleen-table p0">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th scope="col" class="roboto" style="font-size:14px; font-weight:bold;">Downloaden factuur</th>
                                        <th scope="col" class="roboto" style="font-size:14px; font-weight:bold;">Datum</th>
                                        <th scope="col" class="roboto" style="font-size:14px; font-weight:bold;">Bedrag</th>
                                        <th scope="col" class="roboto" style="font-size:14px; font-weight:bold;">Vervaldatum</th>
                                        <th scope="col" class="roboto" style="font-size:14px; font-weight:bold;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>';

        if (count($rows6) > 0) {
            foreach ($rows6 as $row) {
                $output .= '<tr>
                        <th scope="row" class="roboto" style="font-size:14px; font-weight:bold;"><a href="' . $row['pdf'] . '" download><img src="' . esc_url(KUCRM_COMPANY_URL . 'public/images/pdf.svg') . '" class="img-responsive img-download">' . $row['invoice_number'] . '</a></th>
                        <td class="roboto" style="font-size:14px; font-weight:bold;">' . date('d-m-Y', strtotime($row['invoice_date'])) . '</td>
                                                        <td class="roboto" style="font-size:14px; font-weight:bold;">&euro; ' . $row['total_incl_vat'] . '</td>
                                                        <td class="roboto" style="font-size:14px; font-weight:bold;">' . date('d-m-Y', strtotime($row['due_date'])) . '</td>
                                                        <td class="roboto" style="font-size:14px; font-weight:bold;"><span class="fa fa-check"></span>' . $row['status'] . '</td>
                                                    </tr>';
                break;
            }
        } else {
            $output .= '<tr>
                                    <td colspan="5" class="roboto"><strong>Geen aankoopfacturen gevonden</strong></td>
                                </tr>';
        }
        $output .= '</tbody>
                            </table>
                        </div>
                        <div class="col-md-6 px-md-3 p0">
                        <a href="' . esc_url($this->kunstuitleen_url($base_url = '', 'my-purchase-invoicecs', $this->kunstuitleen_page_slug())) . '" >
                        <button type="button" class="btn btn-default"><strong class="roboto">Bekijk alle betalingen en aankoopfacturen</strong><i class="fa fa-angle-right"></i></button></a>
                        </div>
                    </div>
                    <div class="row rent-overview"  style="margin-top:40px;">
                        <div class="col-md-9 p0">
                            <label class="h4 roboto"><strong>Betalingsoverzicht huren</strong></label>
                        </div>
                        <div class="col-md-12 table-responsive kunstuitleen-table p0">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                    <th scope="col" class="roboto" style="font-size:14px; font-weight:bold;">Downloaden factuur</th>
                                    <th scope="col" class="roboto" style="font-size:14px; font-weight:bold;">Datum</th>
                                    <th scope="col" class="roboto" style="font-size:14px; font-weight:bold;">Bedrag</th>
                                    <th scope="col" class="roboto"style="font-size:14px; font-weight:bold;">Gespaard</th>
                                    <th scope="col" class="roboto" style="font-size:14px; font-weight:bold;">Status</th>
                                    </tr>
                                </thead>
                                 <tbody>';

        if (count($rows1) > 0) {
            foreach ($rows1 as $row) {
                $output .= '<tr>

                <th scope="row" class="roboto" style="font-size:14px; font-weight:bold;"><a href="' . $row['pdf'] . '" download><img src="' . esc_url(KUCRM_COMPANY_URL . 'public/images/pdf.svg') . '" class="img-responsive img-download">' . $row['invoice_number'] . '</a></th>
                <td class="roboto" style="font-size:14px; font-weight:bold;">' . date('d-m-Y', strtotime($row['invoice_date'])) . '</td>
                <td class="roboto" style="font-size:14px; font-weight:bold;">&euro; ' . $row['amount'] . '</td>
                <td class="roboto" style="font-size:14px; font-weight:bold;">&euro; ' . $row['savings'] . '</td>
                <td class="roboto" style="font-size:14px; font-weight:bold;"><span class="fa fa-check"></span>' . $row['status'] . '</td>

                                    </tr>';
                break;
            }
        } else {
            $output .= '<tr>
                                    <td colspan="5" class="roboto"><strong>Geen aankoopfacturen gevonden</strong></td>
                                </tr>';
        }
        $output .= '</tbody>
                            </table>
                        </div>
                            <div class="col-md-6 p0">
                            <a href="' . esc_url($this->kunstuitleen_url($base_url = '', 'my-rental-invoices', $this->kunstuitleen_page_slug())) . '" >
                            <button type="button" class="btn btn-default"><strong class="roboto">Bekijk alle betalingen en huurfacturen</strong><i class="fa fa-angle-right"></i></button></a>
                            </div>    
                        </div>
                    </div>';
        return $output;
    }

    /**
     * Kunstuitleen account my artwork
     */


    public function kunstuitleen_account_my_artworks()
    {
        $output = $url = $menu_link = $static_page_slug = $kunstuitleen_get_query_vars = $args = '';
        $static_page_slug = $this->kunstuitleen_page_slug();
        $kunstuitleen_get_query_vars = $this->kunstuitleen_get_query_vars();
        $menu_link = $kunstuitleen_get_query_vars . '/my-inventory/';
        $url = $this->Kunstuitleen_url($base_url = '', $menu_link, $static_page_slug);
        $personal_args = $rent_agreement_inventory = '';
        $personal_args = array(
            'url' => $this->kunstuitleen_get_previous_pageurl('my-inventory'),
            'title' => "",
            'icon' => 'fa-angle-right',
            'class' => 'h4 roboto ',
            'style' => 'font-weight: bold;',
        );
        $rent_agreement_inventory = $this->kunstuitleen_anchor_url($personal_args);
        $output = '';
        $output = $url = $menu_link = $static_page_slug = $kunstuitleen_get_query_vars = $edit_url = $edit_menu_link = $company_id = $users = '';
        $favorieten = get_favorieten();
        $data = getRentAgreement();
        $data = json_decode($data, true);
        $agreement = array();
        if (count($data) > 0) {
            foreach ($data as $key => $row) {
                $agreement[$key] = $row;
            }
        }
        $output = '';
        $output .= '<div class="row">
    <div class="col-md-12" style="margin-left:0px;">
        <label class="h3 roboto text-capitalize col-md-10"><strong>Overzicht van huurfacturen</strong></label>
        <div class="col-md-2 select-year">
            <select class="form-control rent_agreement_year" id="rent_agreement_year_2">';
        foreach (array_keys($data) as $key) {
            $output .= '<option>' . $key . '</option>';
        }

        $output .= '</select>
        </div>
    </div>
</div>

<div class="rentAgreementTab" id="rentAgreementTab">';
        if (count($agreement) > 0) {
            foreach ($agreement as $key => $rows) {
                $output .= ' <div id="' . $key . '" class="panel-collapse collapse in">
        <div class="panel-body p0">
            <div class="row ">
                <div class="col-md-12 table-responsive kunstuitleen-table">
                    <table class="table table-borderless">
                        <thead>
                                    <tr>
                                        <th scope="col" class="roboto" style="font-size:14px; font-weight:bold;">Huurovereenkomst</th>
                                        <th scope="col" class="roboto" style="font-size:14px; font-weight:bold;">start datum</th>
                                        <th scope="col" class="roboto" style="font-size:14px; font-weight:bold;">Totaal gehuurde kunst</th>
                                        <th scope="col" class="roboto" style="font-size:14px; font-weight:bold;">Totaal galeriewaarde</th>
                                        <th scope="col" class="roboto" style="font-size:14px; font-weight:bold;">Totaal huur</th>
                                        <th scope="col" class="roboto" style="font-size:14px; font-weight:bold;">Inventaris</th>
                                    </tr>
                                </thead>
                                <tbody>';
                if (count($rows) > 0) {
                    foreach ($rows as $row) {
                        $output .= '<tr>
                                        <td class="roboto" style="font-size:14px; font-weight:bold;">' . $row['id'] . '</td>
                                        <td class="roboto" style="font-size:14px; font-weight:bold;">' . date('d-m-Y', strtotime($row['start_date'])) . '</td>
                                        <td class="roboto" style="font-size:14px; font-weight:bold;">' . $row['total_art_rented'] . '</td>
                                        <td class="roboto" style="font-size:14px; font-weight:bold;">&euro; ' . $row['total_gallery_price_art_rented'] . '</td>
                                        <td class="roboto" style="font-size:14px; font-weight:bold;">&euro; ' . $row['total_rent'] . '</td>
                                        <td class="roboto" style="font-size:14px; font-weight:bold;">
                                        <a href="#" class="inventoryDetails" id="' . $row["id"] . '" ><i class="fa fa-angle-right"></i></a></td>
                                    </tr>';
                    }
                } else {
                    $output .= '<tr>
                                    <td colspan="5" class="roboto"><strong>Geen aankoopfacturen gevonden</strong></td>
                                </tr>';
                }
                $output .= '</tbody>
                            </table>
                        </div>
                    </div>
                    </div>
                    </div>';
            }
        } else {
            //no data
            $output .= '<div class="row">
                <div class="col-md-12">
                    <div class="row text-center" id="label">
                        <label class="h5 roboto"><strong>Geen aankoopfacturen gevonden</strong></label>
                    </div>
                </div>
                </div>';
        }
        $output .= '</div>';
        return $output;
    }


    /**
     * Kunstuitleen account my credits
     */
    public function kunstuitleen_account_my_credits()
    {
        $data = getCredits();
        $savingsData = getPrivateSavingsData();
        $savingsData = json_decode($savingsData, true);
        $savings = getPrivateSavings();
        $savings = json_decode($savings, true);
        isset($savings['total_savings']) ? $total_savings = $savings['total_savings'] : $total_savings = 0;
        isset($savings['last_credited']) ? $last_credited = $savings['last_credited'] : $last_credited = 0;
        $data = json_decode($data, true);
        $rows = array();
        function funcType($type)
        {
            if ($type == 'Gespaard') {
                return '+ ';
            } else {
                return '- ';
            }
        }
        if (count($data) > 0) {
            foreach ($data as $key => $row) {
                $rows[$key] = $row;
            }
        }
        $rows2 = array();
        if (count($savingsData) > 0) {
            foreach ($savingsData as $key => $row) {
                $rows2[$key] = $row;
            }
        }
        $total_card_amount = 0;
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $total_card_amount += $row["card_amount"];
            }
        }
        $output = '';
        $output .= '<div class="row">
                        <label class="h4 roboto text-capitalize plr-15"><strong>Mijn cadeaubonnen</strong></label>
                    </div>
                    <div class="row main-row mb-3">
                        <div class="col-md-6">
                            <div class="account_page_first inline-block box-shadow">
                                <div class="row">
                                    <div class="col-md-9">
                                    <label class="col-md-12 roboto h4"><strong>Totaal aan spaartegoed</strong></label>
                                    <label class="col-md-12 roboto h4"><strong>€ ' . $total_savings . '</strong></label>
                                    <label class="col-md-12 roboto  gift-cards">Laatst bijgeschre : € ' . $last_credited . '</label>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="row">
                                        <img src="' . esc_url(KUCRM_COMPANY_URL . 'public/images/savings_FILL0_wght400_GRAD0_opsz48.svg') . '" class="img-responsive">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row text-center" id="label">
                                            <label class="h5 mr-jonas"><strong>Geef iemand cadeau</strong></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="account_page_first inline-block box-shadow">
                            <div class="row">
                            <div class="col-md-9">
                                <label class="col-md-12 mr-jonas h4"><strong>Totaal aan cadeaubonnen</strong></label>
                                <label class="col-md-12 roboto h4"><strong>€ ' . $total_card_amount . '</strong></label>
                                <label class="col-md-12 mr-jonas  gift-cards">Bijna aflopende bon:XXXX</label>
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                <img src="' . esc_url(KUCRM_COMPANY_URL . 'public/images/voucher_img.svg') . '" class="img-responsive">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="row text-center" id="label">
                                    <label class="h5 mr-jonas"><strong>Bekijk al mijn cadeaubonnen</strong></label>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="row " style="margin-top:210px;">
                        <div class="col-md-9 payment-overview-heading p0 mt-3">
                            <label class="h4 roboto"><strong>Tegoeden Overzicht</strong></label>
                        </div>
                    </div>';

        $output .= '<div class="row table-gift-card table-responsive kunstuitleen-table mt-1">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th scope="col" class="roboto" style="font-size:14px; font-weight:bold;">Factuur</th>
                                    <th scope="col" class="roboto" style="font-size:14px; font-weight:bold;">Datum</th>
                                    <th scope="col" class="roboto" style="font-size:14px; font-weight:bold;">Bedrag</th>
                                    <th scope="col" class="roboto" style="font-size:14px; font-weight:bold;">Type</th>
                                </tr>
                            </thead>
                            <tbody>';
        if (count($rows2) > 0) {
            foreach ($rows2 as $row2) {
                $output .= '<tr>
                                                   
                                                    <td class="roboto" style="font-size:14px; font-weight:bold;">' . $row2['invoice_no'] . '</td>
                                                    <td class="roboto" style="font-size:14px; font-weight:bold;">' . $row2['invoice_date'] . '</td>
                                                    <td class="roboto" style="font-size:14px; font-weight:bold;">'.funcType($row2['type']) .'&euro; ' . $row2['amount'] . '</td>
                                                    <td class="roboto" style="font-size:14px; font-weight:bold;">' . $row2['type'] . '</td>
                                                </tr>';
            }
        } else {
            $output .= '<tr>
                                                <td colspan="5" class="roboto"><strong>Geen aankoopfacturen gevonden</strong></td>
                                            </tr>';
        }

        $output .= '</tbody>
                        </table>
                    </div>


                    <div class="row table-gift-card table-responsive kunstuitleen-table mt-3">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th scope="col" class="roboto" style="font-size:14px; font-weight:bold;">Cadeaubonnummer</th>
                                    <th scope="col" class="roboto" style="font-size:14px; font-weight:bold;">Wardee</th>
                                    <th scope="col" class="roboto" style="font-size:14px; font-weight:bold;">Restwarde</th>
                                    <th scope="col" class="roboto" style="font-size:14px; font-weight:bold;">Vervaldatum</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>';
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $output .= '<tr>
                                                   
                                                    <td class="roboto" style="font-size:14px; font-weight:bold;">' . $row['card_number'] . '</td>
                                                    <td class="roboto" style="font-size:14px; font-weight:bold;">&euro; ' . $row['card_amount'] . '</td>
                                                    <td class="roboto" style="font-size:14px; font-weight:bold;">&euro; ' . $row['used_amount'] . '</td>
                                                    <td class="roboto" style="font-size:14px; font-weight:bold;">' . date('d-m-Y', strtotime($row['expiry_date'])) . '</td>
                                                    
                                                </tr>';
            }
        } else {
            $output .= '<tr>
                                                <td colspan="5" class="roboto"><strong>Geen aankoopfacturen gevonden</strong></td>
                                            </tr>';
        }

        $output .= '</tbody>
                        </table>
                    </div>';
        return $output;
    }

    /**
     * Kunstuitleen account my purchase invoicecs
     */
    public function kunstuitleen_account_my_purchase_invoicecs()
    {
        $data = getSaleInvoice();
        $data = json_decode($data, true);
        $invoice = array();
        if (count($data) > 0) {
            foreach ($data as $key => $row) {
                $invoice[$key] = $row;
            }
        }
        $output = '';
        $output .= '<div class="row">
    <div class="col-md-12">
        <label class="h3 roboto text-capitalize col-md-10"><strong>Overzicht van huurfacturen</strong></label>
        <div class="col-md-2 select-year">
            <select class="form-control sale_year" id="sale_private_year">';
        foreach (array_keys($data) as $key) {
            $output .= '<option>' . $key . '</option>';
        }
        $output .= '</select>
        </div>
    </div>
</div>
<div class="saleInvoiceTab" id="saleInvoiceTab">';
        if (count($invoice) > 0) {
            foreach ($invoice as $key => $rows) {
                $output .= ' <div id="' . $key . '" class="panel-collapse collapse in">
        <div class="panel-body p0">
            <div class="row ">
                <div class="col-md-12 table-responsive kunstuitleen-table">
                    <table class="table table-borderless">
                        <thead>
                                    <tr>
                                        <th scope="col" class="roboto">Downloaden</th>
                                        <th scope="col" class="roboto">Datum</th>
                                        <th scope="col" class="roboto">Bedrag</th>
                                        <th scope="col" class="roboto">Vervaldatum</th>
                                        <th class="roboto">Status</th>
                                    </tr>
                                </thead>
                                <tbody>';
                if (count($rows) > 0) {
                    foreach ($rows as $row) {
                        $output .= '<tr>
                                        <th scope="row" class="roboto"><a href="' . $row['pdf'] . '" download><img src="' . esc_url(KUCRM_COMPANY_URL . 'public/images/pdf.svg') . '" class="img-responsive img-download">' . $row['invoice_number'] . '</a></th>
                                        <td class="roboto"><strong>' . date('d-m-Y', strtotime($row['invoice_date'])) . '</strong></td>
                                        <td class="roboto"><strong>&euro; ' . $row['total_incl_vat'] . '</strong></td>
                                        <td class="roboto"><strong>' . date('d-m-Y', strtotime($row['due_date'])) . '</strong></td>
                                        <td class="roboto summary"><span class="fa fa-check"></span><strong>' . $row['status'] . '</strong></td>
                                    </tr>';
                    }
                } else {
                    $output .= '<tr>
                                    <td colspan="5" class="roboto"><strong>Geen aankoopfacturen gevonden</strong></td>
                                </tr>';
                }
                $output .= '</tbody>
                            </table>
                        </div>
                    </div>';
            }
        } else {
            //no data
            $output .= '<div class="row">
                <div class="col-md-12">
                    <div class="row text-center" id="label">
                        <label class="h5 roboto"><strong>Geen aankoopfacturen gevonden</strong></label>
                    </div>
                </div>
                </div>';
        }
        $output .= '</div>';
        return $output;
    }

    /**
     * Kunstuitleen account my rental invoices
     */
    public function kunstuitleen_account_my_rental_invoices()
    {
        $data = getRentInvoice();
        //convert data into array   
        $data = json_decode($data, true);
        $invoice = array();
        if (count($data) > 0) {
            foreach ($data as $key => $row) {
                $invoice[$key] = $row;
            }
        }
        $output = '';
        $output .= '<div class="row">
                        <div class="col-md-12">
                            <label class="h3 roboto text-capitalize col-md-10"><strong>Overzicht van huurfacturen</strong></label>
                            <div class="col-md-2 select-year">
                                <select class="form-control rent_year" id="rent_private_year">';
        foreach (array_keys($data) as $key) {
            $output .= '<option>' . $key . '</option>';
        }
        $output .= '</select>
                            </div>
                        </div>
                    </div>
                    <div class="rentInvoiceTab" id="rentInvoiceTab">';
        if (count($invoice) > 0) {
            foreach ($invoice as $key => $rows) {
                $output .= ' <div id="' . $key . '" class="panel-collapse collapse in">
                            <div class="panel-body p0">
                                <div class="row ">
                                    <div class="col-md-12 table-responsive kunstuitleen-table">
                                        <table class="table table-borderless">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="roboto">Downloaden Facturen</th>
                                                    <th scope="col" class="roboto">Datum</th>
                                                    <th scope="col" class="roboto">Bedrag</th>
                                                    <th scope="col" class="roboto">Gespaard</th>
                                                    <th class="roboto">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                if (count($rows) > 0) {
                    foreach ($rows as $row) {
                        $output .= '<tr>
                                                        <th scope="row" class="roboto"><a href="' . $row['pdf'] . '" download><img src="' . esc_url(KUCRM_COMPANY_URL . 'public/images/pdf.svg') . '" class="img-responsive img-download">' . $row['invoice_number'] . '</a></th>
                                                        <td class="roboto"><strong>' . date('d-m-Y', strtotime($row['invoice_date'])) . '</strong></td>
                                                        <td class="roboto"><strong>&euro; ' . $row['amount'] . '</strong></td>
                                                        <td class="roboto"><strong>&euro; ' . $row['savings'] . '</strong></td>
                                                        <td class="roboto summary"><span class="fa fa-check"></span><strong>' . $row['status'] . '</strong></td>
                                                    </tr>';
                    }
                } else {
                    $output .= '<tr>
                                                    <td colspan="5" class="roboto"><strong>Geen huurfacturen gevonden</strong></td>
                                                </tr>';
                }
                $output .= '</tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>';
            }
        } else {
            //no data
            $output .= '<div class="row">
                <div class="col-md-12">
                    <div class="row text-center" id="label">
                        <label class="h5 roboto"><strong>Geen huurfacturen gevonden</strong></label>
                    </div>
                </div>
                </div>';
        }
        $output .= '</div>';
        return $output;
    }

    /**
     * Kunstuitleen get single company
     */
    public function kunstuitleen_get_single_company()
    {
        $output = $Kunstuitleen_Database = $table_name = $wp_get_current_user = $table_name = $user_id = '';
        $wp_get_current_user = wp_get_current_user();
        $Kunstuitleen_Database = new Kunstuitleen_Database;
        $table_name = 'company_details';
        $user_id = $wp_get_current_user->ID;
        $output = $Kunstuitleen_Database->kunstuitleen_select_where_id($table_name, $user_id);
        return $output;
    }
    /**
     * Kunstuitleen account my details
     */
    public function kunstuitleen_account_my_details()
    {
        $output = $url = $menu_link = $static_page_slug = $kunstuitleen_get_query_vars = $args = $create_comany_account_url = '';
        $static_page_slug = $this->kunstuitleen_page_slug();
        $kunstuitleen_get_query_vars = $this->kunstuitleen_get_query_vars();
        $menu_link = $kunstuitleen_get_query_vars . '/manage-account/';
        $url = $this->Kunstuitleen_url($base_url = '', $menu_link, $static_page_slug);

        $args = array(
            'url' => $this->kunstuitleen_get_previous_pageurl('create-company-account'),
            'title' => esc_html__('Bedrijfsgegevens', 'kunstuitleen-company-crm'),
            'icon' => 'fa-angle-right',
            'class' => 'h4 roboto',
        );
        $create_comany_account_url = $this->kunstuitleen_anchor_url($args);

        $personal_args = $rent_agreement_inventory = '';
        $personal_args = array(
            'url' => $this->kunstuitleen_get_previous_pageurl('my-inventory'),
            'title' => esc_html__('Persoonlijke gegevens', 'kunstuitleen-company-crm'),
            'icon' => 'fa-angle-right',
            'class' => 'h4 roboto',
            'style' => 'font-weight: bold;',
        );
        $rent_agreement_inventory = $this->kunstuitleen_anchor_url($personal_args);

        $personal_args = $personal_account_password_update = '';
        $personal_args = array(
            'url' => $this->kunstuitleen_get_previous_pageurl('edit-account'),
            'title' => esc_html__('Inloggegevens wijzigen', 'kunstuitleen-company-crm'),
            'icon' => 'fa-angle-right',
            'class' => 'h4 roboto',
            'style' => 'font-weight: 900;',
        );
        $personal_account_password_update = $this->kunstuitleen_anchor_url($personal_args);


        $payment_information_args = $payment_information_account_url = '';
        $payment_information_args = array(
            'url' => $this->kunstuitleen_get_previous_pageurl('edit-account'),
            'title' => esc_html__('Betaalgegevens', 'kunstuitleen-company-crm'),
            'icon' => 'fa-angle-right',
            'class' => 'h4 roboto',
        );
        $payment_information_account_url = $this->kunstuitleen_anchor_url($payment_information_args);
        $wp_get_current_user = $user_id = $selected_data = '';
        $wp_get_current_user = wp_get_current_user();
        $user_id = $wp_get_current_user->ID;
        $selected_data = $this->kunstuitleen_get_single_company();
        if (!empty($selected_data) && in_array('company', $wp_get_current_user->roles)) :
            $output .= '<div class="row company-details">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="details_heading">
                                        <label class="h4 roboto col-md-12"><strong>' . esc_html__('Bedrijfsgegevens', 'kunstuitleen-company-crm') . '</strong></label>
                                    </div>
                                </div>';
            foreach ($selected_data as $selected_key => $selected_val) :
                if (!empty($selected_val)) :
                    $output .= '<div class="row">';
                    switch ($selected_key):
                        case 'company_name':
                            $output .= '<label class="h5 roboto col-md-12"><strong>' . esc_html__('Bedrijfsname : ', 'kunstuitleen-company-crm') . '</strong>' . esc_html($selected_val) . '</label>';
                            break;
                        case 'house_number':
                            $output .= '<label class="h5 roboto col-md-12"><strong>' . esc_html__('Straatnaam : ', 'kunstuitleen-company-crm') . '</strong>' . esc_html($selected_val) . '</label>';
                            break;
                        case 'postal_code':
                            $output .= '<label class="h5 roboto col-md-12"><strong>' . esc_html__('Postcode : ', 'kunstuitleen-company-crm') . '</strong>' . esc_html($selected_val) . '</label>';
                            break;
                        case 'invoice_email':
                            $output .= '<label class="h5 roboto col-md-12"><strong>' . esc_html__('Email : ', 'kunstuitleen-company-crm') . '</strong>' . esc_html($selected_val) . '</label>';
                            break;
                    endswitch;
                    $output .= '</div>';
                endif;
            endforeach;
            $output .= '</div>
                        </div>';
        endif;
        if (!empty($wp_get_current_user)) :
            $user_data = array(
                'display-name' => $wp_get_current_user->display_name,
                'street-name' => get_user_meta($user_id, 'street', true),
                'postal-code' => get_user_meta($user_id, 'postcode', true),
                'city' => get_user_meta($user_id, 'city', true),
                'phone' => get_user_meta($user_id, 'phone', true),
                'email' => $wp_get_current_user->user_email,
            );
            $output .= '<div class="kunstuitleen-my-details box-shadow kunstuitleen-my-details_moblie">
            <div class="row information">
                            <div class="col-md-9">
                                <div class="information_title ">
                                    <div class="details_heading mb-3">
                                        <label class="h4" style="height: 24px;
                                        color: #2A374A;
                                        font-family: Roboto;
                                        font-size: 16px;
                                        font-weight: 500;
                                        letter-spacing: 0;
                                        line-height: 24px;"><strong>' . esc_html__('Persoonlijke gegevens', 'kunstuitleen-company-crm') . '</strong></label>
                                    </div>
                                </div>';
            foreach ($user_data as $user_data_key => $user_data_val) :
                if (!empty($user_data_val)) :
                    $output .= '<div class="row" >';
                    switch ($user_data_key):
                        case 'display-name':
                            $output .= '<label class="col-md-12" style="color: #8f9fb0; font-family: Roboto;font-size: 12px;font-weight:800;height: 16px;"> ' . esc_html($user_data_val) . ' </label>';
                            break;
                        case 'street-name':
                            $output .= '<label class="col-md-12" style="color: #8f9fb0; font-family: Roboto;font-size: 12px;font-weight: 800;height: 16px;"> ' . esc_html($user_data_val) . ' </label>';
                            break;
                        case 'postal-code':
                            $output .= '<label class="col-md-12" style="color: #8f9fb0; font-family: Roboto;font-size: 12px;font-weight: 800;height: 16px;"> ' . esc_html($user_data_val) . ' </label>';
                            break;
                        case 'city':
                            $output .= '<label class="col-md-12" style="color: #8f9fb0;font-family: Roboto;font-size: 12px;font-weight: 800;height: 16px;"> ' . esc_html($user_data_val) . ' </label>';
                            break;
                        case 'phone':
                            $output .= '<label class="col-md-12" style="color: #8f9fb0;font-family: Roboto;font-size: 12px;font-weight: 800;height: 16px;"> ' . esc_html($user_data_val) . ' </label>';
                            break;
                        case 'email':
                            $output .= '<label class="col-md-12" style="color: #8f9fb0;font-family: Roboto;font-size: 12px;font-weight: 800;height: 16px;"> ' . esc_html($user_data_val) . ' </label>';
                            break;
                    endswitch;
                    $output .= '</div>';
                endif;
            endforeach;
            $output .= '</div>
                            <div class="col-md-3 img-col">

                                <div class="row">
                                    <img class="img-responsive"style="float:bottom;" src="' . esc_url(KUCRM_COMPANY_URL . 'public/images/user2.svg') . '">
                                </div>
                            </div>
                        </div>';
        endif;
        $output .= '<div class="row desired-deatils mt-15">
                        <div class="col-md-12">
                            ';
        if (!empty($create_comany_account_url) && in_array('company', $wp_get_current_user->roles) || in_array('administrator', $wp_get_current_user->roles)) :
            $output .= '<div class="row mt-15">
                                            <div class="col-md-4">';
            $output .= $create_comany_account_url;
            $output .= '</div>
                                        </div>';
        endif;


        $output .= '</div>
            </div> 
            </div>';
        if (!empty($create_comany_account_url) && in_array('company', $wp_get_current_user->roles) || in_array('administrator', $wp_get_current_user->roles)) :
            $output .= '<div class="row box-account-management_main kunstuitleen-my-details_moblie">
                                <div class="col-md-12 box-account-management box-shadow">
                                    <div class="row account-management">
                                        <div class="col-md-9">
                                            <div class=" account-management_data">
                                                <label class="h4 roboto"><strong>' . esc_html__('Beheer van accounts', 'kunstuitleen-company-crm') . '</strong></label>
                                            </div>
                                            <div class="row mt-15">
                                                <div class="col-md-12">
                                                    <label class="col-md-12 h5 roboto"><strong class="heir_content">' . esc_html__('Heir vind je alle sub accounts om deze te kunnen beheren en aan te maken.', 'kunstuitleen-company-crm') . '</strong></label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 mt-15 Beheer_btn">
                                                    <a href="' . esc_url($url) . '" class="btn btn-default kunstuitleen-url">' . esc_html__('Beheer accounts', 'kunstuitleen-company-crm') . '<i class="fa fa-angle-right"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 grp-img-col">
                                            <div class="row">
                                                <img class="img-responsive" src="' . esc_url(KUCRM_COMPANY_URL . 'public/images/user3.svg') . '">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
        endif;
        $output .= '<div class="row box-account-management_main kunstuitleen-my-details_moblie">
                                <div class="col-md-12 box-shadow">
                                    <div class="row account-management">
                                        <div class="col-md-9 ">
                                            <div class="">
                                                <label class="h4 roboto"><strong>' . esc_html__('Account bescherming', 'kunstuitleen-company-crm') . '</strong></label>
                                            </div>
                                            <div class="row mt-15">
                                                <div class="col-md-12">
                                                    <label class="col-md-12 h5 roboto"><strong class="heir_content">' . esc_html__('Heir vind je alles om je account veilig te houden', 'kunstuitleen-company-crm') . '</strong></label>
                                                </div>
                                            </div>';
        if (!empty($personal_account_password_update)) :
            $output .= '<div class="row">
                                                <div class="col-md-12 mt-15 Beheer_btn">';
            $output .= $personal_account_password_update;
            $output .= '</div>
                                                                                    </div>';
        endif;
        $output .= '
                                        </div>
                                        <div class="col-md-3 grp-img-col">
                                            <div class="row">
                                                <img class="img-responsive" src="' . esc_url(KUCRM_COMPANY_URL . 'public/images/lock.svg') . '">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
        return $output;
    }

    /**
     * Kunstuitleen account my details create new account
     */
    public function kunstuitleen_account_my_details_create_new_account()
    {
        $output = '';
        $output .= do_shortcode('[kucrm-company-user-register-form]');
        return $output;
    }

    public function kunstuitleen_account_password_update()
    {
        $output = '';
        $output .= do_shortcode('[kucrm-account-password-update]');
        return $output;
    }

    public function kucrm_company_rent_agreement_inventory()
    {
        $output = '';
        $output .= do_shortcode('[kucrm-company-rent-agreement-inventory]');
        return $output;
    }
    /**
     * Kunstuitleen account my details manage account
     */
    public function kunstuitleen_account_my_details_manage_account()
    {
        $output = $url = $menu_link = $static_page_slug = $kunstuitleen_get_query_vars = $edit_url = $edit_menu_link = $company_id = $users = '';
        $static_page_slug = $this->kunstuitleen_page_slug();
        $kunstuitleen_get_query_vars = $this->kunstuitleen_get_query_vars();
        $menu_link = $kunstuitleen_get_query_vars . '/create-new-account/';
        $url = $this->Kunstuitleen_url($base_url = '', $menu_link, $static_page_slug);
        $edit_menu_link = $kunstuitleen_get_query_vars . '/edit-account/';
        $edit_url = $this->Kunstuitleen_url($base_url = '', $edit_menu_link, $static_page_slug);
        $company_id = get_current_user_id();
        $get_current_user = wp_get_current_user();
        $users = kucrm_get_users_by_company($company_id);
        if (in_array('company', $get_current_user->roles) || in_array('administrator', $get_current_user->roles)) :
            $output .= '<div class="row mb-30px">
                            <div class="col-md-3 create-account">
                                <a href="' . esc_url($url) . '" class="btn btn-default">' . esc_html__('Maak niew account', 'kunstuitleen-company-crm') . '<i class="fa fa-angle-right"></i></a>
                            </div>
                        </div>';
        endif;
        if (!empty($personal_information_account_url)) :
            $output .= '<div class="row">
                                                <div class="col-md-4 mt-15">';
            $output .= $personal_information_account_url;
            $output .= '</div>
                                            </div>';
        endif;
        if (!empty($users)) :
            foreach ($users as $user_key => $user_val) :
                $get_category = $cat = '';
                if (!empty($user_val['search_value']) && is_array($user_val['search_value'])) :
                    foreach ($user_val['search_value'] as $userkey => $userval) :
                        $get_category = get_term_by('id',  $userval, 'waarde');
                        $cat .= $get_category->name . ', ';
                    endforeach;
                endif;
                $output .= '<div class="row box-shadow main-col mb50px">
                                <div class="col-md-12">
                                    <div class="row">
                                        <label class="col-md-12 roboto h4"><strong>' . esc_html($user_val['department']) . '</strong></label>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-12 h5 roboto text-capitalize"><strong>' . esc_html($user_val['display_name']) . '</strong></label>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-12 h5 roboto"><strong>' . esc_html($user_val['email']) . '</strong></label>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-12 h5 roboto"><strong>2</strong></label>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-12 h5 roboto"><strong>' . esc_html(rtrim($cat, ', ')) . '</strong></label>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 manage-acount-btn">
                                            <a href="' . esc_url($edit_url . '?id=' . base64_encode($user_val['id'])) . '" class="btn btn-default roboto h4">' . esc_html__('Beheer Account', 'kunstuitleen-company-crm') . '</a>
                                        </div>
                                    </div>
                                </div>
                            </div>';
            endforeach;
        else :
            $output .= '<div class="alert alert-info" role="alert">' . esc_html__('U heeft hier geen account.', 'kunstuitleen-company-crm') . '</div>';
        endif;
        return $output;
    }

    /**
     * Kunstuitleen account my details edit account
     */
    public function kunstuitleen_account_my_details_edit_account()
    {
        $output = '';
        $output .= do_shortcode('[kucrm-company-user-register-form]');
        return $output;
    }

    public function kunstuitleen_account_rent_agreement_inventory()
    {
        $output = '';
        $output .= do_shortcode('[kucrm-company-rent-agreement-inventory]');
        return $output;
    }
    /**
     * Kunstuitleen account my details create company account
     */
    public function kunstuitleen_account_my_details_create_company_account()
    {
        $output = $prev_url = $args = $company_details = '';
        $args = array(
            'url' => $this->kunstuitleen_get_previous_pageurl(),
            'title' => esc_html__('Terug', 'kunstuitleen-company-crm'),
        );
        $prev_url = $this->kunstuitleen_anchor_url($args);
        $company_details = $this->kunstuitleen_get_single_company();
        $checked = !empty($company_details['mailing_address']) ? 'checked' : '';
        $output = '<div class="row">
                        <div class="col-md-9">
                            <form role="form" id="company-details-form" name="company-details-form">
                                <div class="form-group">
                                    <label for="bedrijfsnaam" class="h4 roboto"><strong>' . esc_html__('Bedrijfsnaam *', 'kunstuitleen-company-crm') . '</strong></label>
                                    <input type="text" class="form-control" id="bedrijfsnaam" name="company-name" value="' . esc_attr($company_details['company_name']) . '" required>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="postcode" class="h4 roboto"><strong>' . esc_html__('Postcode *', 'kunstuitleen-company-crm') . '</strong></label>
                                                    <input type="text" class="form-control" id="postcode" name="postcode" value="' . esc_attr($company_details['postal_code']) . '" required>                
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="Huisnummer" class="h4 roboto"><strong>' . esc_html__('Huisnummer *', 'kunstuitleen-company-crm') . '</strong></label>
                                                    <input type="text" class="form-control" id="Huisnummer" name="house-number" value="' . esc_attr($company_details['house_number']) . '" required>                
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="Toevoeging" class="h4 roboto"><strong>' . esc_html__('Toevoeging *', 'kunstuitleen-company-crm') . '</strong></label>
                                                    <input type="text" class="form-control" id="Toevoeging" name="addition" value="' . esc_attr($company_details['addition']) . '" required>                
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-md-12 h5 roboto sample"><strong>' . esc_html__('Straatnaam 00-00 1234 AB Plaatsnaam', 'kunstuitleen-company-crm') . '</strong></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="roboto h4 col-md-12 mailing-address"><strong>' . esc_html__('Postadres', 'kunstuitleen-company-crm') . '</strong></label>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-1 inp-check">
                                                    <input type="checkbox" class="form-control" id="mailing-address" name="mailing-address" value="' . esc_attr($company_details['mailing_address']) . '" ' . esc_attr($checked) . '>
                                                </div>
                                                <div class="col-md-11">
                                                    <label class="roboto h4">
                                                        <strong>' . esc_html__('Postadres is gelijk aan vestigingsadres', 'Postadres is gelijk aan vestigingsadres') . '</strong>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <label class="roboto h4 col-md-12" for="Telefoonnummer"><strong>' . esc_html__('Telefoonnummer *', 'kunstuitleen-company-crm') . '</strong></label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" id="Telefoonnummer" name="phone-number" value="' . esc_attr($company_details['phone_number']) . '" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="roboto h4" for="Moederbedrijf"><strong>' . esc_html__('Moederbedrijf', 'kunstuitleen-company-crm') . '</strong></label>
                                    <input type="text" class="form-control" id="Moederbedrijf" name="parent-company" value="' . esc_attr($company_details['parent_company']) . '">
                                </div>
                                <div class="form-group">
                                    <label class="roboto h4" for="factuur-email"><strong>' . esc_html__('Factuur Email', 'kunstuitleen-company-crm') . '</strong></label>
                                    <input type="text" class="form-control" id="factuur-email" name="invoice-email" value="' . esc_attr($company_details['invoice_email']) . '">
                                </div>';
        if (!empty($company_details['id'])) :
            $output .= '<input type="hidden" id="company_type" name="company_type" value="update"/>';
            $output .= '<input type="hidden" id="company_id" name="company_id" value="' . esc_attr($company_details['id']) . '"/>';
        endif;
        $output .= $prev_url;
        $output .= '<button type="submit" class="btn btn-default roboto h4" id="company-details">' . esc_html__('Wijzinging van gegevens doorgeven', 'kunstuitleen-company-crm') . '</button>
                                <img src="' . esc_url(KUCRM_COMPANY_URL . 'public/images/loading.gif') . '" class="kucrm_company_loader" style="display:none;">
                            </form>
                        </div>
                    </div>';
        return $output;
    }

    /**
     * Kunstuitleen count
     */
    public function kunstuitleen_count($args, $val)
    {
        $output = '';
        if (!empty($args)) :
            $i = 1;
            foreach ($args as $args_key => $args_val) :
                if ($args_val['status'] == $val) :
                    $output = $i;
                endif;
                $i++;
            endforeach;
        endif;
        return $output;
    }

    /**
     *  Kunstuitleen company details form ajax
     */
    public function kunstuitleen_company_details_form_ajax()
    {
        $total_fields = '';
        $form_data = array();
        parse_str($_POST['form_data'], $form_data);
        $form_data = wp_unslash($form_data);
        $data = array(
            'company-name' => esc_html__('Bedrijfsnaam', 'kunstuitleen-company-crm'),
            'postcode' => esc_html__('Postcode', 'kunstuitleen-company-crm'),
            'house-number' => esc_html__('Huisnummer', 'kunstuitleen-company-crm'),
            'addition' => esc_html__('Toevoeging', 'kunstuitleen-company-crm'),
            'phone-number' => esc_html__('Telefoonnummer', 'kunstuitleen-company-crm'),
        );
        $all_fileds = array(
            'company-name',
            'postcode',
            'house-number',
            'addition',
            'mailing-address',
            'phone-number',
            'parent-company',
            'invoice-email'
        );
        $required_fileds = array(
            'company-name',
            'postcode',
            'house-number',
            'addition',
            'phone-number',
            'invoice-email'
        );
        $total_fields = count($required_fileds);
        $data = array();
        $error = 0;
        if (!empty($form_data)) :
            foreach ($form_data as $form_key => $form_val) :
                if (in_array($form_key, $all_fileds) && !empty($form_val)) :
                    switch ($form_key):
                        case 'company-name':
                            $data[] = array(
                                'status' => 'success',
                                'field_key' => $form_key,
                                'message' => ''
                            );
                            break;
                        case 'postcode':
                            if (!preg_match("/^[0-9]+$/", $form_val)) :
                                $data[] = array(
                                    'status' => 'error',
                                    'field_key' => $form_key,
                                    'message' => esc_html__('Please enter number.', 'kunstuitleen-company-crm')
                                );
                            elseif (!preg_match("/^[0-9]{6}$/", $form_val)) :
                                $data[] = array(
                                    'status' => 'error',
                                    'field_key' => $form_key,
                                    'message' => esc_html__('Please enter six digit postcode number.', 'kunstuitleen-company-crm')
                                );
                                $error = 1;
                            else :
                                $data[] = array(
                                    'status' => 'success',
                                    'field_key' => $form_key,
                                    'message' => ''
                                );
                            endif;
                            break;
                        case 'house-number':
                            $data[] = array(
                                'status' => 'success',
                                'field_key' => $form_key,
                                'message' => ''
                            );
                            break;
                        case 'addition':
                            $data[] = array(
                                'status' => 'success',
                                'field_key' => $form_key,
                                'message' => ''
                            );
                            break;
                        case 'phone-number':
                            if (!preg_match("/^[0-9]+$/", $form_val)) :
                                $data[] = array(
                                    'status' => 'error',
                                    'field_key' => $form_key,
                                    'message' => esc_html__('Please enter number.')
                                );
                                $error = 1;
                            elseif (!preg_match("/^[0-9]{10}$/", $form_val)) :
                                $data[] = array(
                                    'status' => 'error',
                                    'field_key' => $form_key,
                                    'message' => esc_html__('Please enter 10 digit number.')
                                );
                                $error = 1;
                            else :
                                $data[] = array(
                                    'status' => 'success',
                                    'field_key' => $form_key,
                                    'message' => ''
                                );
                            endif;
                            break;
                        case 'invoice-email':
                            if (!is_email($form_val)) :
                                $data[] = array(
                                    'status' => 'error',
                                    'field_key' => $form_key,
                                    'message' => esc_html__('Please enter valid email address.')
                                );
                                $error = 1;
                            elseif (is_email($form_val)) :
                                $data[] = array(
                                    'status' => 'success',
                                    'field_key' => $form_key,
                                    'message' => ''
                                );
                            endif;
                            break;
                    endswitch;
                elseif (in_array($form_key, $all_fileds) && empty($form_val)) :
                    switch ($form_key):
                        case 'company-name':
                            $data[] = array(
                                'status' => 'error',
                                'field_key' => $form_key,
                                'message' => esc_html__('Please enter company name.')
                            );
                            $error = 1;
                            break;
                        case 'postcode':
                            $data[] = array(
                                'status' => 'error',
                                'field_key' => $form_key,
                                'message' => esc_html__('Please enter postcode number.')
                            );
                            $error = 1;
                            break;
                        case 'house-number':
                            $data[] = array(
                                'status' => 'error',
                                'field_key' => $form_key,
                                'message' => esc_html__('Please enter house number.')
                            );
                            $error = 1;
                            break;
                            /* case 'house-number':
                                $data[] = array( 'status' => 'error', 'field_key' => $form_key, 'message' => 'Please enter house number.' );
                        break;*/
                        case 'addition':
                            $data[] = array(
                                'status' => 'error',
                                'field_key' => $form_key,
                                'message' => esc_html__('Please enter addition.')
                            );
                            $error = 1;
                            break;
                            /* case 'mailing-address':
                                $data[] = array( 'status' => 'error', 'field_key' => $form_key, 'message' => 'Please enter checkthe .' );
                        break; */
                        case 'phone-number':
                            $data[] = array(
                                'status' => 'error',
                                'field_key' => $form_key,
                                'message' => esc_html__('Please enter phone number.')
                            );
                            $error = 1;
                            break;
                    /* case 'parent-company':
                                $data[] = array( 'status' => 'error', 'field_key' => $form_key, 'message' => 'Please enter parent company name.' );
                        break;*/
                    /* case 'invoice-email':
                                $data[] = array( 'status' => 'error', 'field_key' => $form_key, 'message' => 'Please enter email address.' );
                        break;*/
                    endswitch;
                endif;
            endforeach;
            if ($error == 1) :
                echo json_encode($data);
            else :
                $Kunstuitleen_Database = $table = $column = $format = $compny_id = '';
                $Kunstuitleen_Database = new Kunstuitleen_Database;
                $table = 'company_details';

                $company_name = !empty($form_data['company-name']) ? $form_data['company-name'] : '';
                $postcode = !empty($form_data['postcode']) ? $form_data['postcode'] : '';
                $house_number = !empty($form_data['house-number']) ? $form_data['house-number'] : '';
                $addition = !empty($form_data['addition']) ? $form_data['addition'] : '';
                $mailing_address = !empty($form_data['mailing-address']) ? $form_data['mailing-address'] : 'off';
                $phone_number = !empty($form_data['phone-number']) ? $form_data['phone-number'] : '';
                $parent_company = !empty($form_data['parent-company']) ? $form_data['parent-company'] : '';
                $invoice_email = !empty($form_data['invoice-email']) ? $form_data['invoice-email'] : '';
                $company_type = !empty($form_data['company_type']) ? $form_data['company_type'] : '';
                $company_id = !empty($form_data['company_id']) ? $form_data['company_id'] : '';
                $current_user = wp_get_current_user();

                $column = array(
                    'company_name' => $company_name,
                    'postal_code' => $postcode,
                    'house_number' => $house_number,
                    'addition' => $addition,
                    'mailing_address' => $mailing_address,
                    'phone_number' => $phone_number,
                    'parent_company' => $parent_company,
                    'invoice_email' => $invoice_email,
                    'status' => 0,
                );

                if ($company_type == 'update') :
                    $where = array(
                        'id' => $company_id
                    );
                    $format = array(
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%d'
                    );
                    $where_format = array(
                        '%d'
                    );
                    $compny_id_update = $Kunstuitleen_Database->kunstuitleen_update($table, $column, $where, $format, $where_format);
                    if (!is_wp_error($compny_id_update)) :
                        echo json_encode(array(
                            'status' => 'success',
                            'message' => 'Company details has been successfully updated.'
                        ));
                    else :
                        echo json_encode(array(
                            'status' => 'error',
                            'message' => 'Oops! company details not update.'
                        ));
                    endif;
                else :
                    $column['company_owner_name'] = $current_user->first_name . ' ' . $current_user->last_name;
                    $column['company_owner_id'] = $current_user->id;
                    $column['registration_date'] = date('Y-m-d H:i:s');
                    $format = array(
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%d',
                        '%s',
                        '%d',
                        '%s'
                    );
                    $compny_id = $Kunstuitleen_Database->kunstuitleen_insert($table, $column, $format);
                    if (!is_wp_error($compny_id)) :
                        echo json_encode(array(
                            'status' => 'success',
                            'message' => 'Company details has been successfully inserted.'
                        ));
                    else :
                        echo json_encode(array(
                            'status' => 'error',
                            'message' => 'Oops! Company details not inserted.'
                        ));
                    endif;
                endif;
            endif;
        endif;
        wp_die();
    }

    public function kucrm_company_artwork_ajax()
    {
        if ($_POST['colleagues_mail']) {
            $colleagues = $_POST['colleagues_mail'];
            $headers[] = 'From:' . "testing@gmail.com";
            $headers[] = "MIME-Version: 1.0";
            $headers[] = "Content-Type: text/html; charset=iso-8859-1";
            $subject = 'Mail for password reset';
            $message = '<p>Test mail </p>';
            foreach ($colleagues as $key => $email_id) {

                $sent = wp_mail($email_id, $subject, $message, $headers);

                if ($sent) {
                    echo json_encode(array(
                        'status' => 'success',
                        'message' => 'Email Send'
                    ));
                } else {
                    echo json_encode(array(
                        'status' => 'error',
                        'message' => 'Email Not Send'
                    ));
                }
            }
            //
        } else {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Please atleast check one checkbox.'
            ));
        }

        wp_die();
    }
}

/* my artworks favorite  */
if (!function_exists('kstage_favorieten_account_my_artworks')) {
    function kstage_favorieten_account_my_artworks($postsPerPage = '', $favorieten)
    {
        $posts_per_page = !empty($postsPerPage) ? $postsPerPage : -1;
        if (!empty($favorieten)) :
            $favorieten = $favorieten;
        endif;
        $the_query = new WP_Query(array(
            'post_type' => 'collectie',
            'orderby' => 'date',
            'post__in' => $favorieten,
            'order' => 'DESC',
            'posts_per_page' => $posts_per_page
        ));
        return $the_query;
    }
}
function getPrivateSavingsData()
{
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;
    $user_meta = get_user_meta($user_id, 'user_type', true);
    if (!empty($user_meta)) {
        if ($user_meta == 'private') {
            $relation_id = get_user_meta($user_id, 'relation_id', true);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://k-crm.agile-steps.com/api/private-savings-data/' . $relation_id);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);$content = trim(curl_exec($ch));
            curl_close($ch);
            return $content;
        }
    } else {
        return false;
    }
}

function getRentInventory($rent_id)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://k-crm.agile-steps.com/api/rent-agreement-inventory/' . $rent_id);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);$content = trim(curl_exec($ch));
    curl_close($ch);
    return $content;
}
function getRentAgreement()
{
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;
    $user_meta = get_user_meta($user_id, 'user_type', true);
    if (!empty($user_meta)) {
        if ($user_meta == 'company') {
            return false;
        } elseif ($user_meta == 'private') {
            $relation_id = get_user_meta($user_id, 'relation_id', true);
            return getMyRentAgreements($relation_id);
        }
    } else {
        return false;
    }
}
function getCredits()
{
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;
    $user_meta = get_user_meta($user_id, 'user_type', true);
    if (!empty($user_meta)) {
        if ($user_meta == 'company') {
            return false;
        } elseif ($user_meta == 'private') {
            $relation_id = get_user_meta($user_id, 'relation_id', true);
            return getMyCredits($relation_id);
        }
    } else {
        return false;
    }
}
function getMyCredits($relation_id)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://k-crm.agile-steps.com/api/gift-card-details/' . $relation_id);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);$content = trim(curl_exec($ch));
    curl_close($ch);
    return $content;
}
function getMyRentAgreements($relation_id)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://k-crm.agile-steps.com/api/rent-agreement-details/' . $relation_id);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);$content = trim(curl_exec($ch));
    curl_close($ch);
    return $content;
}
function getPrivateSavings()
{
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;
    $user_meta = get_user_meta($user_id, 'user_type', true);
    if (!empty($user_meta)) {
        if ($user_meta == 'private') {
            $relation_id = get_user_meta($user_id, 'relation_id', true);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://k-crm.agile-steps.com/api/private-savings/' . $relation_id);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);$content = trim(curl_exec($ch));
            curl_close($ch);
            return $content;
        }
    } else {
        return false;
    }
}
function getSaleInvoice()
{
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;
    $user_meta = get_user_meta($user_id, 'user_type', true);
    if (!empty($user_meta)) {
        if ($user_meta == 'company') {
            return getSaleInvoiceCompany();
        } elseif ($user_meta == 'private') {
            $relation_id = get_user_meta($user_id, 'relation_id', true);
            return getSaleInvoicePrivate($relation_id);
        }
    } else {
        return false;
    }
}
function getSaleInvoicePrivate($relation_id)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://k-crm.agile-steps.com/api/sale-invoice-private/' . $relation_id);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);$content = trim(curl_exec($ch));
    curl_close($ch);
    return $content;
}
function postSaleInvoicePrivate($data)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://k-crm.agile-steps.com/api/sale-invoice-private/2');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);$content = trim(curl_exec($ch));
    curl_close($ch);
    return $content;
}
function getSaleInvoiceCompany()
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://k-crm.agile-steps.com/api/sale-invoice-company/2');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);$content = trim(curl_exec($ch));
    curl_close($ch);
    return $content;
}
function getRentInvoice()
{

    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;
    $user_meta = get_user_meta($user_id, 'user_type', true);
    if (!empty($user_meta)) {
        if ($user_meta == 'company') {
            return getRentInvoiceCompany();
        } elseif ($user_meta == 'private') {
            $relation_id = get_user_meta($user_id, 'relation_id', true);
            return getRentInvoicePrivate($relation_id);
        }
    } else {
        return false;
    }
}
function getRentInvoicePrivate($relation_id)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://k-crm.agile-steps.com/api/rent-invoice-private/' . $relation_id);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);$content = trim(curl_exec($ch));
    curl_close($ch);
    return $content;
}
function getRentInvoiceCompany()
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://k-crm.agile-steps.com/api/rent-invoice-company/2');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);$content = trim(curl_exec($ch));
    curl_close($ch);
    return $content;
}
