<?php
/**
 * Created by PhpStorm.
 * User: Sangnv00452
 * Date: 3/17/14
 * Time: 9:53 AM
 */
?>

<!DOCTYPE >
<html>
<head>
    <meta http-equiv="Content-type"  ="text/html; charset=UTF-8"/>
    <link rel="stylesheet" href="libs/css/bootstrap.min.css" />
    <link rel="stylesheet" href="src/css/main.css">
    <script src="libs/js/jquery-1.10.2.js"></script>
    <script src="libs/js/bootstrap.min.js"></script>
    <script id="facebook-jssdk" async="" src="//connect.facebook.net/en_US/all.js#xfbml=1&appId=528207350609924"></script>
</head>

<body>
<!-- Load the Facebook JavaScript SDK -->
<div id="fb-root"></div>
<script>

    sessionStorage.startTime = 0;
    window.fbAsyncInit = function() {
        FB.Canvas.setSize({
            width : 810,
            height : 800
        });

        FB.init({
            appId : '528207350609924', // App ID
            channelUrl : 'https://microsoft.mashwire.com.sg/channel.html',
            status : true, // check login status
            cookie : true, // enable cookies to allow the server to access
            xfbml : true // parse XFBML
        });

        FB.Event.subscribe('edge.create', function(response) {
            //top.location.href = pageLink;
            $.ajax({
                url:"server/action-router.php",
                type : "POST",
                data : {
                    action : "user like app",
                    page_id : pageId,
                    user_id : userId
                },success : function(response){
                    top.location.href = pageLink;
                }
            });
        });
        FB.Event.subscribe('edge.remove', function(response){
//            alert("remove like");
//            alert("remove like");
//            console.log("remove like");
//            console.log("pageId");
//            console.log("userId");
//            $.ajax({
//                url:"server/action-router.php",
//                type : "POST",
//                data : {
//                    action : "user unlike",
//                    page_id : pageId,
//                    user_id : userId
//                },success :function(){
//                    top.location.href = pageLink;
//                }
//            });
        });
        FB.getLoginStatus(function(response) {
            // User authorized
            if (response.authResponse) {
                var accessToken = response.authResponse.accessToken;
            } else {
                // logic to facebook
                FB.login(function(response) {
                    if (response.authResponse) {

                    } else {

                    }
                }, {
                    'scope' : 'publish_stream'
                })
            }
        });
    };

    // Load the SDK Asynchronously
    ( function(d) {
        var js, id = 'facebook-jssdk';
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement('script');
        js.id = id;
        js.async = true;
        js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=528207350609924";
        d.getElementsByTagName('head')[0].appendChild(js);
    }(document));
</script>
<div id='main'>
    <?php
    require_once ('libs/fb-php-sdk/facebook.php');

    $app_id = 528207350609924;
    $app_secret = '07adc85d82bfc584bee9a6aacf95bd59';
    $config = array('appId' => $app_id, 'secret' => $app_secret);
    $facebook = new Facebook($config);
    $user_id = $facebook -> getUser();

    $signed_request = $facebook -> getSignedRequest();
    $like_status = $signed_request["page"]["liked"] ? 1 : 0;
    $country = $signed_request["user"]["country"];
    $_SESSION['lang'] = $country;
    $page_id = $signed_request["page"]["id"];
    $page_json = json_decode(file_get_contents("https://graph.facebook.com/$page_id"),true);
    $page_link = $page_json["link"]."/app_".$app_id;
    $page_link_json = json_encode($page_link);

    echo "<script type='text/javascript'>pageLink = $page_link_json</script>";
    echo "<script type='text/javascript'>userId = $user_id</script>";
    echo "<script type='text/javascript'>pageId = $page_id</script>";
    $redirect_uri = $page_link_json;

    if (!$user_id) {
        $login_url = $facebook -> getLoginUrl(array('scope' => 'email, publish_stream, user_birthday', 'redirect_uri' => $page_link));
        echo "<script type='text/javascript'>window.top.location.href = '$login_url';</script>";
    }else{
        if (!$signed_request["page"]["liked"]) {
            include '<h1>Like us to continue!</h1>';
        }else {
            include 'content.php';
//            echo "<script type='text/javascript'>window.location.href = 'shared/select-country.php?country=$country&lang=$country&fbid=$user_id&fbcountry=$country&fbpageid=$page_id&fbpagelink=$page_link';</script>";
        }
    }
    ?>
</div>
    <div class="app-footer">
        <h1>This is footer</h1>
    </div>
</body>
</html>
