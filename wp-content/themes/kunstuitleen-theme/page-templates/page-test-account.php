<?php
   /*
       Template name: Test Account
   */    
       get_header(); ?>
       <style type="text/css">@font-face {
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
li .btn:hover,.active .btn:focus{
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
    margin-left: 0;
}
.condition .h4{
    color:#9dafc2
}
.condition .col-md-10{
    border-right: 1px solid #f3f3f3;
}
#condition{
    border-bottom: 1px solid #f3f3f3;
    padding-bottom: 30px;
}
.gift-cards{
    color: #9dafc2;
}
.create-account{
    margin-top: 10px;
    float: right;
}
.create-account .btn-default{
    padding-top: 10px;
    padding-bottom: 10px;
    font-size: 18px;
    border: 0;
    color: #2a374a;
}
.fa{
    text-align: center;
    font-size: 22px;
    padding-left: 10px;
    display: inline-flex;
    align-content: stretch;
    justify-content: center;
}
.mb-30px{
    margin-bottom: 30px;
}
.box-shadow{
    -webkit-box-shadow: 0 10px 6px -6px #eaeaea;
    -moz-box-shadow: 0 10px 6px -6px #eaeaea;
    box-shadow: 0 10px 6px -6px #eaeaea;
}
.mb50px{
    margin-bottom: 50px;
}
.main-col .col-md-12 .h5{
    margin-bottom: 0;
}
.manage-acount-btn{
    margin-top: 15px;
    padding-bottom: 30px;
}
.manage-acount-btn .btn-default{
    padding-top: 10px;
    padding-bottom: 10px;
    font-size: 18px;
    border: 0;
    color: #2a374a;
    padding-left: 0;
}
.btn-default:hover, .btn-default:focus, .btn-default:active, .btn-default.active, .open>.dropdown-toggle.btn-default{
    background-color: white;
}
.btn:active, .btn.active{
    -webkit-box-shadow: none;
    box-shadow: none;
}
.btn:focus, .btn:active:focus, .btn.active:focus{
    outline: none;
}
.title{
    color: #2a374a;
}</style>
         <main class="flex-shrink-0">
        <div class="container">
            <div class="row text-center">
                <label class="h2 mr-jonas"><strong>Bedrijfsgegevens</strong></label>
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
                                    <li><a href="#" class="btn"><label class="h4 mr-jonas"><strong>Log uit</strong></label></a></li>
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
                                <label class="h4 mr-jonas"><strong>Waarde aan kunst: 00,00</strong></label>
                            </div>
                            <div class="col-md-10" id="condition">
                                <label class="h4 mr-jonas"><strong>Algemene voorwardeen</strong></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-9">
                                <?php  echo do_shortcode('[kucrm-company-user-register-form]'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
       

<?php get_footer(); ?>
