//////////////////////////////////////////////// Google Translate In The Website //////////////////////////////////////////////




************************************ Header Code *******************************************
<li class="nav-item">
    <div id="google_translate_element"></div>
</li>





************************************ app file code ********************************************

<style>
.goog-te-combo {
    all: unset !important;
    border: 1px solid black !important;
    padding: 10px !important;
}

.skiptranslate iframe {
    visibility: hidden !important;
}
</style>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
</script>
<script>
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            includedLanguages: 'en,ar,ru,fa,tr,uz,vi,ko,hi,zh-CN,id,ms,ne', // Add the desired languages
        }, 'google_translate_element');
    }
</script>



<script>
$(document).ready(function() {          
        function printone(){
            var current_google_lang = $('.goog-te-combo').val();
            // alert(current_google_lang);           

            if(current_google_lang == 'ne'){
                $('.title').text('हामीसँग सामेल हुनुहोस् र हजारौं रोजगारहरू अन्वेषण गर्नुहोस् ! हामीसँग सामेल हुनुहोस् र हजारौं रोजगारहरू अन्वेषण गर्नुहोस्');
            }
        }
        // Set interval to call the function every second
        var intervalId = setInterval(printone, 1000);
});
</script>