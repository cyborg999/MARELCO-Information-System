<?php 
	include_once "backend/process.php";
	$list = $model->getComplaintExport();

?>
<link href="css/bootstrap.min.css" rel="stylesheet">

<div class="row">
	
	<div class="columns col-sm-12">
		<table data-form="information sheet" class="table">
			<thead>
				<tr>
					<th colspan="9" style="text-align:center;">
						<img width="50" src="img/logo.png">
						<h4>MARINDUQUE ELECTRIC COOPERATIVE, INC</h4>
						<h5>(MARELCO)</h5>
						<p>Boac, Marinduque</p>
						<p>CONSUMER COMPLAINTS LOGBOOK</p>
						<p>(CWD Monitoring Report)</p>
						<br>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Name of Consumer</td>
					<td>Address</td>
					<td>Contact Number</td>
					<td>Nature of Complaint</td>
					<td>Date & Time Receipt of Complaints</td>
					<td>Action Desired</td>
					<td>Action Taken</td>
					<td>Date & Time of Action</td>
					<td>Accomplished getUserById</td>
				</tr>
				<?php foreach($list as $idx => $u): ?>
	                <tr>
	                   <td><?= $u['f_name']." ".$u['m_name']." ".$u['l_name'];?></td>
	                  <td><?= $u['c_brgy'].", ".ucfirst($u['c_municipality']).", Marinduque";?></td>
	                  <td><?= $u['c_contact'];?></td>
	                  <td><?= $u['complaint_nature'];?></td>
	                  <td><?= $u['dateadded'];?></td>
	                  <td><?= $u['action_desired'];?></td>
	                  <td><?= $u['action_taken'];?></td>
	                  <td><?= $u['action_datetime'];?></td>
	                  <td><?= $u['by'];?></td>
	                </tr>
	                <?php endforeach ?>
			</tbody>
		</table>
	</div>
</div>
		