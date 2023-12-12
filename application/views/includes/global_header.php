<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
?>

<!doctype html>
<html>
    <head>
        <title>
            <?php echo isset($title) && !empty($title) ? $title : '404' ; ?>
        </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="favicon" href="<?=base_url()?>favicon.ico" />
        <?php if(isset($page_type) && $page_type == 'login'):?>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" />
        <?php endif; ?>
        <?php if(isset($page_type) && $page_type != 'login'):?>
            <link href="<?=$rurl?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
            <link href="<?=$rurl?>assets/plugins/lobipanel/lobipanel.min.css" rel="stylesheet" type="text/css"/>
            <link href="<?=$rurl?>assets/plugins/pace/flash.css" rel="stylesheet" type="text/css"/>
            <link href="<?=$rurl?>assets/plugins/select2/select2.min.css" rel="stylesheet" type="text/css"/>
            <link href="<?=$rurl?>assets/plugins/datetimepicker/datetimepicker.css" rel="stylesheet" type="text/css"/>
            <link href="<?=$rurl?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
            <link href="<?=$rurl?>assets/pe-icon-7-stroke/css/pe-icon-7-stroke.css" rel="stylesheet" type="text/css"/>
            <link href="<?=$rurl?>assets/themify-icons/themify-icons.css" rel="stylesheet" type="text/css"/>
            <link href="<?=$rurl?>assets/plugins/toastr/toastr.css" rel="stylesheet" type="text/css"/>
            <link href="<?=$rurl?>assets/plugins/emojionearea/emojionearea.min.css" rel="stylesheet" type="text/css"/>
            <link href="<?=$rurl?>assets/plugins/monthly/monthly.css" rel="stylesheet" type="text/css"/>
            <link href="<?=$rurl?>assets/dist/css/style.css" rel="stylesheet" type="text/css"/>
            <link href="<?=$rurl?>assets/dist/css/custom.css" rel="stylesheet" type="text/css"/>
            <link href="<?=$rurl?>assets/plugins/summernote/summernote.css" rel="stylesheet" type="text/css"/>
            <link href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
            <link href="<?=$rurl?>assets/plugins/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
            
        <?php endif; ?>
    </head>
    <body class="hold-transition sidebar-mini">
        <input type="hidden" id="loggedUser" value="<?=auth_id()?>"/>
        <script>
        setTimeout(function(){
            if(window.ReactNativeWebView){
               let answer = document.getElementById("loggedUser").value;
               window.ReactNativeWebView.postMessage(JSON.stringify({userId: answer}));
               console.log(JSON.stringify({userId: answer}));
            }
        }, 1000);
       </script>
       <div class="wrapper">
        