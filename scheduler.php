
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
            $.ajax({
              url   : "backend/process.php",
              data  : {getLinemanEvents:true, id:id},
              type  : 'POST',
              dataType  : 'JSON',
              success   : function(response){
                calendar.fullCalendar({
                    // header        : false,
                    // eventColor    : '#428bca',
                    // eventColor    : 'red',
                    columnFormat  :'ddd', 
                    allDaySlot    : false,
                    firstDay :1,
                    eventOverlap  : false,
                     nextDayThreshold : '00:00:00', // 9am
                    defaultView   : "agendaWeek",
                     defaultTimedEventDuration  : '00:30:00',
                    forceEventDuration          : true,
                     defaultDate: new Date(response.serverDate),
                      selectable: true,
                      timezoneParam:  "UTC",
                      draggable:false,
                      droppable: true, // this allows things to be dropped onto the calendar
                      editable: true,
                      eventLimit: true, // allow "more" link when too many events
                      events : response.records,
                    select : function(start, end, allDay){
                      var day = ""+start._d+"";
                      var sat = day.search("Sat");

                      if(sat != -1){
                        alert("Weekends are not allowed");
                        return false;
                      } else {
                         var sun = day.search("Sun");
                        if(sun != -1){
                          alert("Weekends are not allowed");
                          return false;
                        }
                      }
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
                                console.log("err d2");
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
