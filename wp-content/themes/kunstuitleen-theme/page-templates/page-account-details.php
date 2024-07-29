<?php
/*
    Template name: Account - Details
*/    
get_header(); 
?>

        <div class="container mb-30px">
            <div class="row text-center">
                <label class="h2 mr-jonas title"><strong>Accountoverzicht</strong></label>
            </div>
            <div class="row main_account" style="margin-top: 40px;">
                <div class="col-md-12">
                    
					<?php include( locate_template( 'inc/account_sidebar.php', false, false )); ?>
					
                    <div class="col-md-9 main">
                        <div class="row">
                            <label class="h4 mr-jonas"><strong>Mijn huidige kunstwerken</strong></label>
                        </div>
                        <div class="row current-artworks-headings">
                            <label class="h4 mr-jonas per-month"><strong>Total per maand € 00,00</strong></label>
                        </div>
                        <div class="row content d-lg-flex my-details">
                            <div class="col-md-4 img-view">
                                <div class="row">
                                    <img class="img-responsive" src="/wp-content/uploads/2021/07/large46121.jpg">
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
                                                    <img src="/wp-content/uploads/2021/07/6121218.png" class="img-responsive">
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
                                            <th scope="row" class="mr-jonas"><a href="#"><img class="img-responsive pdf" src="/wp-content/uploads/2021/07/icons8-pdf-64.png">0000</a></th>
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
                                            <th scope="row" class="mr-jonas"><a href="#"><img class="img-responsive pdf" src="/wp-content/uploads/2021/07/icons8-pdf-64.png">0000</a></th>
                                            <td class="mr-jonas"><strong>01-06-2020</strong></td>
                                            <td class="mr-jonas"><strong>€ 00,00</strong></td>
                                            <td class="mr-jonas"><strong>01-07-2020</strong></td>
                                            <td class="mr-jonas"><strong><i class="fa fa-check"></i>Geincasseerd</strong></td>
                                            <td class="mr-jonas"><strong>Details<i class="fa fa-sign-in"></i></strong></td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="mr-jonas"><a href="#"><img class="img-responsive pdf" src="/wp-content/uploads/2021/07/icons8-pdf-64.png">0000</a></th>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
											
<?php get_footer(); ?>