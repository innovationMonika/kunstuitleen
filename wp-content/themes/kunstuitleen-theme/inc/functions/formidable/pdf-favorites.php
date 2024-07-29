<html>
    <head>
        <style>
      
            @page {
              margin-left:1.3cm;
              margin-right:1.3cm;
              margin-bottom: 2cm;
              margin-top: 67.5mm;
              header: html_myheader;
              footer: html_myfooter;
            }
                
            a { color: #be2a53; }
            body {
                font-family: Verdana, sans-serif;
                font-size:9pt;
            }
            td { vertical-align: top; }
        </style>
    </head>
    <body>
    
    
    <htmlpageheader name="myheader">
    
        <table width="100%">
            <tr>
                <td width="50%">
                   <img src="http://kunstuitleen.nl/wp-content/themes/kunstuitleen/static/images/pdf/kunstuitleen.svg" />
                </td>
                <td width="50%" align="right" style="text-align:right;">
                    <img src="http://kunstuitleen.nl/wp-content/themes/kunstuitleen/static/images/pdf/slogan-<?php echo $cookieWebVariant; ?>.svg" />
                </td>
            </tr>
        </table>
        
        <div style="padding-top:2.5mm; width: 100%;">
        
            <table width="100%">
                <tr>
                    <td width="78%" style="color:#ee2920;font-size:26pt;font-family:Palatino, serif;text-transform:uppercase;">
                        Aanvraag van Uw selectie
                    </td>
                    <td width="22%" style="font-size:8pt;line-height:17pt;text-align:right;" valign="middle">
                        Pagina {PAGENO} - {nb}
                    </td>
                </tr>
            </table>
            
        </div>
  
        <?php if( $cookieWebVariant == 'werk' ): // Werk ?>
        
            <table width="100%">
                <tr>
                    <td width="70%" style="font-size:8pt;line-height:17pt;">
                        <?php if( $post_type !=  'preselect_collection' ): ?>Indien beschikbaar blijven deze kunstwerken maximaal 2 weken voor u gereserveerd.<br/><?php endif; ?>
                            
                            <span style="color:#ee2920;">Geselecteerde waarden:  
                                <?php $w = 0; $total = count($waardes); foreach($waardes as $waarde){
                                    if( ${'waarde_'.$waarde->slug} > 0 ) {
                                        $letter = strtoupper($waarde->slug);
                                        
                                        if( $letter == 'X' ){ $letter = 'XL'; }
                                        
                                        echo $letter . ' x ' . ${'waarde_'.$waarde->slug};
                                        
                                        if( $total != 0 && $w < count( ${'waarde_'.$waarde->slug} ) ){ echo '  |  '; }
                                        $w++;
                                    }
                                } ?>
                            </span>
                    
                    </td>
                    <td width="30%" valign="middle" style="text-align: right;">
                        <?php if( $post_type !=  'preselect_collection' ): ?>
                        <table cellpadding="10" width="100%" style="background-color:#ee2920;color:#FFF;font-size:10pt;text-align:center;"><tr><td style="font-weight:bold;font-family:"Trebuchet MS", sans-serif;">
                            VAN <?php echo strtoupper( date_i18n('M \'d', strtotime( date('Ymd') ) ) ) . ' T/M ' . strtoupper( date_i18n( 'M \'d', strtotime('+2 weeks') ) ); ?>
                        </td><tr></table>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
            
        <?php else: // Thuis ?>
            
             <table width="100%">
                <tr>
                    <td width="70%" style="font-size:8pt;line-height:17pt;">
                        Dank voor je bezoek aan KUNSTUITLEEN.NL. Hieronder tref je de selectie aan van jouw favoriete kunstwerken. We komen ze snel laten zien bij je thuis. Ik bel je even voor een afspraak.
                    </td>
                    <td width="30%" valign="middle" style="text-align: right;"></td>
                </tr>
            </table>
            
        <?php endif; ?>
            
        </div>
    
    </htmlpageheader>
    
    <htmlpagefooter name="myfooter">
        <div style="background-color:#000;color:#FFF;font-size: 9pt; text-align: center; padding: 5mm; width: 100%; ">
            KUNSTUITLEEN.NL  |  Donauweg 23  |  1043 AJ Amsterdam  |  +31 (0) 20 624 11 24  |  <?php echo $emailaddress; ?>
        </div>
    </htmlpagefooter>
    
    <sethtmlpageheader name="myheader" value="on" page="ALL" />
    
    <?php if( $favorieten ){ ?>
        <?php $f = 0; $a = 0; ?>
        <?php 
        
        $the_query = new WP_Query( array(
            'post_type' => $post_type, 
            'orderby' => 'date', 
            'post__in' => $favorieten,
            'order' => 'DESC', 
            'posts_per_page' => '20') 
        ); 
        
        ?>
        
        <?php $totalart = $the_query->found_posts; ?>
                                
        <?php if ( $the_query->have_posts() ) {	while ( $the_query->have_posts() ) { $the_query->the_post(); $f++; $a++; ?>
            <?php $technieken = get_the_terms( $post->ID, 'techniek' ); ?>
            <?php $waarden = get_the_terms( $post->ID, 'waarde' ); ?>
            
            <?php $image = get_field('art_image'); ?>
            
            <div style="background-image:url('http://kunstuitleen.nl/wp-content/themes/kunstuitleen/static/images/pdf/pdfart-bg.svg');background-repeat:no-repeat;background-position: left bottom;border-top:0.5px solid #d0d0d0;margin-bottom:5mm;padding:6mm 10mm;position:relative;height:120px;min-height:120px;max-height:120px;width: 100%;">
                <table width="100%">
                    <tr>
                        <td style="text-align:center;" width="30%">
                            <div style="height:100px;">
                                <p style="font-family:Palatino, serif;font-size:18pt;line-height:12pt;">
                                    <span style="color:#ee2920;">#<?php echo $a; ?></span><br/>
                                    <?php echo substr(get_the_title(), 0, 30); ?>
                                </p>
                            </div><br/>
                            <p style="text-transform:uppercase;font-family:"Trebuchet MS", sans-serif;font-size:12pt;"><?php get_field('art_kunstenaar_name'); ?></p>
                        </td>
                        <td style="text-align:center;font-family:"Trebuchet MS", sans-serif;font-size:8pt;" width="30%">
                            Techniek: <?php echo $technieken[0]->name; ?><br/><br/>
                            
                            <?php if( $cookieWebVariant == 'werk' ): // Werk ?>
                                Waarde: <?php echo strtoupper($waarden[0]->slug); ?><br/><br/>
                            <?php else: ?>
                                Maandbedrag: &euro; <?php echo get_field('art_maandprijs'); ?><br/><em>(waarvan 50% spaartegoed)</em><br/><br/>
                            <?php endif; ?>
                            
                            Formaat: <?php echo get_field('art_lijstafmeting'); ?><br/><br/>
                            Nummer: <?php echo get_field('art_inventnr'); ?><br/>
                        </td>
                        <td style="text-align:right;" width="40%">
                            <img src="<?php echo $image; ?>" alt="<?php the_title(); ?>" style="height:125px;max-width:100%;width:auto;" />
                        </td>
                    </tr>
                </table>
                
            </div>
            
            
            <?php if( $f == 4 && $a < $totalart ) { echo '<pagebreak />'; $f = 1; } ?>
        <?php } /* endwhile */ } /* endif */ wp_reset_postdata(); /* Restore original Post Data */ ?>
        
        <?php if( $totalart > 2 && $totalart < 5 ){ echo '<pagebreak />'; } ?>
    
    <?php } ?>
    
    </body>
</html>