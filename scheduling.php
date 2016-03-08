
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
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css">

    <!-- Custom styles for this template -->
    <link href="css/blog.css" rel="stylesheet">
    <link href='css/fullcalendar.css' rel='stylesheet' />
    <link href='css/fullcalendar.print.css' rel='stylesheet' media='print' />
    <style type="text/css">
    #external-events {
      float: left;
      min-width: 150px;
      padding: 0 10px;
      border: 1px solid #ccc;
      background: #eee;
      text-align: left;
    }
      
    #external-events h4 {
      font-size: 16px;
      margin-top: 0;
      padding-top: 1em;
    }
      
    #external-events .fc-event {
      margin: 10px 0;
      cursor: pointer;
    }
      
    #external-events p {
      margin: 1.5em 0;
      font-size: 11px;
      color: #666;
    }
      
    #external-events p input {
      margin: 0;
      vertical-align: middle;
    }
    </style>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body data-id="<?= $_GET['id'];?>">
    <?php include_once "header.php"; ?>
    <div class="container">
      <div class="blog-header">
        <h1 class="blog-title">Weekly Schedule</h1>
      </div>
      <div class="row">
        <div class="col-sm-12 blog-main">
        <?php
          // $x = $model->getSchedulingEventListener();
        ?>
            <div id='calendar'></div>
          <ul id="errors"></ul>
        </div><!-- /.blog-main -->
      </div><!-- /.row -->
    </div><!-- /.container -->
    <footer class="blog-footer">
      <p>
        <a href="#">Back to top</a>
      </p>
    </footer>
    <!-- Add event -->
    <div class="modal fade" id="addNew-event">
         <div class="modal-dialog">
              <div class="modal-content">
                   <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Add Service</h4>
                   </div>
                   <div class="modal-body">
                        <form class="form-validation" role="form">
                             <div class="form-group">
                                  <label for="eventName">Service Overview</label>
                                  <input type="text" class="input-sm form-control validate[required]" id="eventName" placeholder="...">
                             </div>
                             <div class="form-group">
                                <label for="lineman">Assign to Inspector</label>
                                <?php $inspector = $model->getAllActiveInspector(); ?>
                                <select id="inspector" class="form-control">
                                  <?php foreach($inspector as $idx => $l): ?>
                                    <option value="<?= $l['id'];?>"><?= $l['name'];?></option>
                                  <?php endforeach ?>
                                </select>
                            </div>
                             <div class="form-group">
                                <label for="lineman">Assign to lineman</label>
                                <?php $lineman = $model->getAllActiveLineman(); ?>
                                <select id="lineman" class="form-control">
                                  <?php foreach($lineman as $idx => $l): ?>
                                    <option value="<?= $l['id'];?>"><?= $l['name'];?></option>
                                  <?php endforeach ?>
                                </select>
                            </div>
                          
                             <input type="hidden" id="currentComplaintId">
                             <input type="hidden" id="getStart" />
                             <input type="hidden" id="getEnd" />
                        </form>
                   </div>
                   
                   <div class="modal-footer">
                        <input type="submit" class="btn btn-info btn-sm" id="addEvent" value="Add Service">
                        <button type="button" class="btn btn-info btn-sm" id="cancelEvent" data-dismiss="modal">Close</button>
                   </div>
              </div>
         </div>
    </div>
    
    <!-- Modal Resize alert -->
    <div class="modal fade" id="editEvent">
         <div class="modal-dialog" style="width:850px;">
              <div class="modal-content">
                   <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Edit Service</h4>
                   </div>
                   <div class="modal-body">
                      <div class="form-group">
                            <label for="e-eventName">Service Overview</label>
                            <input type="text" class="input-sm form-control validate[required]" id="e-eventName" placeholder="...">
                       </div>
                        <div class="form-group">
                          <label for="e-inspector">Assign to Inspector</label>
                          <?php $inspector = $model->getAllActiveInspector(); ?>
                          <select id="e-inspector" class="form-control">
                            <?php foreach($inspector as $idx => $l): ?>
                              <option value="<?= $l['id'];?>"><?= $l['name'];?></option>
                            <?php endforeach ?>
                          </select>
                      </div>
                       <div class="form-group">
                          <label for="e-lineman">Assign to lineman</label>
                          <?php $lineman = $model->getAllActiveLineman(); ?>
                          <select id="e-lineman" class="form-control">
                            <?php foreach($lineman as $idx => $l): ?>
                              <option value="<?= $l['id'];?>"><?= $l['name'];?></option>
                            <?php endforeach ?>
                          </select>
                      </div>
                     
                      <div class="form-group">
                        <label>Inspection Result</label>
                        <table class="table">
                          <tbody>
                            <tr>
                              <td rowspan="2" style="text-align:center;font-weight:bold;">Date Attended</td>
                              <td colspan="3" style="text-align:center;font-weight:bold;">Old KWH Meter</td>
                              <td colspan="3" style="text-align:center;font-weight:bold;">New KWH Meter</td>
                              <td></td>
                              <td></td>
                              <!-- <td>O.R # Date</td> -->
                            </tr>
                            <tr>
                              <td>Class/Brand</td>
                              <td>Reading</td>
                              <td>Serial #</td>
                              <td>Class/Brand</td>
                              <td>Reading</td>
                              <td>Serial #</td>
                              <td>Type of Kwh Meter</td>
                              <td>Length of SDW</td>
                            </tr>
                            <tr>
                              <td><input type="text" class="date-attended datepicker form-control"/></td>
                              <td><input type="text" class="o-brand form-control"/></td>
                              <td><input type="text" class="o-reading form-control"/></td>
                              <td><input type="text" class="o-serial form-control"/></td>
                              <td><input type="text" class="n-brand form-control"/></td>
                              <td><input type="text" class="n-reading form-control"/></td>
                              <td><input type="text" class="n-serial form-control"/></td>
                              <td><input type="text" class="n-kwh form-control"/></td>
                              <td><input type="text" class="n-sdw form-control"/></td>
                            </tr>
                          </tbody>                            
                        </table>
                      </div>
                       <input type="hidden" id="e-currentComplaintId">
                   </div>
                   <div class="modal-footer">
                        <button type="button" class="btn btn-info btn-sm" id="updateEdit">Update</button>
                   </div>
              </div>
         </div>
    </div>
    <script type="text/html" id="lm">
      <option value="[ID]">[NAME]</option>
    </script>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script> <!-- jQuery Library -->
    <!-- // <script type="text/javascript" src="js/jquery-ui.custom.min.js"></script> -->
    <script src="js/jquery-ui.min.js"></script> <!-- jQuery Library -->
    <script src="js/bootstrap.min.js"></script>
    <script src='js/moment.min.js'></script>
    <script src='js/fullcalendar.min.js'></script>
    <script type="text/javascript">
    (function($){
      var Schedule = {
          id: null,
          __init : function(){
            this.loadCalendar();

            this.__listen();            
          },
          __listen : function(){

          },
          loadCalendar : function(){
            var id = $("body").data("id");
            var calendar = $("#calendar");
            return false;
            $.ajax({
              url   : "backend/process.php",
              data  : {getSchedulingEvent:true},
              type  : 'POST',
              dataType  : 'JSON',
              success   : function(response){

                return false;
                calendar.fullCalendar({
                    header        : false,
                    // eventColor    : '#428bca',
                    eventColor    : 'red',
                    columnFormat  :'ddd', 
                    allDaySlot    : false,
                    eventOverlap  : false,
                     nextDayThreshold : '00:00:00', // 9am
                    defaultView   : "agendaWeek",
                     defaultTimedEventDuration  : '00:30:00',
                    forceEventDuration          : true,
                     defaultDate: new Date(),
                      selectable: true,
                      timezoneParam:  "UTC",
                      draggable:false,
                      droppable: true, // this allows things to be dropped onto the calendar
                      editable: true,
                      eventLimit: true, // allow "more" link when too many events
                      events : response,
                    select : function(start, end, allDay){
                         $("#calendar").fullCalendar('addEventSource', [{
                              start: start,
                              end: end,
                              block: true
                          }]);
                          calendar.fullCalendar('unselect');

                          $.ajax({
                            url     : "backend/process.php",
                          data  : {addScheduler:true,start:start._d,end:end._d,id:id},
                            type    : 'POST',
                            dataType    : 'JSON',
                            success     : function(response){
                             
                            },
                            error       : function(){
                                console.log("err");
                            }
                          });
                          //disable selectable to this time range after

                    },
                    eventRender: function(event, element) {

                      //  console.log(event._start);
                      // if(event.added == "true"){
                      //   event.editable = false;
                      //   event.resizable = false;
                      //   event.selectable = false;
                      // }

                    },
                     eventResize: function(event, delta, revertFunc) {

                        if (!confirm("is this okay?")) {
                            revertFunc();
                        } else {
                          // update record
                          var id = event.id;
                          var endDate = event.end.format();

                          $.ajax({
                              url   : "backend/process.php",
                              data  : {updateEvent:true, id:id,endDate:endDate},
                              type  : 'POST',
                              dataType : 'JSON',
                              success   : function(response){
                                console.log(response);
                              },
                              error   : function(){
                                console.log("err");
                              }
                          });
                        }

                    },
                    eventAfterRender: function(event,element,view){
                      // return false;

                      // lastId = event._id;
                      // console.log(event.color); 
                      // if( event.color =="blue"){
                      //   event.resizable = false;
                      //   event.editable = false;
                      // }
                    },
                     eventClick: function(event, element) {
                        if (confirm("Are you sure you want to delete this timeblock?")) {
                          $.ajax({
                            url     : "backend/process.php",
                            data    : { 
                              deleteLinemanEvent    : true,
                              id : event._id
                            },
                            type    : 'POST',
                            dataType    : 'JSON',
                            success     : function(response){
                              calendar.fullCalendar('removeEvents',event._id);
                            },
                            error       : function(){
                                console.log("err");
                            }
                          });
                          
                        }
                    },
                  });
              },
              error     : function(){
                console.log("Err");
              }
            });

            return false;

            return false;
            $.ajax({
              url         : "backend/process.php",
              data        : {getEvents: true},
              type        : 'POST',
              dataType    : 'JSON',
              success     : function(response){
               lastId = null;

                
              },
              error       : function(){
                  console.log("err");
              }
          });
          }
      }

      Schedule.__init();

      })(jQuery);
    </script>
  </body>
</html>
