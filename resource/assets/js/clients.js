$("#clientTable").DataTable({dom:"Bfrtip",buttons:["excelHtml5","csvHtml5","pdfHtml5"],pageLength:50,oLanguage:{sSearch:"Quick Search "}});$("#clientAdd").submit(function(e){e.preventDefault(),$(".loading").show(),$.ajax({url:base_url+"client/add_new",type:"POST",data:$("#clientAdd").serialize(),success:function(e){data=JSON.parse(e),"success"==data.data?($("#clientAdd")[0].reset(),$("#load-success").show(),setTimeout(()=>{$(".loading").hide(),$("#load-success").hide(),data.update?location.reload():data.ref?location.href=data.redirect:location.href=base_url+"clients"},1e3)):location.reload()}})});$(function(){$("#invrclient").autocomplete({source:"<?=base_url()?>client/search_match",select:function(n,e){n.preventDefault(),$("#invrcid").val(e.item.id)},minLength:3}),$(".ui-menu").css("z-index","99999999999999"),$("#invrclient").keyup(function(){""==$("#invrclient").val()&&$("#invrcid").val("")})});
function resendInvoices(event){event.preventDefault();let invoices=[];$('.checkme:checked').each((i,el)=>{invoices.push(el.getAttribute('value'))});if(invoices.length===0){alert("Select invoices to resend.");return false}else{$(".loading").show();$.ajax({url:base_url+"invoice/resend",type:"POST",data:{invoices},success:function(res){if(res=="done"){show_success("Sent Successfully.");$(".loading").hide()}else{show_error("Something went wrong!");$(".loading").hide()}}})}}
function mergeInvoices(event){event.preventDefault();let invoices=[];$('.checkme:checked').each((i,el)=>{invoices.push(el.getAttribute('value'))});if(invoices.length===0){alert("Select invoices to merge.");return false}else{$(".loading").show();$.ajax({url:base_url+"invoice/mergeSelected",type:"POST",data:{invoices},success:function(res){if(res=="done"){show_success("Merged Successfully.");location.reload();}else if(res=="wrong"){show_error("Please selected only performa invoices!");$(".loading").hide();}else{show_error("At least 2 invoices must be selected!");$(".loading").hide()}}})}}