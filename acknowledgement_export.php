<?php 
  include_once "backend/process.php";
  $info = $model->getScheduleById($_GET['id']);
  // $brgy = $model->getBrgyById($info['brgy']);
      // $info['brgy'] = $brgy['name'];
  // echo "<pre>";
  // print_r($info);
  // die();
?>
<link href="css/bootstrap.min.css" rel="stylesheet">

<!-- <div class="container"> -->
  <table class="table" data-form="information sheet" >
    <thead>
      <tr>
        <th width="100"></th>
        <th>
          <img width="70" style="position:relative;right:0px; top:-55px;" src="img/logo.png">
        </th>
        <th colspan="3" style="text-align:center;">
            <h2>MARINDUQUE ELECTRIC COOPERATIVE, INC.</h2>
          <h4>(MARELCO)</h4>
          <h5>Boac, Marinduque</h5>
          <p>Acknowledgement Receipt</p>
        </th>
        <th width="100"></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td colspan="5">Date Issued : <?= $info['start'];?></td>
        <td >MCT # : <?= $info['or'];?></td>
      </tr>
      <tr>
        <td colspan="5">
          <label>METER SPECIFICATION</label>
        </td>
        <td>SDW: <?= $info['sdw'];?></td>
      </tr>
      <tr>
        <td colspan="6">
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <td>BRAND</td>
                  <!-- <td>TYPE</td> -->
                  <!-- <td>CLASS</td> -->
                  <td>SERIAL NO.</td>
                  <td>READING</td>
                  <td>NATURE OF SERVICE</td>
                </tr>
                <tr>
                  <td><?= $info['newBrand'];?></td>
                  <td><?= $info['newSerial'];?></td>
                  <td><?= $info['newReading'];?></td>
                  <td><?= $info['nature'];?></td>
                </tr>
              </tbody>
            </table>
        </td>
      </tr>
      <tr>
        <td colspan="6">
          <p>I HEREBY ACKNOWLEDGE TO HAVE RECEIVED THE KWH METER SPECIFIED ABOVE AND INSTALLED IN MY PREMISES. I AGREE THAT THE SAME
          MAY BE INSPECTED, READ, REPLACED, APPREHENDED OR REMOVED BASE ON THE EXISTING POLICIES OF THE COOPERATIVE
          AND LAWS AS OF THE COUNTRY.
          </p>
        </td>
      </tr>
      <tr>
        <td colspan="3" >
          Issued By:
            <hr>
            <p style="text-align:center;">Materials & Equipment Officer</p>
            
            <br>
            <br>
            Noted By:
            <hr>
            <p style="text-align:center;">Logistic & Equipment Section Head</p>

            
        </td>
        <td colspan="3">
          <br>
            <p style="text-align:center;"><?= $info['consumer'];?></p>
          <hr>
            <p style="text-align:center;">Name/Signature of Consumer</p>

          
          <br>
          <br>
            <p style="text-align:center;"><?= $info['address'];?></p>
          <hr>
            <p style="text-align:center;">Address</p>

          
          <br>
          <br>
          
            <p style="text-align:center;"><?= $info['dateAttended'];?></p>

          <hr>
            <p style="text-align:center;">Date Connected</p>

          
          <br>
          <br>
            <p style="text-align:center;">Connected By:</p>

          
          <hr>
            <p style="text-align:center;">Name/Signature of LINE MAN</p>

          
        </td>
      </tr>
    </tbody>
  </table>

<!-- </div> -->
  