$(function(){/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)||$("#product_img_01").ezPlus({scrollZoom:!0,tint:!0,tintColour:"#000",tintOpacity:.5}),$(document).on("submit","#product_message_form",function(e){if(e.preventDefault(),!_s.validateForm(this))return!1;let i=$(this).serialize(),a=$(this).data("action");$.ajax({method:"POST",data:i,url:a,dataType:"JSON"}).always(t=>{$(this).find("#send_btn").prop("disabled",!1)}).done(t=>{$(this).trigger("reset"),$("#productContactModal").modal("hide"),window.Swal.fire({icon:"success",text:t.message,confirmButtonText:GLOBAL.LANG=="ar"?"\u0625\u063A\u0644\u0627\u0642":"Close"})}).fail(t=>{_s.handleFailure(t,this)})})});