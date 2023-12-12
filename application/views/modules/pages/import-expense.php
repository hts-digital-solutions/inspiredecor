<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
?>

<section class="content content-header">
   <div class="row">
      <div class="col-sm-12">
         <div class="panel panel-bd">
            <div class="panel-heading ">
               <div class="btn-group"> 
                  Import Expense
               </div>
            </div>
            <div class="panel-body">
               <form action="<?=base_url()?>projectExpense/import_expense" method="POST" enctype="multipart/form-data">
                  <div class="col-sm-12 col-md-6 col-xs-12">
                     <div class="cards">
                        <div class="card-headers">
                           <div class="importa-leading">
                               <div class="col-md-4">
                                  <div class="form-group">
                                     <lable class="imprt-lable"> Select File</lable>
                                  </div>
                            </div>
                               <div class="col-md-8">
                                  <div class="form-group">
                                     <input type="file" name="expensefile" required="" class="file-set">
                                  </div>
                            </div>
                           </div>
                          
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-12 col-md-6 col-xs-12">
                      <a href="<?=base_url()?>resource/tmp/import-format-expense.csv">Download format</a><br/><br/>
                      <button class="btn btn-primary">Submit</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</section>