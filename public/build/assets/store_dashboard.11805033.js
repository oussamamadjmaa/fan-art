$(function(){let t=$("#latest_products_messages");$.ajax({method:"GET",url:GLOBAL.APP_URL+"/panel/dashboard/",dataType:"JSON",cache:!1}).then(s=>{t.html(s.latest_products_messages)}),$(document).on("change","#visits_duration",function(){$("#durationForm").submit()})});