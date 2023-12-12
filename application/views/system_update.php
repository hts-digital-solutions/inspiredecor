<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
?>

<!doctype html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" />
        <title>Update Your System!</title>
    </head>
    <body>
        
        <div class="container">
            <div class="jumbotron bg-light">
                <div class="row">
                    <div class="col-md-7 col-sm-12 col-xs-12">
                        <span id="bError" class="text-danger"></span>
                        <div style="display:none;text-align:center;" id="process">
                            <img width="60" src="<?=base_url()?>resource/tmp/loading.gif" alt="loading" />
                            <p class="text-danger">Don't do these untill get success message!</p>
                            <ol style="list-style:none;">
                                <li><code>Don't hit back button.</code></li>
                                <li><code>Don't refresh window.</code></li>
                                <li><code>Don't perform any action in this window.</code></li>
                            </ol>
                        </div>
                        <div id="success" style="text-align:center;display:none;">
                            <img width="60" src="<?=base_url()?>resource/tmp/done.png" alt="done" />
                            <h2>Success!</h2>
                            <a href="<?=base_url()?>">Go Back to panel</a>
                        </div>
                    </div>
                    <form class="col-md-4 col-sm-12 col-xs-12 p-0" method="post"
                    id="updateForm" name="updateForm" enctype="multipart/form-data">
                        <div class="form-group">
                            <code>Please upload zip file you downloaded!</code><br>
                            <label for="file">Upload file</label>
                            <input type="file" accept="application/zip" id="zipfile"
                            class="form-control" name="zipfile"/>
                        </div>
                        <div class="form-group">
                            <button type="submit" id="submit" name="submit" class="btn btn-block btn-warning">Upload</button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
        
        <div id="backUpModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
        
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-danger">Alert!</h4>
              </div>
              <div class="modal-body">
                <p><b>Backup your database before every update: </b>
                <a href="<?=base_url()?>System_Updater/backupDB" target="_blank">Click here to download</a>
                </p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
            </div>
        
          </div>
        </div>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script>
            
            $("#backUpModal").modal("show");
            
            $("#updateForm").submit((e)=>
            {
                e.preventDefault();
                
                let file = $("#zipfile").val();
                let ext = file.split(".");
                if(ext[ext.length - 1] !== 'zip' || file === ''){
                    $("#bError").html("Please select zip file!");
                    $("#zipfile").val("");
                    return false;
                }else{
                    $("#bError").html("");
                    $("#process").show();
                    $("#submit").attr("disabled","true");
                    
                    let form = document.getElementById("updateForm");
                    let formData = new FormData(form);
                    $.ajax({
                        url : "<?=base_url()?>System_Updater/upload_update_file",
                        type: "POST",
                        async: true,
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(res){
                            resData = JSON.parse(res);
                            if(resData['status'] === 1 && resData['data'] === 'done')
                            {
                                $("#process").hide();
                                $("#success").show();
                                $("#zipfile").val("");
                                $("#submit").removeAttr("disabled");
                                
                            }else if(resData['status'] === 0 && resData['data'] === 'uploaderror'){
                                $("#bError").html("File is currupted, please check.");
                                $("#process").hide();
                            }else if(resData['status'] === 0 && resData['data'] === 'filetype'){
                                $("#bError").html("File type is not supported, please check.");
                                $("#process").hide();
                            }else if(resData['status'] === 0 && resData['data'] === 'nodir'){
                                $("#bError").html("'resource/tmp/' directory is missing.");
                                $("#process").hide();
                            }else if(resData['status'] === 0 && resData['data'] === 'missing'){
                                $("#bError").html("Missing file.");
                                $("#process").hide();
                            }else if(resData['status'] === 0 && resData['data'] === 'filenotfound'){
                                $("#bError").html("File is not valid to update!");
                                $("#process").hide();
                            }else if(resData['status'] === 0 && resData['data'] === 'updateerror'){
                                $("#bError").html("Got some error while updating system! OR CRM is up to date. ");
                                $("#process").hide();
                            }else if(resData['status'] === 0 && resData['data'] === 'broken'){
                                $("#bError").html("File is broken can't update!");
                                $("#process").hide();
                            }
                            else{
                               $("#bError").html("Something went wrong!"); 
                               $("#process").hide();
                            }
                        }
                    })
                }
                //url 
            });
        </script>
    </body>
</html>
