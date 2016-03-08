<?php include_once "backend/process.php"; ?>

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
 
  </head>

  <body>
    <div class="blog-masthead">
      <div class="container">

        <nav class="blog-nav">
           <li class="this"><a href="" class="blog-nav-item ">Supply Monitoring and Repair Management System</a></li>
           <li class="this"><a class="blog-nav-item pull-right" href="login.php">Login</a></li>
           <li class="this"><a class="blog-nav-item pull-right" href="registration.php">Application for Membership</a></li>
           <li class="this"><a class="blog-nav-item pull-right " href="complaints_requirements.php">Services</a>
            <ol class="pull-right" style="left:280px;">
              <li><a href="complaints_requirements.php">Complaints</a></li>
              <li><a href="requests_requirements.php">Requests</a></li>
            </ol>
           </li>
            
           <li class="this "><a class="blog-nav-item pull-right active" href="index.php">Home</a></li>
        </nav>
      </div>
    </div>
    <style type="text/css">
    #myCarousel {
      height: 70%;
      overflow: hidden;
      position: relative;
      width: 100%;
    }
    .carousel-inner .item {
      height: 500px;
    }
    </style>
    <div id="myCarousel"  class="carousel slide">
        <?php  $slideshow = $model->getSlideshows(); ?>
        <ol class="carousel-indicators">
            <?php foreach($slideshow as $idx => $slide): ?>
            <li data-target="#myCarousel" data-slide-to="<?= $idx; ?>" class="<?= ($idx == 0) ? 'active' :''; ?>"></li>
            <?php endforeach ?>
        </ol>
        <div class="carousel-inner">
            <?php foreach($slideshow as $idx => $slide): ?>
                <div class="item <?= ($idx == 0) ? 'active':'' ;?>">
                    <div class="fill">
                        <img style="width:100%;max-height:100%;" src="<?= $slide['cover'];?>">
                    </div>
                    <div class="carousel-caption">
                        <h1 style="color:white;"><?= $slide['title']; ?></h1>
                        <p><?= $slide['desc']; ?></p>
                    </div>
                </div>
            <?php endforeach ?>
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="icon-prev"></span>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span class="icon-next"></span>
            </a>
          </div>
      </div>
            <?php $setting = $model->getSetting(); ?>

    <div class="container">
            <img src="img/marelco.jpg" style="position:fixed;left:0px;" alt="marelco">
      <br>
      <div class="row">
        <div class="col-sm-3 blog-sidebar">
          <div class="sidebar-module sidebar-module-inset" style="overflow:hidden;position:relative;">
            <h4>About</h4>
            <p><?= $setting['about'];?></p>
            <table>
              <tr>
                <td width="20"><span class="glyphicon glyphicon-phone"></span></td>
                <td><?= $setting['mobile'];?></td>
              </tr>
              <tr>
                <td width="20"><span class="glyphicon glyphicon-phone-alt"></span></td>
                <td><?= $setting['phone'];?></td>
              </tr>
              <tr>
                <td width="20"><span class="glyphicon glyphicon-envelope"></span></td>
                <td><?= $setting['email'];?></td>
              </tr>
            </table>
          </div>
          <div class="sidebar-module">
            <h4>Announcements</h4>
            <?php $announcement = new Model(); $announcement = $announcement->getAllAnnouncement(); ?>

            <style type="text/css">
            .news li p {
                width: 250px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            </style>
            <ol class="list-unstyled news">
              <?php foreach($announcement as $idx => $a): ?>
              <li>
                <a class="getNews" href="news.php?id=<?= $a['id']; ?>"><?= $a['title']?></a>
                <p ><?= $a['description']?></p>
              </li>
              <?php endforeach ?>
            </ol>
          </div>
        </div><!-- /.blog-sidebar -->
        <?php $latest = $model->getLatestAnnouncement(); ?>
        <div class="columns col-sm-8 col-sm-offset-1 ">
        <div class="row">
           <div class="columns col-sm-12 blog-main">
           <!--  <?php foreach($latest as $idx => $a): ?>
              <div class="blog-post">
                <h2 class="blog-post-title"> <?= $a['title']?></h2>
                <p class="blog-post-meta"><?= $a['dateadded']?> by <a href="#"><?= $a['username']?></a></p>
                <p><?= $a['description']?></p>
              </div>
            <?php endforeach ?> -->
          </div>
          <div class="columns col-sm-12">

            <h2>Vision:</h2>
            <?= $setting['vission'];?>
            <hr>
            <h2>Mission:</h2>
            <?= $setting['mission'];?>

          </div>
        </div>
         
            
        </div><!-- /.blog-main -->
      </div>
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
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">
      $('.carousel').carousel({
          interval: 5000 //changes the speed
      });

      var News = {
        __init  : function(){
          this.__listen();
        },
        __listen  : function(){
          var news = $(".getNews");

          news.on("click", function(e){
            var url = $(this).attr("href");

            $(".blog-post").remove();
            
            $.ajax({

              url   : url,
              type  : 'GET',
              dataType  : "html",
              success   : function(response){
                $(".blog-main").append(response);
              },
              error     : function(){
                console.log("err");
              }
            });

            e.preventDefault();
          });
        }
      }

      News.__init();
    </script>
  </body>
</html>
