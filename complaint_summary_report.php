<?php 
	include_once "backend/process.php";
	$list = $model->getComplaintSummaryExport();

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
					<p>Summary of Consumer's Complaint/Request</p>
					<br>
				</th>
			</tr>
		</thead>
              <tbody>
              <tr>
                 <td>Name</td>
                  <td>Address</td>
                  <td>Complaints/Request</td>
                  <td>Date Applied</td>
                  <td>Date Attended</td>
                  <td colspan="3">Old Kwh Meter</td>
                  <td colspan="3">New Kwh Meter</td>
                  <td>Lengtd of SDW</td>
                  <td>Executed By</td>
                </tr>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>Class/Brand</td>
                  <td>Reading</td>
                  <td>Serial No.</td>
                  <td>Class/Brand</td>
                  <td>Reading</td>
                  <td>Serial No.</td>
                  <td></td>
                  <td>executed</td>
                </tr>
                <?php foreach($list as $idx => $u): ?>
                <tr>
                  <td><?= $u['lastname'].", ".$u['firstname']." ".$u['middlename']." ";?></td>
                  <td><?= $u['brgy'].", ".$u['municipality']." Marinduque";?></td>
                  <td><?= $u['complaint_nature'];?></td>
                  <td><?= $u['date_attended'];?></td>
                  <td><?= $u['date_attended'];?></td>
                  <td><?= $u['old_brand'];?></td>
                  <td><?= $u['old_reading'];?></td>
                  <td><?= $u['old_serial'];?></td>
                   <td><?= $u['new_brand'];?></td>
                  <td><?= $u['new_reading'];?></td>
                  <td><?= $u['new_serial'];?></td>
                  <td><?= $u['sdw_length'];?></td>
                  <td><?= $u['lineman'];?></td>
                </tr>
                <?php endforeach ?>
              </tbody>
            </table>	

</div>
</div>
	