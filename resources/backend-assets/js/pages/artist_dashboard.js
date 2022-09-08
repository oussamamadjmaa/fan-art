$(function(){
    //Get latest artworks messages
    let latest_artworks_messages_div = $("#latest_artworks_messages");
    $.ajax({
        method:"GET",
        url:GLOBAL.APP_URL+"/panel/dashboard/",
        dataType:"JSON",
        cache:false,
    }).then((res) => {
        latest_artworks_messages_div.html(res.latest_artworks_messages);
    });

    $(document).on('change', '#visits_duration', function(){
        $("#durationForm").submit();
    })
})
