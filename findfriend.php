<!doctype html>
<!--[if lt IE 7]>
    <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en">
    <![endif]-->
    <!--[if IE 7]>
        <html class="no-js lt-ie9 lt-ie8" lang="en">
        <![endif]-->
        <!--[if IE 8]>
            <html class="no-js lt-ie9" lang="en">
            <![endif]-->
            <!--[if gt IE 8]>
            <!-->
            <html class="no-js" lang="en">
            <!--<![endif]-->
            
            <head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
                <title>Twitter Mutual Friends - Simon Tabor</title>
                <link rel="stylesheet" href="/style.css" type="text/css">
                <script src="/js/libs/modernizr-2.5.3-respond-1.1.0.min.js"></script>
            </head>
            
            <body>
                <header>
                    <div>
                        <h3>Retrieve mutual followers:</h3>
                    </div>
                </header>
                <div role="main">
                    <form id="usernameform">
                     <input type="text" id="username" placeholder="Twitter Username" autofocus>
                     <input type="text" id="username2" placeholder="another Username" >
                     <input type="submit" id="getpeople" value="&raquo;">
                 </form>
                 <div id="results" style="display:none">
                        <div id="unfollows">
                        <p class="unfollowers"></p>
                        <p class="difference"></p>
                        <ul></ul>

                    </div>
                    <h3>These mutual followers has <span id="totalmatches"><span style="font-size:10px">(loading...)</span></span> people</3>
                    <div id="matches">
                    </div>
                </div>
            </div>
            <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
            <script>
            window.jQuery || document.write('<script src="/js/libs/jquery-1.7.1.min.js"><\/script>')
            </script>
            <script src="/js/plugins.js"></script>
            <script src="/js/script.js"></script>
            <script>
            
$('#usernameform').submit(function (e) {
    e.preventDefault();
    if ($('#username').val() !== ""&&$('#username2').val() !== "") 
    getlists($('#username').val(), $('#username2').val());

})
var initialrequest, d = {};
function getlists(username, username2) {
    
    $('#unfollows').animate({'height':'0px'},300).find('ul').html(' ');
    namesandhandles = [];
    window.location.hash = username;
    $('#username').attr('placeholder','Try another?');
    $('#results').fadeIn(200);
    $('#results').css('background','url(/loading.gif) no-repeat 50% 100%');
    
    $.getJSON('http://api.twitter.com/1/followers/ids.json?screen_name='+username+'&callback=?', function (data) {
        d.followers = data.ids;
        var followers = data.ids;
        initialrequest = $.getJSON('http://api.twitter.com/1/users/lookup.json?screen_name='+username+'&callback=?', function (user_data) {
            d.user_data = user_data;
            
            if (user_data[0].protected) {
               $('#results').css({'background':'none','text-align':'center'}).text('Sorry, this Twitter account seems to be protected.');

           }
       })
        
        $.getJSON('http://api.twitter.com/1/followers/ids.json?screen_name='+username2+'&callback=?', function (data) {
            var followers2 = data.ids, compare = {}, matches = [];
            for (var j in followers) {
                compare[followers[j]] = followers[j];
            }
            for (var i in followers2) {
                if (typeof compare[followers2[i]] != 'undefined') {
                    matches.push(followers2[i]);
                } 
            }
            $('#totalmatches').text(matches.length);
            var repeats = Math.ceil(matches.length/100);
            var mutualslist = '<ul>', total = 0;
            var starttime = new Date().getTime();
            for (var j=1; j<=repeats;j++) {

                $.getJSON('http://api.twitter.com/1/users/lookup.json?user_id='+matches.slice((j-1)*100,j*100).toString()+'&callback=?', function (data) {

                    console.log(data);
                    total+= data.length;
                    for (var i in data) {
                        mutualslist+='<li><img src="'+data[i].profile_image_url_https+'" title="'+data[i].name+'" /><p>'+data[i].name+'<br><a target="_blank" href="http://twitter.com/'+data[i].screen_name+'">@'+data[i].screen_name+'</a></p></li>';
                        namesandhandles.push(data[i].name.toLowerCase());
                        namesandhandles.push(data[i].screen_name.toLowerCase());

                    }
                    if (total == matches.length) {
                        console.log('that took ', new Date().getTime() - starttime,'ms');
                        $('#matches').html(mutualslist+'</ul>');
                        $('#results').css('background','none');
                    }
                })
}
})
})
}
if (window.location.hash) {
    getlists(window.location.hash.split('#')[1]);
    $('#username').attr('placeholder','Try another?');
    $('#results').fadeIn(200);
}

</script>
<script type="text/javascript">
var GoSquared={};
GoSquared.acct = "GSN-757634-O";
(function(w){
    function gs(){
        w._gstc_lt=+(new Date); var d=document;
        var g = d.createElement("script"); g.type = "text/javascript"; g.async = true; g.src = "//d1l6p2sc9645hc.cloudfront.net/tracker.js";
        var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(g, s);
    }
    w.addEventListener?w.addEventListener("load",gs,false):w.attachEvent("onload",gs);
})(window);
</script>
</body>
</html>