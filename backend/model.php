<?php
error_reporting(0);

class Model {
	protected $db;
	public $errors = array();

	function op($data){
		echo "<pre>";
		print_r($data);
	}

	function opd($data){
		op($data);
		die();
	}

	public function _isCurl(){
	    return function_exists('curl_version');
	}

	public function __construct(){
		// if (session_status() == PHP_SESSION_NONE) {
			session_start();
		// }

		// $this->testMsg();
		$curlEnabled = $this->_isCurl();

		if($curlEnabled == false){
			echo "Please enable the 'curl' setting in order to use the Chikka API";
			die();
		}

		$server 	= "localhost";
		$db 		= "meralco";
		$username 	= "root";
		$charset 	= "utf8";
		$password 	= "";

		// $server 	= "mysql13.000webhost.com";
		// $db 		= "a5559775_marelco";
		// $username 	= "a5559775_root";
		// $charset 	= "utf8";
		// $password 	= "matantei999";

		$db = new PDO("mysql:host=$server;dbname=$db;charset=$charset", $username, $password);

		$this->db = $db;

		$x = $this->getAllActiveLineman();
	
		$this->registrationListener();
		$this->loginUserListener();
		$this->addAnnouncementListener();
		$this->loadAnnouncementListener();
		$this->updateStudentInfoListener();
		$this->loadProfileListener();
		$this->restrictAccess();
		$this->loadFilesListener();
		$this->loadLinemanListener();
		$this->addEventListener();
		$this->loadEventListener();
		$this->logout();
		$this->complaintListener();
		$this->complaintListListener();
		$this->exportListener();
		$this->getComplaintListListener();
		$this->addSupplyListener();
		$this->updateSupplyListener();
		$this->deactivateUserListener();
		$this->updateSettingListener();
		$this->addSlidesListener();
		$this->getSetting();
		$this->deleteSlide();
		$this->addNatureListener();
		$this->deleteNatureListener();
		$this->addApplicationListener();
		$this->addBranchListener();
		$this->updateRequirementsListener();
		$this->searchApplicant();
		$this->updateMyRequirementsListener();
		$this->addMaterialListener();
		$this->updateMaterialListener();
		$this->searchMaterial();
		$this->completeRequirementListener();
		$this->editNatureListener();
		$this->searchEmailListener();
		$this->generateReportListener();
		$this->sendSmsListener();
		$this->updateBranchListener();
		$this->getMyScheduleListener();
		$this->updateUserListener();
		$this->addBrgyListener();
		$this->sendMessageListener();
		$this->filterStatusListener();
		$this->viewMessages();
		$this->sendStockNotificationListener();
		$this->ajaxMunicipalityListener();
		$this->sendRequirementNotificationByConsumerTypeListener();
		$this->updateRequirementsChecklistListener();
		$this->updateEventScheduleListener();
		$this->getReceiverSMS();
		$this->approveSmslistener();
		$this->sendMembershopNotificationListener();
		$this->notifySmsListener();
		$this->sendLinemanNotificationListener();
		$this->deleteComplaintNatureListener();
		$this->getRemainingStockListener();
		$this->deleteNewsListener();
		$this->updateNewsListener();
		$this->updateSlideShowListener();
		$this->scheduleMemberListener();
		$this->addStockListener();
		$this->addSchedulerListener();
		$this->getLinemanEventsListener();
		$this->deleteLinemanEventListener();
		$this->updateEventListener();
		$this->getSchedulingEventListener();
		$this->forgotpasswordListener();
		$this->sendRequestRequirementsNotificationListener();
		
		// $this->populateBrgy();
	}	

