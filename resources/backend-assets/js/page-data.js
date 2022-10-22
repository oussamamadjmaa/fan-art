var isGettingPage = false;
var nextPageUrl = true;
var pageParams = _s.getUrlVars(['page']);

$(function () {
    _s.getItemsList();

    $(window).scroll(function () {
        if (nextPageUrl && !isGettingPage && $(window).scrollTop() + $(window).height() > $(document).height() - 60) {
            _s.getItemsList();
        }
    });
});

_s.getItemsList = function (reqParams) {
    pageParams = {...pageParams, ...reqParams };
    if (nextPageUrl && !isGettingPage && $("#page-data-list").length) {
        $(".loading-data").remove();
        $("#page-data-list").append(`<div class="py-3 text-center loading-data"><i class="fa fa-spinner fa-spin text-primary"></i></div>`);
        isGettingPage = true;
        $.ajax({
            method:"GET",
            url:GLOBAL['PAGE_URL'],
            data:pageParams,
            dataType:"JSON",
            cache:false,
        }).always(res => {
                isGettingPage = false;
        }).done((res) => {
            $(".loading-data").remove();
            if (res) {
                $("#page-data-list").append(res.data);
                // $(".items-count").text(res.total);
                nextPageUrl = res.next_page_url;
                pageParams['cursor'] = res.next_cursor;
            }
        });
    }
}
