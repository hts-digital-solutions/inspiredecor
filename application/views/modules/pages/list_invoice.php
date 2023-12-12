<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
?>
<link href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css" rel="stylesheet" type="css">     

<section class="content content-header pd-lft">
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-bd lobidrag lobipanel lobipanel-sortable">
        <div class=" panel-heading ui-sortable-handle">
          <div class="col-md-6 col-xs-6">
            <div class="btn-group"><p>List Invoice </p></div>
          </div>
          <div class="col-md-6 col-xs-6">
            <div class="reset-buttons">
              <a href="<?=base_url()?>create-invoice" class="btn btnes exports">Create Invoice</a>
            </div>
          </div>
        </div>
        <div class="panel-body">
          <div class="col-sm-12 col-md-12 col-xs-12">
            <div class="cards">
                <div class="card-headers">
                   <div class="searchbuy">
              <button type="button" id="advS" class="btn btnes exports"><i class="fa fa-search" aria-hidden="true"></i>&nbsp; Advance</button>
              </div>
                
              <form action="" method="GET" name="searchIForm" id="searchIForm" class="advS"
              <?php echo isset($_GET) && !empty($_GET) ? '' : 'style="display:none;"';?>>
              <div class="serach-lists">
                <div class="col-md-2">
                  <div class="form-group">
                    <input type="text" class="form-control" name="client_name" 
                    placeholder="Client Name" 
                    value="<?php echo isset($_GET['client_name']) ? $_GET['client_name'] : ''; ?>" />
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <select class="form-control" name="service">
                        <option value="">Service</option>
                        <?php $ps = get_module_values('product_service'); 
                        if(isset($ps) && !empty($ps)):?>
                        <?php foreach($ps as $p):?>
                        <option value="<?=$p->product_service_id?>" 
                        <?php echo isset($_GET['service']) && $_GET['service'] == $p->product_service_id ? 'selected':''; ?>
                        ><?=$p->product_service_name?></option>
                        <?php endforeach;?>
                        <?php endif;?>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <select class="form-control" name="status" id="inv_status" onchange="getInvDateBox()">
                      <option value="">Status</option>
                      <option value="pending"
                      <?php echo isset($_GET['status']) && $_GET['status'] == 'pending' ? 'selected' : ''; ?>
                      >Pending</option>
                      <option value="paid"
                      <?php echo isset($_GET['status']) && $_GET['status'] == 'paid' ? 'selected' : ''; ?>
                      >Paid</option>
                      <option value="due"
                      <?php echo isset($_GET['status']) && $_GET['status'] == 'due' ? 'selected' : ''; ?>
                      >Due</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-2" id="inv_ddf" style="display:none;">
                  <div class="form-group">
                    <input type="text" class="form-control" name="due_date_from"
                    placeholder="Due Date From" id="iduedate" 
                    value="<?php echo isset($_GET['due_date_from']) ? $_GET['due_date_from'] : ''; ?>"/>
                  </div>
                </div>
                <div class="col-md-2" id="inv_ddt" style="display:none;">
                  <div class="form-group">
                    <input type="text" class="form-control" name="due_date_to"
                    placeholder="Due Date To" id="iduedate2" 
                    value="<?php echo isset($_GET['due_date_to']) ? $_GET['due_date_to'] : ''; ?>"/>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <select class="form-control" name="pay_method">
                      <option value="">Payment Method</option>
                      <option value="online"
                      <?php echo isset($_GET['pay_method']) && $_GET['pay_method'] == 'online' ? 'selected' : ''; ?>
                      >Online</option>
                      <option value="chq-deposit"
                      <?php echo isset($_GET['pay_method']) && $_GET['pay_method'] == 'chq-deposit' ? 'selected' : ''; ?>
                      >Chq/Deposit</option>
                      <option value="cod" 
                      <?php echo isset($_GET['pay_method']) && $_GET['pay_method'] == 'cod' ? 'selected' : ''; ?>
                      >Cod</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-2" style="padding:1px 5px;">
                  <div class="form-group">
                    <select class="form-control" name="is_recurring">
                      <option value="">Select</option>
                      <option value="yes"
                      <?php echo isset($_GET['is_recurring']) && $_GET['is_recurring'] == 'yes' ? 'selected' : ''; ?>
                      >Client Invoice</option>
                      <option value="no"
                      <?php echo isset($_GET['is_recurring']) && $_GET['is_recurring'] == 'no' ? 'selected' : ''; ?>
                      >Lead Invoice</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <button type="submit" class="btn btnss btn-success form-control">Search</button>
                  </div>
                </div>
              </div>
              </form>
             
                <div class="table-responsive mob-bord">
                  <table class="table table-bordered table-hover" id="invList">
                    <thead>
                      <tr>
                        <th><input type="checkbox" class="check"/></th>
                        <th>Name</th>
                        <th class="typesss"> Type</th>
                        <th class="typesss">Date</th>
                        <th>Service</th>
                        <th class="statusess">Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($invoices) && !empty($invoices)):?>
                    <?php foreach($invoices as $i):?>
                      <tr>
                        <td class="list-check">
                            <input type="checkbox" class="checkme" name="radioGroup" value="<?=base64_encode($i->invoice_id)?>" />
                        </td>
                        <td><a href="<?=base_url()?>add-client?edit=<?=base64_encode($i->client_id)?>"><?=$i->client_name?></a></td>
                        <td>
                            <?php 
                            echo ($i->is_recurring)=='yes' ? 'Client Invoice' : 'Lead Invoice';
                            ?>
                        </td>
                        <td><?= get_formatted_date($i->created) ?></td>
                        <td>
                        <?php $p = explode(",",$i->products);
                        $n = array();
                        foreach($p as $pr){
                            array_push($n,get_module_value($pr, 'product_service')); 
                        }
                        echo implode(",",$n);
                        ?></td>
                        <td><?php echo "<span class='text-success'>".get_formatted_price($i->paid_amount)."</span>/<span class='text-danger'>".get_formatted_price($i->invoice_total)."</span>"?></td>
                        <td>
                       <?php
                        if($i->order_status=='paid'){
                            echo '<span class="label label-success">Paid</span>';
                        }else{
                            echo' <span class="label label-danger">'. ucfirst($i->order_status).'</span>';
                        }
                        ?> </td>
                        <td>
                        <?php if($i->paid_amount == 0):?>
                          <button type="button" class="btn btn-warning btn-xs" title="Edit Invoice">
                            <a href="<?=base_url()?>edit-invoice?edit=<?=base64_encode($i->invoice_id)?>"><i class="fa fa-pencil"></i></a>
                          </button>
                        <?php endif;?>
                          <button type="button" class="btn btn-info btn-xs" title="Add Payment">
                            <a href="<?=base_url()?>invoice/payment/<?=base64_encode($i->invoice_id)?>"><i class="fa fa-money"></i></a>
                          </button>
                          <a onclick="return confirm('Data will be lost. Do you want to continue?');"
                          href="<?=base_url()?>invoice/action?delete=<?=base64_encode($i->invoice_id)?>" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a>
                        </td>
                      </tr>
                    <?php endforeach;?>
                    <?php endif;?>
                    </tbody>
                  </table>
                  <button type="button" onclick="deleteSelected('invoice');" class="btn btn-danger">Delete</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