	public function verify($id){
		$stmnt = $this->db->prepare("
				UPDATE user
				SET status = 3
				WHERE WHERE id = ?
			");
		$stmnt->execute(array($id));

		Header("Location:login.php");
	}

	public function forgotpasswordListener(){
		if(isset($_POST['forgotpassword'])){
			$user = $_POST;
			$exists = $this->db
				->query("SELECT * FROM user WHERE username = '".$user['username']."' LIMIT 1");

			if($user['password'] != $user['password2']){
				$this->errors[] = "Passwords didn't match";
			}	

			if(strlen($user['password']) < 6){
				$this->errors[] = "Password is too short";
			}

			if($exists->rowCount($user['username']) == 0){
				$this->errors[] = "Username doesnt exists";
			}

			if(count($this->errors) > 0){
				$this->getErrors();
			} else {
				$record = $exists->fetch();
				$id = $record['id'];

				//alert d2
				$stmnt = $this->db->prepare("
						UPDATE user
						SET password = ?,
						status = 0
						WHERE id = ?
					");
				$stmnt->execute(array(md5($user['password']), $id));

				$url = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
				$url = str_replace("backend/process.php", "verify.php", $url);
				$url .= "?id=".$id;
				$msg = "Click the following link to reset your password\n $url";

				// use wordwrap() if lines are longer than 70 characters
				$msg = wordwrap($msg,70);
				// send email
				mail($record['email'],"Password Reset Request",$msg);

				die(json_encode(array("added" => true)));
			}
		}
	}

	public function getActiveLinemanSchedule(){
		$records = array();
		$branch = $this->getBranchById($_SESSION['user']['branch_id']);
		$branch = $branch['municipality'];

		$stmnt = $this->db->prepare("
				SELECT t1.*,t2.branch_id,t3.municipality,t2.type as 'userRole'
				FROM user_schedule t1
				LEFT JOIN user t2 ON t1.userid = t2.id
				LEFT JOIN info t4 ON t2.id = t4.userid
				LEFT JOIN branch t3 ON t2.branch_id = t3.id
				WHERE t2.deleted = 0
				AND t4.municipality LIKE '%".$branch."%'
				ORDER BY t2.id, t1.start
			");

		$stmnt->execute();

		while ($row = $stmnt->fetch()) {
			$row['superBranch'] = $branch;
			$records[] = $row;
		}
		
		return $records;
	}

	public function getAllActiveComplaints(){
		$complaints = array();
		$branch = $this->getBranchById($_SESSION['user']['branch_id']);
		$branch = $branch['municipality'];

		$stmnt = $this->db->prepare("
			SELECT t1.* , t3.emergency_level,t3.alloted_time,t3.type as 'natureType'
				from complaints t1
				LEFT JOIN nature t3 ON t1.complaint_nature = t3.name
				where t1.id not in(select DISTINCT(t2.complaint_id) from schedule t2)
				AND t1.municipality LIKE '%".$branch."%'
				AND t1.completed = 1
				ORDER BY t1.type,t1.dateadded,FIELD(t3.emergency_level,'High','Medium','Low'),t1.brgy ASC
			");

		$stmnt->execute();
		$counter = 0;
		while($row = $stmnt->fetch()){
			$row['added'] = false;
			$row['filter_level'] = 0;
			$row['idx'] = $counter;
			$complaints[] = $row;
			$counter++;
		}	

		return $complaints;
	}

	public function superScheduler($lineman){
		$branch = $this->getBranchById($_SESSION['user']['branch_id']);
		$branch = $branch['municipality'];

		$this->db->query("delete from schedule where branch LIKE '%".$branch."%'");

		// die();
		//if lineman = 0, reason = no lineman,inspector available to all schedule
		if(count($lineman) === 0){
			$stmnt = $this->db->query("
					UPDATE complaints
					SET reason = 'No Lineman/Inspector added'
				");
		}

		$today 		= date("Y-m-d H:i:s");
		// todo: if may record na ung sched ni lineman this week, move to next week
		//if no assigned task for this week, check next week, update $today var
		$noCurrentWeekTask 	= false;

		// if cant find record on 3rd week, end infinite loop
		$weekLoop = 0;

		//for time adjustment if current time is within dateDiff but greater than startDate, for 1st loop only
		$initialTimeCounter = 0;

		//loop until no complaints left
		// do {
		// 	if($weekLoop >= 3){
		// 		$noCurrentWeekTask = TRUE;
		// 		break;
		// 	}
			$foundFirstSched = false;
			foreach($lineman as $idx => $l){
				$startDay 	= date("l", strtotime($l['start']));
				$todayDay 	= date("l", strtotime($today));

				$found = false;

				if(date("N", strtotime($todayDay)) > date("N", strtotime($startDay))){
					continue;
				}

				//current week lang ang maseschedule para maipon at maschedule by priority
				while($found == false){
					$tomorrow = new DateTime($today." +1 day");
					$today = $tomorrow->format("Y-m-d H:i:s");
					$todayDay 	= date("l", strtotime($today));
					
					if(date("N", strtotime($todayDay)) == date("N", strtotime($startDay))){
						$found = true;
						// echo "<pre>";
						// echo "DATE FOUND<pre>";
						// var_dump($today);
					}
				}

					$startDate 	= new DateTime($l['start']);
					$endDate  	= new DateTime($l['end']);
					$dateDiff 	= $startDate->diff($endDate);

					//get total differents in minutes because alloted_time is set to minutes too
					$minutes = $dateDiff->days * 24 * 60;
					$minutes += $dateDiff->h * 60;
					$minutes += $dateDiff->i;
				
					if(date("N", strtotime($todayDay)) == date("N", strtotime($startDay))){
						$complaint 	= $this->getAllActiveComplaints();

						foreach($complaint as $idx => $c){
						 	if($c['alloted_time'] == ""){
								$c['alloted_time'] = 30;
							}


							/**
							* TODO: SELECT ONLY THE SCHEDULE OF THE LINEMAN THAT IS GREATER THAN THE CURRENT DATE
							*/

							$inStock = $this->isInStock($c['brgy'], $c['complaint_nature']);

							if($inStock === true){
								//if remaining minutes is still enough to cover the complaints time, move next
								if( (($l['userRole'] == "line_man") && ($c['natureType'] == "complaint")) || 
									(($l['userRole'] == "inspector") && ($c['natureType'] == "request")) 
									){
										if($c['alloted_time'] <= $minutes){
											$adjusted = false;

											if($complaint[$idx]['added'] === false){
												// time adjustment occurs on first schedule time of the day only
												if($initialTimeCounter == 0){
												// if($foundFirstSched === false){
													$todayDateTime 		= new DateTime($today);
													$sDate = clone $startDate;
													$todayStartDateDiff = $sDate->diff($todayDateTime);
													
													$minutes2 = $todayStartDateDiff->days * 24 * 60;
													$minutes2 += $todayStartDateDiff->h * 60;
													$minutes2 += $todayStartDateDiff->i;
													
													$adjustedStartDate = $sDate->add(new DateInterval('PT' . $minutes2 . 'M'));
													$generatedStartDate = new DateTime($adjustedStartDate->format("Y-m-d H:i:s")." -7 days");

													$x = strtotime($generatedStartDate->format("Y-m-d H:i:s"));
													$y = strtotime($endDate->format("Y-m-d H:i:s"));
													$minDiff = date("i",strtotime($x-$y));
													
													// if($c['alloted_time'] <= $minDiff){
													// 	break;
													// } 

													//if startdate > end date
													if($x>$y){
														// echo "2<pre>";
														// // print_r($startDate);
														// echo "<pre>";
														// print_r($generatedStartDate);
														// echo "<pre>";
														// print_r($endDate);
														// // die();
														continue;
													}

													//if today == startdate
													if(date("N", strtotime(date("Y-m-d"))) == date("N", strtotime($generatedStartDate->format("Y-m-d H:i:s")))){
														$startDate = $generatedStartDate;
														$minutes -= $todayStartDateDiff->i;
														$adjusted = true;
													}
												}

												//normal deduction of remaining time
												$finalEnd = clone $startDate;
												$finalEnd = $finalEnd->add(new DateInterval('PT' . $c['alloted_time'] . 'M'));
												// echo "<pre>";
												// print_r($startDate);
												$continue = false;
												if($adjusted === true){
													$adjustedEndDate = $finalEnd->format("Y-m-d H:i:s");

													if(strtotime($adjustedEndDate) <= strtotime(date("Y-m-d H:i:s", $l['end']))){
														$continue = true;
													} 
													
												} else {
													$continue = true;
												}

												if($continue == true) {
													// check first if schedule already 	exists, if true, move to next available schedule +minutes
													$stmnt = $this->db->query("
														SELECT e_date
														FROM schedule
														WHERE branch LIKE '%".$l['superBranch']."%'
														AND s_date BETWEEN '".$startDate->format("Y-m-d H:i:s")."' AND '".date("Y-m-d H:i:s",strtotime($l['end']))."'
														ORDER BY e_date DESC
		            									LIMIT 1
													");

													$isLastRecordEnough = $stmnt->fetch();

													$add = true;
													// // // // todo:add by lineman filter
													if($stmnt->rowcount() > 0){
														// break;
														$lastMinute = new DateTime($isLastRecordEnough['e_date']);
														$xxx = clone $endDate;
														$lastMinDiff 	= $lastMinute->diff($xxx);

													
														// die();
														if($c['alloted_time'] < $lastMinDiff->i){
																// echo "1<pre>";
																// print_r($startDate);
																$add = false;
															// continue;
														}
														// if end date > l[end]

														if(strtotime($finalEnd->format("Y-m-d H:i:s")) >  strtotime(date("Y-m-d H:i:s", strtotime($l['end'])))){
															// echo "d2<pre>";
															// var_dump($finalEnd);
															// echo "<pre>";
															// var_dump($l['end']);
															$add = false;
															// continue;
														}	
														// continue;
													} 

														if($add == true){
															$z = $finalEnd->format("Y-m-d H:i:s");
															$zz = date("Y-m-d H:i:s", strtotime($l['end']));
															// echo "d2<pre>";
																// var_dump($startDate->format("Y-m-d H:i:s"));
	// echo "<pre>";			
	// 															var_dump($z);
	// 															echo "<pre>";
	// 															var_dump($zz);
																	if(strtotime($z) > strtotime($zz)){
																		$add = false;
																	}
														}
														
															
													if($add === true){
														
														//if today, ifFoundFirst == false, if startDateHIS>currentDateHIS
														//foundFirst = true
														$finalAdd = true;

														if(date("N", strtotime($todayDay)) == date("N", strtotime(date("Y-m-d H:i:s")))){
															// var_dump(date("H:i:s"));
															if($foundFirstSched === false){
																if(strtotime(date("H:i:s")) > strtotime($startDate->format("H:i:s")) ){
																// if(strtotime($startDate->format("H:i:s")) <= strtotime(date("H:i:s"))){
																	// $finalAdd = false;
																	echo "<pre>";
																	echo "<pre>";
																	var_dump($startDate->format("H:i:s"));
																	echo "<pre>";
																	var_dump((date("H:i:s")));
																	// if($adjusted){

																	// }
																	continue;
																}
															} 
															
														}	
														
														if($finalAdd === true){
															$stmnt = $this->db->prepare("
															INSERT INTO schedule(overview,complaint_id,user_id,startdate,enddate,lineman_id,inspector_id,branch,s_date,e_date)
															VALUES(?,?,?,?,?,?,?,?,?,?)
														");

														$stmnt->execute(array(
																$c['complaint_nature'],
																$c['id'],
																$_SESSION['user']['id'],
																// 1,
																$startDate->format("D M d Y H:i:s"),
																$finalEnd->format("D M d Y H:i:s"),
																(($l['userRole'] == "line_man") ? $l['userid'] : ""),
																(($l['userRole'] == "inspector") ? $l['userid'] : ""),
																$branch,
																$startDate->format("Y-m-d H:i:s"),
																$finalEnd->format("Y-m-d H:i:s")
															));

															$minutes 			-= $c['alloted_time'];
															$startDate 			= $finalEnd;
															$complaint[$idx]['added'] 	= true;
														}
														
														// $notified = $this->checkIfNotifiedByComplaintId($c['id']);

														// if($notified != true){
														// 	$this->addScheduleNotif($c['id']);
														// 	$this->getLinemanMessageForAutoScheduling($startDate->format("D M d Y H:i:s"), $c['id'], $l['userid']);
														// } 
													}
													
												}
											} else {
												break 1;
											}
										} else {
											if($complaint[$c['idx']]['filter_level'] <= 4){
												$complaint[$c['idx']]['filter_level'] = 4;
												//reason : alloted time doesnt fit lineman/inspector's schedule
												$stmnt = $this->db->prepare("
														UPDATE complaints
														SET reason = ?
														WHERE id = ?
													");

												$stmnt->execute(array(
														"Alloted Time for this request doesn't fit any lineman's schedule",
														$c['id']
													));
											}

											break 1;
										}
								} else {
									if($complaint[$c['idx']]['filter_level'] <= 3){
										$complaint[$c['idx']]['filter_level'] = 3;

										$stmnt = $this->db->prepare("
											UPDATE complaints
											SET reason = ?
											WHERE id = ?
										");

										$stmnt->execute(array(
												"No Assigned Inspector/Lineman for this type of request.",
												$c['id']
											));	
									}
								}
							} else {
								if($complaint[$c['idx']]['filter_level'] <= 1){
										$complaint[$c['idx']]['filter_level'] = 1;
									//reason : alloted time doesnt fit lineman/inspector's schedule
									$stmnt = $this->db->prepare("
											UPDATE complaints
											SET reason = ?
											WHERE id = ?
										");

									$stmnt->execute(array(
											"Alloted Time for this request doesn't fit any lineman's schedule",
											$c['id']
										));
								}
							}
								
							$initialTimeCounter++;
						}
					} else {
					}
				// }
			}

			//set to next monday 00 AM if no record matches this whole week
			// $today = date("Y-m-d H:i:s", strtotime("next monday"));

			// $weekLoop++;

		// } while ($noCurrentWeekTask === false);

		die(json_encode(array("done")));
	}

	public function addScheduleNotif($id){
		$stmnt = $this->db->prepare("
				INSERT INTO schedule_notif
				VALUES(null,?)
			");
		$stmnt->execute(array($id));
	}

	public function checkIfNotifiedByComplaintId($id){
		return $this->db->query("
				SELECT *
				FROM schedule_notif
				WHERE complaint_id = ".$id."
			")->rowcount();
	}

	public function isInStock($brgyId, $nature){
		$branch = $this->getBrgyById($brgyId);
		$branchId = $branch['branch_id'];

		$stmnt = $this->db->prepare("
				SELECT t3.id,t1.name,t2.quantity,t3.quantity as 'q2'
				FROM nature t1
				LEFT JOIN nature_supply t2 ON t2.nature_id = t1.id
				LEFT JOIN material t3 ON t3.id = t2.material_id
				WHERE t1.name = ?
				AND t3.branch_id = ?
			");
		$stmnt->execute(array($nature, $branchId));
		$record = $stmnt->fetchAll();


		foreach($record as $idx => $r){
			if($r['q2'] >= $r['quantity']){
				// $quantity = true;
			} else {
				return false;
			}
		}

		return true;
	}

	public function getLinemanMessageForAutoScheduling($start_date, $complaint_id, $lineman_id){
		$time = current(explode("(",$start_date));
		$start = explode(" " , $time);
		$startDate = $start[1]."/".$start[2]."/".$start[3]." ".$start[4];
		$complaint = $this->getComplaintDetailById($complaint_id);
		$lineman = $this->getInfoByUserId($lineman_id);
		// $inspector = $this->getInfoByUserId($_POST['inspector']);

		$brgy = $this->getBrgyById($complaint['brgy']);
		$consumerName = $complaint['firstname']." ".$complaint['middlename']." ".$complaint['lastname'];
		$address = $brgy['name']." ".$complaint['municipality']." ".$complaint['province'];

		$message = "Request Detail[".$startDate."] : ".$complaint['complaint_nature']."
		".$consumerName.", ".$address.", ".$complaint['contact_number'];

		$data = array(
				"message" => $message,
				"recipients" => array(
						$lineman[0]['contact_number'],
						$complaint['contact_number']
					)
			);

			foreach($data['recipients'] as $idx => $r){
				$this->sendMessage($r, $message);
			}

		// die(json_encode($data));
	}

	public function getClosestDate($date, $dayName = "Sun", $year = -1) {
	    $cts = strtotime($date);
	    $ts = strtotime("{$year} YEAR", $cts);

	    switch($dayName){
	    	case "Mon" : $day = 1; break;
	    	case "Tue" : $day = 2; break;
	    	case "Wed" : $day = 3; break;
	    	case "Thur" : $day = 4; break;
	    	case "Fri" : $day = 5; break;
	    	case "Sat" : $day = 6; break;
	    	case "Sun" : $day = 0; break;
	    }

	    $days = array(
	        'Sunday',
	        'Monday',
	        'Tuesday',
	        'Wednesday',
	        'Thursday',
	        'Friday',
	        'Saturday',
	    );

	    $day = $days[$day];

	    $prev = strtotime("PREVIOUS {$day}", $ts);
	    $next = strtotime("NEXT {$day}", $ts);

	    $prev_gap = $ts - $prev;
	    $next_gap = $next - $ts;

	    return $prev_gap < $next_gap ? $prev : $next;
	}

	public function getSchedulingEventListener(){
		if(isset($_POST['getSchedulingEvent'])){
			$lineman = $this->getActiveLinemanSchedule();
			
			$this->superScheduler($lineman);

		}
	}

	public function updateEventListener(){
		if(isset($_POST['updateEvent'])){
			$id = $_POST['id'];
			$enddate = $_POST['endDate'];
			$time = strtotime($enddate);
		    $enddate = Date('m/d/Y H:i:s', $time);

		    $stmnt = $this->db->prepare("
		    		UPDATE user_schedule
		    		SET end
		    		 = ?
		    		WHERE id = ?
		    	");
		    $stmnt->execute(array($enddate, $id));

		    die(json_encode(array("updated" => true)));
		}	
	}

	public function deleteLinemanEventListener(){
		if(isset($_POST['deleteLinemanEvent'])){
			$stmnt = $this->db->prepare("
					DELETE FROM user_schedule
					WHERE id = ?
				");
			$stmnt->execute(array($_POST['id']));

			die(json_encode(array("deleted")));
		}
	}

	public function getLinemanEventsListener(){
		if(isset($_POST['getLinemanEvents'])){
			$records = array();
			$stmnt = $this->db->prepare("
					SELECT *
					FROM user_schedule
					WHERE userid = ?
				");
			$stmnt->execute(array($_POST['id']));

			while($row = $stmnt->fetch()){
				$sTime = explode(" ", $row['start']);
				$day = date("l",strtotime($row['start']));
				$start = date("m/d/Y",strtotime($day.' this week'));

				$sTime = end($sTime);
				$start .= " ".$sTime;

				$eTime = explode(" ", $row['end']);
				$day = date("l",strtotime($row['end']));
				$end = date("m/d/Y",strtotime($day.' this week'));
				$eTime = end($eTime);
				$end = $end." ".$eTime;
				// echo "<pre>";
				// print_r($row);
				// $start
				$data = array(
						"id" => $row['id'],
						"start" => $start,
						"added" => "true",
						"end" => $end
					);

				$records[] = $data;
			}

			die(json_encode(array("serverDate" => date("m-d-Y"), "records" => $records)));
		}
	}

	public function addSchedulerListener(){
		if(isset($_POST['addScheduler'])){
			$time = strtotime("-8 hour",strtotime(current(explode("(",$_POST['start']))));
		    $his = Date('H:i:s', $time);
		    $day = Date('l', $time);
		    if($day == "Sunday"){
		    	$time = strtotime("+7 days", $time);
		    }

		    $start = Date('m/d/Y H:i:s', $time);
		    $end = "";
		    $newtimestamp = strtotime("$start + 30 minute");

		    if($_POST['end'] == ""){
			    $end = Date('m/d/Y H:i:s', $newtimestamp);
		    } else {
				$end = strtotime("-8 hour",strtotime(current(explode("(",$_POST['end']))));

				  if($day == "Sunday"){
			    	$end = strtotime("+7 days", $end);
			    }


			    $end = Date('m/d/Y H:i:s', $end);
		    }
		 
		 //   	$dStart = new DateTime($start);
			// $dEnd = new DateTime($end);

			$stmnt = $this->db->prepare("
						INSERT INTO user_schedule
						VALUES(NULL,?,?,?)
				");
		
			$stmnt->execute(array($_POST['id'],$start,$end));

			die(json_encode(array("addedd2")));
		}
	}

	public function addStockListener(){
		if(isset($_POST['addStock'])){
			$supplies = $_POST['supplies'];
	
			foreach($supplies as $idx => $s){
				$parentMaterial = $this->getMaterialById($s[2]);
			
				$this->updateSupplyById($parentMaterial['parent_id'], $s[1]);
				$stmnt = $this->db->prepare("
					UPDATE material
					SET 
					quantity = quantity + ?
					WHERE id = ?
				");

				$stmnt->execute(array($s[1], $s[2]));

				//update supply approved
			}

			//mark request as approved
			$stmnt = $this->db->prepare("
					UPDATE supply
					SET approved = 1
					WHERE id = ?
				");
			$stmnt->execute(array($_POST['id']));

			die(json_encode(array("true")));
		}
	}

	public function verifyUserById($id){
		$stmnt = $this->db->prepare("
				UPDATE user
				SET note = ?
				WHERE id = ?
			");
		$stmnt->execute(array("1", $id));
	}

	public function scheduleMemberListener(){
		if(isset($_POST['scheduleMember'])){
			$data = $_POST['data'];

			foreach($data as $idx => $member){
				$id = $member[0];
				$user = $this->getInfoByUserId($id);

				$user[0]['type'] = "request";
				$user[0]['province'] = "Marinduque";
				$user[0]['or_number'] = "";
				$user[0]['consumer_name'] = "";
				$user[0]['address'] = "";
				$user[0]['complaint_nature'] = "Membership";
				$user[0]['action_taken'] = "";
				$user[0]['action_datetime'] = "";
				$user[0]['action_desired'] = "";
				$user[0]['complaint_datetime'] = $member[1];

				// update verified column of user table /note
				$this->verifyUserById($id);

				//add to complaint list for scheduling
				$this->processComplaint($user[0]);
			}
		}
	}

	public function updateSlideShowListener(){
		if(isset($_POST['updateSlideShow'])){

			$stmnt = $this->db->prepare("
					UPDATE slides
					SET title = ?, `desc` = ?
					WHERE id = ?
				");
			$stmnt->execute(array($_POST['title'], $_POST['desc'], $_POST['id']));
			die(json_encode(array("updated" => true)));
		}
	}

	public function deleteNewsListener(){
		if(isset($_POST['deleteNews'])){
			$stmnt = $this->db->prepare("
					DELETE FROM  announcement
					WHERE id = ?
				");

			$stmnt->execute(array($_POST['id']));

			die(json_encode(array("deleted" => true)));
		}
	}

	public function updateNewsListener(){
		if(isset($_POST['updateNews'])){
			$stmnt = $this->db->prepare("
					UPDATE announcement
					SET title = ?,
					description = ?
					WHERE id = ?
				");
			$stmnt->execute(array($_POST['title'], $_POST['desc'], $_POST['id']));

			die(json_encode(array("updated")));
		}
	}

	public function getRemainingStockListener(){
		if(isset($_POST['getRemainingStock'])){
			$stmnt = $this->db->prepare(
					"
					SELECT quantity
					FROM material
					WHERE id = ?
					LIMIT 1
					"
				);
			$stmnt->execute(array($_POST['parentId']));
			$record = $stmnt->fetch();

			die(json_encode(array($record['quantity'])));
		}
	}

	public function deleteComplaintNatureListener(){
		if(isset($_POST['deleteComplaintNature'])){
			$id = $_POST['id'];

			$stmnt = $this->db->prepare("
					DELETE 
					FROM  nature
					WHERE id = ?
				");
			$stmnt->execute(array($_POST['id']));

			die(json_encode(array("deleted")));
		}
	}

	public function populateBrgy(){
		$brgy = array(
				"boac" => array(
					"Agot","Agumaymayan","Amoingon","Apitong","Balagasan","Balaring","Balogo","Bamban","Bangbangalon",
					"Bantad","Bantay","Bayuti","Binunga","Boi","Boton","Buliasnin","Bunganay","Caganhao","Canat","Catubugan",
					"Cawit","Daig","Daypay","Duyay","Hinapulan","ihatub Isok 1 (poblacion)","Isok 2 (poblacion)","Laylay","Lupac",
					"Mahinhin","Mainit","Malbog","Maligaya","Malusak()","Mansiwat","Mataas na bayan","Maybo","Mercado","(Poblacion)",
					"Murallon (Poblacion)","Ogbac","Pawa","Pili","Poctoy","Poras","Puting BuHangin","Puyog","Sambong",
					"San Miguel (Poblacion)","San Miguel (Poblacion)","Santol","Sawi","Tabi","Tabigue","Tagwak","Tambunan",
					"Tampus (poblacion)","Tanza","Tugos","Tumagabok","Tumapon"),
				"mogpog" => array(
					"Anapog-Sibucao","Argao","Balanacan","Banto","Bintakay","Bocboc","Butansapa","Candahon","Capayang"," Danao",
					"Dulong Bayan (Pob.)"," Gitnang Bayan (Pob)","Guisian","Hinadharan","  Hinanggayon","Ino","Janagdong",
					"Lamesa","Laon","Magapua","Malayak","Malusak ","Mampaitan","Mangyan-Mababad","Market Site (PoB.)","Mataas na Byan",
					"Mendez","Nangka I (Pob.)","Nangka 2"," Paye","Pili","Putung Buhangin","Sayao","Silangan","Sumanggga","Tarug",
					"Villa Mendez (Pob.)"),
				"gasan" => array(
					"Antipolo","Bachao Ilaya","Bachao Ibaba","Bacong-Bacong","Bahi","Bangbang","Banot","Banuyo","Bognuyan",
					"Cabugao","Dawis","Dili","Libtangin","Mahunig","Mangiliol","Masiga","Matangdang Gasan","Pangi","Pinggan",
					"Tabionan","Tapuyan","TIGUION","Barangay I (Pob.)","Barangay II (Pob.)","Barangay III (pob)"),
				"buenavista" => array(
					"Bagacay","Bagtingon","Bicas-bicas","Caigangan","Daykitin","Libas","Malbog","Sihi"," Timbo","Tungib-Lipata",
					"Yook","Barangay 1 Pob.","Barangay II Pob.","Barangay III Pob.","Barangay IV Pob."),
				"sta. cruz" => array(
					"Alobo","Angas"," Aturan","Bagong Silangan Pob","Baguidbirin","Baliis","Balogo","Banahaw Pob. Bangcuangan",
					"Banogbog","Biga","Botilao"," Buyabod","Dating Byan","Devilla","Dolores","Haguimit Hupi","Ipil","Jolo","Kaganhao",
					"Kalangkang","Kamandugan","Kasily","Kilo-kilo","Kinyaman","Labo","Lamesa","Landy"," Lapu-lapu Pob.","Libjo","Lipa",
					"Lusok","Maharlika Pob.","Makulapnit","Maniwaya","Manlibunan","Masaguisi","Masalukot","Matalaba","Mongpong",
					"Morales"," Napo","Pag-asa Pob.","Pantayin","Polo","Pulong-parang","San Isidro","Punong","San Antonio",
					"San Isidro","Tagum","Tamayo"," Tambangan","Tawiran","Taytay"),
				"torrijos" => array(
					"Bayakbakin","Bolo","Bonliw","Buangan"," Cabuyo","Cagpo","Dampulan","Bangwayin","KayDuke","Mabuhay","Makawayan",
					"Malibago","Malinao","Maranlig","Marlangga","Matuyatuya","Nangka","Pakaskasan","Payanas","Poblacion","Poctoy",
					"Sibuyao","Suha","Talawan","Tigwi")
			);
		
		//boac 6,mogpog 7,gasan 8,stacruz 9,buenavista 10,torrijos 11
		foreach($brgy as $municipality => $b){
			foreach($b as $bb){
				$branch = 6;
				switch($municipality){
					case "mogpog" : 
						$branch = 7;
					break;

					case "gasan" : 
						$branch = 8;
					break;
					
					case "buenavista" : 
						$branch = 9;
					break;
					
					case "sta. cruz" : 
						$branch = 10;
					break;
					
					case "torrijos" : 
						$branch = 11;
					break;
				}
				$stmnt = $this->db->prepare(
						"INSERT INTO brgy
							VALUES(NULL,?,?,?)
						"
					);
				$stmnt->execute(array($bb,$branch,$municipality));

			}

		}
		die('added');

	}

	public function getMissingRequirementByUserId($id, $type, $recipient){
		$stmnt = $this->db->prepare("
				SELECT requirement
				FROM user
				WHERE id = ?
			");
		$stmnt->execute(array($id));
		$record = $stmnt->fetch();
		$record = explode("|", $record['requirement']);
		$record = array_flip($record);
	
		$missing = array();
		$requirements = $this->getAllRequirementsByType($type);

		foreach($requirements as $idx => $r){
			if(!array_key_exists($r['name'], $record)){
				$missing[] = $r['name'];
			}
		}
		
		if(count($missing) > 0){
			$req = implode(",", $missing);
			$message = "Missing Requirements: ".$req;
			
			$this->sendMessage($recipient, $message);
		}
	}

	public function notifySmsListener(){
		if(isset($_POST['notifySms'])){
			foreach($_POST['data'] as $idx => $d){
				$this->getMissingRequirementByUserId($d[0], $d[2], $d[1]);
			}
		}
	}

	public function approveSmslistener(){
		if(isset($_POST['approveWalkin'])){
			$stmnt = $this->db->prepare("
					UPDATE complaints
					SET completed = 1
					WHERE id = ?
				");
			$stmnt->execute(array($_POST['id']));

			die(json_encode(array("added")));
		}

		if(isset($_POST['approveSms'])){
			$records = array();
			$stmnt = $this->db->prepare("
				SELECT *,(
						SELECT t2.name
						FROM nature t2
						WHERE t2.id = ?
						LIMIT 1
					) as nature
				FROM sms
				WHERE id = ?
				LIMIT 1
				");
			$stmnt->execute(array($_POST['complaintId'],$_POST['id']));
			$record = $stmnt->fetch();

			$record['number'] = str_replace("639", "09", $record['sender']);
			$message = explode("/" , $record['message']);
			
			$fullname = explode(",", $message[0]);
			$nature = explode(" ", $fullname[0]);
			$natureComplaint = $nature[0];
			$address = explode(",", $message[1]);
			$record['firstname'] = isset($nature[1]) ? $nature[1] : "";
			$record['middlename'] = isset($fullname[1]) ? $fullname[1] : "";
			$record['lastname'] = isset($fullname[2]) ? $fullname[2] : "";
			$record['brgy'] = isset($address[0]) ? $address[0] : "";
			$record['municipality'] = isset($address[1]) ? $address[1] : "";
			// $record['brgy'] = "as33sssssd";
			$stmnt = $this->db->query("
					SELECT id
					FROM brgy
					WHERE name = '".trim($record['brgy'])."'
					LIMIT 1
				");
			$brgy = $stmnt->fetch();

			//check first if valid brgy 
			$brgyCount = $stmnt->rowCount();
			if($brgyCount == 0){
				die(json_encode(array("failed" => "Invalid Brgy")));
			}
			//check first if valid municipality
			$stmnt = $this->db->query("
					SELECT DISTINCT(municipality)
					FROM brgy
					WHERE municipality = '".$record['municipality']."'
					LIMIT 1
				");
			$muni = $stmnt->fetch();

			//check first if valid brgy 
			$muniCount = $stmnt->rowCount();
			if($muniCount == 0){
				die(json_encode(array("failed" => "Invalid Municipality")));
			}

			$record['brgy'] = $brgy['id'];

			//update instead of insert
			$stmnt = $this->db->prepare("
					UPDATE complaints
					SET completed = 1
					WHERE id = ?
				");
			$stmnt->execute(array($_POST['realComplaintId']));
			// $stmnt = $this->db->prepare("
			// 	INSERT INTO complaints(
			// 		contact_number,
			// 		complaint_nature,
			// 		dateadded,
			// 		type,
			// 		firstname,
			// 		middlename,
			// 		lastname,
			// 		brgy,
			// 		municipality,
			// 		province
			// 	)
			// 	VALUES(?,?,?,?,?,?,?,?,?,?)
			// ");
			// $natureId = str_replace("C-", "", $natureComplaint);

			// $complaintNature = $this->getNatureById($natureId);

			// $stmnt->execute(array(
			// 	$record['number'],
			// 	$record['nature'],
			// 	$record['date_created'],
			// 	$complaintNature['type'],
			// 	$record['firstname'],
			// 	$record['middlename'],
			// 	$record['lastname'],
			// 	$record['brgy'],
			// 	$record['municipality'],
			// 	"Marinduque"
			// ));

			//update sms table so this request wont be displayed again in the list
			$stmnt = $this->db->prepare("
					UPDATE sms
					SET seen = ?
					WHERE id = ?
				");
			
			$stmnt->execute(array(1, $_POST['id']));

			die(json_encode(array("added" => true, "failed" => false)));
		}
	}

	public function getAllWalkinConsumerRequest(){
		$records = array();
		$branch = $this->getBranchById($_SESSION['user']['branch_id']);
		$branch = $branch['municipality'];

		$stmnt = $this->db->query("
				SELECT *
				FROM complaints
				WHERE walkin = 1
				AND completed = 0
				AND municipality like '%".$branch."%'
			");

		while($row = $stmnt->fetch()){
			$message = explode(" ", $row['message']);
			$row['nature_id'] = str_replace("C-", "", $message[0]);

			$records[] = $row;
		}

		return $records;
	}

	public function getSmsRequests(){
		$records = array();
		$branch = $this->getBranchById($_SESSION['user']['branch_id']);
		$branch = $branch['municipality'];

		$stmnt = $this->db->query("
				SELECT *
				FROM sms 
				WHERE seen = 0
				AND (message like '%".$branch."%')
				AND (message like '%/%')

			");

		while($row = $stmnt->fetch()){
			$message = explode(" ", $row['message']);
			$row['nature_id'] = str_replace("C-", "", $message[0]);

			$records[] = $row;
		}

		return $records;
	}

	public function getAllRequirementsByNatureId($id){
		$records = array();
		$stmnt = $this->db->prepare("
				SELECT *
				FROM nature 
				WHERE id = ?
				LIMIT 1
			");

		$stmnt->execute(array($id));

		while($row = $stmnt->fetch()){
		// 	echo "<pre>";
		// print_r($row);
		// die();

			$record = explode(",", $row['requirements']);
		
			return $record;
			// $records[] = $row;
		}

		return $records;
	}

	public function sendRequestRequirement($natureId, $recipient){
		$requirements = $this->getAllRequirementsByNatureId($natureId);

		if(count($requirements) > 0){
			$req = implode(",", $requirements);
			$message = $type." Type Requirements: ".$req;

			$this->sendMessage($recipient, $message);
		} else {
			// die("no count d2");
		}
	}

	public function sendRequestRequirementsNotificationListener(){
		if(isset($_POST['sendRequestRequirementsNotification'])){
			foreach($_POST['data'] as $idx => $d){
				$this->sendRequestRequirement($d['id'], $d['sender']);
			}

			die(json_encode(array("done2")));
		}
	}

	public function addSmsToComplaint($sms, $isWalkin = false){
		$record = (array) $sms;

		$record['number'] = str_replace("639", "09", $record['sender']);
		$message = explode("/" , $record['message']);
		

		$fullname = explode(",", $message[0]);
		$nature = explode(" ", $fullname[0]);
		$natureComplaint = $nature[0];
		$address = explode(",", $message[1]);

		$record['firstname'] = isset($nature[1]) ? $nature[1] : "";
		$record['middlename'] = isset($fullname[1]) ? $fullname[1] : "";
		$record['lastname'] = isset($fullname[2]) ? $fullname[2] : "";
		$record['brgy'] = isset($address[0]) ? $address[0] : "";
		$record['municipality'] = isset($address[1]) ? $address[1] : "";

		$stmnt = $this->db->query("
				SELECT id
				FROM brgy
				WHERE name = '".trim($record['brgy'])."'
				LIMIT 1
			");
		$brgy = $stmnt->fetch();

		//check first if valid brgy 
		$brgyCount = $stmnt->rowCount();

		if($brgyCount == 0){
			return 0;
		}
		//check first if valid municipality
		$stmnt = $this->db->query("
				SELECT DISTINCT(municipality)
				FROM brgy
				WHERE municipality = '".$record['municipality']."'
				LIMIT 1
			");
		$muni = $stmnt->fetch();

		//check first if valid brgy 
		$muniCount = $stmnt->rowCount();
		if($muniCount == 0){
			return 0;
		}

		$record['brgy'] = $brgy['id'];

		$stmnt = $this->db->prepare("
			INSERT INTO complaints(
				contact_number,
				complaint_nature,
				dateadded,
				type,
				firstname,
				middlename,
				lastname,
				brgy,
				municipality,
				province,completed,walkin
			)
			VALUES(?,?,?,?,?,?,?,?,?,?,0,?)
		");

		$natureId = str_replace("C-", "", $natureComplaint);

		$complaintNature = $this->getNatureById($natureId);

		$stmnt->execute(array(
			$record['number'],
			$complaintNature['name'],
			$record['date_created'],
			$complaintNature['type'],
			$record['firstname'],
			$record['middlename'],
			$record['lastname'],
			$record['brgy'],
			$record['municipality'],
			"Marinduque",
			($isWalkin === true) ? 1 : 0
		));

		$id = $this->db->lastInsertId();
		//update sms table so this request wont be displayed again in the list
		$stmnt = $this->db->prepare("
				UPDATE sms
				SET seen = ?
				WHERE id = ?
			");
		
		$stmnt->execute(array(1, $_POST['id']));

		return $id;
	}

	public function getReceiverSMS(){
		if(isset($_POST['getConsumerSms'])){
			$records = array();
			$url = "http://alamko.info/chikka/inbox_json.php?last_days=10";
			$json = json_decode(file_get_contents($url));

			foreach($json as $idx => $j){
				//insert to sms table if not exists
				$exists = $this->db->query("
						SELECT *
						FROM sms
						WHERE inbox_id = ".$j->id."    
						LIMIT 1
					");
				$exists = $exists->rowcount();

				if($exists == false){
					$validMessage = strpos($j->message, "/");

					if($validMessage != -1){
						//add to complaint
						//todo sa approve sms, update instead of insert
						//todo sa scheduling, exlude complete 0
						//lipat to sa baba
						//complaintId
						$id = $this->addSmsToComplaint($j);

						if($id != 0){
							$stmnt = $this->db->prepare("
								INSERT INTO sms
								VALUES(
										NULL,?,?,?,?,?,?,?,0,?
									)
							");

							$stmnt->execute(array(
								$j->id,
								$j->sender,
								$j->receiver,
								$j->message,
								$j->request_id,
								$j->date_created,
								$j->timestamp,
								$id
							));

							//natureId
							$complaintId = explode(" ", $j->message);
							$complaintId = str_replace("C-", "", $complaintId[0]);
							$stmnt = $this->db->prepare("
									SELECT emergency_level
									FROM nature
									WHERE id = ?
									LIMIT 1
								");
							$stmnt->execute(array($complaintId));
							$level = $stmnt->fetch();
							$level = $level['emergency_level'];

							$branch = $this->getBranchById($_SESSION['user']['branch_id']);
							$branch = $branch['municipality'];
							$sameBranch = strpos($j->message, $branch);

							if($sameBranch <> -1){
								$records[] = array(
									"date" 		=> $j->date_created,
									"message" 	=> $j->message,
									"id"		=> $complaintId,
									"level"		=> $level,
									"sender" 	=> $j->sender
								);
							}	
						}
					}
				}
			}

			$branchId = $_SESSION['user']['branch_id'];
			$userMunicipality = $this->getBranchById($branchId);

			$stmnt = $this->db->query("
					SELECT *
					FROM sms
					WHERE seen = 0
					AND message LIKE '%".$userMunicipality['municipality']."'
					AND (message like '%/%')
				");
			
			die(json_encode(array(
				"count" => $stmnt->rowcount(),
				"records" => $records
				)));
		}
	}

	public function updateEventScheduleListener(){
		if(isset($_POST['updateEventSchedule'])){
			$this->updateStockAfterInspection($_POST['complaintId']);

			$stmnt = $this->db->prepare("
					UPDATE schedule
					SET lineman_id = ?,
						inspector_id = ?,
						overview = ?
					WHERE  complaint_id = ?
				");

			$stmnt->execute(array(
					$_POST['linemanId'],
					$_POST['inspectorId'],
					$_POST['title'],
					$_POST['complaintId']
				));

			//DELETE inspection result base on complaintId first
			$stmnt = $this->db->prepare("
					DELETE FROM inspection_result
					WHERE complaint_id = ?
				");

			$stmnt->execute(array($_POST['complaintId']));

			//Then insert bababa babanana
			$stmnt = $this->db->prepare("
					INSERT INTO inspection_result
					VALUES(
							NULL,
							?,?,?,?,?,?,?,?,?,?,?
						)
				");

			$stmnt->execute(array(
					$_POST['complaintId'],
					$_POST['dateAttended'],
					$_POST['oldBrand'],
					$_POST['oldReading'],
					$_POST['oldSerial'],
					$_POST['newBrand'],
					$_POST['newReading'],
					$_POST['newSerial'],
					$_POST['or_num'],
					$_POST['kwh_meter_type'],
					$_POST['sdw_length']
				));

			die(json_encode(array("updated")));
		}
	}

	public function getComplaintById($id){
		$records = array();
		$stmnt = $this->db->prepare("
				SELECT *
				FROM complaints
				WHERE id = ?
				LIMIT 1
			");
		$stmnt->execute(array($id));

		return $stmnt->fetch();
	}

	public function getNatureByName($name){
		$stmnt = $this->db->prepare("
				SELECT *
				FROM nature
				WHERE name = ?
			");
		$stmnt->execute(array($name));

		return $stmnt->fetch();
	}

	public function getNatureSupplyByNatureId($id){
		$records = array();
		$stmnt = $this->db->prepare("
				SELECT *
				FROM nature_supply
				WHERE nature_id = ?
			");
		$stmnt->execute(array($id));

		while($row = $stmnt->fetch()){
			$records[] = $row;
		}

		return $records;
	}

	public function updateStockAfterInspection($complaintId){
		//update only if there is no inspection result
		$inspected = $this->getInspectionResultByComplaintId($complaintId);

		if(!isset($inspected['id'])){
			if($inspected == 0){
				$complaint = $this->getComplaintById($complaintId);
				$nature = $this->getNatureByName($complaint['complaint_nature']);

				//yung quantity nito yung ibabawas
				$natureSupply = $this->getNatureSupplyByNatureId($nature['id']);

				foreach($natureSupply as $idx => $n){
					$materialId = $n['material_id'];
					$quantity = $n['quantity'];
			
					$this->updateSupplyById($materialId, $quantity);
				}
			}
		}
	}

	public function getRequirementChecklistByNatureAndConsumerId($nature, $consumerId){
		$records = array();
		$stmnt = $this->db->prepare("
				SELECT *
				FROM requirement_checklist
				WHERE consumer_id = ?
				AND nature = ?
			");

		$stmnt->execute(array($consumerId, $nature));

		while($row = $stmnt->fetch()){
			$records[trim($row['requirement'])] = $row['checked'];
		}

		return $records;
	}

	public function updateRequirementsChecklistListener(){
		if(isset($_POST['updateRequirementsChecklist'])){
			$requirements = $_POST['checklist'];
			$consumerId = $_POST['consumerId'];
			$nature = $_POST['nature'];

			//DELETE first all the record related to consumerId and nature
			$stmnt = $this->db->prepare("
					DELETE 
					FROM requirement_checklist
					WHERE consumer_id = ?
					AND nature = ?
				");
			$stmnt->execute(array($consumerId,$nature));

			//THEN  add new checked requirement
			foreach($requirements as $idx => $r){
				$stmnt = $this->db->prepare("
						INSERT INTO requirement_checklist
						VALUES(
								NULL,
								?,?,1,?
							)
					");
				$stmnt->execute(array($consumerId, $nature, $r));
			}
			
			die(json_encode(array("updated")));
		}	
	}

	public function ajaxMunicipalityListener(){
		if(isset($_POST['ajaxMunicipality'])){
			$m = $_POST['ajaxMunicipality'];

			$records = array();
			$stmnt = $this->db->prepare("
					SELECT * 
					FROM brgy
					WHERE municipality = ?
				");

			$stmnt->execute(array($m));

			while($row = $stmnt->fetch()){
				$records[] = $row;
			}

			die(json_encode($records));
		}
	}

	public function getUserByBranchId($id, $byuser = false){
		$records = array();

		if($byuser != false){
			$stmnt = $this->db->prepare("
				select t2.contact_number
				from user t1
				left join info t2 
				on t1.id = t2.userid
				where t1.branch_id  = ?
				and t1.type = ?
				and t1.deleted = 0
				and t2.contact_number != ''
			");

			$stmnt->execute(array($id, $byuser));	

		} else {
			$stmnt = $this->db->prepare("
				select t2.contact_number
				from user t1
				left join info t2 
				on t1.id = t2.userid
				where t1.branch_id  = ?
				and t1.deleted = 0
				and t2.contact_number != ''
			");

			$stmnt->execute(array($id));	
		}

		while($row = $stmnt->fetch()){
			$records[] = $row;
		}

		return $records;

	}

	public function getActiveWarehousePersonnel(){
		$records = array();
		$stmnt = $this->db->prepare("
				SELECT t2.contact_number
				FROM user t1
				LEFT JOIN info t2 ON t1.id = t2.userid
				WHERE t1.type = ? 
				AND t1.deleted = ?
				AND t1.status != 0
			");
		$stmnt->execute(array("warehouse_personnel",0));

		while($row = $stmnt->fetch()){
			$records[] = $row;
		}

		return $records;
	}

	public function sendStockNotificationListener(){
		if(isset($_POST['sendNotif'])){
			//get all system users of branch
			$users = array();
		
			//if si warehouse personnel ang naka login, notify current branch csc
			if($_POST['type'] == "warehouse_personnel"){
				$users = $this->getUserByBranchId($_POST['branchId'], "consumer_service_coordinator");
			} else {
				// if si csc ang nakalogin, notify si warehouse personnel
				$users = $this->getActiveWarehousePersonnel();
			}

			foreach($users as $idx => $u){
				if(strlen($u['contact_number'] > 10)){
					$this->sendMessage($u['contact_number'], $_POST['message']);
				}
			}
		}
	}

	public function filterStatusListener(){
		if(isset($_POST['filterStatus'])){
			$statusId = $_POST['id'];
			$records = array();

			if($statusId == 0){
				$records = $this->getAllApplicants();
			} else {
				$records = $this->getAllApplicants($_POST['id']);
			}
			
			die(json_encode($records));
		}
	}

	public function getBrgyByMunicipality($municipality = "boac"){
		$records = array();
		$municipality = (isset($_POST['ajaxMunicipality'])) ? $_POST['ajaxMunicipality'] :  $municipality;
		$stmnt = $this->db->prepare("
				SELECT * 
				FROM brgy
				WHERE municipality = ?
			");

		$stmnt->execute(array($municipality));

		while($row = $stmnt->fetch()){
			$records[] = $row;
		}

		return $records;
	}

	public function getAllBrgy(){
		$records = array();
		$stmnt = $this->db->query("
				SELECT t1.*,t2.name as 'branchName'
				FROM brgy t1
				LEFT JOIN branch t2
				ON t1.branch_id = t2.id
				ORDER BY t1.name
			");

		while($row = $stmnt->fetch()){
			$records[] = $row;
		}

		return $records;
	}

	public function viewMessages(){
		if(isset($_POST['viewMsg'])){
			$stmnt = $this->db->query("
				SELECT id 
				FROM info
				WHERE userid = ".$_SESSION['user']['id']."
			");
	
			$stmnt->execute();
			$id = $stmnt->fetch();
			$id = $id['id'];

			$records = array();
			$stmnt = $this->db->prepare("
					SELECT t1.*,concat(t2.firstname,' ',t2.lastname) as sender 
					FROM inbox t1
					LEFT JOIN info t2
					ON T1.recipient_id = t2.id
					WHERE t1.recipient_id = ?
				");
			$stmnt->execute(array($id));

			while($row = $stmnt->fetch()){
				$records[] = $row;
				//update seen
				$this->updateInboxSeen($row['id']);
			}


			die(json_encode($records));
		}	
	}

	public function updateInboxSeen($id){
		$stmnt = $this->db->prepare("
				UPDATE inbox
				SET seen = 1
				WHERE id = ?
			");
		$stmnt->execute(array($id));
	}

	public function getMessagesCount(){
		$stmnt = $this->db->query("
				SELECT id 
				FROM info
				WHERE userid = ".$_SESSION['user']['id']."

			");
		$stmnt->execute();
		$id = $stmnt->fetch();
		
		return  $this->db
			->query("
				SELECT *
				FROM inbox 
				where recipient_id = ".$id['id']."
				AND seen = 0
				")
			->rowCount();
	}

	public function getAllRecipients(){
		$records = array();
		$stmnt 	= $this->db->query("
				select t3.name as 'branch',t2.*,t1.deleted,t1.username,t1.email,t1.status,t1.requirement,t2.consumer_type,t1.date_registered
				from info t2
				left join user t1 on t1.id = t2.userId
				left join branch t3 on t1.branch_id = t3.id
				WHERE t1.type !='applicant'
				AND t1.id !=".$_SESSION['user']['id']."
			");

		while($row = $stmnt->fetch()){
			$records[] = $row;
		}

		return $records;
	}

	public function sendMessageListener(){
		if(isset($_POST['sendMsg'])){
			$recipients = $_POST['recipients'];

			foreach($recipients as $idx => $r){
				$this->addToInbox($_POST['title'], $_POST['message'], $r);
			}

			die(json_encode(array("added" => true)));
		}
	}

	public function addToInbox($title, $message, $recipientId){
		$stmnt = $this->db->prepare("
				INSERT INTO inbox
				VALUES(NULL,?,?,?,?,null,?)
			");

		$stmnt->execute(array($message,$title,$recipientId,0, $_SESSION['user']['id']));
	}

	// todo: how to update once the complaint is fixed by the lineman?
	//turn error reporting off
	public function addBrgyListener(){
		if(isset($_POST['addBrgy'])){
			// echo "<pre>";
			// print_r($_POST);
			// die();	
			//check if brgy already exists for municipality
			$records = array();
			$stmnt = $this->db->prepare("
					SELECT *
					FROM brgy
					WHERE name = ?
					AND municipality = ?
					LIMIT 1
				");

			$stmnt->execute(array($_POST['brgy'], $_POST['municipality']));

			while($row = $stmnt->fetch()){
				$records[] = $row;
			}

			if(count($records) > 0){
				$this->errors[] = "Barangay already exists in this municipality.";
				$this->getErrors();
			} else {
				//insert new records
				$stmnt = $this->db->prepare("
						INSERT INTO brgy
						VALUES(NULL,?,?,?)");	

				$stmnt->execute(array($_POST['brgy'], $_POST['branchId'], $_POST['municipality']));

				die(json_encode(array("success" => true)));
			}

		}
	}

	public function getComplaintExport(){
		$records 	= array();
		$stmnt 		= $this->db->prepare("
				SELECT
				t1.id as 'c_id',
				 t1.firstname as 'f_name',
					t1.contact_number as 'c_contact',t1.complaint_nature,t1.dateadded,
					t1.action_desired,t1.action_taken,t1.action_datetime,
				 t1.middlename as 'm_name', t1.lastname as 'l_name',
				 t4.name as 'c_brgy', t1.municipality as 'c_municipality',
				 t2.lineman_id as 's_id',t2.inspector_id as 's_idd',
				t3.*
				FROM complaints t1
				LEFT JOIN schedule t2 on t2.complaint_id= t1.id
				LEFT JOIN brgy t4 on t1.brgy = t4.id
				LEFT JOIN info t3 on t2.lineman_id = t3.userid
			");
		$stmnt->execute(array());

		while($row = $stmnt->fetch()){
			$lineman = $this->getInfoByUserId($row['s_id']);
			$by = $lineman[0]['lastname'].", ".$lineman[0]['firstname']." ".$lineman[0]['middlename'];
			$row['by'] = $by;
			$records[] = $row;
		}
	
		return $records;
	}

	public function getAllActiveInspector(){
		$records = array();
		$branch = $this->getBranchById($_SESSION['user']['branch_id']);
		$branch = $branch['municipality'];

		$stmnt   = $this->db->prepare("
				SELECT t1.id,CONCAT(t2.firstname,' ',t2.lastname) as name FROM user t1
				left join info t2 on t1.id = t2.userid
				WHERE t1.type = ?
				AND t2.municipality LIKE '%".$branch."%'
				AND t1.deleted = 0

			");		
		
		$stmnt->execute(array("inspector"));

		while($row = $stmnt->fetch()){
			$records[] = $row;
		}

		return $records;
	}

	public function getAllActiveLineman(){
		$records = array();
		$branch = $this->getBranchById($_SESSION['user']['branch_id']);
		$branch = $branch['municipality'];
		$stmnt   = $this->db->prepare("
				SELECT t1.id,CONCAT(t2.firstname,' ',t2.lastname) as name FROM user t1
				left join info t2 on t1.id = t2.userid
				WHERE t1.type = ?
				AND t2.municipality LIKE '%".$branch."%'
				AND t1.deleted = 0

			");		
		
		$stmnt->execute(array("line_man"));

		while($row = $stmnt->fetch()){
			$records[] = $row;
		}

		return $records;
	}

	public function getInfoByUserId($id){
		$stmnt 	= $this->db->prepare("
				SELECT *
				FROM info
				WHERE userid = ?
				LIMIT 1
			");

		$stmnt->execute(array($id));

		return $stmnt->fetchAll();
	}

	public function getInfoByContactNumber($number){
		$stmnt 	= $this->db->prepare("
				SELECT *
				FROM info
				WHERE contact_number = ?
				LIMIT 1
			");

		$stmnt->execute(array($number));

		return $stmnt->fetchAll();
	}

	public function getApplicationDetailById($id){
		if(is_numeric($id)){
			//TODO: Check user access here
			$records = array();

			$records['user'] 	= $this->getApplicantById($id);
			$records['info'] 	= $this->getInfoByUserId($id);
			$records['spouse'] 	= $this->getSpouseById($id);
			return $records;
		}
	}

	public function getComplaintDetailById($id){
		$stmnt 	= $this->db->prepare("
				SELECT *
				FROM complaints
				WHERE id =?
			");
		$stmnt->execute(array($id));

		while($row = $stmnt->fetch()){
			return $row;
		}
	}

	public function getMyScheduleListener(){
		if(isset($_POST['loadMySchedule'])){
			$records 	= array();
			$stmnt 		= $this->db->prepare("
					SELECT * 
					FROM schedule
					WHERE lineman_id = ?
				");

			$stmnt->execute(array($_SESSION['user']['id']));

			while($row = $stmnt->fetch()){
				$data = array(
						'id' 	=> $row['complaint_id'],
						'title' => $row['overview'],
						'start' => $row['startdate'],
						'end' 	=> $row['enddate']);

				$records[] = $data;
			}

			die(json_encode($records));
		}
	}

	public function getUnfixedComplaint($byType = false){
		$id = (isset($_GET['id'])) ? $_GET['id']: null;
		$and  = ($byType != false) ?  " AND (t1.type=?) " : "";
		$records 	= array();
		// $branch = $this->getBranchById($_SESSION['user']['branch_id']);
		// $branch = $branch['municipality'];

		if($id != null){
			$stmnt 		= $this->db->prepare("
				SELECT t1.* from complaints t1
				where t1.id not in(select DISTINCT(t2.complaint_id) from schedule t2)
				AND t1.id = ?".$and."
			");
			if($byType != false){

				$stmnt->execute(array($id, $byType));
			} else {
				$stmnt->execute(array($id));
			}
		} else {
			$branch = $this->getBranchById($_SESSION['user']['branch_id']);
			$branch = $branch['municipality'];
			$stmnt 		= $this->db->prepare("
				SELECT t1.* , t3.emergency_level
				from complaints t1
				LEFT JOIN nature t3 ON t1.complaint_nature = t3.name
				where (t1.id not in(select DISTINCT(t2.complaint_id) from schedule t2))
				".$and." 
				AND t1.completed = 1
				AND t1.municipality LIKE '%".$branch."%'
				ORDER BY t3.emergency_level,t1.dateadded ASC
			");

			if($byType != false){
				$stmnt->execute(array($byType));
			} else {
				$stmnt->execute(array());
			}
		}
		

		while($row = $stmnt->fetch()){
			//check requirements kung kumpleto na TODO:
			$records[] = $row;
		}

		return $records;
	}

	public function createFile($content){
		$myfile = fopen("uploads/newfile.txt", "w") or die("Unable to open file!");
		$txt = "John Do2e\n";
		fwrite($myfile, $txt);
		$txt = $content;
		fwrite($myfile, $txt);
		fclose($myfile);
	}

	public function getMessages(){
		    	$this->createFile('asdsa');

		    	die();
		include "chikkaConfig.php";
		$chikkaAPI = new ChikkaSMS($clientId, $secretKey, $shortCode);

		if($_POST){

		    // if($chikkaAPI->receiveNotifications() !== null){
		    	//add
		    	$this->createFile($_POST['message']);
				// $this->addMessage();
				$chikkaAPI->reply($_POST['request_id'],NULL,$_POST['mobile_number'], 'FREE', "test reply");

				echo "Accepted";

			    // var_dump($chikkaAPI->receiveNotifications());
		    // } else {
		    // 	$this->createFile("Error");
		    // 	echo "Error";
		    // }
		}
	}

	public function getMessages2(){
		include "chikkaConfig.php";
		$chikkaAPI = new ChikkaSMS($clientId, $secretKey, $shortCode);

		if($_POST){
		    if ($chikkaAPI->receiveNotifications() === null) {
		            echo "Message has not been processed.";
		        }
		    else{
		        echo "Message has been successfully processed.";
		    }

		    if($chikkaAPI->receiveNotifications() !== null){
		    	//add
		    	//change message_type to incoming
		    	//create text file here
				$this->addMessage();
			    var_dump($chikkaAPI->receiveNotifications());
		    }
		}
	}

	public function addMessage(){
		if(isset($_POST['message'])){
			$stmnt = $this->db->prepare("
					INSERT INTO message
					VALUES(	NULL,
							?,
							?,
							?,
							?,
							?,
							?,
							?, 
							0)");

			$stmnt->execute(array(
						$_POST['message_type'],
						$_POST['mobile_number'],
						$_POST['shortcode'],
						$_POST['request_id'],
						$_POST['message'],
						$_POST['timestamp'],
						"admin"));
		}

	}

	public function sendMessage($number, $message){
		//cut message 420 max
		$char = 400;
		$max = strlen($message);
		$length = ceil($max / $char);

			$start = 0;
		if($length > 1){
			for($i = 1;$i<=$length;$i++){
				$part = substr($message, $start,$char);
				if($i < $length){
					$part .= "(...) ($i/$length)";
				} else {
					$part .= " ($i/$length)";
				}

				$message2 = $part;

				$this->finalSend($number, $message2);
				
				$start +=$char;

			}
		} else {
			$this->finalSend($number, $message);
		}

		
	}

	public function finalSend($number, $message){
		$number 	= preg_replace('/0/', '63', $number, 1);
		include "chikkaConfig.php";

		$chikkaAPI = new ChikkaSMS($clientId,$secretKey,$shortCode);
		$response = $chikkaAPI->sendText(uniqid(), $number, $message);

		header("HTTP/1.1 " . $response->status . " " . $response->message);
		exit(0);
	}

	public function sendSmsListener(){
		if(isset($_POST['sendSms'])){
			$recipients = $_POST['recipients'];
			$message 	= $_POST['message'];

			foreach($recipients as $idx => $r){
				$this->sendMessage($r, $message);
			}
		}
	}

	public function updateBranchListener(){
		if(isset($_POST['upadateBranch'])){
			$stmnt = $this->db->prepare("
					UPDATE branch
					SET name = ?, municipality = ?
					WHERE id = ? ");

			$stmnt->execute(array($_POST['name'], $_POST['municipality'], $_POST['id']));

			die(json_encode(array("updated" => true)));
		}
	}

	public function getUserByUserId($id){
		$stmnt = $this->db->prepare("
				SELECT t1.*,t1.id as 'mainId',t2.*, t3.lastname as 'sLastname', 
					t3.firstname as 'sFirstname', t3.middlename as 'sMiddlename', t3.dob as 'sDob', 
					t3.pob as 'sPob', t3.occupation as 'sOccupation'
				FROM user t1 
				LEFT JOIN info t2 on t1.id = t2.userid
				LEFT JOIN spouse t3 on t1.id = t3.userid
				WHERE t2.userid = ?
				LIMIT 1
			");
		$stmnt->execute(array($id));

		return $stmnt->fetchAll();
	}
	public function getUserById($id){
		$stmnt = $this->db->prepare("
				SELECT t1.*,t1.id as 'mainId',t2.*, t3.lastname as 'sLastname', 
					t3.firstname as 'sFirstname', t3.middlename as 'sMiddlename', t3.dob as 'sDob', 
					t3.pob as 'sPob', t3.occupation as 'sOccupation'
				FROM user t1 
				LEFT JOIN info t2 on t1.id = t2.userid
				LEFT JOIN spouse t3 on t1.id = t3.userid
				WHERE t1.id = ?
				LIMIT 1
			");

		$stmnt->execute(array($id));

		return $stmnt->fetchAll();
	}

	public function generateReportListener(){
		if(isset($_POST['generateExport'])){
			$this->createReport($_POST['html'], $_POST['filename']);

		}
	}

	public function createReport($html, $filename){
		include_once "../mpdf/mpdf/mpdf.php";
        ini_set('max_execution_time', 300); //300 seconds = 5 minutes
        
		$mpdf 		= new mPDF();

		$mpdf->SetHTMLHeader('<div style="text-align: right; font-weight: bold;"><img src="../img/logo.png" height="20" /></div><div></div>'); 
        $mpdf->SetHTMLFooter('
            <table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000; font-weight: bold; font-style: italic;"><tr>
            <td width="33%"><span style="font-weight: bold; font-style: italic;">{DATE j-m-Y}</span></td>
            <td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td>
            <td width="33%" style="text-align: right; ">Marelco</td>
            </tr></table>');


        // $stylesheet = file_get_contents('../css/bootstrap.min.css');

        // $mpdf->WriteHTML($stylesheet,1);
		// $mpdf->WriteHTML($html,2);
		$mpdf->WriteHTML($html);
		$mpdf->Output('../reports/'.$filename,'F');

		die(json_encode(array("filename" => "reports/".$filename)));
	}

	public function searchEmailListener(){
		if(isset($_POST['searchEmail'])){
			$records = array();
			$stmnt 	= $this->db->query("
					SELECT t1.id as 'mainId',t1.*,t2.firstname,t2.* FROM user t1
					LEFT JOIN info t2
					on t1.id = t2.userid
					WHERE t1.email like '%".$_POST['email']."%'
				");	

			while($row = $stmnt->fetch()){
				$row['fullname'] = $row['firstname']." ".$row['lastname'];
				$records[] = $row;
			}

			die(json_encode($records));
		}
	}

	public function editNatureListener(){
		if(isset($_POST['editNature'])){
			$stmnt = $this->db->prepare("
					UPDATE nature
					SET type = ?, name = ?, emergency_level = ?,  requirements = ?, alloted_time =?,
					description = ?
					WHERE id = ?
				");

			$stmnt->execute(array($_POST['nature'], $_POST['name'], $_POST['emergency_level'],
			 $_POST['requirements'],
				$_POST['alloted_time'],$_POST['description'],$_POST['id']));
			
			$this->addNatureSupply($_POST['id'], $_POST['supply']);

			die(json_encode(array("updated" => true)));
		}
	}

	public function getBrgyById($id){
		$stmnt = $this->db->prepare("
				SELECT *
				FROM brgy
				WHERE id = ?
			");

		$stmnt->execute(array($id));

		return $stmnt->fetch();
	}


	public function getNatureById($id){
		$stmnt = $this->db->prepare("
				SELECT *
				FROM nature
				WHERE id = ?
			");

		$stmnt->execute(array($id));

		return $stmnt->fetch();
	}

	public function getChildrenById($id){
		$records = array();
		$stmnt = $this->db->prepare("
				SELECT *
				FROM
				children
				WHERE userid = ?
			");
		
		$stmnt->execute(array($id));

		while($row = $stmnt->fetch()){
			$records[] = $row;
		}

		return $records;
	}

	public function getSpouseById($id){
		$stmnt = $this->db->prepare("
				SELECT * 
				FROM spouse
				WHERE userid = ?
				LIMIT 1
			");

		$stmnt->execute(array($id));

		return $stmnt->fetchAll();
	}

	public function getApplicantById($id){
		$stmnt = $this->db->prepare("
				SELECT *
				FROM user
				WHERE id = ?
			");
		$stmnt->execute(array($id));

		$record = $stmnt->fetchAll(PDO::FETCH_ASSOC);

		
		return $record;
	}

	public function completeRequirementListener(){
		if(isset($_POST['completeRequirement'])){
			$stmnt = $this->db->prepare("
					UPDATE user
					SET status = 3
					WHERE id = ?
				");

			$stmnt->execute(array($_POST['id']));

			die(json_encode(array(true)));
		}
	}

	public function getAllRequirementsByType($type){
		$records = array();
		$stmnt = $this->db->prepare("
				SELECT *
				FROM requirements 
				WHERE membership_type = ?
			");

		$stmnt->execute(array($type));

		while($row = $stmnt->fetch()){
			$records[] = $row;
		}

		return $records;
	}

	public function searchMaterial(){
		if(isset($_POST['searchMaterial'])){
			$records = array();
			$all = $_POST['all'];

			if($all == "true"){
				$stmnt 	= $this->db->query("
					SELECT * 
					FROM material 
				");
			} else {
				$stmnt 	= $this->db->query("
					SELECT * 
					FROM material 
					WHERE description like '%".$_POST['txt']."%'
				");	
			}

			while($row = $stmnt->fetch()){
				$records[] = $row;
			}

			die(json_encode(array("materials"=>$records)));
		}
	}

	public function updateMaterialListener(){
		if(isset($_POST['updateMaterial'])){

			if($_POST['updateQty'] != "false"){
				$this->updateSupplyById($_POST['parentId'], $_POST['additional']);
			}	
	$stmnt = $this->db->prepare("
					UPDATE material
					SET class_code = ?,
					description = ?,
					quantity = ?,
					unit = ?,
					remarks = ?,
					is_default = ?
					WHERE id = ?
				");

			$stmnt->execute(array(
						$_POST['classCode'],
						str_replace('"', "'", $_POST['description']),
						$_POST['quantity'],
						$_POST['unit'],
						$_POST['remarks'],
						($_POST['checked'] == "true") ? 1 : 0,
						$_POST['id']));
			
			die(json_encode(array("added" => true)));
		}
	}

	public function updateSupplyByParentId($parentId, $consumed){
		$stmnt = $this->db->prepare("
				UPDATE material
				SET quantity = quantity - ?
				WHERE parent_id = ? 
			");

		$stmnt->execute(array($consumed, $parentId));
	}

	public function addMaterialListener(){
		if(isset($_POST['addMaterial'])){
			
			if($_POST['isMain'] == "true"){

				$stmnt = $this->db->prepare("
						INSERT INTO material
						VALUES(NULL,NULL,?,?,?,?,?,?,NULL,NULL)
					");

				$stmnt->execute(array(
					$_POST['classCode'],
					$_POST['description'],
					$_POST['quantity'],
					$_POST['unit'],
					$_POST['remarks'],
					0));

				//update remaining stock of main inventory
				die(json_encode(array("added" => true)));
			}

			// update remaining stock of parentId
			$this->updateSupplyById($_POST['parentId'], $_POST['quantity']);

			$stmnt = $this->db->prepare("
					INSERT INTO material
					VALUES(NULL,NULL,?,?,?,?,?,?,?,?)
				");

			$stmnt->execute(array(
				$_POST['classCode'],
				$_POST['description'],
				$_POST['quantity'],
				$_POST['unit'],
				$_POST['remarks'],
				($_POST['checked'] == "true") ? 1 : 0,
				$_POST['branchId'],
				$_POST['parentId']));
			
			die(json_encode(array("added" => true)));
		}
	}

	public function searchApplicant(){
		if(isset($_POST['searchApplicant'])){
			$records = array();
			$stmnt 	= $this->db->prepare("
				select t2.*,t1.deleted,t1.username,t1.email,t1.status,t1.requirement
				from info t2
				left join user t1 on t1.id = t2.userId
				WHERE t1.type ='applicant'
				AND MATCH ( firstname, lastname,middlename ) 
                  AGAINST (?)
			");

			$stmnt->execute(array($_POST['txt']));

			while($row = $stmnt->fetch()){
				$records[] = $row;
			}

			die(json_encode(array("users"=>$records)));
		}
	}

	public function updateMyRequirementsListener(){
		if(isset($_POST['updateMyRequirements'])){
			$requirements = implode("|", $_POST['data']);
			
			$stmnt = $this->db->prepare("
					UPDATE user
					SET requirement  = ?
					WHERE id = ?
				");

			$stmnt->execute(array($requirements, $_POST['id']));

			if($_POST['orientation'] == "true"){
				$this->updateUserStatus($_POST['id'], 2);
			} else {
				$this->updateUserStatus($_POST['id'], 1);
			}

			die(json_encode(array("updated" => true)));
		}
	}

	public function updateUserStatus($id, $status){
		$stmnt = $this->db->prepare("
				UPDATE user
				SET status = ?
				WHERE id = ?
			");

		$stmnt->execute(array($status, $id));
	}

	public function updateRequirementsListener(){
		if(isset($_POST['updateRequirements'])){
			//delete all requirements first
			$this->db->query("DELETE FROM requirements");

			foreach($_POST['data'] as $idx => $data){
				$stmnt = $this->db->prepare("
						INSERT INTO requirements
						VALUES(NULL, ?,?,?)
					");

				$stmnt->execute(array($data[1], $data[0], $data[2]));
			}

			die(json_encode(array("added" => true)));
		}
	}

	public function getAllRequirements(){
		$records = array();
		$stmnt = $this->db->query("SELECT * FROM requirements");

		while($row = $stmnt->fetch()){
			$records[] = $row;
		}

		return $records;
	}

	public function getAllBranchMunicipality(){
		$records = array();
		$stmnt 	= $this->db->query("
				SELECT DISTINCT(municipality)
				FROM branch
			");

		while($row = $stmnt->fetch()){
			$records[] = $row;
		}

		return $records;
	}

	public function getFirstBranch(){
		$stmnt = $this->db->prepare(" 
				SELECT * FROM branch LIMIT 1
			");
		$stmnt->execute();

		$record = $stmnt->fetch();
		return $record['id'];
	}

	public function getDefaultMaterial(){
		$branchId = (isset($_GET['id'])) ? $_GET['id']: $this->getFirstBranch();
		$records = array();
		$stmnt = $this->db->query("
				SELECT *
				FROM material
				WHERE is_default = 1 
				AND branch_id = ".$branchId."
			");

		while ($row = $stmnt->fetch()) {
			$records[] = $row;
		}

		return $records;
	}

	public function getMaterialByBranchId($main = false, $forBranch = false){
		$branchId = (isset($_GET['id'])) ? $_GET['id']: $this->getFirstBranch();	
		$sort = (isset($_GET['sort'])) ? $_GET['sort']: 'ASC';
		$records = array();

		if($main === true){
			if($forBranch === true){
				//get 
				$stmnt 	= $this->db->query("
					SELECT * 
					FROM material
					WHERE parent_id is  NULL
					AND id NOT IN(
							SELECT parent_id
							FROM material
							WHERE branch_id = ".$branchId."
						)
				");	
			
			} else {
				$stmnt 	= $this->db->query("
					SELECT * 
					FROM material
					WHERE parent_id is NULL
				");	
			}
		} else {
          	$userType = $_SESSION['user']['type'];
          	// $userType = "warehouse_personnel";

          	if($userType !="warehouse_personnel"){
              $branchId = $_SESSION['user']['branch_id'];
              // $branchId = 6;
          	}

          	if(isset($_GET['branch'])){
          		$branchId = $_SESSION['user']['branch_id'];
              // $branchId = 6;		
          	}

			$stmnt 	= $this->db->query("
				SELECT * 
				FROM material
				WHERE branch_id = ".$branchId."
				and supply_id is  null
				and is_default = 0
				ORDER BY quantity ".$sort."
			");

		}

		while($row = $stmnt->fetch()){
			if($_SESSION['user']['type'] == "consumer_service_coordinator"){
				$row['limit'] = ($row['quantity'] <= 10) ?  true : false ;
			} else {
				//warehouse,admin
				$row['limit'] = ($row['quantity'] <= 50) ?  true : false ;
			}

			$records[] = $row;
		}

		return $records;
	}

	public function getNatureSupplyById($natureId){
		$records = array();
		$stmnt = $this->db->prepare("
				SELECT *
				FROM nature_supply
				WHERE nature_id = ?
			");
		$stmnt->execute(array($natureId));

		while($row = $stmnt->fetch()){
			$records[$row['material_id']] = $row;
		}

		return $records;
	}

	public function getAllBranches(){
		$records = array();
		$stmnt 	= $this->db->query("
				SELECT * 
				FROM branch
			");

		while($row = $stmnt->fetch()){
			$records[] = $row;
		}

		return $records;
	}

	public function addBranchListener(){
		if(isset($_POST['addBranch'])){
			$stmnt = $this->db->prepare("
					INSERT INTO branch
					VALUES(NULL,?,?,NULL)
				");
			$stmnt->execute(array($_POST['municipality'], $_POST['name']));

			die(json_encode(array("added" => true)));
		}
	}

	public function sendMembershipRequirementByType($type, $recipient){
		$requirements = $this->getAllRequirementsByType($type);
		$req = array();

		foreach($requirements as $idx => $r){
			$req[] = $r['name'];
		}

		if(count($req) > 0){
			$req = implode(",", $req);			
			$message = $type." Type Requirements: ".$req;

			$this->sendMessage($recipient, $message);
		}
	}

	public function addApplicationListener(){
		if(isset($_POST['addApplication'])){
			$this->validateUser($_POST, true);
			$id = null;

			if(count($this->errors) > 0){
				$this->getErrors();
			} else {
				$id = $this->addUser($_POST, true);
			}

			$fname 	= $_POST['firstname'];
			$lname 	= $_POST['lastname'];
			$contact_number 	= $_POST['contact_number'];
			$mname 	= $_POST['middlename'];
			$gender = $_POST['gender'];
			$age 	= $_POST['age'];
			$dob 	= $_POST['dob'];
			$nationality 	= $_POST['nationality'];
			$religion 	= $_POST['religion'];
			$address 	= $_POST['address'];
			$weight 	= $_POST['weight'];
			$height 	= $_POST['height'];
			$municipality 	= $_POST['municipality'];
			$brgy 	= $_POST['brgy'];

			$civil_status 	= $_POST['civil_status'];
			$pob			= $_POST['pob'];
			$membership_type = $_POST['membership_type'];
			$consumer_type	= $_POST['consumer_type'];
			$photo 	= $_POST['photo'];
	
			$stmnt =  $this->db->query("
					SELECT *
					FROM info
					WHERE userid = ".$id."
				");

			$exists =$stmnt->rowCount();

			if($exists > 0){
				//update
				$stmnt = $this->db->prepare(
					"UPDATE info
						SET firstname = ?,
						lastname = ?,
						middlename = ?,
						age = ?,
						sex = ?,
						dob = ?,
						religion = ?,
						address = ?,
						nationality = ?,
						weight = ? ,
						height = ?,
						userid = ?,
						civil_status = ?,
						pob = ?,
						membership_type = ?,
						consumer_type = ?,
						photo = ?,
						contact_number = ?,
						brgy = ?,
						municipality = ?
						WHERE userid = ? 
					");
				$stmnt->execute(array(
						$fname,
						$lname,
						$mname,
						$age,
						$gender,
						date("Y-m-d",strtotime($dob)),
						$religion,
						$address,
						$nationality,
						$weight,
						$height,
						$id,
						$civil_status,
						$pob,
						$membership_type,
						$consumer_type,
						$photo,
						$contact_number,
						$brgy,
						$municipality,
						$id
					));

			} else {
				$stmnt = $this->db->query(
					"INSERT INTO info
					VALUES(NULL, 
						'".$fname."',
						'".$lname."',
						'".$mname."',
						'".$age."',
						'".$gender."',
						'".date("Y-m-d",strtotime($dob))."',
						'".$religion."',
						'".$address."',
						'".$nationality."',
						'".$weight."',
						'".$height."',
						".$id.",
						'".$civil_status."',
						'".$pob."',
						'".$membership_type."',
						'".$consumer_type."',
						'".$photo."',
						'".$contact_number."',
						'".$brgy."',
						'".$municipality."'

						)"
				);	
			}
			
			
			//add spouse
			$stmnt = $this->db->prepare("
					INSERT INTO spouse
					VALUES(NULL,?,?,?,?,?,?,?,?)
				");

			$stmnt->execute(array($_POST['s_lastname'],
				$_POST['s_firstname'],
				$_POST['s_middlename'],
				$_POST['s_dob'],
				$_POST['s_pob'],
				$_POST['s_occupation'],
				$id,
				$_POST['s_age']));

			//update branch id of applicant base on their municipality
			// $stmnt = $this->db->prepare("
			// 		SELECT * 
			// 		FROM branch 
			// 		WHERE 
			// 	");

			//add children
			$this->addChildren($_POST, $id);
			die(json_encode(array(
				"added" =>true,
				"id" => $id,
				"type" => $_POST['consumer_type'],
				"number" => $_POST['contact_number'])
				));
		}	
	}

	public function sendMembershopNotificationListener(){
		if(isset($_POST['sendMembershopNotification'])){
			$this->sendMembershipRequirementByType($_POST['type'],$_POST['number']);
		}
	}

	public function addChildren($children, $parentId){
		if(array_key_exists("c-name", $children)){
			foreach($children['c-name'] as $idx => $child){
				if($child !=""){
					if($children['c-dob'][$idx] != ""){
						$stmnt  =  $this->db->prepare("
							INSERT INTO children 
							VALUES(NULL,?,?,?)");
						$stmnt->execute(array($child, $children['c-dob'][$idx], $parentId));
					}
				}
				
			}
		}
	}

	public function deleteNatureListener(){
		if(isset($_POST['deleteNature'])){
			$stmnt = $this->db->prepare("
					DELETE FROM nature
					WHERE id = ?
				");

			$stmnt->execute(array($_POST['id']));

			die(json_encode(array("deleted" => true)));
		}
	}

	public function getNatureByTypeAndPriority($type){
		$records = array();
		$records['Low'] = array();
		$records['Medium'] = array();
		$records['High'] = array();
		$stmnt 	= $this->db->prepare("
				SELECT * FROM nature
				WHERE type = ?
			");

		$stmnt->execute(array($type));

		while($row = $stmnt->fetch()){
			$records[$row['emergency_level']][] = $row;
		}

		return $records;
	}

	public function getNature(){
		$records = array();
		$stmnt 	= $this->db->prepare("
				SELECT * FROM nature
			");

		$stmnt->execute();

		while($row = $stmnt->fetch()){
			$records[] = $row;
		}

		return $records;
	}

	public function getNatureRequirementByName($name){
		$records = array();
		$stmnt 	= $this->db->prepare("
				SELECT * FROM nature
				WHERE name = ?
			");

		$stmnt->execute(array($name));

		while($row = $stmnt->fetch()){
			$records[] = $row;
		}

		return $records;
	}

	public function getNatureByType($type){
		$records = array();
		$stmnt 	= $this->db->prepare("
				SELECT * FROM nature
				WHERE type = ?
			");

		$stmnt->execute(array($type));

		while($row = $stmnt->fetch()){
			$records[] = $row;
		}

		return $records;
	}

	public function addNatureListener(){
		if(isset($_POST['addNature'])){
			$stmnt = $this->db->prepare("
					SELECT name
					FROM nature 
					WHERE name = ?
					LIMIT 1
				");
			$stmnt->execute(array($_POST['name']));
			$exists = $stmnt->rowCount();

			if($exists > 0){
				die(json_encode(array("added"=>false)));
			}

			$stmnt = $this->db->prepare("
					INSERT INTO nature
					VALUES(NULL,?,?,?,?,?,?)
				");

			$stmnt->execute(array($_POST['nature'],
				$_POST['name'],$_POST['emergency_level'],$_POST['requirements'],
				$_POST['alloted_time'], $_POST['description']));

			$id = $this->db->lastInsertId();

			$this->addNatureSupply($id,$_POST['supply']);
			die(json_encode(array("added"=>true)));
		}
	}

	public function addNatureSupply($natureId, $supply){
		//delete first
		$stmnt = $this->db->prepare("
				DELETE FROM nature_supply
				WHERE nature_id = ?
			");
		$stmnt->execute(array($natureId));
		if(array_key_exists("chkId", $supply)){
			foreach($supply as $idx => $s){
				if($idx == "chkId"){
					foreach($s as $idx2 => $id){
						$quantity = $supply['quantity'][$idx2];

						if($quantity !=""){
							$stmnt = $this->db->prepare("
									INSERT INTO nature_supply
									VALUES(NULL,?,?,?)
								");
							$stmnt->execute(array($natureId, $id, $quantity));
						}
					}
				}
			}
		}
	}

	public function deleteSlide(){
		if(isset($_POST['deleteSlide'])){
			$stmnt = $this->db->prepare("DELETE FROM slides where id = ?");

			$stmnt->execute(array($_POST['id']));

			die(json_encode(array("deleted" => true)));
		}
	}

	public function getSlideshows(){
		$result = array();
		$stmnt 	= $this->db->query("SELECT * FROM slides");

		while($row = $stmnt->fetch()){
			$result[] = $row;
		}

		return $result;
	}

	public function addSlidesListener(){
		if(isset($_POST['addSlide'])){
			$slides = $_POST['slides'];

			foreach($slides as $idx => $slide){
				$stmnt = $this->db->prepare("
						INSERT INTO slides
						VALUES(NULL,?,?,?,?)
					");	

				$stmnt->execute(array($slide[1], $slide[2], date("Y-m-d H:i:s"),$slide[0]));
			}

			die(json_encode(array("added" => true)));
		}
	}

	public function getSetting(){
		return  $this->db->query("SELECT * FROM setting LIMIT 1")->fetch();
	}

	public function updateSettingListener(){
		if(isset($_POST['updateSetting'])){
			$exists = ($_POST['id'] == "null") ? 0 : 1;

			if($exists > 0){
				$stmnt = $this->db->prepare("
								UPDATE setting
								SET about = ? , mobile = ? ,
								phone = ?, fax = ? ,
								email = ? , slogan = ?,
								mission = ?, vission =?
								WHERE id = ?
							");
				
				$stmnt->execute(array(trim($_POST['about']),trim($_POST['mobile']),trim($_POST['phone']),
					trim($_POST['fax']),$_POST['email'],trim($_POST['slogan']), $_POST['mission'],
						$_POST['vission'],$_POST['id']));

			} else {
				$stmnt = $this->db->prepare("
								INSERT INTO setting
								VALUES(NULL,?,?,?,?,?,?,?,?,?,?)
							");

				$stmnt->execute(array($_POST['about'],$_POST['mobile'],$_POST['phone'],
					$_POST['fax'],$_POST['email'],$_POST['slogan'],$_POST['mission'],$_POST['vission']));
			}

			die(json_encode(array("updated" => true)));
		}
	}

	public function getBranchById($id){
		$stmnt =  $this->db->prepare("
				SELECT * 
				FROM branch
				where id = ?
				LIMIT 1
			");
		$stmnt->execute(array($id));

		return $stmnt->fetch();
	}

	public function getAllApplicantForReport(){
		$records = array();
		$stmnt 	= $this->db->prepare("
				 select t1.id,t2.userid,t2.*,t1.type,t1.deleted,t1.username,t1.email,t1.status,t1.requirement,t1.date_registered
				 from user t1 
				 left join info t2 on t1.id = t2.userid 
				  WHERE t1.type = ? and t2.userid is not null
				");
		
		$stmnt->execute(array("applicant"));

		while($row = $stmnt->fetch()){
			$records[] = $row;
		}

		return $records;
	}

	public function getAllApplicants($status = false, $noMunicipality = false){
		$branchId = $_SESSION['user']['branch_id'];
		$userMunicipality = $this->getBranchById($branchId);
		$records = array();

		if($status !== false){
			$stmnt 	= $this->db->prepare("
			 select t1.id,t2.userid,t2.*,t1.type,t1.deleted,t1.username,t1.email,t1.status,t1.requirement,t1.date_registered
			 from user t1 
			 left join info t2 on t1.id = t2.userid 
			  WHERE t2.municipality =? and  t1.type = ? and t2.userid is not null
			  and t1.status = ?
			  and t1.note is null

			");

			$stmnt->execute(array($userMunicipality['municipality'], "applicant", $status));
		} else {
			if($noMunicipality === true){
				$stmnt 	= $this->db->prepare("
				 select t1.id,t2.userid,t2.*,t1.type,t1.deleted,t1.username,t1.email,t1.status,t1.requirement,t1.date_registered
				 from user t1 
				 left join info t2 on t1.id = t2.userid 
				  WHERE t1.type = ? and t2.userid is not null
			  and t1.note is null

				  GROUP BY t2.userid
				  ORDER BY t1.id DESC
				");
				
				$stmnt->execute(array("applicant"));
			} else {
				$stmnt 	= $this->db->prepare("
				 select t1.id,t2.userid,t2.*,t1.type,t1.deleted,t1.username,t1.email,t1.status,t1.requirement,t1.date_registered
				 from user t1 
				 left join info t2 on t1.id = t2.userid 
				  WHERE t2.municipality =? and  t1.type = ? and t2.userid is not null
			  and t1.note is null

				");
				
				$stmnt->execute(array($userMunicipality['municipality'], "applicant"));
			}
			
		}
		
		while($row = $stmnt->fetch()){
			$records[] = $row;
		}

		return $records;
	}

	public function deactivateUserListener(){
		if(isset($_POST['updatedDeleted'])){
			$stmnt = $this->db->prepare("
					UPDATE user
					SET deleted = ?,
					 status = ?
					WHERE id = ?
				");
			$status = ($_POST['deleted'] == 1) ? 0 :1;
			$stmnt->execute(array($_POST['deleted'], $status, $_POST['id']));

			die(json_encode(array()));
		}
	}

	public function getUsersByType($type) {
		$records 	= array();
		$stmnt 		= $this->db->prepare("
				SELECT t1.*,t2.* 
				FROM user t1
				LEFT JOIN info t2 ON t1.id = t2.userid
				WHERE t1.type = ?
			");
		$stmnt->execute(array($type));

		while($row = $stmnt->fetch()){
			$records[] = $row;
		}

		return $records;
	}

	public function getAllUsers($linespectorOnly = false, $type = false){
		$records 	= array();
		$branchId = $_SESSION['user']['branch_id'];
		$userMunicipality = $this->getBranchById($branchId);
		$records = array();

		if($linespectorOnly === true){
			$stmnt 		= $this->db->query("
				SELECT t1.id as 'mainId',t1.*,t2.*,t3.name as 'branch' 
				FROM user t1
				LEFT JOIN info t2 ON t1.id = t2.userid
				LEFT JOIN branch t3 ON t1.branch_id = t3.id
				WHERE t1.type = '".$type."'
				AND t2.municipality = '".$userMunicipality['municipality']."'
			");
		} else {
			$stmnt 		= $this->db->query("
				SELECT t1.id as 'mainId',t1.*,t2.*,t3.name as 'branch' 
				FROM user t1
				LEFT JOIN info t2 ON t1.id = t2.userid
				LEFT JOIN branch t3 ON t1.branch_id = t3.id
				WHERE t1.type not in('admin', 'applicant','inspector','line_man')
				AND t2.municipality = '".$userMunicipality['municipality']."'
			");	
		}
		

		while($row = $stmnt->fetch()){
			$records[] = $row;
		}

		return $records;
	}

	public function updateSupplyListener(){
		if(isset($_POST['updateSupply'])){
			$stmnt = $this->db->prepare("
					UPDATE supply
					SET requesting_dept = ?, purpose = ?, date = ?, work_order_ref_no = ?, requested_by = ?,
					approved_by = ?, muv_no = ?
					WHERE id = ? ");

			$stmnt->execute(array(
						$_POST['r_dept'],
						$_POST['purpose'],
						$_POST['date'],
						$_POST['ref_no'],
						$_POST['requestedBy'],
						$_POST['approvedBy'],
						$_POST['mrvNo'],
						$_POST['id']));

			//delete all materials instead of updating it one by one, then just readd

			$stmnt = $this->db->prepare("DELETE FROM material WHERE supply_id = ?");
			$stmnt->execute(array($_POST['id']));
			
			$this->addMaterials($_POST['materials'], $_POST['id']);		
				
			die(json_encode(array("updated" => true)));
		}
	}

	public function getSupplyInfoById($id){
		$stmnt = $this->db->query(
				"SELECT * FROM supply WHERE id=".$id." LIMIT 1"
			);
		while($row = $stmnt->fetch()){
			$branch = $this->getBranchById($row['requesting_dept']);
			$row['branch'] = $branch['name'];

			return $row;
		}
	}

	public function getSupplyById($id){
		$records 	= array();
		$stmnt 		= $this->db->prepare("SELECT * FROM supply WHERE id = ? LIMIT 1");
		$stmnt->execute(array($id));

		while($row = $stmnt->fetch()){
			$branch = $this->getBranchById($row['requesting_dept']);
			$row['branch'] = $branch['name'];
			$records['supply'] = $row;

			$s = $this->db->prepare("SELECT * FROM material WHERE supply_id = ?");
			$s->execute(array($id));

			while($row2= $s->fetch()){
				$records['materials'][] = $row2;
			} 
		}

		return $records;
	}

	public function getAllMaterial(){
		// echo "<pre>";
		// print_r($_SESSION);
		// die();
		$records = array();
		$stmnt = $this->db->query("
				SELECT * FROM material
				ORDER BY is_default DESC
			");

		while($row = $stmnt->fetch()){
			$records[] = $row;
		}

		return $records;
	}

	public function getMaterialById($id){
		return  $this->db->query(
				"SELECT * FROM material WHERE id=".$id
			)->fetch();
	}

	public function getMaterialsBySupplyId($id){
		$records = array();
		$stmnt = $this->db->prepare("
				SELECT *
				FROM material
				WHERE supply_id = ?
			");
		$stmnt->execute(array($id));

		while($row = $stmnt->fetch()){
			//get remaining quantity

			$parentMaterial = $this->getMaterialById($row['parent_id']);
			$parentMaterial = $this->getMaterialById($parentMaterial['parent_id']);
			$row['max'] = $parentMaterial['quantity'];

			$records[] = $row;
		}

		return $records;
	}

	public function getAllSupply($check){
		$records 	= array();
		$stmnt = null;

		if($check == true){
			$userType = $_SESSION['user']['type'];
			// $userType = "warehouse_personnel";

			if($userType !="warehouse_personnel"){
              $branchId = $_SESSION['user']['branch_id'];
              // $branchId = 6;
				$stmnt 		= $this->db->query('
					SELECT * FROM supply
					WHERE requesting_dept = "'.$branchId.'"
					');

          	} else  {
				$stmnt 		= $this->db->query('SELECT * FROM supply
					');
          	}
		} else {
			$stmnt 		= $this->db->query('SELECT * FROM supply');
		}

		while($row = $stmnt->fetch()){
			$brgy= $this->getBranchById($row['requesting_dept']);
			$row['brgy'] = $brgy['name'];
			$records[] = $row;
		}

		return $records;

	}	

	public function addSupplyListener(){
		if(isset($_POST['addSupply'])){
			$stmnt = $this->db->prepare("
					INSERT INTO supply
					VALUES(NULL,?,?,?,?,?,?,?,null)
				");

			$stmnt->execute(array($_POST['branchId'],$_POST['purpose'],
				$_POST['date'],$_POST['ref_no'],$_POST['requestedBy'],$_POST['approvedBy'],
				$_POST['mrvNo']));
        	
        	$id = $this->db->lastInsertId();

			$this->addMaterials($_POST['materials'], $id);
		}
	}

	public function addMaterials($materials, $supplyId){
		foreach($materials as $idx => $material){
			$stmnt = $this->db->prepare("
				INSERT INTO material
				VALUES(NULL,?,?,?,?,?,?,0,?,?)
			");

			$stmnt->execute(array($supplyId,$material[0],$material[1],$material[2],$material[3],$material[4], $_POST['branchId'], $material[5]));
			
			//then update the current quantity of this material
			// $this->updateSupplyById($material[5], $material[2]);
		}

		die(json_encode(array("added" => true)));	
	}

	public function updateSupplyById($parentId, $consumed){
		$stmnt = $this->db->prepare("
				UPDATE material
				SET quantity = quantity - ?
				WHERE id = ? 
			");

		$stmnt->execute(array($consumed, $parentId));
	}

	public function getComplaintListListener(){
		if(isset($_POST['getComplaints'])){
			$records = array();

			$stmnt = $this->db->query("SELECT id,complaint_nature FROM complaints WHERE user_id IS NULL");
			
			while($row = $stmnt->fetch()){
				$records[] 	= $row;
			}

			die(json_encode($records));
		}
	}

	public function complaintListListener(){
		if(isset($_POST['loadComplaints'])){
			$records 	= array();
			$type 		= $_POST['type'];
			$branch = $this->getBranchById($_SESSION['user']['branch_id']);
			$branch = $branch['municipality'];
			$stmnt 		= $this->db->query("
				SELECT t1.id as 'tid', t1.*, t3.name as 'brgyy', CONCAT(t2.firstname,' ',t2.lastname) as fullname
				FROM complaints t1

				LEFT JOIN info t2 ON t1.user_id = t2.userid
				LEFT JOIN brgy t3 ON t1.brgy = t3.id
				WHERE  t1.type = '".$type."'
				AND t1.complaint_nature != 'Membership'
				AND t1.municipality LIKE '%".$branch."%'
				ORDER BY t1.id DESC
			");
	
			while($row = $stmnt->fetch()){
				$records[] = $row;
			}

			die(json_encode($records));
		}
	}

	public function complaintListener(){
		if(isset($_POST['complaintAdd'])){
			$this->processComplaint($_POST);
		}
	}

	public function processComplaint($data){
		$required = array("firstname", "middlename","lastname", 
			"brgy","municipality","province", "contact_number",
			"complaint_nature");

		foreach($required as $idx => $field){
			if(empty($data[$field])){
				$fieldname = ucwords(str_replace("_", " ", $field));
				$this->errors[] = $fieldname." is required";
			}
		}
		
		$contactNumber = $data['contact_number'];

		if(!is_numeric($contactNumber)){
			$this->errors[] = "Invalid Contact Number";
		} else {
			if(strlen($contactNumber) != 11){
				$this->errors[] = "Contact Number must consist of eleven digits number";
			} else {
				if($contactNumber[0] != "0"){
					$this->errors[] = "Contact Number must start with 0";
				}
			}
		}
		
		if(count($this->errors) > 0){
			die(json_encode(array('error' => $this->errors)));
		} else {
			$today = date("Y-m-d");
			$exists = $this->db->query("
					SELECT * FROM complaints 
					WHERE firstname = '".$data['firstname']."'
					AND lastname = '".$data['lastname']."'
					AND middlename = '".$data['middlename']."'
					AND complaint_nature = '".$data['complaint_nature']."'
					AND dateadded like '%".$today."%'
					LIMIT 1
				")->rowCount();

			if($exists > 0){
					$this->errors[] = "You can only add this service once a day";

				die(json_encode(array('error' => $this->errors)));
			}
			
			$complaintId = $this->getNatureByName($data['complaint_nature']);
			$complaintId = $complaintId['id'];
			$brgy = $this->getBrgyById($data['brgy']);
			$brgy = $brgy['name'];			

			$message = "C-".$complaintId." ".$data['firstname'].",".$data['middlename'].",".$data['lastname']."/".$brgy.",".$data['municipality'];
		
			// echo "<pre>";
			// print_r($data);
			// die();
			$data['message'] = $message;
			$data['sender'] = $data['contact_number'];
			$id = $this->addSmsToComplaint($data, true);

			// if($id != 0){
			// 		$stmnt = $this->db->prepare("
			// 				INSERT INTO sms
			// 				VALUES(
			// 						NULL,0,?,?,?,?,?,?,1,?
			// 					)
			// 			");

			// 		$stmnt->execute(array(
			// 			$data['contact_number'],
			// 			"2929078229",
			// 			$message,
			// 			"504830",
			// 			strtotime(date("Y-m-d H:i:s")),
			// 			date("Y-m-d H:i:s"),
			// 			$id
			// 		));
				
			// 	die(json_encode(array("added" => true)));
			// } else {
			// 	die(json_encode(array("added" => false)));
			// }
		
			die(json_encode(array("added" => true)));

			// $stmnt = $this->db->prepare("
			// 		INSERT INTO complaints(
			// 			consumer_name,
			// 			address,
			// 			contact_number,complaint_nature,
			// 			complaint_datetime,action_desired,action_taken,
			// 			action_datetime,user_id,dateadded,type,
			// 			firstname,middlename,lastname,
			// 			brgy,municipality,province,or_number
			// 			)
			// 		VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
			// 	");

			// $stmnt->execute(array(
			// 	$data['consumer_name'],
			// 	$data['address'],
			// 	$data['contact_number'],
			// 	$data['complaint_nature'],
			// 	date("Y-m-d H:i:s"),
			// 	$data['action_desired'],
			// 	$data['action_taken'],
			// 	$data['action_datetime'],
			// 	$_SESSION['user']['id'],
			// 	date("Y-m-d H:i:s"),
			// 	$data['type'],
			// 	$data['firstname'],
			// 	$data['middlename'],
			// 	$data['lastname'],
			// 	$data['brgy'],
			// 	$data['municipality'],
			// 	$data['province'],
			// 	$data['or_number']
			// ));

		}
	}

	public function exportListener(){
		if(isset($_GET['export'])){
			$this->export($_GET['export']);
		}
	}

	public function getInspectionResultByComplaintId($complaintId){
		$stmnt = $this->db->prepare("
				SELECT *
				FROM inspection_result
				WHERE complaint_id = ?
				LIMIT 1
			");
		$stmnt->execute(array($complaintId));

		return $stmnt->fetch();
	}

	public function loadEventListener(){
		if(isset($_POST['getEvents'])){
			$records = array();
			// $where = (isset($_POST['myschedule'])) ? " WHERE user_id = ".$_POST['myschedule'] : "";
			$where =" WHERE ";

			if($_POST['type'] == "request"){
				$where .= " inspector_id !=0";
			} else {
				$where .= " lineman_id !=0";
			}

			$stmnt = $this->db->query("
					SELECT * FROM schedule
					".$where);	

			while($row = $stmnt->fetch()){
				$complaint = $this->getComplaintDetailById($row['complaint_id']);
				$complaintBranch = trim(strtolower($complaint['municipality']));
				$userBranch = $this->getBranchById($_SESSION['user']['branch_id']);
				$userBranch = trim(strtolower($userBranch['municipality']));

				if($userBranch == $complaintBranch){
					$inspectionResult = $this->getInspectionResultByComplaintId($row['complaint_id']);
					$data = array(
							"complaintId" => $row['complaint_id'],
							"color" => ($complaint['type'] == "request") ? "blue" : "green",
							"id" 	 => $row['id'],
							"title"	 => $row['overview'],
							"start"	 => $row['startdate'],
							"nature" => $complaint['complaint_nature'],
							"linemanId" => $row['lineman_id'],
							"inspectorId" => $row['inspector_id'],
							"end"	 => $row['enddate'],
							"dateAttended"	 => $inspectionResult['date_attended'],
							"oldBrand"	 => $inspectionResult['old_brand'],
							"oldReading"	 => $inspectionResult['old_reading'],
							"oldSerial"	 => $inspectionResult['old_serial'],
							"newBrand"	 => $inspectionResult['new_brand'],
							"newReading"	 => $inspectionResult['new_reading'],
							"kwh"	 => $inspectionResult['kwh_meter_type'],
							"sdw"	 => $inspectionResult['sdw_length'],
							"or"	 => $inspectionResult['or_number'],
							"newSerial"	 => $inspectionResult['new_serial']
							);

					$records[] = $data;
				}
			}

			die(json_encode(array("serverDate" => date("m-d-Y"), "records" => $records)));
		}
	}

	public function getAllSchedule(){
		$records = array();
		$stmnt = $this->db->prepare("
				SELECT *
				FROM schedule
			");
		$stmnt->execute();

		while($row = $stmnt->fetch()){
			$data = array();

			$data['schedule'] = $row;
			$data['complaint'] = $this->getComplaintDetailById($row['complaint_id']);
			$data['lineman'] = $this->getInspectionResultByComplaintId($row['complaint_id']);
			$data['basic'] = array(
						"consumer" => $complaint['firstname']." ".$complaint['lastname'],
						"address" => $complaint['brgy']." ".$complaint['municipality'].", Marinduque",
						"complaintId" => $row['complaint_id'],
						"color" => ($row['lineman_id'] == "0") ? "blue" : "green",
						"id" 	 => $row['id'],
						"title"	 => $row['overview'],
						"start"	 => $row['startdate'],
						"nature" => $complaint['complaint_nature'],
						"linemanId" => $row['lineman_id'],
						"inspectorId" => $row['inspector_id'],
						"end"	 => $row['enddate'],
						"dateAttended"	 => $inspectionResult['date_attended'],
						"oldBrand"	 => $inspectionResult['old_brand'],
						"oldReading"	 => $inspectionResult['old_reading'],
						"oldSerial"	 => $inspectionResult['old_serial'],
						"newBrand"	 => $inspectionResult['new_brand'],
						"newReading"	 => $inspectionResult['new_reading'],
						"kwh"	 => $inspectionResult['kwh_meter_type'],
						"sdw"	 => $inspectionResult['sdw_length'],
						"or"	 => $inspectionResult['or_number'],
						"newSerial"	 => $inspectionResult['new_serial']
						);

			$records[] = $data;
		}

		return $records;
	}

	public function getScheduleById($id){
		$stmnt = $this->db->prepare("
					SELECT * FROM schedule
					WHERE id = ?
					");	
		$stmnt->execute(array($id));

			while($row = $stmnt->fetch()){
				$complaint = $this->getComplaintDetailById($row['complaint_id']);
				$inspectionResult = $this->getInspectionResultByComplaintId($row['complaint_id']);
				$data = array(
						"consumer" => $complaint['firstname']." ".$complaint['lastname'],
						"address" => $complaint['brgy']." ".$complaint['municipality'].", Marinduque",
						"complaintId" => $row['complaint_id'],
						"color" => ($row['lineman_id'] == "0") ? "blue" : "green",
						"id" 	 => $row['id'],
						"title"	 => $row['overview'],
						"start"	 => $row['startdate'],
						"nature" => $complaint['complaint_nature'],
						"linemanId" => $row['lineman_id'],
						"inspectorId" => $row['inspector_id'],
						"end"	 => $row['enddate'],
						"dateAttended"	 => $inspectionResult['date_attended'],
						"oldBrand"	 => $inspectionResult['old_brand'],
						"oldReading"	 => $inspectionResult['old_reading'],
						"oldSerial"	 => $inspectionResult['old_serial'],
						"newBrand"	 => $inspectionResult['new_brand'],
						"newReading"	 => $inspectionResult['new_reading'],
						"kwh"	 => $inspectionResult['kwh_meter_type'],
						"sdw"	 => $inspectionResult['sdw_length'],
						"or"	 => $inspectionResult['or_number'],
						"newSerial"	 => $inspectionResult['new_serial']
						);

				return $data;
				echo "<pre>";
				print_r($complaint);
				die();
			}
	}

	public function getComplaintSummaryExport($group = false){
		$records = array();
		$groupBy = " ";

		if($group != false){
			$groupBy ="t2.complaint_nature,";
		}

		$stmnt = $this->db->prepare("
				SELECT t1.*,t2.complaint_nature,
				t2.firstname, t2.lastname, t2.middlename, t3.lineman_id,
				t2.brgy, t2.municipality,t2.contact_number
				FROM inspection_result t1
				LEFT JOIN complaints t2 ON t1.complaint_id = t2.id
				LEFT JOIN schedule t3 ON t1.complaint_id = t3.complaint_id
				ORDER BY ".$groupBy."
				 t1.date_attended desc
			");
		$stmnt->execute(array());

		while($row = $stmnt->fetch()){
			$brgy = $this->getBrgyById($row['brgy']);
			$lineman = $this->getInfoByUserId($row['lineman_id']);
			$consumerType = $this->getInfoByContactNumber($row['contact_number']);
			$row['brgy'] = $brgy['name'];
			$consumerType = (isset($consumerType[0]) ? $consumerType[0]['consumer_type']: "");
			$row['consumerType'] = $consumerType;
			$row['lineman'] = $lineman[0]['firstname']." ".$lineman[0]['lastname'];

			$records[] = $row;
		}

		return $records;
	}

	public function getLinemanMessage(){
		$time = current(explode("(",$_POST['start']));
		$start = explode(" " , $time);
		$startDate = $start[1]."/".$start[2]."/".$start[3]." ".$start[4];
		$complaint = $this->getComplaintDetailById($_POST['complaintId']);
		$lineman = $this->getInfoByUserId($_POST['lineman']);
		$inspector = $this->getInfoByUserId($_POST['inspector']);

		$brgy = $this->getBrgyById($complaint['brgy']);
		$consumerName = $complaint['firstname']." ".$complaint['middlename']." ".$complaint['lastname'];
		$address = $brgy['name']." ".$complaint['municipality']." ".$complaint['province'];

$message = "Request Detail[".$startDate."] : ".$complaint['complaint_nature']."
".$consumerName.", ".$address.", ".$complaint['contact_number'];

		$data = array(
				"message" => $message,
				"recipients" => array(
						$lineman[0]['contact_number'],
						$inspector[0]['contact_number'],
						$complaint['contact_number']
					)
			);

		die(json_encode($data));
	}

	public function sendLinemanNotificationListener(){
		if(isset($_POST['sendLinemanNotification'])){
			$message = $_POST['response']['message'];
			$recipients = $_POST['response']['recipients'];
			foreach($recipients  as $idx => $r){
				$this->sendMessage($r, $message);
			}
		}
	}

	public function addEventListener(){
		if(isset($_POST['addEvent'])){
			$stmnt = $this->db->prepare("
					INSERT INTO schedule(overview,complaint_id,user_id,startdate,enddate,lineman_id,inspector_id)
					VALUES(?,?,?,?,?,?,?)
				");

			$stmnt->execute(array(
					$_POST['eventname'],
					$_POST['complaintId'],
					$_SESSION['user']['id'],
					$_POST['start'],
					$_POST['end'],
					$_POST['lineman'],
					$_POST['inspector']
				));

			$this->db->query("UPDATE complaints SET user_id = ".$_POST['lineman']." WHERE complaint_id = "+$_POST['complaintId']);
			
			$this->getLinemanMessage();

			// die(json_encode(array("added"=>true)));
		}
	}   
	                                
	public function loadLinemanListener(){
		if(isset($_POST['loadLineman'])){
			$records = array();
			$stmnt = $this->db->query("SELECT t1.* from info t1 LEFT JOIN user t2 on t1.userid = t2.id");

			while($row = $stmnt->fetch()){
				$records[] = $row;
			}

			die(json_encode($records));
		}
	}

	public function loadProfileListener(){
		if(isset($_POST['loadProfile'])){
			$record = array();
			$stmnt = $this->db->prepare("SELECT * FROM info WHERE userid = ? LIMIT 1");
			$stmnt->execute(array($_SESSION['user']['id']));
			
			while($row = $stmnt->fetch()){
				die(json_encode($row));
			}

		}
	}	

	public function updatePhotoById($id, $photo){
		$stmnt = $this->db->prepare("
				UPDATE info
				SET photo = ?
				WHERE userid = ?
			");
		$stmnt->execute(array($photo, $id));
	}

	public function getProfile(){
		$record = array();
		$stmnt = $this->db->prepare("SELECT * FROM info WHERE userid = ? LIMIT 1");
		$stmnt->execute(array($_SESSION['user']['id']));
		// $stmnt->execute(array(125));

		while($row = $stmnt->fetch()){
			if($row['photo'] == ""){
					$row['photo'] = "img/user.png";
				} else {
					$row['photo'] = "uploads/".$row['photo'];
				}                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            

				return $row;
			}

			return array();
	}

	public function loadFilesListener(){
		if(isset($_POST['loadFiles'])){
			$records 	= array();
			// todo:show by user role
			$stmnt 		= $this->db->query("SELECT * FROM file");

			while($row = $stmnt->fetch()){
				$records[] = $row;
				// opd($row);
			}

			die(json_encode($records));
		}
	}

	public function addFile($filename, $type, $size){
		$stmnt = $this->db->prepare("INSERT INTO file(filename,type,size,userid) VALUES(?,?,?,?)");
		$stmnt->execute(array($filename, $type, $size, 1));
	}

	public function logout(){
		if(isset($_POST['logout'])){
			session_destroy();

			die(json_encode(array("redirect")));
		}
	}

	public function restrictAccess(){
		if(isset($_POST['loadSession'])){
			$data = array();

			if(isset($_SESSION['user'])){
				$data = array(
					"id" 			=> $_SESSION['user']['id'],
					"type" 			=> strtoupper(str_replace("_", " ", $_SESSION['user']['type'])),
					"email" 		=> $_SESSION['user']['email'],
					"username" 		=> $_SESSION['user']['username'] );

			} else {
				$data = array("redirect" => "index.html");				
			}

			die(json_encode($data));
		}
	}

	public function updateUserListener(){
		if(isset($_POST['updateUserDetail'])){
			$fname 	= $_POST['firstname'];
			$lname 	= $_POST['lastname'];
			$mname 	= $_POST['middlename'];
			$gender = $_POST['gender'];
			$age = $_POST['age'];
			$dob 	= $_POST['dob'];
			$pob 	= $_POST['pob'];
			$nationality 	= $_POST['nationality'];
			$religion 	= $_POST['religion'];
			$address 	= $_POST['address'];
			$weight 	= $_POST['weight'];
			$height 	= $_POST['height'];
			$contact 	= $_POST['contact_number'];
			$status 	= $_POST['civil_status'];
			$membership_type 	= $_POST['membership_type'];
			$consumer_type 	= $_POST['consumer_type'];
			$userId = $_POST['userid'];
			$brgy = $_POST['brgy'];
			$municipality = $_POST['municipality'];


			//insert blank info data if not exists
			$record = array();
			$exists = $this->db
			->query("SELECT * FROM info WHERE userid = ".$userId." LIMIT 1")
			->rowCount();

			if($exists == 0){
				$stmnt = $this->db->prepare("
					INSERT INTO info(id,userid)
					VALUES(NULL,?)
					");
				$stmnt->execute(array($userId));
			}

			$stmnt = $this->db->prepare(
				"UPDATE info 
					SET firstname = ?, lastname = ?,middlename = ?,
					age = ?, sex = ?, dob = ?, religion = ?, address = ? ,
					pob = ?, contact_number = ?, civil_status = ?,
					membership_type = ?, consumer_type = ?,
					nationality = ?, weight = ?, height = ?, brgy =?,
					municipality = ?
					WHERE userid = ?
				")->execute(array(
					$fname,
					$lname,
					$mname,
					$age,
					$gender,
					date("Y-m-d", strtotime($dob)),
					$religion,
					$address,
					$pob,
					$contact,
					$status,
					$membership_type, 
					$consumer_type,
					$nationality,
					$weight,
					$height, 
					$brgy,
					$municipality,
					$userId));

				//update branch Id
				if(isset($_POST['branchId'])){
					$stmnt = $this->db->prepare("
							UPDATE user
							SET branch_id = ?
							WHERE id = ?
						");

					$stmnt->execute(array($_POST['branchId'], $userId));
				}

			die(json_encode(array("status" => "Record is Updated")));
		}
		
	}


	public function updateStudentInfoListener(){
		if(isset($_POST['updateStudentInfo'])){
			$fname 	= $_POST['firstname'];
			$lname 	= $_POST['lastname'];
			$mname 	= $_POST['middlename'];
			$gender = $_POST['gender'];
			$age = $_POST['age'];
			$dob 	= $_POST['dob'];
			$nationality 	= $_POST['nationality'];
			$religion 	= $_POST['religion'];
			$address 	= $_POST['address'];
			$weight 	= $_POST['weight'];
			$height 	= $_POST['height'];
			$brgy 	= $_POST['brgy'];
			$municipality 	= $_POST['municipality'];
			$userId 	= $_SESSION['user']['id'];
			
			// echo "<pre>";
			// print_r($_POST);
			// die(); jordand2
			$exists = $this->db->query("SELECT * FROM info WHERE userid = ".$userId." LIMIT 1")->fetch();

			if($exists == true){
				$stmnt = $this->db->prepare(
						"UPDATE info 
							SET firstname = ?, lastname = ?,middlename = ?,
							age = ?, sex = ?, dob = ?, religion = ?, address = ? ,
							nationality = ?, weight = ?, height = ?, brgy = ?,
							municipality = ?
							WHERE userid = ?
						")->execute(array($fname,$lname,$mname,$age,$gender,date("Y-m-d", strtotime($dob)),
							$religion,$address,$nationality,$weight,$height, $userId, $brgy, $municipality));

					die(json_encode(array("status" => "Record is Updated")));

			} else {
				$stmnt = $this->db->query(
				// $stmnt = (
						"INSERT INTO info
						VALUES(NULL, 
							'".$fname."',
							'".$lname."',
							'".$mname."',
							'".$age."',
							'".$gender."',
							'".date("Y-m-d",strtotime($dob))."',
							'".$religion."',
							'".$address."',
							'".$nationality."',
							'".$weight."',
							'".$height."',
							".$userId.")"
					);

				die(json_encode(array("status" => "Record is Updated")));
			}
			
		}
	}

	public function loadAnnouncementListener(){
		if(isset($_POST['loadAnnouncement'])){
			$this->getAllAnnouncement();
		}
	}

	public function addAnnouncementListener(){
		if(isset($_POST['announcement'])){
			$this->addAnnouncement($_POST);
		}
	}

	public function addAnnouncement($data){
		$this->db->prepare("
				INSERT INTO announcement(title, description,user_id)
				VALUES(?,?,?)
			")->execute(array($data['title'], $data['description'], $_SESSION['user']['id']));

		die(json_encode(array("added")));
	}

	public function getAnnouncementById($id){
		$records 	= array();
		$stmnt 		= $this->db->prepare("
			SELECT t1.*,t2.username 
			FROM announcement  t1
			LEFT JOIN  user  t2 on t1.user_id = t2.id
			WHERE t1.id =?			
			ORDER BY t1.dateadded
			LIMIT 1
			
		");

		$stmnt->execute(array($id));

		while($row = $stmnt->fetch()){
			$row['dateadded'] = date("M-d", strtotime($row['dateadded']));
			$records[] 	= $row;
		}

		return $records;
	}

	public function getLatestAnnouncement(){
		$records 	= array();
		$stmnt 		= $this->db->query("
			SELECT t1.*,t2.username 
			FROM announcement  t1
			LEFT JOIN  user  t2 on t1.user_id = t2.id
			ORDER BY t1.dateadded DESC
			LIMIT 3
		");

		while($row = $stmnt->fetch()){
			$row['dateadded'] = date("M-d", strtotime($row['dateadded']));
			$records[] 	= $row;
		}

		return $records;
	}

	public function getAllAnnouncement(){
		$records 	= array();
		$stmnt 		= $this->db->query("
			SELECT t1.*,t2.username 
			FROM announcement  t1
			LEFT JOIN  user  t2 on t1.user_id = t2.id
			ORDER BY t1.dateadded DESC
			LIMIT 20
		");

		while($row = $stmnt->fetch()){
			$row['dateadded'] = date("M-d", strtotime($row['dateadded']));
			$records[] 	= $row;
		}

		return $records;
	}

	public function loginUserListener(){
		if(isset($_POST['login'])){
			$this->getLoginUser($_POST);
		}
	}

	public function getErrors(){
		die(json_encode(array("error" => $this->errors)));
	}

	public function getLoginUser($data){
		$stmnt = $this->db
			->query("SELECT * FROM 
				user WHERE username = '".$data['username']."' AND deleted = 0 AND password = '".md5($data['password'])."' LIMIT 1");
		
		if($stmnt->rowCount() > 0){
			foreach($stmnt as $idx => $user){
				$_SESSION['user'] = $user;
				//status
				// 0 = unverified but registered online
				// 1 = incomplete requirement
				// 2 = attended orientation

				if($user['type'] == 'admin'){

					die(json_encode(array("redirect" => "dashboard.php")));
				}

				$noPlatform = array("line_man", "inspector");

				if(in_array($user['type'], $noPlatform)){
					$this->errors[] = "Invalid Account Informantion";
					$this->getErrors();
				}
				
				if($user['status'] != 0){
					die(json_encode(array("redirect" => "dashboard.php")));
				} else {
					die(json_encode(array("redirect" => "Account is not yet verified")));
				}

				// if($user['type'] == "admin"){
				// 	header("Location:adminPage.php");
				// } else {
				// 	header("Location:../index.html");
				// }

				break;
			}
		} else {
			$this->errors[] = "Invalid Account Informantion";
			$this->getErrors();
		}
	}

	public function registrationListener(){
		if(isset($_POST['registration'])){
			$this->validateUser($_POST);
		}
	}

	public function isUserExists($username){
		return  $this->db
			->query("SELECT username FROM user WHERE username = '".$username."' LIMIT 1")
			->rowCount();
	}

	public function isUserExistsByNameAndContactNumber($firstname, $lastname, $middlename, $contactNumber){
		$stmnt=  $this->db
			->prepare("
					SELECT *
					FROM info
					WHERE firstname = ?
					AND lastname = ?
					AND middlename = ?
					AND contact_number = ?
					LIMIT 1
				");

		$stmnt->execute(array(
					$firstname,
					$lastname,
					$middlename,
					$contactNumber
				));

		while($row = $stmnt->fetch()){
			return 1;
		}

		return 0;
	}

	public function validateUser($user, $die = false){
		if(isset($_POST['contact_number'])){
			$contactNumber = $_POST['contact_number'];


			if(!is_numeric($contactNumber)){
				$this->errors[] = "Invalid Contact Number";
			} else {
				if(strlen($contactNumber) != 11){
					$this->errors[] = "Contact Number must consist of eleven digits number";
				} else {
					if($contactNumber[0] != "0"){
						$this->errors[] = "Contact Number must start with 0";
					}
				}
			}

			//validate if firstname,lastname,middlename,contact number exists
			$exists = $this->isUserExistsByNameAndContactNumber($user['firstname'], 
				$user['lastname'],$user['middlename'],$user['contact_number']);

			if($exists > 0){
				$this->errors[] = "The account is already registered.";
			}
		}

		if(! isset($_POST['walkInApplicant'])){
			if($user['password'] != $user['password2']){
				$this->errors[] = "Passwords didn't match";
			}	

			if(strlen($user['password']) < 6){
				$this->errors[] = "Password is too short";
			}

			if($this->isUserExists($user['username']) == 1){
				$this->errors[] = "Username already exists";
			}

			if(strlen($user['username']) < 6){
				$this->errors[] = "Username is too short";
			}
		}

		if(count($this->errors) > 0){
			$this->getErrors();
		} else {
			if($die == false){
				$this->addUser($user);
			}
		}
	}

	public function sendRequirementNotificationByConsumerType($type, $recipient){
		$requirements = $this->getAllRequirementsByType($type);
		$req = array();

		foreach($requirements as $idx => $r){
			$req[] = $r['name'];
		}

		$req = implode(",", $req);
		$message = $type." Type Requirements: ".$req;

		$this->sendMessage($recipient, $message);
	}

	public function addUser($data, $die = false){
		$stmnt = $this->db->prepare("
				INSERT INTO user(username,password,email,type,branch_id,status) 
				VALUES (?,?,?,?,?,?)
			");

		$status = (isset($data['status'])) ? 1 : 0;

		if(isset($_POST['notwalkin'])){
			$status = 1;
		}

		if(isset($_POST['walkInApplicant'])){
			$stmnt->execute(array(
					'walkinUser', 
					md5("sudoadmin"), 
					"walkinemail@gmail.com", 
					$data['type'], 
					(isset( $data['branch']) ?  $data['branch'] : (isset($data['branchId'])) ? $data['branchId']: null),
					$status
				)
			);

		} else {
			$stmnt->execute(array(
					$data['username'], 
					md5($data['password']), 
					$data['email'], 
					$data['type'], 
					(isset( $data['branch']) ?  $data['branch'] : (isset($data['branchId'])) ? $data['branchId']: null),
					$status
				)
			);

		}

		$id = $this->db->lastInsertId();

		$stmnt = $this->db->prepare("
				INSERT INTO info(userid)
				VALUES(?)
			");

		$stmnt->execute(array($id));


		if($die != true){
			die(json_encode(array("added" => true)));
		} else {
        	return  $id;
		}
	}

	public function sendRequirementNotificationByConsumerTypeListener(){
		if(isset($_POST['sendRegistrationMessage'])){
			$this->sendRequirementNotificationByConsumerType($_POST['consumer_type'], $_POST['contact_number']);
		}
	}
}


