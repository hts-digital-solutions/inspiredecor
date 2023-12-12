<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
?>

<section class="content content-header">
 <div class="row">
  <div class="col-sm-12">
   <div class="panel panel-bd lobidrag lobipanel lobipanel-sortable">
    <div class="panel-heading ui-sortable-handle">
     <div class="btn-group">
      <p>Batch pdf invoice export</p>
     </div>
    </div>
    <div class="panel-body">
     <div class="col-sm-12 col-md-12 col-xs-12">
      <div class="cards">
       <div class="serach-lists">
        <div class="col-md-2">
         <div class="form-group">
          <input type="text" name="clientname" placeholder="Client Name" class="form-control" />
         </div>
        </div>
        <div class="col-md-2">
         <div class="form-group">
          <select class="form-control">
           <option value="Conditional">Date range type</option>
           <option value="Daily">Daily</option>
           <option value="Month">Month</option>
           <option value="Year">Year</option>
          </select>
         </div>
        </div>
        <div class="col-md-2">
         <div class="form-group">
          <input type="text" name="date" class="form-control" placeholder="Start range" />
         </div>
        </div>
        <div class="col-md-2">
         <div class="form-group">
          <input type="text" name="date" class="form-control" placeholder="End Range" />
         </div>
        </div>
        <div class="col-md-2">
         <select class="form-control select2" multiple>
          <option value="Payumoney">Payumoney</option>
          <option value="razorpay">razorpay</option>
          <option value="cash">cash</option>
          <option value="bank trasnfer">bank trasnfer</option>
         </select>
        </div>
        <div class="col-md-2">
         <select class="select2 form-control" multiple>
          <lable>Status</lable>

          <option value="Active">Paid</option>
          <option value="Unpaid">Unpaid</option>
          <option value="Cancel">Cancel</option>
          <option value="Refunded">Refunded</option>
         </select>
        </div>
       </div>
      </div>
     </div>
     <div class="col-sm-12 col-md-12 col-xs-12">
      <div class="cards">
       <div class="serach-lists">
        <div class="col-md-2">
         <select class="mdb-select md-form form-control">
          <option value="Status">Status</option>
          <option value="Delhi">Delhi</option>
          <option value="Uttar Pradesh">Uttar Pradesh</option>
         </select>
        </div>
        <div class="col-md-2">
         <div class="form-group">
          <a href="#" class="btn btnss btn-success">Submit</a>
         </div>
        </div>
       </div>
      </div>
     </div>
    </div>
   </div>
  </div>
 </div>
</section>
