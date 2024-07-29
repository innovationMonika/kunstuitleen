<html>
    <head>
        <style>
      
            @page {
                margin-left:1.3cm;
                margin-right:1.3cm;
                margin-bottom: 0;
                margin-top: 1.3cm;
            }
            
            body {
                font-family: mrjonesbook, serif;
                font-size: 14pt;
            }
            
            p {
                font-size: 17pt;
                line-height: 18pt;
                margin: 0;
            }
            
            a { 
                color: #be2a53; 
            }
            
            .container {
                width: 100%;
            }
            
                .container::after {
                    content: '';
                    clear: both;
                    display: block;                    
                }
                
            .f-left {
               float: left; 
            }
            
            .f-right {
                float: right;
            }
            
            .logo-container {
                width: 50mm;
            }
            
                .logo {
                    width: 50mm;
                }
                
            .slogan-container {
                font-size: 32pt;
                line-height: 50pt;
                font-family: nikaia, serif;
                text-align: right;
                position: relative;
                padding-left: 10mm;
                padding-right: 5mm;
                text-transform: uppercase;
                width: 204.4mm;
            }
            
            .gift-container {
                background-image: url('<?php echo $url; ?>/wp-content/themes/kunstuitleen/static/images/pdf/pdf-kadobon-bg.svg');
                background-position: center center;
                background-repeat: no-repeat;
                margin-top: -9mm;
                height: 158mm;
                position: relative;
            }
            
                .gift-inner-container {
                    padding: 15mm 12mm 5mm 12mm;
                    width: 100%;
                }
            
                .gift-content-container {
                    height: 125mm;
                    width: 140mm;
                    position: relative;
                }
                
                    .gift-content {
                        height: 80mm;
                        position: absolute;
                        top: 6.25cm;
                        left: 2.5cm;
                        width: 140mm;
                        
                    }
                
                    .gift-data {
                        border: 1pt solid #000;
                        color: #575756;
                        position: absolute;
                        left: 2.5cm;
                        bottom: 2.2cm;
                        width: 100mm;
                    }
                    
                        .gift-meta {
                            background-color: #000;
                            color: #e0bb47;
                            font-family: nikaia, serif;
                            font-size: 12pt;
                            padding: 4mm;
                        }

                        .gift-meta {
                            color: #b0d8ec;
                        }
                        
                            .gift-meta span {
                                text-transform: uppercase;
                            }
                            
                        .gift-contact {
                            padding: 4mm;
                        }
                        
                    .gift-photo {
                        margin-top: -24mm;
                        text-align: right;
                        width: 100mm;
                    }
                    
                .gift-price,
                .price-bg {
                    position: absolute;
                    bottom: 1.34cm;
                    right: 1.33cm;
                    z-index: 999;
                }
                    
                    .price-data {
                        background-color: red;
                        position: absolute;
                        top: 0;
                        left: 0;
                    }
            
            
        </style>
    </head>
    <body>
        
        <div class="container">
            <div class="logo-container f-left">
                <img src="<?php echo $url; ?>/wp-content/themes/kunstuitleen/static/images/pdf/kunstuitleen.svg" class="logo" />
            </div>
            <div class="slogan-container f-right">
                Serving the art of inspiration
            </div>
        </div>
        
        <div class="container gift-container">
            <div class="gift-inner-container">
                <div class="gift-content-container f-left"><!-- EMPTY --></div>
                <div class="gift-photo f-right">
                    <img src="<?php echo $url; ?>/wp-content/themes/kunstuitleen/static/images/pdf/pdf-foto-pand.png" style="width: 92mm;  position: relative; z-index: 0;" />
                </div>
            </div>
        </div>
        
        <div class="gift-content">
            <br/><?php echo str_replace('</p>', '</p><br/>', $kadobon['message']); ?>
        </div>
        
        <div class="gift-data">
            <div class="gift-meta <?= $kadobon['web_variant'] ?>">
                <span>Geldig t/m <?php echo $kadobon['end_date']; ?></span><br/>
                <em>Bonnummer:</em> <?php echo $kadobon['bonnummer']; ?>
            </div>
            <div class="gift-contact">
                Wij zijn gevestigd in Amsterdam Art Center<br/>Donauweg 23 - 1043 AJ Amsterdam
            </div>
        </div>
        
        <div class="price-bg">
            <img src="<?php echo $path . '/wp-content/themes/kunstuitleen/static/images/pdf/pdf-kadobon-price-bg-' . $kadobon['web_variant'] . '.png'; ?>" style="height: auto; width: 143mm;" />
        </div>
        
        <div class="gift-price">
            <?php include( $path . '/wp-content/themes/kunstuitleen/static/images/pdf/pdf-kadobon-price-' . $kadobon['web_variant'] . '.svg'); ?>
        </div>
        
    
    </body>
</html>