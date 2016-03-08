<?php include_once "backend/process.php"; ?>
<?php include_once "backend/user_access.php"; ?>
    <div class="blog-masthead">
      <div class="container">
                  <?php $count =  count($model->getAllApplicants(0,true)); ?>

        <nav class="blog-nav">
          <li class="this"><a class="blog-nav-item <?= (isset($_GET['active'])) ? (($_GET['active'] == "dashboard") ? "active" : "" ): ""?>" href="dashboard.php?active=dashboard">Dashboard</a></li>
          <?php if($config['request'] !="hidden"): ?>
          <li class="this "><a class="blog-nav-item service-sms <?= ($count>0) ? 'applicantColor': '';?> <?= (isset($_GET['active'])) ? (($_GET['active'] == "services")  ? "active" : ""): ""?>" >Services <span class="caret"></span></a>
            <ol>
              <?php if($config['request']['add_nature'] == 1): ?>
              <li><a href="add_nature.php?active=services">Add Nature of Complaint/Request</a></li>
              <?php endif ?>
              <?php if($config['request']['complaint_nature_list'] == 1): ?>
              <li><a href="complaint_nature_list.php?active=services">Nature of Complaints/Request</a></li>
              <?php endif ?>
              <?php if($config['request']['request'] == 1): ?>
              <li><a href="request.php?active=services">Request</a></li>
              <?php endif ?>
              <?php if($config['request']['complaints'] == 1): ?>
              <li><a href="complaints.php?active=services">Complaint</a></li>
              <?php endif ?>
              <?php if($config['request']['sms'] == 1): ?>
                <li><a href="sms.php?active=services">Consumer SMS<span class='smsCount'>0</span></a></li>
                <li><a href="walkin.php?active=services">Consumer Request/Complaint</li>
              <?php endif ?>

              <?php if($config['request']['complaints_list'] == 1): ?>
              <li><a href="complaints_list.php?active=services">Consumer Complaints Logbook</a></li>
              <?php endif ?>
              <?php if($config['request']['request_list'] == 1): ?>
              <li><a href="request_list.php?active=services">Consumer Requests Logbook</a></li>
              <?php endif ?>
              <!--  -->
              <?php if($config['user'] != 'hidden') :?>
                <?php if($config['user']['add_applicant'] == 1): ?>
                <li><a href="add_applicant.php?active=services">Add Walk In Applicant</a></li>
                <?php endif ?>
                <?php if($config['user']['applicant'] == 1): ?>
                <li><a href="applicant.php?active=services">Applicants<span class='applicantCount'>
                  <?= $count;?>
                </span></a></li>
                <?php endif ?>
              <?php endif ?>
            </ol>
          </li>
          <?php endif ?>
          <?php if($config['user'] !="hidden"): ?>
                  

          <li class="this "><a class="blog-nav-item  <?= (isset($_GET['active'])) ? (($_GET['active'] == "user")  ? "active" : ""): ""?>" >Users <span class="caret"></span></a>
            <ol>
              <?php if($config['user']['add_user'] == 1): ?>
              <!-- <li><a href="add_user.php?active=user">Add System User</a></li> -->
              <li><a href="add_systemuser.php?active=user">Add System User</a></li>
              <?php endif ?>
              <?php if($config['user']['users'] == 1): ?>
              <li><a href="users.php?active=user">System Users</a></li>
              <?php endif ?>
            </ol>
          </li>
          <li class="this "><a class="blog-nav-item  <?= (isset($_GET['active'])) ? (($_GET['active'] == "field")  ? "active" : ""): ""?>" >Field Users <span class="caret"></span></a>
            <ol>
              <?php if($config['user']['add_linespector'] == 1): ?>
              <li><a href="add_linespector.php?active=field">Add Lineman/Inspector Info.</a></li>
              <?php endif ?>
              <?php if($config['user']['all_linespector'] == 1): ?>
              <li><a href="all_linespector.php?active=field">All Lineman</a></li>
              <?php endif ?>
                <?php if($config['user']['all_linespector'] == 1): ?>
              <li><a href="all_inspector.php?active=field">All Inspector</a></li>
              <?php endif ?>
            </ol>
          </li>
          <?php endif ?>
          <?php $supply = $model->getAllSupply(true);  

          if($config['supply'] !="hidden"): ?>
          <li class="this "><a class="blog-nav-item <?= (count($supply)> 0) ? 'applicantColor': '';?> <?= (isset($_GET['active'])) ? (($_GET['active'] == "supply")  ? "active" : ""): ""?>" >Supply <span class="caret"></span></a>
            <ol>
              <?php if($config['supply']['supply'] == 1): ?>
              <li><a href="supply.php?active=supply">Supplies Inventory</a></li>
              <?php endif ?>
              <?php if($config['supply']['requisition'] == 1): ?>
              <li><a href="requisition.php?active=supply">Branch Requisition</a></li>
              <?php endif ?>
              <?php if($config['supply']['all_requisition'] == 1): ?>
              <li><a href="all_requisition.php?active=supply">All Supplies Requisition <span class="smsCount"><?= count($supply);?></span></a></li>
              <?php endif ?>
            </ol>
          </li>
          <?php endif ?>
          <?php if($config['schedule'] !="hidden"): ?>
          <li class="this "><a class="blog-nav-item <?= (isset($_GET['active'])) ? (($_GET['active'] == "schedule")  ? "active" : ""): ""?>" >Schedule <span class="caret"></span></a>
            <ol>
              <?php if($config['schedule']['schedule_complaints'] == 1): ?>
              <!-- <li><a href="schedule.php?active=schedule">All Schedule</a></li> -->
              <li><a href="schedule_complaints.php?active=schedule">Complaints</a></li>
              <?php endif ?>
              <?php if($config['schedule']['schedule_request'] == 1): ?>
              <!-- <li><a href="myschedule.php?active=schedule">My Schedule</a></li> -->
              <li><a href="schedule_request.php?active=schedule">Request</a></li>
              <?php endif ?>
            </ol>
          </li>
          <?php endif ?>
          <?php if($config['setting'] !="hidden"): ?>
          <li class="this "><a class="blog-nav-item <?= (isset($_GET['active'])) ? (($_GET['active'] == "system")  ? "active" : ""): ""?>" >System Setting <span class="caret"></span></a>
            <ol>
              <?php if($config['setting']['setting'] == 1): ?>
              <li><a href="setting.php?active=system">Setting</a></li>
              <?php endif ?>
               <?php if($config['setting']['slides'] == 1): ?>
              <li><a href="slides.php?active=system">Add Slideshow</a></li>
              <?php endif ?>
              <?php if($config['setting']['slideshow'] == 1): ?>
              <li><a href="slideshow.php?active=system">All Slideshow</a></li>
              <?php endif ?>
              <?php if($config['setting']['add_announcement'] == 1): ?>
              <li><a href="add_announcement.php?active=system">Add Announcement</a></li>
              <?php endif ?>
              <?php if($config['setting']['announcements'] == 1): ?>
              <li><a href="announcements.php?active=system">All Announcement</a></li>
              <?php endif ?>
              <?php if($config['setting']['add_branch'] == 1): ?>
              <li><a href="add_branch.php?active=system">Add Branch</a></li>
              <?php endif ?>
              <?php if($config['setting']['branches'] == 1): ?>
              <li><a href="branches.php?active=system">All Branches</a></li>
              <?php endif ?>

              <!-- TODO -->
              <?php if($config['setting']['add_brgy'] == 1): ?>
              <li><a href="add_brgy.php?active=system">Add Barangay</a></li>
              <li><a href="all_brgy.php?active=system">All Barangay</a></li>
              <?php endif ?>
            </ol>
          </li>
          <?php endif ?>
          <?php if($config['report']['report'] == 1): ?>
          <li class="this "><a class="blog-nav-item <?= (isset($_GET['active'])) ? (($_GET['active'] == "reports")  ? "active" : ""): ""?>" >Reports <span class="caret"></span></a>
            <ol>
              <li><a href="information_sheet_report.php?active=reports">Information Sheet</a></li>
              <li><a href="applicants_export.php?active=reports">Applications for Inspection</a></li>
              <li><a href="complaint_report.php?active=reports">Consumer Complaints Logbook</a></li>
              <li><a href="complaint_summary_export.php?active=reports">Summary of Consumer Complaints/Request</a></li>
              <li><a href="accomplishment_list_export.php?active=reports">List of Accomplishment</a></li>
              <li><a href="acknowledgement.php?active=reports">Acknowledgement Receipt</a></li>
            </ol>
          </li>
          <?php endif ?>

            <a href="logout.php" class="pull-right blog-nav-item">logout</a>
        </nav>
      </div>
    </div>
      <div id="pop-ups" style="position: fixed;bottom: 10px;left: 10px;width: 400px;z-index: 999;">

      </div>
    <script type="text/html" id="popup-notif">
      <div class="pop-up" style="margin:10px;width: 400px;min-height: 100px;background: [COLOR];font-size: 11px!important;
      z-index: 999;">
          <a href="" class="close-popup" style="color:black;float:right;margin:10px;">
            <span class="glyphicon glyphicon-remove"></span>
          </a>
          <blockquote style="font-size:15px;color:white;">
          <p style="font-size:15px;color:white;">[MESSAGE]</p>
            <a href="" style="font-size:15px;color:white;">[DATE]</a>
            </p>
          </blockquote>
      </div>
    </script>