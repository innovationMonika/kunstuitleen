/*
    Voorselectie / Preselection
    JS
*/

jQuery(function($){
   
   /** Countdown timer **/
if($('#countdown').length != 0){
    
    //var datetime = "2017/08/29 10:00:00";
    var datetime = countdown_datetime;

    var date1=new Date();
    var date2=new Date(datetime);
    
    if( date1 > date2 ){ 
        // Do nothing
    } else {
        // Datetime not passed, activate countdown
        $("#countdown").countdown(datetime, function(event) {
            
            // Update time
            $(this).find('.countdown.days div').text(event.strftime('%D') );
            $(this).find('.countdown.hours div').text(event.strftime('%H') );
            //$(this).find('.countdown.minutes div').text(event.strftime('%M') );
            //$(this).find('.countdown.seconds div').text(event.strftime('%S') );
   
        }).on('finish.countdown', function(){
            // On Finish
            console.log('Datum/Tijd is bereikt');
            $("#countdown").stop.countdown
        });
    
    }      
    

    
}

    
     
});