$("#leadtable").DataTable({dom:"Bfrtip",buttons:["excelHtml5","csvHtml5","pdfHtml5"],sorting:!1,oLanguage:{sSearch:"Quick Search "}});$(".datepicker").datetimepicker({format:date_format,timepicker:!1});$("#bulkForm").submit(function(e){e.preventDefault();let a=[];if($(".checkme:checked").each((e,t)=>{a.push(t.getAttribute("value"))}),0===a.length)return alert("Select leads to perform bulk action."),!1;$(".loading").show(),$.ajax({url:base_url+"lead/bulk_a",type:"POST",data:{status:$("#bstatus").val(),agent:$("#agent").val(),leads:a},success:function(e){data=JSON.parse(e),"success"==data.data?($("#load-success").show(),setTimeout(()=>{$(".loading").hide(),$("#load-success").hide()},1e3),location.reload()):(alert("Something went wrong!"),$(".loading").hide())}})});$(".progress").hide(),$("#uploadfile").submit(function(e){e.preventDefault();let a=document.getElementById("uploadfile"),t=new FormData(a);""==$("#upload_file").val()?$("#uerror").html("Please choose a file to upload!"):($("#uerror").html(""),$(".loading").show(),$.ajax({xhr:function(){var e=new window.XMLHttpRequest;return e.upload.addEventListener("progress",function(e){if(e.lengthComputable){$(".progress").show();var a=e.loaded/e.total*100;$(".progress-bar").width(a+"%"),$(".progress-bar").html(a+"%")}},!1),e},url:base_url+"lead/attach_doc",type:"POST",data:t,processData:!1,contentType:!1,beforeSend:function(){$(".progress-bar").width("0%"),$(".progress").hide()},success:function(e){data=JSON.parse(e),"success"==data.data?location.reload():"failed"==data.data?($("#uerror").html("File not found to upload."),$(".loading").hide()):"uploaderror"==data.data?($("#uerror").html("Unable to upload this file."),$(".loading").hide()):"filetypeerror"==data.data?($("#uerror").html("File type is not allowed."),$(".loading").hide()):"sizeerror"==data.data&&($("#uerror").html("File size is not allowed."),$(".loading").hide())}}))}),$("#uploadtable").DataTable(),$("#followup_table").DataTable({dom:"Bfrtip",buttons:["excelHtml5","csvHtml5","pdfHtml5"],oLanguage:{sSearch:"Quick Search "}});