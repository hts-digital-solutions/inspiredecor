<?php defined("BASEPATH") OR exit("No direct access allowed.");?>

<section class="content content-header">
    <div class="row" style="justify-content:end;display:flex;align-items:center;">
        <a href="<?=base_url()?>import-expense" class="btn btn-sm btn-primary">Import Expenses</a>
    </div>
    <div class="row">
        <div class="panel panel-bd" style="display:inline-block;padding:20px 10px;width:100%;">
            <form action="<?=base_url()?>projectExpense/add_new" method="POST">
            <input type="hidden" name="pid" value="<?=isset($expense->expense_id) ? base64_encode($expense->expense_id) : ''?>" />
            <div class="card-headers row">
              <div class="col-md-3">
                  <div class="form-group">
                      <label>Client</label>
                      <select class="form-control select2" required onchange="filterProject(event);" name="client_id">
                          <option value="">Select</option>
                          <?php foreach($clients as $client):?>
                          <option value="<?=$client->client_id?>"
                          <?php echo isset($expense->client_id) && $expense->client_id == $client->client_id ? 'selected':'';?>
                          ><?=$client->client_name?></option>
                          <?php endforeach;?>
                      </select>
                  </div>
              </div>
              <div class="col-md-3">
                  <div class="form-group">
                      <label>Project</label>
                      <select class="form-control select2" name="project_id" required>
                          <option value="">Select</option>
                          
                      </select>
                  </div>
              </div>
              <div class="col-md-3">
                  <div class="form-group">
                      <label>Category</label>
                      <select class="form-control select2" id="category" name="category" required>
                          <option value="">Select</option>
                          <?php foreach($categories as $c):?>
                          <option value="<?=strtolower($c->name)?>" <?php echo isset($expense->category) && $expense->category == strtolower($c->name) ? 'selected':'';?>><?=$c->name?></option>
                          <?php endforeach;?>
                          <?php if(auth_id() == 0):?>
                          <option value="other" <?php echo isset($expense->category) && $expense->category == 'other' ? 'selected':'';?>>Other Expenses</option>
                          <?php endif;?>
                      </select>
                  </div>
              </div>
              <?php if(auth_id() == 0):?>
              <div class="col-md-3" style="display:none;" id="expense-other">
                  <div class="form-group">
                      <label>Expense Name</label>
                      <input class="form-control" name="expense_name" id="expense_name" value="<?=$expense->category ?? ''?>" type="text"/>
                  </div>
              </div>
              <?php endif;?>
              <div class="col-md-3">
                  <div class="form-group">
                      <label>Quantity</label>
                      <input class="form-control" name="quantity" id="quantity" value="<?=$expense->quantity ?? 1?>" type="number" min="1" required />
                  </div>
              </div>
              
              <div class="col-md-3">
                  <div class="form-group">
                      <label>Price</label>
                      <input class="form-control" name="price" value="<?=$expense->price ?? 0?>" id="price" type="text" required />
                  </div>
              </div>
              
              <div class="col-md-3">
                  <div class="form-group">
                      <label>Total Price</label>
                      <input readonly class="form-control" name="total_price" value="<?=$expense->total_price ?? 0?>" id="total_price" type="text" required />
                  </div>
              </div>
              
              <div class="col-md-3">
                  <div class="form-group">
                      <label>Type</label>
                      <select class="form-control" name="type" required>
                          <option value="">Select</option>
                          <option value="cash" <?php echo isset($expense->type) && $expense->type == 'cash' ? 'selected':'';?>>Cash</option>
                          <option value="credit" <?php echo isset($expense->type) && $expense->type == 'credit' ? 'selected':'';?>>Credit</option>
                          <option value="paytm" <?php echo isset($expense->type) && $expense->type == 'paytm' ? 'selected':'';?>>Paytm</option>
                          <option value="googlepay" <?php echo isset($expense->type) && $expense->type == 'googlepay' ? 'selected':'';?>>Googlepay</option>
                          <option value="phonepay" <?php echo isset($expense->type) && $expense->type == 'phonepay' ? 'selected':'';?>>Phonepay</option>
                          <option value="online transfter" <?php echo isset($expense->type) && $expense->type == 'online transfer' ? 'selected':'';?>>Online Transfer</option>
                          <option value="adjustment" <?php echo isset($expense->type) && $expense->type == 'adjustment' ? 'selected':'';?>>Adjustment</option>
                          <option value="product upsell" <?php echo isset($expense->type) && $expense->type == 'product upsell' ? 'selected':'';?>>Product Upsell</option>
                      </select>
                  </div>
              </div>
              <?php if(auth_id() == 0):?>
                <div class="form-group col-md-3">
                    <label>Business Associate</label>
                    <select name="agent" class="form-control">
                        <option value="">Select</option>
                        <option value="0"  <?= isset($expense)? ($expense->created_by_id === '0' ? 'selected' : '') :'' ?>>Admin user</option>
                        <?php foreach($agents as $a):?>
                            <option value="<?=$a->agent_id?>" <?=$a->agent_id === ($expense->created_by_id ?? '') ? 'selected' : ''?>><?=$a->agent_name?></option>
                        <?php endforeach;?>
                    </select>
                </div>
              <div class="col-md-3">
                  <div class="form-group">
                      <label>Expense Date</label>
                      <input class="form-control" name="date" value="<?= isset($expense->created) ? date('Y-m-d', strtotime($expense->created)) : ''?>" id="date" type="date" />
                  </div>
              </div>
              <?php endif;?>
              
              <div class="col-md-12">
                    <div class="form-group">
                        <label>Comments</label>
                        <textarea name="comment" class="form-control"><?=$expense->comment ?? ''?></textarea>
                    </div>
              </div>
              
              <div class="col-md-12 text-right">
                  <button class="btn btn-info">Submit</button>
              </div>
            </div>
            </form>
        </div>
    </div>
</section>

<script>
    function filterProject(e)
    {
        const projects = JSON.parse('<?=$projects?>');
        const options = projects.filter(d => d.client_id == e.target.value).map(d => {
            return `<option value="${d.project_id}">${d.project_name}</option>`;
        }).join("");
        
        const blankOption = "<option value=''>Select</option>";
        
        document.querySelector("select[name='project_id']").innerHTML = (blankOption + options);
    }
    
    document.querySelector("#price").onkeyup = function(e) {
        document.querySelector("#total_price").value = document.querySelector("#price").value && document.querySelector("#quantity").value ? (parseInt(document.querySelector("#quantity").value) * parseFloat(document.querySelector("#price").value)) : 0
    }
    
    document.querySelector("#quantity").onkeyup = function(e) {
        document.querySelector("#total_price").value = document.querySelector("#price").value && document.querySelector("#quantity").value ?(parseInt(document.querySelector("#quantity").value) * parseFloat(document.querySelector("#price").value)) : 0
    }
    
    document.querySelector("#category").onchange = function(e){
        if(e.target.value === 'other') {
            document.querySelector("#expense-other").style.display = 'block';
        }else {
            document.querySelector("#expense-other").style.display = 'none';
        }
    }
    
    <?php if(isset($expense->client_id)):?>
        const id = '<?=$expense->client_id?>';
        const pid = '<?=$expense->project_id?>';
        const projects = JSON.parse('<?=$projects?>');
        const options = projects.filter(d => d.client_id == id).map(d => {
            return `<option value="${d.project_id}" ${d.project_id === pid ? 'selected' : ''}>${d.project_name}</option>`;
        }).join("");
        
        const blankOption = "<option value=''>Select</option>";
        
        document.querySelector("select[name='project_id']").innerHTML = (blankOption + options);
    <?php endif;?>
</script>