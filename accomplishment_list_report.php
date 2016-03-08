<?php 
	include_once "backend/process.php";
	$list = $model->getComplaintSummaryExport(true);

?>
<link href="css/bootstrap.min.css" rel="stylesheet">
<div class="row">
<div class="col-sm-12 columns">
	<table data-form="information sheet" class="table">
		<thead>
			<tr>
				<th colspan="13" style="text-align:center;">
					<img width="50" src="img/logo.png">
					<h4>MARINDUQUE ELECTRIC COOPERATIVE, INC</h4>
					<h5>(MARELCO)</h5>
					<p>Boac, Marinduque</p>
					<p>List of Accomplishment</p>
					<br>
				</th>
			</tr>
		</thead>
              <tbody>
                 <tr>
                  <td>Name</td>
                  <td>Address</td>
                  <td>Date Connected</td>
                  <td>Initial Reading</td>
                  <td>Type of Consumer</td>
                  <td>Lengtd of SDW</td>
                  <td colspan="2">Meter</td>
                  <td>OR Number/Date</td>
                  <td>Executed By</td>
                </tr>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>Serial No.</td>
                  <td>Class/Brand</td>
                  <td></td>
                  <td></td>
                </tr>
                <?php $last=""; foreach($list as $idx => $u){
                    if($last != $u['complaint_nature']){
                      $last = $u['complaint_nature']; ?>
                      <tr>
                        <td colspan="10"><b><?= strtoupper($last);?></b></td>
                      </tr>
                    <?php }
                 ?>
                <tr>
                 <td><?= $u['lastname'].", ".$u['firstname']." ".$u['middlename']." ";?></td>
                  <td><?= $u['brgy'].", ".$u['municipality']." Marinduque";?></td>
                  <td><?= $u['date_attended'];?></td>
                  <td><?= $u['new_reading'];?></td>
                  <td><?= $u['consumerType'];?></td>
                  <td><?= $u['sdw_length'];?></td>
                  <td><?= $u['new_serial'];?></td>
                   <td><?= $u['new_brand'];?></td>
                  <td></td>
                  <td><?= $u['lineman'];?></td> 
                </tr>
                <?php } ?>
              </tbody>
            </table>	

</div>
</div>
	