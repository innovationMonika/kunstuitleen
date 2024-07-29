<?php
/*
    Template name: My Artworks
*/    
get_header(); 
?>

<div class="my_artwork">
        <div class="container">
            <div class="row text-center">
                <label class="h2 mr-jonas title"><strong>Mijn kunstwerken</strong></label>
            </div>
            <div class="row" style="margin-top: 40px;">
                <div class="col-md-12">
					<?php include( locate_template( 'inc/account_sidebar.php', false, false )); ?>
                    <div class="col-md-9 main">
                        <div class="row flex">
                            <div class="col-md-9 mb-30px">
                                <input type="text" class="form-control search" placeholder="&#xF002;  Zoek naar eerder geselecteerde kunst...">
                            </div>
                            <div class="col-md-3 align-self-center">
                                <button type="button" class="btn btn-default search-btn">Kies niew kunst<i class="fa fa-angle-right"></i></button>
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
                                    </div>
                                </div>
                                <div class="row current-artworks-headings">
                                    <label class="h4 mr-jonas col-md-12 per-month"><strong>Total per maand € 00,00</strong></label>
                                </div>
                                <div class="row content d-lg-flex">
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
                                            <img class="img-responsive" src="/wp-content/uploads/2021/07/large60427.jpg">
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
                    </div>
                </div>
            </div>
        </div>
	
	
        <div class="modal fade" id="share-collegue" tabindex="-1" role="dialog" aria-labelledby="share-collegueLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body modal-collegue" id="modal-collegue">
                        <div class="row" id="send-request">
                            <label class="h3 col-md-12 mr-jonas form-title"><strong>Deel met collega's</strong></label>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="h4 mr-jonas title">De link wordt prive gedeeld met alleen je gedeelde collega die bekend staan in het account. Je collega's kunnen zo huin eigen kunstwerk kiezen van de door jou voorgeselecteerde favorieten</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 select-box">
                                <select id="boot-multiselect-demo" class="form-control" multiple="multiple">
                                    <option value="kees@email.com" class="form-control">kees@email.com</option>
                                    <option value="kelvin@email.com" class="form-control">kelvin@email.com</option>
                                    <option value="leon@email.com" class="form-control">leon@email.com</option>
                                    <option value="collega.4@email.com" class="form-control">collega.4@email.com</option>
                                </select>
                            </div>
                        </div>
                        <div class="row" id="send-request">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-info btn-block btn-round part mr-jonas">Deel</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body confirm" id="modal-collegue">
                        <div class="row">
                            <label class="h3 col-md-12 mr-jonas form-title"><strong>Link is succesvol gedeeld</strong></label>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="h4 mr-jonas title">De link wordt prive gedeeld met alleen je gedeelde collega die bekend staan in het account. Je collega's kunnen zo huin eigen kunstwerk kiezen van de door jou voorgeselecteerde favorieten</label>
                            </div>
                        </div>
                        <div class="row text-center img-checked">
                            <img src="images/icons8-checked.svg" class="img-responsive checked">
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-info btn-block btn-round mr-jonas" id="close" data-dismiss="modal">Sluit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="delete-share" tabindex="-1" role="dialog" aria-labelledby="delete-shareLabel" aria-hidden="true">
            <div class="modal-dialog" style="width: 480px;">
                <div class="modal-content">
                    <div class="modal-body delete-share-body">
                        <div class="row">
                            <div class="col-md-12">
                                <img class="img-responsive icon-trash" src="images/icons8-trash-208.png">
                                <label class="mr-jonas h4 delete-title">Weet je zeker dat het wilt verwijderen</label>
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            </div>
                        </div>
                        <div class="row">
                            <p>Het kunstwerk zal uit je collectie worden verwijderen</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger">Ja Verwijder</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal" id="cancel">Annuleer</button>
                      </div>
                </div>
            </div>
        </div>
	</div>

<?php get_footer(); ?>