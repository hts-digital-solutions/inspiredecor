function markTaskComplete(el){id=el.getAttribute('data-fire-t');if(id!==''){$(".loading").show();$.ajax({url:base_url+"task/markComplete",type:"POST",data:{id},success:function(res){data=JSON.parse(res);if(data['data']=="success"){location.reload();$(".loading").hide();show_success("Task completed successfully.")}else{$(".loading").hide();show_success("Completed Already.")}}})}else{show_error("Something went wrong!")}}function addTaskComment(el){id=el.getAttribute('data-fire-t');if(id!==''){$("#TaskModelC").modal("show");$("#thid").val(id)}else{show_error("Something went wrong!")}}$("#task_date,#popupdate").datetimepicker({timepicker:true,format:date_php_format,formatTime:'g:i A',step:5,defaultSelect:false});$("#task_c_table").DataTable({dom:'Bfrtip',buttons:['excelHtml5','csvHtml5','pdfHtml5'],"ordering":false,"oLanguage":{"sSearch":"Quick Search "}});$("#tasktable").DataTable({dom:'Bfrtip',buttons:['excelHtml5','csvHtml5','pdfHtml5'],"ordering":false,"oLanguage":{"sSearch":"Quick Search "}});$("#bulkTaskForm").submit(function(event){event.preventDefault();let tasks=[];$('.checkme:checked').each((i,el)=>{tasks.push(el.getAttribute('value'))});if(tasks.length===0){alert("Select tasks to perform bulk action.");return false}else{$(".loading").show();$.ajax({url:base_url+"task/bulk_action",type:"POST",data:{status:$("#bstatus").val(),agent:$("#agent").val(),tasks},success:function(res){data=JSON.parse(res);if(data['data']=="success"){$("#load-success").show();setTimeout(()=>{$(".loading").hide();$("#load-success").hide()},1000);location.reload()}else{alert("Something went wrong!");$(".loading").hide()}}})}});