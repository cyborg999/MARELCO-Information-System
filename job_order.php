<?php 
  include_once "backend/process.php";
  $info = $model->getComplaintById($_GET['id']);
  $brgy = $model->getBrgyById($info['brgy']);
      $info['brgy'] = $brgy['name'];
  // echo "<pre>";
  // print_r($info);
  // die();
?>
<link href="css/bootstrap.min.css" rel="stylesheet">

<!-- <div class="container"> -->
  <table class="table" data-form="information sheet" >
    <thead>
      <tr>
        <th colspan="10" style="text-align:center;">
          <img width="50" src="img/logo.png">
          <h4>(MARELCO)</h4>
          <h5>Boac, Marinduque</h5>
          <p>Application For Membership and Information Sheet</p>
          <br>
        </th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td colspan="10">
          <button class="pull-right">MCS FORM 03</button>
        </td>
      </tr>
      <tr>
        <td colspan="10">
          <h3 style="text-align:center;font-size:13px;font-weight:bold;">SERVICE REQUEST FORM</h3>
        </td>
      </tr>
      <tr>
        <td colspan="5">Member/Consumer Information</td>
        <td colspan="5" class="pull-right">
        <span class="pull-right"><?= date("m-d-Y");?></span>
        </td>
      </tr>
      <tr>
        <td>NAME:</td>
        <td colspan="3">
          <input type="text" class="form-control" value="<?= $info['firstname'];?>" placeholder="firstname..."/>
        </td>
        <td colspan="3">
          <input type="text" class="form-control" value="<?= $info['lastname'];?>"  placeholder="lastname..."/>
        </td>
        <td colspan="3">
          <input type="text" class="form-control" value="<?= $info['middlename'];?>"  placeholder="middlename..."/>
        </td>
      </tr>
      <tr>
        <td></td>
        <td colspan="3">
          <p>First</p>
        </td>
        <td colspan="3">
          <p>Last</p>
        </td>
        <td colspan="3">
          <p>Middle</p>
        </td>
      </tr>
      <tr>
        <td>ADDRESS:</td>
        <td colspan="6">
          <input type="text" value="<?= $info['brgy'].', '.$info['municipality'].',';?>Marinduque"  class="form-control" placeholder="address..."/>
        </td>
        <td colspan="3">
          <p class="pull-left">Phone No. </p>
          <input type="text"  class="form-control pull-right" style="margin-left:15px!important; width:70%;" placeholder="phone number..."/>
        </td>
      </tr>
      <tr>
        <td>ACCOUNT NO.</td>
        <td colspan="2">
          <input type="text" class="form-control" placeholder="account number" />
        </td>
        <td>Meter SN</td>
        <td colspan="2">
          <input type="text" class="form-control" placeholder="meter sn" />
        </td>
         <td colspan="4">
          <p class="pull-left">Mobile</p>
          <input type="text" value="<?= $info['contact_number'];?>" class="form-control pull-right" style="margin-left:15px!important; width:70%;" placeholder="mobile..."/>
        </td>
      </tr>
      <tr>
        <td colspan="5">SERVICE TYPE:</td>
        <td colspan="5">For Teller's use</td>
      </tr>
      <tr>
        <td></td>
        <td colspan="2">

          <label>
            <input checked type="checkbox"/> <?= $info['complaint_nature'];?>
          </label>
        </td>
        <td colspan="2">
            <label>Note:
            <textarea class="form-control">Note</textarea>
            </label>
        </td>
        <td colspan="5">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th colspan="3" style="text-align:center;">Payment of Fees</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="text-align:center">Particulars</td>
                  <td style="text-align:center">OR No. and date</td>
                  <td style="text-align:center">Amount</td>
                </tr>
                <tr>
                  <td><span style="margin:2px;padding:2px;"></span></td>
                  <td><span style="margin:2px;padding:2px;"></span></td>
                  <td><span style="margin:2px;padding:2px;"></span></td>
                </tr>

                <tr>
                  <td><span style="margin:2px;padding:2px;"></span></td>
                  <td><span style="margin:2px;padding:2px;"></span></td>
                  <td><span style="margin:2px;padding:2px;"></span></td>
                </tr>

                <tr>
                  <td><span style="margin:2px;padding:2px;"></span></td>
                  <td><span style="margin:2px;padding:2px;"></span></td>
                  <td><span style="margin:2px;padding:2px;"></span></td>
                </tr>
                <tr>
                  <td><span style="margin:2px;padding:2px;"></span></td>
                  <td><span style="margin:2px;padding:2px;"></span></td>
                  <td><span style="margin:2px;padding:2px;"></span></td>
                </tr>

                <tr>
                  <td><span style="margin:2px;padding:2px;"></span></td>
                  <td><span style="margin:2px;padding:2px;"></span></td>
                  <td><span style="margin:2px;padding:2px;"></span></td>
                </tr>
                <tr>
                  <td><span style="margin:2px;padding:2px;"></span></td>
                  <td><span style="margin:2px;padding:2px;"></span></td>
                  <td><span style="margin:2px;padding:2px;"></span></td>
                </tr>

                <tr>
                  <td><span style="margin:2px;padding:2px;"></span></td>
                  <td><span style="margin:2px;padding:2px;"></span></td>
                  <td><span style="margin:2px;padding:2px;"></span></td>
                </tr>
                <tr>
                  <td><span style="margin:2px;padding:2px;"></span></td>
                  <td><span style="margin:2px;padding:2px;"></span></td>
                  <td><span style="margin:2px;padding:2px;"></span></td>
                </tr>
                <tr>
                  <td>Total</td>
                  <td></td>
                  <td></td>
                </tr>
              </tbody>
            </table>
        </td>
      </tr>
      <tr>
        <td colspan="3">
          <p style="width:80%;">The undersigned hereby requests the services indicated above. It is understood that I will be liable for any and all changes due to this account.</p>
        </td>
        <td colspan="6">Request Received by:</td>
        <td colspan="2">Form/Means:</td>
      </tr>
      <tr>
        <td colspan="2">
            <!-- <input type="text" class="form-control"/> -->
        </td>
        <td>
        <br>
        <br>
          <!-- <input type="text" class="form-control" placeholder="date"/> -->
        </td>
        <td colspan="4">
            <!-- <input type="text" class="form-control"/> -->
        </td>
        <td>
          <!-- <input type="text" class="form-control" placeholder="date"/> -->
        </td>
        <td colspan="2">
          <!-- <input type="text" class="form-control" placeholder="form/means"/> -->
        </td>
      </tr>
      <tr>
        <td colspan="2">
          Member-Consumer's Signature
        </td>
        <td>
          Date
        </td>
        <td colspan="4">
          Area Office Personnel
        </td>
        <td>
          Date/Time
        </td>
        <td></td>
      </tr>
      <tr>
        <td style="text-align:center;" colspan="10">JOB ORDER</td>
      </tr>
      <tr>
        <td colspan="8">
          TO: LINEMAN ON DUTY
        </td>
        <td>Date:</td>
        <td>
          <!-- <input type="text" class="form-control"/> -->
        </td>
      </tr>
      <tr>
        <td colspan="10">
          <p>Please respond/attend to the request/complaint of the abovestated consumer.</p>
        </td>
      </tr>
      <tr>
        <td colspan="2">Prepared By:</td>
        <td colspan="3">Issued By:</td>
        <td colspan="3">Approved By:</td>
        <td></td>
      </tr>
      <tr>
        <td colspan="2">
        <br>
          <br>
            <!-- <input type="text" class="form-control"> -->
            Consumer Services Coordinator
        </td>
        <td colspan="3">
          <br>
          <br>
            <!-- <input type="text" class="form-control"> -->
            Teller/Area Office Supervisor-PIC
        </td>
        <td colspan="3">
          
        </td>
        <td></td>
      </tr>
      <tr>
        <td colspan="3">
          <table class="table">
            <tbody>
              <tr>
                <td width="100">KWH Meter:</td>
                <td style="text-align:center;">Old</td>
                <td style="text-align:center;">New</td>
              </tr>
              <tr>
                <td>Make/Brand</td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>Serial Number</td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>Type</td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>Reading</td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>Seeing</td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>Service Tap</td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>Secondary</td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>Length of SDW</td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>No. Size of SDW</td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>Primary</td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>Length/Phase</td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>N/Size of CDR</td>
                <td></td>
                <td></td>
              </tr>
            </tbody>
          </table>
        </td>
        <td colspan="7">
            <table class="table">
              <tbody>
                <tr>
                  <!-- <td>d2</td> -->
                </tr>
              </tbody>
            </table>
        </td>
      </tr>
      <tr>
        <td colspan="3">Accomplished/Executed By:</td>
        <td colspan="4">
            <p>I hereby acknowledge having been satisfactorily served the services descrived above.</p>
        </td>
        <td colspan="3">
            Date Encoded
        </td>
      </tr>
       <tr>
        <td colspan="2">
        <br>
          <br>
          <!-- <input type="text" class="form-control"/> -->
          Lineman's signature over Printed Name
        </td>
        <td>
        <br>
          <br>
          <!-- <input type="text" class="form-control"> -->
        Date/Time
        </td>
        <td colspan="4">
        <br>
          <br>
        <!-- <input type="text" class="form-control"> -->
          Consumer's Signature Over Printed Name
        </td>
        <td colspan="3">
        <br>
          <br>
            <!-- <input type="text" class="form-control"> -->
            Date Encoded: <br>
            <br>
          <!-- <input type="text" class="form-control"> -->
          Date Posted: 
        </td>
      </tr>
    </tbody>
  </table>

<!-- </div> -->
  