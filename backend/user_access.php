  <?php 
    if(! isset($_SESSION['user'])){
      header("Location:index.php");  
    }
    //default is admin config
    $config = array(
        "request"     => array(
              "request"         => 1,
              "complaints"      => 1,
              "complaints_list" => 1,
              "sms" => 1,
              "request_list"    => 1,
              "add_nature"      => 1,
              "complaint_nature_list"   => 1),
          "user"      => array(
              "add_user"        => 1,
              "users"           => 1,
              "add_applicant"   => 1,
              "add_linespector"   => 1,
              "all_linespector"   => 1,
              "applicant"       => 1),
          "supply"    => array(
              "supply"          => 1,
              "requisition"     => 1,
              "all_requisition" => 1),
          "schedule"  => array(
              "schedule_complaints"        => 1,
              "schedule_request"      => 1),
          "setting"   => array(
              "slides"            => 1,
              "slideshow"         => 1,
              "add_announcement"  => 1,
              "announcements"     => 1,
              "add_branch"        => 1,
              "add_brgy"        => 1,
              "setting"        => 1,
              "branches"          => 1),
          "report"    => array(
              "report"          => 1));

  

  switch($_SESSION['user']['type']){
    case "consumer_service_coordinator" : 
      $config['user']['applicant'] = 1;
      $config['request']['request'] = 1;
      $config['request']['sms'] = 1;
      $config['request']['complaints'] = 1;
      $config['request']['complaints_list'] = 1;
      $config['request']['request_list'] = 1;
      $config['request']['complaint_nature_list'] = 1;
      // $config['supply']['all_requisition'] = 0;
      // $config['report']['report']       = 'hidden';
      $config['setting']['announcements'] = 0;
      $config['setting']['add_announcement'] = 0;

    break;
    case "isd_manager" : 
      $config['request']['request'] = 1;
      $config['request']['sms'] = 1;
      $config['request']['complaints'] = 1;
      $config['request']['complaints_list'] = 1;
      $config['request']['request_list'] = 1;
      $config['supply'] = "hidden";
      $config['user']['add_applicant'] = 0;
      $config['user']['applicant'] = 0;
      $config['user'] = "hidden";

      // $config['user']['users'] = 0;
      $config['schedule'] = "hidden";
      $config['report']['report'] = "hidden";
      $config['setting']['slides'] = 0;
      $config['setting']['slideshow'] = 0;
      $config['setting']['add_branch'] = 0;
      $config['setting']['branches'] = 0;
      $config['setting']['add_announcement'] = 1;
      $config['setting']['announcements'] = 1;
      $config['setting']['add_brgy'] = 0;
    break;
    case "warehouse_personnel":
      $config['request']  = 'hidden';
      $config['user']     = 'hidden';
      $config['setting']  = 'hidden';
      $config['report']['report']       = 'hidden';
      $config['schedule'] = 'hidden';
    break;
    case "brgy_captain" : 
    case "area_supervisor" : 
    case "main_office" : 
      $config['user'] = "hidden";
      $config['request']  = 'hidden';
      // $config['user']['applicant'] = 0;
      // $config['user']['add_applicant'] = 0;
      // $config['user']['add_user'] = 0;
      // $config['user']['users'] = 0;
      // $config['schedule']['schedule'] = 0;
      $config['schedule'] = 'hidden';
      $config['report']['report']       = 'hidden';
      $config['setting'] = 'hidden';
    break;

    case "line_man" : 
    case "applicant" : 
      $config['request']  = 'hidden';
      $config['user']     = 'hidden';
      $config['supply']   = 'hidden';
      $config['setting']  = 'hidden';
      $config['report']['report']       = 'hidden';
      // $config['schedule']['schedule']   = 0;
      // $config['schedule']['myschedule'] = 1;
      $config['schedule'] = 'hidden';
      
    break;
  }
?>