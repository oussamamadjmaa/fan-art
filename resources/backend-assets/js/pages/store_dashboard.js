$(function(){
    //Get latest products messages
    let latest_products_messages_div = $("#latest_products_messages");
    $.ajax({
        method:"GET",
        url:GLOBAL.APP_URL+"/panel/dashboard/",
        dataType:"JSON",
        cache:false,
    }).then((res) => {
        latest_products_messages_div.html(res.latest_products_messages);
    });

    $(document).on('change', '#visits_duration', function(){
        $("#durationForm").submit();
    })
})
