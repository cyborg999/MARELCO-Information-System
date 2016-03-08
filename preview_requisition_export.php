<?php 
  include_once "backend/process.php";
?>
      <link href="css/bootstrap.min.css" rel="stylesheet">

    <div class="container">


      <div class="row">
        <div class="col-sm-12 blog-main">
          <!-- other content goes here -->
          <input type="hidden" id="supplyId" value="<?= $_GET['id'];?>">
          <?php $supplies = $model->getSupplyById($_GET['id']); ?>
          <table class="table" id="supplies">
              <tbody>
               <tr rowspan="4">
                  
                  <td colspan="5" style="text-align:center;">
                    <div style="position:relative;left:0px;">
                      <label style="position:absolute;left:0px;">Form No.</label>
                      <br>
                      <img src="img/marelco.jpg" style="width: 70px; float: left; position: relative; left: -10px;">
                    </div>
                    <b style="font-size:14px;">MARINDUQUE ELECTRIC COOPERATIVE, INC.</b>
                    <p>(MARELCO)</p>
                    <b>Marinduque</b>
                    <br>
                    <b>MATERIALS REQUISITION VOUCHER</b>
                  </td>
                </tr> 
                  <tr>
                      <td colspan="4">
                          <label>Requesting Department: <?= $supplies['supply']['branch'];?>
                          </label>
                      </td>
                      <td>
                          <label>Date: <?= $supplies['supply']['date'];?>
                          </label>
                      </td>
                  </tr>
                  <tr>
                      <td colspan="4">
                          <label>Purpose: <?= $supplies['supply']['purpose'];?>
                          </label>
                      </td>
                      <td>
                          <label>Work Order Ref No: <?= $supplies['supply']['work_order_ref_no'];?>
                          </label>
                      </td>
                  </tr>
                  <tr>
                      <td>Class Code No.</td>
                      <td>Description</td>
                      <td>Quantity</td>
                      <td>Unit</td>
                      <td>Remarks</td>
                  </tr>
                  <?php if(isset($supplies['materials'])): ?>
                      <?php foreach($supplies['materials'] as $idx => $material): ?>
                          <tr class="data">
                            <td><?= $material['class_code'];?></td>
                            <td><?= $material['description'];?></td>
                            <td><?= $material['quantity'];?></td>
                            <td><?= $material['unit'];?></td>
                            <td><?= $material['remarks'];?></td>
                          </tr>
                      <?php endforeach ?>
                  <?php endif ?>
              </tbody>
              <tfoot>
               <tr>
                  <td colspan="6">
                    <label>CHARGE TO:</label>
                  </td>
                </tr>
                <tr>
                  <td>
                    <label>CWO NO:</label>
                  </td>
                  <td>
                    <label>J.O NO:</label>
                  </td>
                  <td colspan="2">
                  <label>M.W.O NO:</label></td>
                  <td colspan="2">
                  <label>M.C.T NO:</label></td>
                </tr>
                <tr>
                  <td colspan="6">
                    <p style="text-align:center;">I hereby certify that the materials/supplies requested above are inventory and will be use solely for the above stated purpose.</p>
                  </td>
                </tr>
                  <tr>
                      <td colspan="2"><label>Requested By: </label>
                      <br>
                      <?= $supplies['supply']['requested_by'];?>
                      </td>
                      <td colspan="2"><label>Approved By:
                      </label>
                      <br>
                      <?= $supplies['supply']['approved_by'];?>
                      </td>
                      <td><label>MRV No:
                      </label>
                      <br>
                      <?= $supplies['supply']['muv_no'];?>
                      </td>
                  </tr>
              </tfoot>
          </table>
        </div><!-- /.blog-main -->

        
      </div><!-- /.row -->

    </div><!-- /.container -->
   
  