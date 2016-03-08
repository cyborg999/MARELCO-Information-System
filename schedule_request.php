
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

  <body>

    <?php include_once "header.php"; ?>

    <div class="container">

      <div class="blog-header">
        <h1 class="blog-title">All Schedule</h1>
      </div>

      <div class="row">
        <div class="col-sm-3 blog-main">
          <div id='external-events'>
            <h4>Request</h4>
            <?php $unfixedComplaints = $model->getUnfixedComplaint("request"); 
            ?>

            <?php 
            $level = "";
            foreach($unfixedComplaints as $idx => $u){ ?>
              <?php
                if($u['emergency_level'] != $level){
                  $level = $u['emergency_level']; ?>
                  <label class="label">Priority Level:</label>
                  <span><?= $u['emergency_level'];?></span>
                <?php } ?>
              <div  style="padding:5px;" data-id="<?= $u['id'];?>" class='fc-event'><?= $u['complaint_nature'];?>
                  <em class="clearfix" style="font-size:11px; padding:5px;"><?= $u['reason'];?></em>
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="col-sm-7 blog-main">
          <!-- other content goes here -->
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
                              <td>OR #</td>
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
                              <td><input type="text" class="or-no form-control"/></td>
                            </tr>
                          </tbody>                            
                        </table>
                      </div>
                       <input type="hidden" id="e-currentComplaintId">
                   </div>
                   <div class="modal-footer">
    <a href="" class="btn btn-primary" id="preview">Job Order</a>

                        <button type="button" class="btn btn-info btn-sm" id="updateEdit">Update</button>
                   </div>
              </div>
         </div>
    </div>
        <div class="modal fade" id="export">
      <div class="modal-dialog" style="width:800px;">
        <div class="modal-content" >
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">PDF Preview</h4>
          </div>
          <div class="modal-body">

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" data-complaintid="" id="pdfExport">Export As PDF</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
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
       function Popup(data) { //$("html")
         var style = '<style>  </style>';
         var mywindow = window.open('', 'my div', '');
         window.innerWidth =2000;
         mywindow.document.write('<html>');
         mywindow.document.write('<head>');
         mywindow.document.write('</head>');
         mywindow.document.write('<body>');
         mywindow.document.write(data.html());
         mywindow.document.write('</body>');
         mywindow.document.write('</html>');
         mywindow.document.close(); // necessary for IE >= 10
         mywindow.focus(); // necessary for IE >= 10

         mywindow.print();
         mywindow.close();

      }
      var Schedule = {
          id: null,
          __init : function(){
            this.loadCalendar();
            
             $("#preview").on("click", function(e){
              e.preventDefault();
              var id = $("#export").data("complaintid");

               $.ajax({
                url     : "job_order.php?id="+id, 
                type    : 'GET',
                dataType  : 'html',
                success   : function(res){
                  console.log(res)
                  var target = $("#export");
                  target.find(".modal-body").html(res);

                  $("#export").modal("show");
                },
                error     : function(){
                  console.log("err");
                }
             });
             });

             $("#pdfExport").on("click", function(){
              var html = $(this).parents(".modal").find(".modal-body");
              console.log(html);
              Popup(html);
            });

            var url = window.location.href;
            $(".datepicker").datepicker();
            $("#updateEdit").on("click", function(e){
              $.ajax({
                url   : "backend/process.php",
                data  : {
                  updateEventSchedule : true,
                  complaintId   : $("#e-currentComplaintId").val(),
                  linemanId   : $("#e-lineman").val(),
                  inspectorId   : $("#e-inspector").val(),
                  title   : $("#e-eventName").val(),
                  dateAttended : $(".date-attended").val(),
                  oldBrand : $(".o-brand").val(),
                  oldReading : $(".o-reading").val(),
                  oldSerial : $(".o-serial").val(),
                  newBrand : $(".n-brand").val(),
                  newReading : $(".n-reading").val(),
                  kwh_meter_type : $(".n-kwh").val(),
                  sdw_length : $(".n-sdw").val(),
                  or_num : $(".or-num").val(),
                  newSerial : $(".n-serial").val()
                },
                type  : 'POST',
                dataType  : 'JSON',
                success   : function(response){
                  $("#editEvent").modal("hide");
                  console.log(response);
                  window.location.href = url;
                },
                error     : function(){
                  console.log('err');
                }
              });

              e.preventDefault();
            });
          },
          __listen : function(){
             this.loadCalendar();
             this.loadLineman();
          },
          loadLineman : function(){
              var me = this;

              $.ajax({
                  url     : "backend/process.php",
                  data    : {loadLineman: true},
                  type    : 'POST',
                  dataType : 'JSON',
                  success     : function(response){
                      var target = $("#lineman");

                      target.html("");

                      for(var i in response){
                          var lm = $("#lm").html();
                          var name = response[i].firstname+" "+response[i].lastname;

                          lm = lm.replace("[ID]", response[i].id).
                              replace("[NAME]", name);

                          target.append(lm);
                      }

                  },
                  error       : function(){
                      console.log("err");
                  }
              })
          },
          loadCalendar : function(){
              var calendar = $("#calendar");
              var me = this;


              // $('#external-events .fc-event').each(function() {
              //   // store data so the calendar knows to render an event upon drop
              //   $(this).data('event', {
              //     title: $.trim($(this).text()), // use the element's text as the event title
              //     stick: true // maintain when user navigates (see docs on the renderEvent method)
              //   });
              //   // make the event draggable using jQuery UI
              //   $(this).draggable({
              //     zIndex: 999,
              //     revert: true,      // will cause the event to go back to its
              //     revertDuration: 0  //  original position after the drag
              //   });
              // });

              $.ajax({
                  url     : "backend/process.php",
                  data    : {getEvents: true, type:"request"},
                  type    : 'POST',
                  dataType : 'JSON',
                  success     : function(response){
                    var lastId = null;

                    $('#calendar').fullCalendar({
                       // header        : false,
                    // eventColor    : '#428bca',
                    // eventColor    : 'red',
                    columnFormat  :'ddd', 
                    allDaySlot    : false,
                    eventOverlap  : false,
                    firstDay : 1,
                     nextDayThreshold : '00:00:00', // 9am
                    defaultView   : "agendaWeek",
                     defaultTimedEventDuration  : '00:30:00',
                    forceEventDuration          : true,
                     defaultDate: new Date(response.serverDate),
                      selectable: true,
                      timezoneParam:  "UTC",
                      draggable:false,
                      droppable: true, // this allows things to be dropped onto the calendar
                      editable: false,
                      eventLimit: true, // allow "more" link when too many events
                      events : response.records,
                      select: function(start, end, allDay) {
                        // return false;
                              // $('#addNew-event').modal('show');   
                              // $('#addNew-event input:text').val('');
                              // $('#getStart').val(start);
                              // $('#getEnd').val(end);

                        // var title = prompt('Event Title:');
                        // var eventData;
                        // if (title) {
                        //   eventData = {
                        //     title: title,
                        //     start: start,
                        //     end: end
                        //   };
                        //   $('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
                        // }
                        // $('#calendar').fullCalendar('unselect');
                      },
                      eventClick: function(calEvent, jsEvent, view){ 
                        $("#editEvent").modal("show");
                        $("#e-currentComplaintId").val(calEvent.complaintId);
                        $("#e-eventName").val(calEvent.title);
                        $("#e-lineman").find("option[value='"+calEvent.linemanId +"']").attr("selected", true);
                        $("#e-inspector").find("option[value='"+calEvent.inspectorId +"']").attr("selected", true);

                        $(".date-attended").val(calEvent.dateAttended);
                        $(".o-brand").val(calEvent.oldBrand);
                        $(".o-reading").val(calEvent.oldReading);
                        $(".o-serial").val(calEvent.oldSerial);
                        $(".n-brand").val(calEvent.newBrand);
                        $(".n-reading").val(calEvent.newReading);
                        $(".n-serial").val(calEvent.newSerial);
                        $(".n-sdw").val(calEvent.sdw);
                        $(".n-kwh").val(calEvent.kwh);
                        $(".or-num").val(calEvent.or);

                        $("#export").data("complaintid", calEvent.complaintId);

                              // // TODO: edit here
                              // $(this).toggleClass('newColor');
                              console.log(calEvent); // "id" if it is set by the event object, will be here.
                              // console.log(this);  // is the div element that was clicked on
                      },
                      eventRender: function(event, element) {
                             // $('#calendar').fullCalendar('removeEvents',event._id);
                        // alert('ren');
                        element.css("backgroundColor", event.color);
                        //   element.append( "<span class='closeon'>X</span>" );
                        //   element.find(".closeon").click(function() {
                        //      $('#calendar').fullCalendar('removeEvents',event._id);
                        //   });
                  
                      },
                      eventAfterRender: function(event,element,view){
                        lastId = event._id;
                        if(event.nature != null){
                          element.append("<p style='font-size:9px;'>("+ event.nature +")</p>");
                        }
                      },
                      drop: function(event, delta, revertFunc, jsEvent, ui, view) {
                        var ele = $(this);
                        var id = ele.data("id");
                        var e = event;
                        $('#addNew-event').modal('show');   
                        $('#addNew-event input:text').val('');
                        $('#getStart').val(event._d);
                        $("#currentComplaintId").val(id);
                        $('#getEnd').val('');


                        $("#addEvent").on("click", function(){
                          calendar.fullCalendar('removeEvents',lastId);
                          ele.remove();
                        });

                        $("#cancelEvent").on("click", function(){
                          calendar.fullCalendar('removeEvents',lastId);
                        });
                      }
                      // events: [
                        // {
                        //   title: 'All Day Event',
                        //   start: '2015-02-01'
                        // },
                        // {
                        //   title: 'Long Event',
                        //   start: '2015-02-07',
                        //   end: '2015-02-10'
                        // },
                        // {
                        //   id: 999,
                        //   title: 'Repeating Event',
                        //   start: '2015-02-16T16:00:00'
                        // },
                        // {
                        //   title: 'Click for Google',
                        //   url: 'http://google.com/',
                        //   start: '2015-02-28'
                        // }
                      // ]
                    });

                      // calendar.fullCalendar({
                      //     header: {
                      //          center: 'title',
                      //          left: 'prev, next',
                      //          right: ''
                      //     },
                      //     selectable: true,
                      //     selectHelper: true,
                      //     editable: true,
                      //     select: function(start, end, allDay) {
                      //         $('#addNew-event').modal('show');   
                      //         $('#addNew-event input:text').val('');
                      //         $('#getStart').val(start);
                      //         $('#getEnd').val(end);
                      //     },
                      //     events: response,
                      //     eventClick: function(calEvent, jsEvent, view){ 
                      //         // TODO: edit here
                      //         $(this).toggleClass('newColor');
                      //         console.log(calEvent); // "id" if it is set by the event object, will be here.
                      //         console.log(this);  // is the div element that was clicked on
                      //     }
                      // }); 

                  },
                  error       : function(){
                      console.log("err");
                  }
              });

            
             // // Calendar views
              // $('body').on('click', '.calendar-actions > li > a', function(e){
              //     e.preventDefault();
              //     var dataView = $(this).attr('data-view');
              //     $('#calendar').fullCalendar('changeView', dataView);
                  
              //     //Custom scrollbar
              //     var overflowRegular, overflowInvisible = false;
              //     overflowRegular = $('.overflow').niceScroll();     
              // });                    
              
              $('body').on('click', '#addEvent', function(){
                  var eventName = $('#eventName').val();
                  var start     = $('#getStart').val();
                  var end       = $('#getEnd').val();
                  var lmId      = $("#lineman").val();
                  var inspectorId = $("#inspector").val();
                  var complaintId = $("#currentComplaintId").val();

                  $.ajax({
                    url     : "backend/process.php",
                    data    : { 
                      addEvent  : true,
                      eventname :eventName, 
                      start     : start, 
                      end       : end,
                      complaintId : complaintId,
                      inspector : inspectorId,
                      lineman     : lmId
                    },
                    type    : 'POST',
                    dataType    : 'JSON',
                    success     : function(response){
                        console.log(response);

                        $.ajax({
                          url   : "backend/process.php",
                          data  : {sendLinemanNotification: true, response:response},
                          type  : 'POST',
                          dataType  : 'JSON',
                          success   : function(response){
                            console.log("Notification sent!");
                          },
                          error     : function(){
                            console.log("err");
                          }
                        });

                         calendar.fullCalendar('renderEvent',{
                               title: eventName,
                               start: start,
                               end:  end,
                               allDay: true,
                          },true ); //Stick the event

                          $('#addNew-event form')[0].reset()
                          $('#addNew-event').modal('hide');
                    },
                    error       : function(){
                        console.log("err");
                    }
                  });
              });  
          }
      }

      Schedule.__init();

      })(jQuery);
    </script>
  </body>
</html>
