<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Notification</title>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap-notifications.min.css">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-9" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Real Time Notification</a>
        </div>

        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="dropdown dropdown-notifications">
              <a href="#notifications-panel" class="dropdown-toggle" data-toggle="dropdown">
                <i data-count="0" class="glyphicon glyphicon-bell notification-icon"></i>
              </a>

              <div class="dropdown-container">
                <div class="dropdown-toolbar">
                  <div class="dropdown-toolbar-actions">
                    <a href="#">Mark all as read</a>
                  </div>
                  <h3 class="dropdown-toolbar-title">Notifications (<span class="notif-count">0</span>)</h3>
                </div>
                <ul class="dropdown-menu">
                </ul>
                <div class="dropdown-footer text-center">
                  <a href="#">View All</a>
                </div>
              </div>
            </li>
            <li><a href="#">New Orders</a></li>
            <li><a href="#">All Orders</a></li>
          </ul>
        </div>
      </div>
    </nav>
    {{-- code for play audio  --}}
    <h2>Sound Information</h2>
    <div id="length">Duration:</div>
    <div id="source">Source:</div>
    <div id="status" style="color:red;">Status: Loading</div>
    <hr>
    <h2>Control Buttons</h2>
    <button id="play">Play</button>
    <button id="pause">Pause</button>
    <button id="restart">Restart</button>
    <hr>
    <h2>Playing Information</h2>
    <div id="currentTime">0</div>
    {{-- code for play audio  --}}
 <!-- Modal -->
 <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">New Order Notification</h4>
        </div>
        <div class="modal-body">
          <h2>You Have <b>2</b> New Orders.</h2>
            <a  class="bg-success" href="">Click for details</a>
          <div> 
            <button id="restart">Stop</button>
          </div>
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="//js.pusher.com/3.1/pusher.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    {{-- code for play audio --}}
    <script>
    $(document).ready(function() {
//       window.customAudioPlay = function(){
//       window.audio = new Audio("http://127.0.0.1:8000/sound/S5FRJ7E-buzzers.mp3");
//       window.audio.play();
// };
      
//       window.audioElement = document.createElement('audio');
//       // S5FRJ7E-buzzers
//       window.audioElement.setAttribute('src', 'http://127.0.0.1:8000/sound/S5FRJ7E-buzzers.mp3');
      
//       window.audioElement.addEventListener('ended', function() {
//           this.play();
//       }, false);
      
//       window.audioElement.addEventListener("canplay",function(){
//           $("#length").text("Duration:" + window.audioElement.duration + " seconds");
//           $("#source").text("Source:" + window.audioElement.src);
//           $("#status").text("Status: Ready to play").css("color","green");
//       });
      
//       window.audioElement.addEventListener("timeupdate",function(){
//           $("#currentTime").text("Current second:" + window.audioElement.currentTime);
//       });
      
//       $('#play').click(function() {
//           window.audioElement.play();
//           $("#status").text("Status: Playing");
//       });
      
//       $('#pause').click(function() {
//           window.audioElement.pause();
//           $("#status").text("Status: Paused");
//       });
      
//       $('#restart').click(function() {
//           window.audioElement.currentTime = 0;
//       });
  });
  </script>
  {{-- code for play audio  --}}
  <script type="text/javascript">
  
  </script>
    <script type="text/javascript">
      var notificationsWrapper   = $('.dropdown-notifications');
      var notificationsToggle    = notificationsWrapper.find('a[data-toggle]');
      var notificationsCountElem = notificationsToggle.find('i[data-count]');
      var notificationsCount     = parseInt(notificationsCountElem.data('count'));
      var notifications          = notificationsWrapper.find('ul.dropdown-menu');

      if (notificationsCount <= 0) {
        notificationsWrapper.hide();
      }

      // Enable pusher logging - don't include this in production
      // Pusher.logToConsole = true;
 var pusher = new Pusher('4d71f99ad50c78d9bc0c', {
      cluster: 'ap2'
    });
    //   var pusher = new Pusher('4d71f99ad50c78d9bc0c','ap2', {
    //     encrypted: true
    //   });

      // Subscribe to the channel we specified in our Laravel Event
      var channel = pusher.subscribe('status-liked');

      // Bind a function to a Event (the full Laravel class)
      channel.bind('App\\Events\\StatusLiked', function(data) {
        var existingNotifications = notifications.html();
        var avatar = Math.floor(Math.random() * (71 - 20 + 1)) + 20;
        var newNotificationHtml = `
          <li class="notification active">
              <div class="media">
                <div class="media-left">
                  <div class="media-object">
                    <img src="https://api.adorable.io/avatars/71/`+avatar+`.png" class="img-circle" alt="50x50" style="width: 50px; height: 50px;">
                  </div>
                </div>
                <div class="media-body">
                  <strong class="notification-title">`+data.message+`</strong>
                  <!--p class="notification-desc">Extra description can go here</p-->
                  <div class="notification-meta">
                    <small class="timestamp">about a minute ago</small>
                  </div>
                </div>
              </div>
          </li>
        `;
        notifications.html(newNotificationHtml + existingNotifications);

        notificationsCount += 1;
        notificationsCountElem.attr('data-count', notificationsCount);
        notificationsWrapper.find('.notif-count').text(notificationsCount);
        notificationsWrapper.show();
        $('#myModal').modal('show');
        // window.customAudioPlay();
      // audio = new Audio("http://127.0.0.1:8000/sound/S5FRJ7E-buzzers.mp3");
      // audio.play();
      let src = 'http://127.0.0.1:8000/sound/S5FRJ7E-buzzers.mp3';
      let audio = new Audio(src);
      audio.play();
        
      });
      // $("#stopNotificationSound").click(function () {
      //                 window.audio.stop();
      //   });
    </script>
  </body>
</html>