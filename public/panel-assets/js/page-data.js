var isGettingPage = false;
var nextPageUrl = true;
var pageParams = getUrlVars(['page']);

$(function () {
    getItemsList();

    $(window).scroll(function () {
        if (nextPageUrl && !isGettingPage && $(window).scrollTop() + $(window).height() > $(document).height() - 60) {
            getItemsList();
        }
    });
});

getItemsList = function (reqParams) {
    pageParams = {...pageParams, ...reqParams };
    if (nextPageUrl && !isGettingPage) {
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

loadDepartments = function (target) {
    $.get(GLOBAL['APP_URL'] + "/data/departments")
        .done(res => {
            putSelectData(res.data || {}, target);
            let selectOfficeTarget = $(target).data('select-office') || false;
            if (selectOfficeTarget) {
                loadDepartmentOffices($(target).val(), selectOfficeTarget);
                $(target).change(function () {
                    loadDepartmentOffices($(this).val(), selectOfficeTarget);
                });
            }
        });
}
loadDepartmentOffices = function (departmentId, target) {
    $.get(GLOBAL['APP_URL'] + "/data/department_offices/" + departmentId)
        .done(res => {
            putSelectData(res.data || {}, target);
        });
    let selectSchoolTarget = $(target).data('select-school') || false;
    if (selectSchoolTarget) {
        loadDepartmentOffices($(target).val(), selectSchoolTarget);
        $(target).change(function () {
            loadDepartmentOffices($(this).val(), selectSchoolTarget);
        });
    }
}

loadOfficeSchools = function (officeId, target) {
    $.get(GLOBAL['APP_URL'] + "/office_schools/" + officeId)
        .done(res => {
            putSelectData(res.data || {}, target);
        });
}
