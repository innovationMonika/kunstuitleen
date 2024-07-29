<?php
   /*
       Template name: Test
   */    
       get_header();?>
       <style type="text/css">
          @font-face {
    font-family: 'MrJones-Book';
    src: url(../mr_jones/Mr_Jones/MrJonesBook.ttf);
}
.margin-top{
    margin-top: 6rem;
}
.cinzel{
    font-family: 'Cinzel', serif;
}
.mr-jonas{
    font-family: "MrJones-Book", sans-serif;
}
ul{
    padding-inline-start: 2px;
   list-style: none;
}
li {
    border-left: 2px solid #e9f4ff;
    padding-left: 10px;
    margin-bottom: 15px;
}
li a{
    color: #2a374a;
}
li a label{
    cursor: pointer;
}
.active{
    background-color: #e9f4ff;
    color: #607ff2;
    border-left: 2px solid #607ff2;
    border-radius: 0 30px 30px 0;
}
.active a{
    color: #607ff2;
}
li:hover{
    background-color: #e9f4ff;
    color: #607ff2;
    border-left: 2px solid #607ff2;
    border-radius: 0 30px 30px 0;
}
li .btn:hover, li .btn:focus ,li a:hover{
    color: #607ff2;
}
.main{
    margin-top: 40px;
}
.main .h4{
    color: #2a374a;
}
.condition{
    border-left: 1px solid #f3f3f3;
    margin-top: 30px;
    border-top: 0;
}
.condition .h4{
    color:#9dafc2
}
.condition .col-md-10{
    border-right: 1px solid #f3f3f3;
    padding-left: 30px;
}
#condition{
    border-bottom: 1px solid #f3f3f3;
    padding-bottom: 30px;
}
.gift-cards{
    color: #9dafc2;
}
.mailing-address{
    padding-left: 0;
}
.ps-0{
    padding-left: 0;
}
.form-control{
    height: 45px;
    font-size: 18px;
    border: 1px solid #e1e8f1;
    color: #2a374a;
    background-color: #f6fafc;
    box-shadow: none;
    font-weight: bold;
    font-family: 'MrJones-Book',sans-serif;
}
.sample{
    padding-top: 15px;
}
.mail-address .h4{
    margin-bottom: 0;
}
.form-group{
    margin-bottom: 20px;
}
input[type="checkbox"]{
    height: 30px;
    width: 30px;
    border: 2px solid #e1e8f1 !important;
    outline: 1px solid #e1e8f1;
    outline-offset: -1px;
}
.inp-check{
    padding-right: 0;
}
form .h4, .h5{
    color:#344052;
}
form .btn-primary{
    width: 100px;
    color: white;
    background-color: #607ff2;
    margin-right: 14px;
    border-color: #607ff2;
    padding-top: 10px;
    padding-bottom: 10px;
    font-size: 18px;
}
.btn-primary .h4{
    color: white;
}
form .btn-default{
    border-color: #607ff2;
    font-weight: bold;
    color: #607ff2;
    padding-top: 10px;
    padding-bottom: 10px;
    font-size: 18px;
}
.form-control:focus{
    border-color: #e1e8f1;
    -webkit-box-shadow: none;
    box-shadow: none;
}
.btn-primary:hover, .btn-primary:focus, .btn-primary:active, .btn-primary.active, .open>.dropdown-toggle.btn-primary{
    background-color: #607ff2;
    border-color: #607ff2;
}
.btn:focus, .btn:active:focus, .btn.active:focus{
    outline: none;
}
.btn:active, .btn.active{
    -webkit-box-shadow: none;
    box-shadow: none;
}
.btn-default:hover, .btn-default:focus, .btn-default:active, .btn-default.active, .open>.dropdown-toggle.btn-default{
    background-color: white;
    border: 1px solid #607ff2;
    color: #607ff2;
}
.btn:focus, .btn:active:focus, .btn.active:focus{
    -webkit-box-shadow: none;
    box-shadow: none;
}
input[type=checkbox]:focus{
    outline: 1px solid #e1e8f1;
    outline-offset: -1px;
}
.form-control [type=checkbox]:focus{
    outline: 1px solid #e1e8f1;
    outline-offset: -1px;
}
.btn-default .h4, .btn-primary .h4{
    cursor: pointer;
}
input:-webkit-autofill,
input:-webkit-autofill:hover, 
input:-webkit-autofill:focus,
textarea:-webkit-autofill,
textarea:-webkit-autofill:hover,
textarea:-webkit-autofill:focus,
select:-webkit-autofill,
select:-webkit-autofill:hover,
select:-webkit-autofill:focus {
    font-family: 'MrJones-Book',sans-serif;
    border: 1px solid #e1e8f1;
    -webkit-text-fill-color: #2a374a;
    transition: background-color 5000s ease-in-out 0s;
}
       </style>
        <main class="flex-shrink-0">
        <div class="container">
            <div class="row text-center">
                <label class="h2 mr-jonas text-capitalize title"><strong>Beheer van accounts</strong></label>
            </div>
            <div class="row" style="margin-top: 40px;">
                <div class="col-md-12">
                    <div class="col-md-3" style="padding-right: 30px;">
                        <div class="row">
                            <div class="col-md-12">
                                <ul>
                                    <li><a href="#" class="btn"><label class="h4 mr-jonas"><strong>Accountoverzicht</strong></label></a></li>
                                    <li><a href="#" class="btn"><label class="h4 mr-jonas"><strong>Mijn kunstwerken</strong></label></a></li>
                                    <li><a href="#" class="btn"><label class="h4 mr-jonas"><strong>Mijn tegoeden</strong></label></a></li>
                                    <li><a href="#" class="btn"><label class="h4 mr-jonas"><strong>Mijn aankoopfacturen</strong></label></a></li>
                                    <li><a href="#" class="btn"><label class="h4 mr-jonas"><strong>Mijn huurfacturen</strong></label></a></li>
                                    <li class="active"><a href="#" class="btn"><label class="h4 mr-jonas"><strong>Mijn gegevens</strong></label></a></li>
                                    <li><a href="#" class="btn"><label class="h4 mr-jonas"><strong>Uitloggen</strong></label></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="row condition">
                            <div class="col-md-10">
                                <label class="h4 mr-jonas"><strong>Contract 0000</strong></label>
                            </div>
                            <div class="col-md-10">
                                <label class="h4 mr-jonas"><strong>Contract Type 1</strong></label>
                            </div>
                            <div class="col-md-10">
                                <label class="h4 mr-jonas"><strong>Aantal kunstwerken: 0</strong></label>
                            </div>
                            <div class="col-md-10">
                                <label class="h4 mr-jonas"><strong>Waarde aan kunst:   € 00,00</strong></label>
                            </div>
                            <div class="col-md-10  box-shadow" id="condition">
                                <label class="h4 mr-jonas"><strong>Algemene voorwardeen</strong></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row mb-30px">
                           
                            <div class="col-md-3 create-account">
                                <a href="http://localhost/rohit/kstage/test-account/" class="btn btn-default"><strong class="mr-jonas">Maak niew account<i class="fa fa-angle-right"></i></strong></label></a>
                            </div>
                        </div>
                         <?php 
                            $company_id = get_current_user_id();

                           $users =  kucrm_get_users_by_company($company_id); 
                         // echo "<pre>"; print_r($users);
                           foreach ($users as $key => $user_data) {
                               
                           $user_id = $user_data['id'];
                          
                           
                           $user_data['user_status'];
                           $user_data['department'];
                           
                           
                            ?>
                        <div class="row box-shadow main-col mb50px">
                            <div class="col-md-12">
                                <div class="row">
                                    <label class="col-md-12 mr-jonas h4"><strong>Afdeling 1</strong></label>
                                </div>
                                <div class="row">
                                    <label class="col-md-12 h5 mr-jonas text-capitalize"><strong><?php echo $user_data['display_name']; ?></strong></label>
                                </div>
                                <div class="row">
                                    <label class="col-md-12 h5 mr-jonas"><strong><?php echo $user_data['email']; ?></strong></label>
                                </div>
                                <div class="row">
                                    <label class="col-md-12 h5 mr-jonas"><strong>2</strong></label>
                                </div>
                                <div class="row">
                                    <label class="col-md-12 h5 mr-jonas"><strong><?php echo $user_data['search_value']; ?></strong></label>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 manage-acount-btn">
                                        <a href="http://localhost/rohit/kstage/test-account?id=<?php echo $user_id; ?>" class="btn btn-default mr-jonas h4" target="_blank" ><strong>Beheer account</strong><i class="fa fa-angle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                       <?php } ?>
                 <!--        <div class="row box-shadow main-col mb50px">
                            <div class="col-md-12">
                                <div class="row">
                                    <label class="col-md-12 mr-jonas h4"><strong>Afdeling 2</strong></label>
                                </div>
                                <div class="row">
                                    <label class="col-md-12 h5 mr-jonas text-capitalize"><strong>Leon Put</strong></label>
                                </div>
                                <div class="row">
                                    <label class="col-md-12 h5 mr-jonas"><strong>leon@email.com</strong></label>
                                </div>
                                <div class="row">
                                    <label class="col-md-12 h5 mr-jonas"><strong>Kamer 2</strong></label>
                                </div>
                                <div class="row">
                                    <label class="col-md-12 h5 mr-jonas"><strong>B waarde kunstwerk tussen € 575 en € 1024</strong></label>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 manage-acount-btn">
                                        <button class="btn btn-default h4 mr-jonas" type="button"><strong>Beheer account</strong><i class="fa fa-angle-right"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </main>
       

<?php get_footer(); ?>