Step : 1

Google Console Developer And Create Api With The Help Of Video.



Step : 2

Here View File Code

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function proceed(){
        var start_time2 = $('input[type="radio"]:checked').data('start_time');
        var end_time2 = $('input[type="radio"]:checked').data('end_time');

        let title = 'Harshit Chauhan';
        let start_date = '2024-03-10';
        let end_date = '2024-03-10';
        let start_time = start_time2;
        let end_time = end_time2;

        let url = `https://test.pearl-developer.com/asianbloom/google-meet/?action=create&title=${title}&startdate=${start_date}&starttime=${start_time}&enddate=${end_date}&endtime=${end_time}`;

        // // location.href = url;
        // window.open(url, '_blank');

        $.ajax({
                type: 'get',
                url: url,
                processData: false, 
                contentType: false,
                success:function(response){
                    let parse_data = JSON.parse(response);
                    window.open(parse_data.conference_link, '_blank');
                },
                error:function(response){
                    console.log(response);
                }
            });
    }
</script>



Step :- 3

Upload Json File Here Is URl 

https://test.pearl-developer.com/synchro/google-meet/

https://test.pearl-developer.com/synchro/google-meet/?action=create