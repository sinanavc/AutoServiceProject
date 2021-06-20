let origin 	     = window.location.origin + "/autoservice";
let loaderButton = `<div class="spinner-border" role="status"><span class="sr-only"></span></div>`;

$(".cars").on("change",function(e){
	let carId = $(this).val();
	if (carId) {
      $.ajax({
        url:origin+"/service/data",
        type:"POST",
        dataType:"json",
        data:{"id":carId,"type":"getCarModels"},
        success:function(result){
          if(result.success){
          	$(".car-models").html(result.theme)
          }else if(result.error) {
            getNotification("error",result.error);
          }
        },
        error:function(xqr){
        },
        complete:function(){
        }
      });
	}
	e.preventDefault();
});

$(".repair-types").on("change",function(e){
	let typeId       = $(this).val();
  let repairDate   = $("#repairDate").val();
	if (typeId) {
      $.ajax({
        url:origin+"/service/data",
        type:"POST",
        dataType:"json",
        data:{"id":typeId,"repairDate":repairDate,"type":"getRepairPlace"},
        success:function(result){
          if(result.success){
          	$(".repair-place").html(result.theme)
          }else if(result.error) {
            getNotification("error",result.error);
          }
        },
        error:function(xqr){
        },
        complete:function(){
        }
      });
	}
	e.preventDefault();
});

$(".add-request").on("click",function(e){
	let formData = $("#service-request-form").serialize()
	if (formData) {
		var btn  = $(this);
		var html = btn.html();
		btn.html(loaderButton);
		btn.prop("disabled", !0);
	    $.ajax({
          url: origin+"/service/data",
          type: "POST",
          data: formData,
          dataType: "json",
          success: function (result) {
            if(result.success){
            	getNotification('success',result.success);
            	$("form").trigger("reset");
            }else {
            	getNotification('error',result.error);
            }
          },
          error: function (xqr) {},
          complete: function () {
          	btn.html(html)
			btn.prop("disabled", false);
          },
        });

	}
	e.preventDefault();
});

$(function() {
	$( "#repairDate" ).datepicker({
		dateFormat: 'yy-mm-dd'
		});
});

function getNotification(type,title){
	const Toast = Swal.mixin({
	  toast: true,
	  position: 'top-end',
	  showConfirmButton: false,
	  timer: 3500,
	  timerProgressBar: true,
	  didOpen: (toast) => {
	    toast.addEventListener('mouseenter', Swal.stopTimer)
	    toast.addEventListener('mouseleave', Swal.resumeTimer)
	  }
	})

	Toast.fire({
	  icon: type,
	  title: title
	})
}