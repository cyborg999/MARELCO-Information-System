<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Marelco</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/blog.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="css/prism.css">
    <link rel="stylesheet" href="css/chosen.min.css">
  </head>

  <body>
    <?php include_once "header.php"; ?>
    <div class="container">

      <div class="blog-header">
        <h1 class="blog-title">Update Applicant's Information</h1>
        <!-- <p class="lead blog-description">The official example template of creating a blog with Bootstrap.</p> -->
      </div>

      <div class="row">
        <div class="col-sm-12 blog-main columns">
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="active"><a href="#new" aria-controls="home" role="tab" data-toggle="tab">New Applicants</a></li>
          <li role="presentation"><a href="#incomplete" aria-controls="profile" role="tab" data-toggle="tab">Incomplete Requirements</a></li>
          <li role="presentation"><a href="#orientation" aria-controls="profile" role="tab" data-toggle="tab">For Orientation</a></li>
          <li role="presentation"><a href="#verified" aria-controls="profile" role="tab" data-toggle="tab">Verified</a></li>
        </ul>
        <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="new">
                  <?php $userList = $model->getAllApplicants(0,true); ?>
                  <table class="table table-bordered table-hovered">
                      <thead>
                          <tr>
                              <th>
                                <label>Send All
                                  <input type="checkbox" class="checkAll" value="true">
                                </label>
                              </th>
                              <th>Active</th>
                              <th>Info</th>
                              <th>Firstname</th>
                              <th>Lastname</th>
                              <th>Membership Type</th>
                              <th>Consumer Type</th>
                              <th>Membership Status
                               <!--  <select id="status" class="hidden">
                                    <option value="0">All</option>
                                    <option value="1">Incomplete Requirement</option>
                                    <option value="2">For Orientation</option>
                                    <option value="3">Verified</option>
                                </select> -->
                              </th>
                              <th>
                                  <a href="" data-toggle="modal" data-target="#addRequirements" class="label btn-success btn">View Requirement Details</a>
                              </th>
                          </tr>
                      </thead>
                      <tbody class="applicants">
                          <?php foreach($userList as $idx => $user): ?>
                              <tr class='tr-status' style="opacity:<?= ($user['deleted'] == 1) ? ".3" : "1"; ?>;">
                                  <td>
                                    <input type="checkbox" data-type="<?= $user['consumer_type'];?>" data-number="<?= $user['contact_number'];?>" data-userid="<?= $user['userid'];?>" value="<?= $user['id']; ?>" name="smsId">
                                  </td>
                                  <td>
                                      <a href="" data-id="<?= $user['userid']; ?>" class="activate label bg-danger btn"><?= ($user['deleted'] == 1) ? "inactive" : "active"; ?></a>
                                  </td>
                                  <td>
                                      <a href="edit_applicant.php?id=<?= $user['userid'];?>">
                                          <img width="50" height="50" src="uploads/<?= ($user['photo'] == "") ? 'user.png': $user['photo'] ;?>"/>
                                      </a>
                                  </td>
                                  <!-- <td><?= $user['username']; ?></td> -->
                                  <!-- <td><?= $user['email']; ?></td> -->
                                  <td><?= $user['firstname']; ?></td>
                                  <td><?= $user['lastname']; ?></td>
                                  <td><?= $user['membership_type']; ?></td>
                                  <td><?= $user['consumer_type']; ?></td>
                                  <td><?php
                                  $text = "New Applicant";
                                  switch($user['status']){
                                    // 0 = new applicant
                                      case 1 : 
                                          $text = "Incomplete Requirements";
                                          break;
                                      case 2 :
                                          $text = "For Orientation";
                                          break;
                                      case 3 :
                                          $text = "Verified";
                                          break;
                                  }
                                  echo $text;
                                  ?></td>
                                  <td>
                                      <a href="" data-req="<?= $user['requirement'];?>" data-id="<?= $user['userid'];?>" data-membership="<?= $user['consumer_type'];?>" class="update-this-user btn btn-sm">update requirements</a>
                                  </td>
                              </tr>
                          <?php endforeach ?>
                          <tr class='last-tr'>

                              <td colspan="9">
                                <input type="submit" id="prepareSms" class="pull-right btn btn-sm btn-primary prepareSms" data-new="true" value="Send SMS">
                              </td>
                          </tr>
                      </tbody>
                  </table>
                </div>
                <div role="tabpanel" class="tab-pane " id="incomplete">
                  <?php $userList = $model->getAllApplicants(1,true); ?>
                  <table class="table table-bordered table-hovered">
                      <thead>
                          <tr>
                              <th>
                                <label>Send All
                                  <input type="checkbox" class="checkAll" value="true">
                                </label>
                              </th>
                              <th>Active</th>
                              <th>Info</th>
                              <th>Firstname</th>
                              <th>Lastname</th>
                              <th>Membership Type</th>
                              <th>Consumer Type</th>
                              <th>Membership Status
                               <!--  <select id="status" class="hidden">
                                    <option value="0">All</option>
                                    <option value="1">Incomplete Requirement</option>
                                    <option value="2">For Orientation</option>
                                    <option value="3">Verified</option>
                                </select> -->
                              </th>
                              <th>
                                  <a href="" data-toggle="modal" data-target="#addRequirements" class="label btn-success btn">View Requirement Details</a>
                              </th>
                          </tr>
                      </thead>
                      <tbody class="applicants">
                          <?php foreach($userList as $idx => $user): ?>
                              <tr class='tr-status' style="opacity:<?= ($user['deleted'] == 1) ? ".3" : "1"; ?>;">
                                  <td>
                                    <input type="checkbox" data-type="<?= $user['consumer_type'];?>" data-number="<?= $user['contact_number'];?>" data-userid="<?= $user['userid'];?>" value="<?= $user['id']; ?>" name="smsId">
                                  </td>
                                  <td>
                                      <a href="" data-id="<?= $user['userid']; ?>" class="activate label bg-danger btn"><?= ($user['deleted'] == 1) ? "inactive" : "active"; ?></a>
                                  </td>
                                  <td>
                                      <a href="edit_applicant.php?id=<?= $user['userid'];?>">
                                          <img width="50" height="50" src="uploads/<?= ($user['photo'] == "") ? 'user.png': $user['photo'] ;?>"/>
                                      </a>
                                  </td>
                                  <!-- <td><?= $user['username']; ?></td> -->
                                  <!-- <td><?= $user['email']; ?></td> -->
                                  <td><?= $user['firstname']; ?></td>
                                  <td><?= $user['lastname']; ?></td>
                                  <td><?= $user['membership_type']; ?></td>
                                  <td><?= $user['consumer_type']; ?></td>
                                  <td><?php
                                  $text = "New Applicant";
                                  switch($user['status']){
                                    // 0 = new applicant
                                      case 1 : 
                                          $text = "Incomplete Requirements";
                                          break;
                                      case 2 :
                                          $text = "For Orientation";
                                          break;
                                      case 3 :
                                          $text = "Verified";
                                          break;
                                  }
                                  echo $text;
                                  ?></td>
                                  <td>
                                      <a href="" data-req="<?= $user['requirement'];?>" data-id="<?= $user['userid'];?>" data-membership="<?= $user['consumer_type'];?>" class="update-this-user btn btn-sm">update requirements</a>
                                  </td>
                              </tr>
                          <?php endforeach ?>
                          <tr class='last-tr'>
                              <td colspan="9">
                                <input type="submit"  class="notify pull-right btn btn-sm btn-primary" value="Notify for missing requirements">
                              </td>
                          </tr>
                      </tbody>
                  </table>
                </div>
                <div role="tabpanel" class="tab-pane " id="orientation">
                  <?php $userList = $model->getAllApplicants(2,true); ?>
                  <table class="table table-bordered table-hovered">
                      <thead>
                          <tr>
                              <th>
                                <label>Send All
                                  <input type="checkbox" class="checkAll" value="true">
                                </label>
                              </th>
                              <th>Active</th>
                              <th>Info</th>
                              <th>Firstname</th>
                              <th>Lastname</th>
                              <th>Membership Type</th>
                              <th>Consumer Type</th>
                              <th>Membership Status
                               <!--  <select id="status" class="hidden">
                                    <option value="0">All</option>
                                    <option value="1">Incomplete Requirement</option>
                                    <option value="2">For Orientation</option>
                                    <option value="3">Verified</option>
                                </select> -->
                              </th>
                              <th>
                                  <a href="" data-toggle="modal" data-target="#addRequirements" class="label btn-success btn">View Requirement Details</a>
                              </th>
                          </tr>
                      </thead>
                      <tbody class="applicants">
                          <?php foreach($userList as $idx => $user): ?>
                              <tr class='tr-status' style="opacity:<?= ($user['deleted'] == 1) ? ".3" : "1"; ?>;">
                                  <td>
                                    <input type="checkbox" data-type="<?= $user['consumer_type'];?>" data-number="<?= $user['contact_number'];?>" data-userid="<?= $user['userid'];?>" value="<?= $user['id']; ?>" name="smsId">
                                  </td>
                                  <td>
                                      <a href="" data-id="<?= $user['userid']; ?>" class="activate label bg-danger btn"><?= ($user['deleted'] == 1) ? "inactive" : "active"; ?></a>
                                  </td>
                                  <td>
                                      <a href="edit_applicant.php?id=<?= $user['userid'];?>">
                                          <img width="50" height="50" src="uploads/<?= ($user['photo'] == "") ? 'user.png': $user['photo'] ;?>"/>
                                      </a>
                                  </td>
                                  <!-- <td><?= $user['username']; ?></td> -->
                                  <!-- <td><?= $user['email']; ?></td> -->
                                  <td><?= $user['firstname']; ?></td>
                                  <td><?= $user['lastname']; ?></td>
                                  <td><?= $user['membership_type']; ?></td>
                                  <td><?= $user['consumer_type']; ?></td>
                                  <td><?php
                                  $text = "New Applicant";
                                  switch($user['status']){
                                    // 0 = new applicant
                                      case 1 : 
                                          $text = "Incomplete Requirements";
                                          break;
                                      case 2 :
                                          $text = "For Orientation";
                                          break;
                                      case 3 :
                                          $text = "Verified";
                                          break;
                                  }
                                  echo $text;
                                  ?></td>
                                  <td>
                                      <a href="" data-req="<?= $user['requirement'];?>" data-id="<?= $user['userid'];?>" data-membership="<?= $user['consumer_type'];?>" class="update-this-user btn btn-sm">update requirements</a>
                                  </td>
                              </tr>
                          <?php endforeach ?>
                          <tr class='last-tr'>

                              <td colspan="9">
                                <input type="submit" class="pull-right btn btn-sm btn-primary prepareSms" data-new="false" value="Send SMS">
                              </td>
                          </tr>
                      </tbody>
                  </table>
                </div>
                <div role="tabpanel" class="tab-pane " id="verified">
                  <?php $userList = $model->getAllApplicants(3,true); ?>
                  <table class="table table-bordered table-hovered">
                      <thead>
                          <tr>
                              <th>
                                <label>Send All
                                  <input type="checkbox" class="checkAll" value="true">
                                </label>
                              </th>
                              <th>Active</th>
                              <th>Info</th>
                              <th>Firstname</th>
                              <th>Lastname</th>
                              <th>Membership Type</th>
                              <th>Consumer Type</th>
                          </tr>
                      </thead>
                      <tbody class="applicants">
                          <?php foreach($userList as $idx => $user): ?>
                              <tr class='tr-status' style="opacity:<?= ($user['deleted'] == 1) ? ".3" : "1"; ?>;">
                                  <td>
                                    <input type="checkbox" data-date="<?= $user['date_registered'];?>" data-type="<?= $user['consumer_type'];?>" data-number="<?= $user['contact_number'];?>" data-userid="<?= $user['userid'];?>" value="<?= $user['id']; ?>" name="smsId">
                                  </td>
                                  <td>
                                      <a href="" data-id="<?= $user['userid']; ?>" class="activate label bg-danger btn"><?= ($user['deleted'] == 1) ? "inactive" : "active"; ?></a>
                                  </td>
                                  <td>
                                      <a href="edit_applicant.php?id=<?= $user['userid'];?>">
                                          <img width="50" height="50" src="uploads/<?= ($user['photo'] == "") ? 'user.png': $user['photo'] ;?>"/>
                                      </a>
                                  </td>
                                  <!-- <td><?= $user['username']; ?></td> -->
                                  <!-- <td><?= $user['email']; ?></td> -->
                                  <td><?= $user['firstname']; ?></td>
                                  <td><?= $user['lastname']; ?></td>
                                  <td><?= $user['membership_type']; ?></td>
                                  <td><?= $user['consumer_type']; ?></td>
                              </tr>
                          <?php endforeach ?>
                          <tr class='last-tr'>
                              <td colspan="9">
                                <input type="submit" id="schedule" class="pull-right btn btn-sm btn-primary" value="Schedule">
                              </td>
                          </tr>
                      </tbody>
                  </table>
                </div>
        </div>
          <!-- other content goes here -->
        
          <ul id="errors"></ul>
        </div><!-- /.blog-main -->
      </div><!-- /.row -->
    </div><!-- /.container -->
    <footer class="blog-footer">
      <p>
        <a href="#">Back to top</a>
      </p>
    </footer>
    <script type="text/html" id="req-tpl">
        <li><label><input type="checkbox" style="opacity:1;" /> <span class="req-name">[NAME]</span></label>
           <a href="" class="deleteChk"><span class="glyphicon glyphicon-remove"></span></a>
        </li>
    </script>
    <!-- Modal Resize alert -->
    <div class="modal fade" id="sendSms">
         <div class="modal-dialog">
              <div class="modal-content">
                   <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Recipients</h4>
                      <?php $userList = $model->getAllApplicants(); ?>
                        <select id="recipients" data-placeholder="Recipients" style="width:350px;" multiple class="chosen-select" tabindex="8">
                          <option value=""></option>
                          <?php foreach($userList as $idx => $u): ?>
                            <option data-id="<?= $u['id'];?>" value="<?= $u['contact_number'];?>"><?= $u['firstname']." ".$u['lastname'];?></option>
                          <?php endforeach ?>                          
                        </select>
                   </div>
                   <div class="modal-body">
                        <textarea class="form-control" placeholder="message" id="message"></textarea>
                   </div>
                   
                   <div class="modal-footer">
                        <button type="button" class="btn btn-info btn-sm" id="saveSms" >Okay</button>
                        <button type="button" class="btn btn-info btn-sm" id="cancelSms" data-dismiss="modal">Cancel</button>
                   </div>
              </div>
         </div>
    </div>
    <div class="modal fade" id="updateRequirement">
         <div class="modal-dialog">
              <div class="modal-content">
                   <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Update User Requirement</h4>
                   </div>
                   <div class="modal-body">
                        <div id="my-residential-requirements">
                            <h5>Residential Membership Requirements</h5>
                            <ul style="list-style-type:none;" id="residential-requirement-edit">
                                <?php $requirements = $model->getAllRequirementsByType("residential"); ?>
                                <?php foreach($requirements as $idx => $r): ?>
                                    <li><label><input type="checkbox" style="opacity:1;" /> <span class="req-name"><?= $r['name'];?></span></label></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                        <div id="my-commercial-requirements">
                            <h5>Commercial Membership Requirements</h5>
                            <ul style="list-style-type:none;" id="commercial-requirement-edit">
                                <?php $requirements = $model->getAllRequirementsByType("commercial"); ?>
                                <?php foreach($requirements as $idx => $r): ?>
                                    <li><label><input type="checkbox" style="opacity:1;" /> <span class="req-name"><?= $r['name'];?></span></label></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                   </div>
                   
                   <div class="modal-footer">
                      <label class="label pull-left">
                        <input type="checkbox" id="checkAllRequirement"/> 
                        Check All
                      </label>
                        <button type="button" class="btn btn-info btn-sm" id="saveMyRequirement" >Okay</button>
                        <button type="button" class="btn btn-info btn-sm" id="editMyCancel" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-info btn-sm pull-right hidden" id="complete" >Mark as Complete</button>
                   </div>
              </div>
         </div>
    </div>
    <div class="modal fade" id="addRequirements">
         <div class="modal-dialog">
              <div class="modal-content">
                   <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Edit Requirement</h4>
                   </div>
                   <div class="modal-body">
                    <div class="row">
                        <div class="columns col-lg-3 col-md-3 col-sm-3">
                            <input type="text" id="newRequirement" class="form-control" placeholder="new.."/>
                        </div>
                        <div class="columns col-lg-3 col-md-3 col-sm-3">
                            <label>Membership Type</label>
                            <label>Residential
                                <input type="radio" value="residential" class="rdaio" style="opacity:1;" checked name="membership_type">
                            </label>
                            <label>Commercial
                                <input type="radio" value="commercial"  class="radsio" style="opacity:1;"  name="membership_type">
                            </label>
                        </div>
                        <div class="columns col-lg-3 col-md-3 col-sm-3">
                            <input type="submit" value="add new requirement" id="addNewRequirement" class="btn "/>
                        </div>
                    </div>
                    <br>
                    <h5>Residential Membership type Requirements</h5>
                        <ul style="list-style-type:none;" id="residential-requirement">
                            <?php $requirements = $model->getAllRequirementsByType("residential"); ?>
                            <?php foreach($requirements as $idx => $r): ?>
                                <li>
                                  <label><input type="checkbox" style="opacity:1;" <?= ($r['checked'] == 1) ? 'checked' : '';?>/>
                                 <span class="req-name"><?= $r['name'];?></span></label>
                                 <a href="" class="deleteChk"><span class="glyphicon glyphicon-remove"></span></a>
                               </li>
                            <?php endforeach ?>
                        </ul>
                         <h5>Commercial Membership type Requirements</h5>
                        <ul style="list-style-type:none;" id="commercial-requirement">
                            <?php $requirements = $model->getAllRequirementsByType("commercial"); ?>
                            <?php foreach($requirements as $idx => $r): ?>
                                <li><label><input type="checkbox" style="opacity:1;" <?= ($r['checked'] == 1) ? 'checked' : '';?>/> <span class="req-name"><?= $r['name'];?></span></label>
                                 <a href="" class="deleteChk"><span class="glyphicon glyphicon-remove"></span></a>
                                </li>
                            <?php endforeach ?>
                        </ul>
                   </div>
                   
                   <div class="modal-footer">
                        <button type="button" class="btn btn-info btn-sm" id="saveRequirement" >Okay</button>
                        <button type="button" class="btn btn-info btn-sm" id="editCancel" data-dismiss="modal">Cancel</button>
                   </div>
              </div>
         </div>
    </div>

    <script type="text/html" id="tr-status">
      <tr class='tr-status' style="opacity:[DELETED_OPACITY];">
        <td>
          <input type="checkbox" value="[USERID]" name="smsId">
        </td>
        <td>
            <a href="" data-id="[USERID]" class="activate label bg-danger btn">[ACTIVE]</a>
        </td>
        <td>
            <a href="edit_applicant.php?id=[USERID]">
                <img width="50" height="50" src="uploads/user.png"/>
            </a>
        </td>
        <td>[USERNAME]</td>
        <td>[EMAIL]</td>
        <td>[FIRSTNAME]</td>
        <td>[LASTNAME]</td>
        <td>[MEMBERSHIP_TYPE]</td>
        <td>[CONSUMER_TYPE]</td>
        <td>[TEXT]</td>
        <td>
            <a href="" data-req="[REQ]" data-id="[USERID]" data-membership="[MEMBERSHIP_TYPE]" 
            class="update-this-user btn btn-sm">update requirements</a>
        </td>
      </tr>
    </script>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script> <!-- jQuery Library -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/chosen.jquery.min.js" type="text/javascript"></script>
    <script src="js/prism.js" type="text/javascript" charset="utf-8"></script>

    <script type="text/javascript">
    (function($){
      var Page = {
        __init : function(){
          this.__defaultListener();
        },
        __defaultListener: function(){
          $(".deleteChk").off().on("click", function(e){
            $(this).parents("li").remove();
            e.preventDefault();
          });

          var me      = this;
          var save    = $("#add-announcement");
          var logout  = $(".logout");
          var activate    = $(".activate");
          var config      = {' .chosen-select' : {}};
          var prepare     = $(".prepareSms");
          var recipients  = $("#recipients");
          var checkAll    = $(".checkAll");
          var sendSms     = $("#saveSms");

          $("#checkAllRequirement").on("click", function(){
            var val = $(this).prop("checked");
            $(this).parents(".modal").find("#residential-requirement-edit input[type='checkbox']").prop("checked", val);
            $(this).parents(".modal").find("#commercial-requirement-edit input[type='checkbox']").prop("checked", val);
          });

          $("#schedule").off().on("click", function(e){
            var checked = Array();

            $("input[name='smsId']:checked").each(function(){
              $(this).parents("tr").addClass("marked");

              var id = $(this).val();
              var data = Array(
                  $(this).data("userid"),
                  $(this).data("date"),
                  $(this).data("type")
                );
              checked.push(data);
            });

            if(checked.length == 0){
              return false;
            }

            $.ajax({
              url   : "backend/process.php",
              data  : {scheduleMember : true, data : checked},
              type  : 'POST',
              dataType  : 'JSON',
              success   : function(response){
                console.log("Notification Sent!");
                alert("Record is sucesfully updated.");
                $(".marked").remove();
              },   
              error     : function(){
                console.log("err");
              }
            });

            e.preventDefault();
          });

          $(".notify").off().on("click", function(){
            var checked = Array();

            $("input[name='smsId']:checked").each(function(){
              var id = $(this).val();
              var data = Array(
                  $(this).data("userid"),
                  $(this).data("number"),
                  $(this).data("type")
                );
              checked.push(data);
            });

            if(checked.length == 0){
              return false;
            }
            var btn = $(this);

            btn.attr("disabled","disabled");
            $.ajax({
              url   : "backend/process.php",
              data  : {notifySms : true, data : checked},
              type  : 'POST',
              dataType  : 'JSON',
              success   : function(response){
                console.log("Notification Sent!");
                alert("Notification Sent");
                btn.removeAttr("disabled");
              },
              error     : function(){
                console.log("err");
              }
            });

            e.preventDefault();
          });

          sendSms.off().on("click", function(e){
            var selected  = $(".chosen-select").val();
            var message   = $("#message").val();
              
            $.ajax({
              url   : "backend/process.php",
              data  : {sendSms : true, recipients : selected, message : message},
              type  : 'POST',
              dataType  : 'JSON',
              success   : function(response){
                $("#sendSms").modal("hide");
              },
              error     : function(){
                console.log("err");
              }
            });
            console.log(selected);
            e.preventDefault();
          });

          checkAll.off().on("click", function(e){
            var checked = checkAll.is(":checked");
            var target  = $(this).parents(".table").find("input[name='smsId']");

            if(checked == true){
              target.prop("checked", true); 
            } else {
              target.removeAttr("checked");
            }
          });
          
          prepare.off().on("click", function(e){
            if($(this).data("new") == true){
              $("#message").val("");
              $("#message").off();
            } else {
              $("#message").attr("data-text","You are required to attend the orientation on ");

              var ele = $("#message");
              var lastText = ele.data("text");;
              ele.val(lastText);
              ele.on("keyup", function (){
                var val = $(this).val();
                var txt = $(this).data("text");
                var idx = val.search(txt);

                if(idx == -1){
                  $(this).val(lastText);
                } else {
                  lastText = val;
                }

              });
            }
            
            var ids = $("input[name='smsId']:checked");
            recipients.find("option:selected").removeAttr("selected");

            ids.each(function(){
              recipients.find("option[data-id='"+ $(this).val() +"']").attr("selected", "selected").trigger('chosen:updated');;
            });

            for (var selector in config) {
              $(selector).chosen(config[selector]);
            }

            $(".chosen-container").css("width", "100%");
            $("#sendSms").modal("show");

            e.preventDefault();
          });

          $("#saveMyRequirement").off().on("click", function(e){
              e.preventDefault();
               var id     = $(this).data("id");
              var req     = $(this).data("req");
              var data    = Array();
              var orientation = false;
              var active      = $(this).data("active");

              $(active).each(function(){
                  var check = $(this).find("input[type='checkbox']").is(":checked");
                  var req = $(this).find(".req-name").html();
                  if(check == true){
                      data.push(req);
                  }
              });

              if($(active).length == data.length){
                  orientation = true;
              }

              if(data.length > 0){
                var url = window.location.href;
                  $.ajax({
                      url     : "backend/process.php",
                      data    : {updateMyRequirements:true, data:data, id:id, orientation : orientation},
                      type    : 'POST',
                      dataType    : 'JSON',
                      success     : function(response){
                                 window.location.reload();
                      },
                      error   : function(){
                          console.log("err");
                      }
                  });
              } else {
                // alert("asda");
              }
          });

          $(".update-this-user").off().on("click", function(e){
              e.preventDefault();
              var id      = $(this).data("id");
              var req     = ""+$(this).data("req")+"|";
              var type    = $(this).data("membership");
              var found   = req.indexOf("|");
              var active  = null;
              var activeTxt = "";

              if(type == "Residential"){
                  $("#my-commercial-requirements").addClass("hidden");
                  $("#my-residential-requirements").removeClass("hidden");

                  active = $("#residential-requirement-edit li");
                  activeTxt = "#residential-requirement-edit li";
              } else {
                  $("#my-commercial-requirements").removeClass("hidden");
                  $("#my-residential-requirements").addClass("hidden");

                  active = $("#commercial-requirement-edit li");
                  activeTxt = "#commercial-requirement-edit li";
              }

              var counter  = 0;

              if( found> -1){
                  req = req.replace(/\&/g, '&amp;');

                  var data = req.split("|");

                  active.each(function(x){
                      var check = $(this).find("input[type='checkbox']");
                      var req = $(this).find(".req-name").html();
              console.log(data,req);
              console.log(x,data.indexOf(req));

                      if(data.indexOf(req) > -1){
                          check.attr("checked", "checked");
                          counter++;
                      } else {
                          check.removeAttr("checked");
                      }
                  });    
              } else {
                  active.each(function(){
                      var check = $(this).find("input[type='checkbox']");

                          check.removeAttr("checked");
                  }); 
              }

              if(counter == active.length){
                  $("#complete").removeClass("hidden");
                  $("#complete").attr("data-id", id);
              } else {
                  $("#complete").addClass("hidden");
                  $("#complete").attr("data-id", "null");
              }

              $("#saveMyRequirement").attr("data-active", activeTxt);
              $("#saveMyRequirement").attr("data-id", id);
              $("#saveMyRequirement").attr("data-req", req);
              $("#updateRequirement").modal("show");
          });

          $("#saveRequirement").off().on("click", function(){
              var data = Array();

              $("#residential-requirement li").each(function(){
                  var check = $(this).find("input[type='checkbox']").is(":checked");
                  var req = $(this).find(".req-name").html();
                  check = (check == true) ? 1 : 0;

                  data.push(Array(check, req, "residential"));
              });

               $("#commercial-requirement li").each(function(){
                  var check = $(this).find("input[type='checkbox']").is(":checked");
                  var req = $(this).find(".req-name").html();
                  check = (check == true) ? 1 : 0;

                  data.push(Array(check, req, "commercial"));
              });

              $.ajax({
                  url     : "backend/process.php",
                  data    : {updateRequirements:true, data:data},
                  type    : 'POST',
                  dataType    : 'JSON',
                  success     : function(response){
                      console.log(response);
                      $("#addRequirements").modal("hide");
                  },
                  error   : function(){
                      console.log("err");
                  }
              });
          });

          $("#complete").off().on("click", function(e){
              var id = $(this).data("id");
                $.ajax({
                      url     : "backend/process.php",
                      data    : {completeRequirement:true, id:id},
                      type    : 'POST',
                      dataType    : 'JSON',
                      success     : function(response){
                          console.log(response);
                          
                          $("#updateRequirement").modal("hide");
                      },
                      error   : function(){
                          console.log("err");
                      }
                  });
              e.preventDefault();
          });

          $("#addNewRequirement").off().on("click", function(){
              var name = $("#newRequirement").val();
              var tpl  = $("#req-tpl").html();
              var type = $("input[name='membership_type']:checked").val();

              if(name.length == 0){
                  alert("Enter a requirement name first.");
                  return false;
              }
              
              tpl = tpl.replace("[NAME]", name);

              if(type == "residential"){
                  $("#residential-requirement").append(tpl);
              } else {
                  $("#commercial-requirement").append(tpl);
              }
              
              me.__defaultListener();
          });

          activate.off().on("click", function(e){
              var me          = $(this);
              var val         = me.html();
              var id          = me.data("id");
              var opposite    = "";

              if(val == "active"){
                  opposite = 1;

                  me.html("inactive");
                  me.parents("tr").css("opacity", .3);
              } else {
                  opposite = 0;

                  me.html("active");
                  me.parents("tr").css("opacity", 1);
              }

              $.ajax({
                  url     : "backend/process.php",
                  data    : {id:id,deleted:opposite, updatedDeleted:true},
                  type    : 'POST',
                  dataType    : 'JSON',
                  success     : function(response){
                      console.log(response);
                  },
                  error       : function(){
                      console.log("err");
                  }
              });

              e.preventDefault();
          });
        },
        __error : function(error){
            $("#errors").html("");
            for(var i in error){
              $("#errors").append("<li>"+error[i]+"</li>");
            }
        }
      }

      Page.__init();
    })(jQuery);
    </script>
  </body>
</html>
