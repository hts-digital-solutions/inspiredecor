<?php defined("BASEPATH") OR die("No direct script access allowed.");?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.9/cropper.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.9/cropper.min.js"></script>
<section class="content content-header pd-lft">
   <div class="row">
        <div class="col-md-12">
            <div class="col-md-3">
                <form id="profileImageForm" enctype="multipart/form-data">
                    <div class="Pimage">
                        <?php
                        $src = $profile->profile_image!=='' ? base_url('resource/system_uploads/agent/').$profile->profile_image 
                        : base_url().'resource/assets/dist/img/avatar5.png';
                        ?>
                        <img src="<?=$src?>" alt="profile image"/>
                    </div>
                    <label for="pimg" style="margin-top:30px;">
                        <input type="file" name="pimg" id="pimg" hidden/>
                    </label>
                    <div id="cropmodal" class="modal" role="dialog">
                      <div class="modal-dialog" style="width:100%;">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="btn btn-primary cropImage" style="position:absolute;">Crop</button>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Crop image before upload</h4>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                                <div class="col-md-11">
                                    <img id="uploaded_image" src="" />
                                </div>
                                <div class="preview"></div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-primary cropImage">Crop</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                    
                      </div>
                    </div>

                </form>
            </div>
            <div class="col-md-9">
                
                <ul class="nav nav-tabs">
                  <li class="active"><a data-toggle="tab" href="#home">Profile</a></li>
                  <li><a data-toggle="tab" href="#menu1">Change Password</a></li>
                </ul>
                <div class="tab-content">
                  <div id="home" class="tab-pane fade in active">
                    <h3>Profile</h3></br>
                    <form action="<?=base_url()?>agent/updateProfile" method="POST" method="POST" id="profileInfoForm">
                        <input type='hidden' name="id" 
                        value="<?php echo isset($profile->agent_id) ? base64_encode($profile->agent_id) : ''; ?>" />
                        <div class="form-group col-md-6">
                            <label>Full Name</label>
                            <input type="text" name="name" required
                            value="<?php echo isset($profile->agent_name) ? $profile->agent_name : ''; ?>"
                            class="form-control" />
                        </div>
                        <div class="form-group col-md-6">
                            <label>Email</label>
                            <input type="email" name="email" required
                            value="<?php echo isset($profile->agent_email) ? $profile->agent_email : ''; ?>"
                            class="form-control" />
                        </div>
                        <div class="form-group col-md-6">
                            <label>Mobile</label>
                            <input type="text" name="mobile" maxlength="10" minlength="10" required
                            value="<?php echo isset($profile->agent_mobile) ? $profile->agent_mobile : ''; ?>"
                            class="form-control" />
                        </div>
                        <div class="form-group col-md-6">
                            <label>Roll</label>
                            <p class="form-control">
                                <?php echo isset($profile->agent_roll) ? $profile->agent_roll : ''; ?>
                            </p>
                        </div>
                        <div class="form-group col-md-12">
                            <input type="submit" name="profile" class="btn btn-primary pull-right" value="Update"/>
                        </div>
                    </form>
                  </div>
                  <div id="menu1" class="tab-pane fade">
                    <h3>Change Password</h3></br>
                    <form action="<?=base_url()?>agent/updatePassword" method="POST" id="profilePasswordForm">
                        <input type='hidden' name="id" 
                        value="<?php echo isset($profile->agent_id) ? base64_encode($profile->agent_id) : ''; ?>" />
                        <div class="form-group col-md-6">
                            <label>Old Password</label>
                            <input type="password" name="oldpass" class="form-control" />
                        </div>
                        <div class="form-group col-md-6">
                            <label>New Password</label>
                            <input type="password" name="newpass" class="form-control" />
                        </div>
                        <div class="form-group col-md-6">
                            <label>Confirm Password</label>
                            <input type="text" name="confirmpass" class="form-control" />
                        </div>
                        <div class="form-group col-md-12">
                            <input type="submit" name="password" class="btn btn-success pull-right" value="Change"/>
                        </div>
                    </form>
                  </div>
                </div>
                
            </div>
        </div>
   </div>
  </div>
</section>
