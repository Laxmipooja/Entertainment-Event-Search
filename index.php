<?php include 'geoHash.php';?>
<?php
if(isset($_GET["location"]))
{
    
    $value= $_GET["location"];
    if(empty($_GET["distance"]))
    {
        $distance = 10;
    }
    else
    {
        $distance = $_GET["distance"];
    }
    if($_REQUEST["hereIsSelected"]=="false")
    {
    $address = urlencode($_GET["location"]);
    $url ="https://maps.googleapis.com/maps/api/geocode/json?"."address=".$address."&key=AIzaSyBOuC1ADFFx_oSm3QYpKfbg8T0Rkp2yg9c";                 
    $Location= file_get_contents($url);
    $obj = json_decode($Location);
    echo $Location;
    exit;
    }
    if($value!="here")
    {
    $address = urlencode($_GET["location"]);
    $url ="https://maps.googleapis.com/maps/api/geocode/json?"."address=".$address."&key=AIzaSyBOuC1ADFFx_oSm3QYpKfbg8T0Rkp2yg9c";                 
    $Location= file_get_contents($url);
    $obj = json_decode($Location);
    $lat=$obj->results[0]->geometry->location->lat;
    $lng=$obj->results[0]->geometry->location->lng;
    $hash=encode($lat,$lng);
    $radius = $distance;
    $option_segment_id = $_GET["selectOptions"];
    $keyword = urlencode($_GET["keyword"]);
    $url_ticket1="https://app.ticketmaster.com/discovery/v2/events.json?apikey=YHrOPA88gew8bEwvRxyNUd97UiZhaAoJ"."&keyword=".$keyword."&segmentId=".$option_segment_id."&radius=".$radius."&unit=miles"."&geoPoint=".$hash;
    $Location_ticket= file_get_contents($url_ticket1);
    echo $Location_ticket;
    exit;  
    }

   if($value=="here")    
    {
    $hash=encode($_GET["ipApiLat"],$_GET["ipApiLon"]);
    $radius = $distance;
    $lat = $_GET["ipApiLat"];
    $lng = $_GET["ipApiLon"];
    $option_segment_id = $_GET["selectOptions"];
    $keyword = urlencode($_GET["keyword"]);
    $url_ticket1="https://app.ticketmaster.com/discovery/v2/events.json?apikey=YHrOPA88gew8bEwvRxyNUd97UiZhaAoJ"."&keyword=".$keyword."&segmentId=".$option_segment_id."&radius=".$radius."&unit=miles"."&geoPoint=".$hash;
    $Location_ticket= file_get_contents($url_ticket1);
    echo $Location_ticket;
    exit;
    }


}

if(isset($_GET["ID"]))
{  
    
    $ID = $_GET["ID"];
    
    $url_Event_Details="https://app.ticketmaster.com/discovery/v2/events/".$ID."?apikey=YHrOPA88gew8bEwvRxyNUd97UiZhaAoJ";
    $Event_Details= file_get_contents($url_Event_Details);
    echo $Event_Details;
    exit;
}
if(isset($_GET["VENUES"]))
{
    $venue = urlencode($_GET["VENUES"]);
    $url_venue_Details="https://app.ticketmaster.com/discovery/v2/venues"."?apikey=YHrOPA88gew8bEwvRxyNUd97UiZhaAoJ"."&keyword=".$venue;
    $Venue_Details= file_get_contents($url_venue_Details);
    echo $Venue_Details;
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
       <meta charset="utf-8"/>
    <title>Homework 4</title>
    
<style>
    div.form_class{
        border:1px solid black;
        background-color: #eeeeee;
        height: 250px;
        width: 650px;
        margin-left: 25%;
        margin-top:40px;
        position:relative;
    }
      div.form_class1{
        position:relative;
        text-align: center;
    }
    div.grid-container{
        display: grid;
        grid-template-columns: auto auto;
        background-color: white;
        padding: 10px;
    }
    div.grid-item{
        background-color: rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(0, 0, 0, 0);
        padding: 0px;
        font-size: 14px;
        text-align: left;
        margin-left: 350px;
    }
   .first p:hover{
    color: grey;    
    }
    a:hover{
    color: grey;    
    }
    .second{
        text-decoration:none;
        color:black;
    }
    .third{
        height: 40px;
    }
    lable:hover{
         color: grey;  
    }
    .third1{
        height:40px;
        width:90px;
        display:block;
    
    }
 .travelModes  div:hover{
        background-color:#A0A0A0;
    }
</style>
</head>
<body>
<div class = "form_class" id="mainform">
    <div class="form_class1"><h2><i>Events Search</i></h2></div>
     <hr style="margin: -15px 9px 0px 9px;">
    <form onsubmit="event.preventDefault();searchResult1();">
        <div style="margin:5px;">
                    Keyword: <input type="text" id="keyword" name="keyword"  value="<?php if(isset($_GET['keyword'])){echo $_GET['keyword'];}?>" required><br>
                    <div style="margin-top:5px;">
                    Category: <select id="selectOptions" name="selectOptions">
                                  <option value="" >default</option>
                                  <option value="KZFzniwnSyZfZ7v7nJ">Music</option>
                                  <option value="KZFzniwnSyZfZ7v7nE" >Sports</option>
                                  <option value="KZFzniwnSyZfZ7v7na">Arts&Theatre</option>
                                  <option value="KZFzniwnSyZfZ7v7nn">Film</option>
                                  <option value="KZFzniwnSyZfZ7v7n1">Miscellaneous</option>
                              </select><br>
                    </div>
                    <div style="float:left;margin-top:5px;">
                     Distance(miles):<input type="text" id="distance" pattern="[0-9]+" name="distance" placeholder="10" value="<?php if(isset($_GET['distance'])){echo $_GET['distance'];}?>">
                    </div>
                    <div style="float:left;margin-top:5px;margin-left:5px;">
                     from:<input class="w3-radio" type="radio" id="here" name="location" value="here" checked onchange="setLocation(this);">
                          <label>Here</label><br>
                          <input style="margin-left:41px;" class="w3-radio" id="radio1" type="radio" name="location" value="location" onchange="setLocation(this);">
                          <input type="text" id="location" name="location" placeholder="location" value="<?php if(isset($_GET['location'])){echo $_GET['location'];}?>" disabled>
                    </div>
                    <input id ="ipLat" style="display:none;" name="ipApiLat">
                    <input id ="ipLon" style="display:none;" name="ipApiLon">
                    <div style="margin-top:75px;margin-left:60px;">
                        <input type="submit" id="searchButton" style="float:left;" value="Search" name="search">
                        <input type="button" style="float:left;margin-left:5px;" value="Clear" onclick="callReset();">
                    </div>
               </div>
        
    </form> 
</div>
    <div id="result"></div>
    <div style="position:relative"id="result"></div>
    <div style="position:relative"id="result_event"></div>
    <script type="text/javascript">
        var latitude1;
        var longitude1;
        var GlobalDelete="";
        function searchResult1(){
            var ipApiLat= document.getElementById("ipLat").value;
            var hereIsSelected = document.getElementById("here").checked;
            var ipApiLon = document.getElementById("ipLon").value;

            if(hereIsSelected)
            {
                    latitude1 = parseFloat(ipApiLat);
                    longitude1 = parseFloat(ipApiLon);
            }    
            else   
            {
            
            var distance=document.getElementById("distance").value;
            var location = document.getElementById("location").value;
            if(location=="")
                {
                    location="here";
                }
            else
               {
                    location=location.replace(/ /g ,'+')
               }
            var selectOptions = document.getElementById("selectOptions").value;
            var keyword = document.getElementById("keyword").value;
            hereIsSelected = document.getElementById("here").checked; 
            var xhttpRequest = new XMLHttpRequest();
            var maparams = "search=test&selectOptions="+selectOptions+"&keyword="+keyword+"&ipApiLat="+ipApiLat+"&ipApiLon="+ipApiLon+"&distance="+distance+"&location="+location+"&hereIsSelected="+hereIsSelected;
            xhttpRequest.onreadystatechange = function() {
                if (xhttpRequest.readyState == 4 && xhttpRequest.status == 200) {
                     var data = JSON.parse(xhttpRequest.responseText);
                      latitude1 = data.results[0].geometry.location.lat;
                      longitude1=data.results[0].geometry.location.lng;
                 }
            };
          
              xhttpRequest.open("GET", "index.php?"+maparams, true);
              xhttpRequest.setRequestHeader("Content-type", "application/x-www-from-urlencoded");
              xhttpRequest.send(); 
                
        }
            searchResult12();
        }
        
        function searchResult12(){
            var ipApiLat= document.getElementById("ipLat").value;
            var ipApiLon = document.getElementById("ipLon").value;
            var distance = document.getElementById("distance").value;
            var location = document.getElementById("location").value;
            if(location=="")
                {
                    location="here";
                }
            else
               {
            location=location.replace(/ /g ,'+')
               }
            var selectOptions = document.getElementById("selectOptions").value;
            var keyword = document.getElementById("keyword").value;
            document.getElementById("ipLon").value 
            var xhttpRequest = new XMLHttpRequest();
            var maparams = "search=test&selectOptions="+selectOptions+"&keyword="+keyword+"&ipApiLat="+ipApiLat+"&ipApiLon="+ipApiLon+"&distance="+distance+"&location="+location;
            xhttpRequest.onreadystatechange = function() {
                if (xhttpRequest.readyState == 4 && xhttpRequest.status == 200) {
                
                     var data = JSON.parse(xhttpRequest.responseText)
                     
                     HTMLTablePage1(data);
            
                    
                 }
            };
          
              xhttpRequest.open("GET", "index.php?"+maparams, true);
              xhttpRequest.setRequestHeader("Content-type", "application/x-www-from-urlencoded");
              xhttpRequest.send(); 
        }
        
        
         function setLocation1(e)
        {
            if(e.defaultValue== "location"){
                document.getElementById("radio1").checked = true;

            }else if(e.defaultValue == "here"){
                document.getElementById("here").checked = true;
            }
        }
        
        function HTMLTablePage1(JSONDOC)
        {
        var j=0;
        var name;
        var widthimg = "70px";
        var heightimg ="70px";
        var ID;
        var HTMLtable = "<table border='2' style='border-collapse:collapse;width:70%;margin: 20px 0px 0px 60px;margin-left:15%'><tr><th><b>Date</b></th><th><b>Icon</b></th><th><b>Event</b></th><th><b>Genre</b></th><th><b>Venue</b></th></tr>";
        if(JSONDOC._embedded!=undefined && JSONDOC!=undefined ){
            var No_Of_Events = JSONDOC._embedded.events.length;
            var No_Of_Events1 = JSONDOC._embedded.events[0].name;
            for(j = 0 ; j < No_Of_Events ; j++)
             {
               var ID = JSONDOC._embedded.events[j].id;
               if(JSONDOC._embedded.events[j].dates.start!=undefined)
               { 
                var localDate =  JSONDOC._embedded.events[j].dates.start.localDate;
                var localTime =  JSONDOC._embedded.events[j].dates.start.localTime;
               }
               else{
                   var localDate = undefined
                   var localTime = undefined
              }
               HTMLtable +="<tr>"
               if((localDate!=undefined || localDate !="")&&(localTime==undefined || localTime==""))
                   {
                        localTime="";    
                        HTMLtable += "<td>"+"<div"+" style=text-align:center>"+"<p>"+localDate+"</p>"+"<p>"+localTime+"</p>"+"</div>"+"</td>";
                   }
               else if((localTime!=undefined || localTime !="") && (localDate==undefined || localDate==""))
                   {
                        localDate ="";    
                        HTMLtable += "<td>"+"<div"+" style=text-align:center>"+"<p>"+localDate+"</p>"+"<p>"+localTime+"</p>"+"</div>"+"</td>";
                   }
               else if(localTime!=undefined && localDate !=undefined)
                    {
                        HTMLtable += "<td>"+"<div"+" style=text-align:center>"+"<p>"+localDate+"</p>"+"<p>"+localTime+"</p>"+"</div>"+"</td>";
                    }
               var imageurl = JSONDOC._embedded.events[j].images[0].url;
               if(imageurl !=undefined || imageurl !="")
                    HTMLtable += "<td>"+"<img src='" + imageurl + "' width='" + widthimg + "' height='" + heightimg + "'></td>"
               else
                   {
                    HTMLtable += "<td>"+imageurl+"</td>"
                   }
               var  Events = "NA"
               var ID  = "NA" 
               var venue1="NA"
               if(JSONDOC._embedded.events[j]._embedded.venues!=undefined && JSONDOC._embedded.events[j]._embedded!=undefined)
                {
                venue1 = JSONDOC._embedded.events[j]._embedded.venues[0].name;
                venue1=venue1.replace(/ /g ,'+')
                
                }
                    
               if(JSONDOC._embedded.events[j].name !=undefined || JSONDOC._embedded.events[j].name !="")
                   {
                       Events = JSONDOC._embedded.events[j].name;
                       ID  =    JSONDOC._embedded.events[j].id;
                       HTMLtable += "<td class='first' id="+ID+" "+"venue="+venue1+" "+"onclick='eventsTable(this)' style='text-decoration:none;color:black'>"+"<p><b>"+Events+"</b></p></td>";
                        GlobalDelete = GlobalDelete+" "+ID;
                       
                   }
               else{
                       HTMLtable += "<td>"+"NA"+"</td><tr>"
                   }
               if(JSONDOC._embedded.events[j].classifications!=undefined)
                {
                    var Genre = JSONDOC._embedded.events[j].classifications[0].segment.name;
                    HTMLtable += "<td>"+Genre+"</td>"
                }
               else
                {
                       HTMLtable += "<td>"+"NA"+"</td>"
                }
                if(JSONDOC._embedded.events[j]._embedded!=undefined)
                    {
                        var lat12= JSONDOC._embedded.events[j]._embedded.venues[0].location.latitude;
                        
                        var lon12 = JSONDOC._embedded.events[j]._embedded.venues[0].location.longitude;
                        
                
    
                        var venue = JSONDOC._embedded.events[j]._embedded.venues[0].name;
   
                        

                       HTMLtable += "<td  style='position:relative;padding-left:10px;' onclick='googleMaps1(this)' id='tdParent"+ID+"'>"+"<div style='width:100%;height:100%;' id='LatitudeLongitude"+ID+"'"+" lat="+lat12+" lon="+lon12+">"+venue+"</div></td></tr>";
                      
                        
                    }
                
                else
                {
                    
                       HTMLtable += "<td>"+"NA"+"</td></tr>"
                }
                
                   
                
            }
           
         HTMLtable+="</table>"  

         document.getElementById("result").innerHTML =HTMLtable; 
        }
            else{
                document.getElementById("result").innerHTML = "<table border='2' style='text-align:center;border-collapse:collapse;width:100%;margin-top:10px;'><tr><td>"+"NO Records Found"+"</td></tr></table>";
            }
        }
            
        
        
        
      function googleMaps1(mapParentElement)
        {
           
            var mapId = mapParentElement.firstChild.id; //div
            
            var deslng = document.getElementById(mapId).getAttribute("lon");
            var deslat = document.getElementById(mapId).getAttribute("lat");
            var mapParentEle = mapParentElement.id; //td
            var top = mapParentElement.getBoundingClientRect().top + window.pageYOffset + 60; //div top
            var left = mapParentElement.getBoundingClientRect().left + window.pageXOffset + 20;  //div left
            document.getElementById(mapId).style.left = left+"px";
            document.getElementById(mapId).style.top = top+"px";
            
            if(document.getElementById("child"+mapId)){
                if(document.getElementById("child"+mapId).style.display == "block"){
                    document.getElementById("child"+mapId).style.display = "none";
                    document.getElementById("travelModes"+mapId).style.display = "none";
                }else if(document.getElementById("child"+mapId).style.display == "none"){
                    document.getElementById("child"+mapId).style.display = "block";
                    document.getElementById("travelModes"+mapId).style.display = "block";
                }
            
            }        
            else if(!document.getElementById("child"+mapId)) {
                var modeOptions = document.createElement('div');
                var mtop = mapParentElement.getBoundingClientRect().top + window.pageYOffset + 55;
                var mleft = mapParentElement.getBoundingClientRect().left + window.pageXOffset + 10;
                modeOptions.style.left = mleft+"px";
                modeOptions.style.top = mtop+"px";
                modeOptions.innerHTML = "<div id='travelModes"+mapId+"' class='travelModes' style='position:absolute;width:95px;height:100px;z-index:10;background-color:#e9e7e9;'><div class='third1' deslat='"+deslat+"' deslng='"+deslng+"' mapid='"+mapId+"' onclick='directionWithTravelMode123(this)'>Walk there</div><div onclick='directionWithTravelMode123(this)' class='third1' deslat='"+deslat+"' deslng='"+deslng+"' mapid='"+mapId+"'>Bike there</div><div onclick='directionWithTravelMode123(this)' class='third1' deslat='"+deslat+"' deslng='"+deslng+"' mapid='"+mapId+"'>Drive there</div></div>";
                document.body.appendChild(modeOptions);
                document.getElementById(modeOptions.firstChild.id).style.left = mleft+"px";
                document.getElementById(modeOptions.firstChild.id).style.top = mtop+"px";
                var newcontent = document.createElement('div');
                newcontent.innerHTML = "<div name='placesMaps' id='child"+mapId+"' style='display:none;position:absolute;z-index: 5;background-color: #fff;padding: 5px;border: 1px solid #999; height:300px;width:300px; '></div><div test='visible' style='position: absolute;top: 5px;left:5px;width:40px;height:40px;border:1px solid black;z-index:5px;'></div>";
                document.getElementById(mapId).appendChild(newcontent.firstChild); // or change to div
                document.getElementById("child"+mapId).style.display = "block";
                document.getElementById("travelModes"+mapId).style.display = "block";
            
        }
            var directionsDisplay = new google.maps.DirectionsRenderer;
            var directionsService = new google.maps.DirectionsService;
            var map = new google.maps.Map(document.getElementById("child"+mapId), {
                zoom: 14,
                center: {lat: parseFloat(deslat), lng: parseFloat(deslng)}
            });
            
            var marker = new google.maps.Marker({
                    position: {lat: parseFloat(deslat), lng: parseFloat(deslng)},
                    map: map,
                    title: ''
            });
            directionsDisplay.setMap(map);
        }
        
      function  eventsTable(data)
        {
           var ID = data.id;  
           var i=0;
           var xhttpRequest = new XMLHttpRequest(); 
           var maparams = "search=test&ID="+ID; 
            var GlobalDelete2 = GlobalDelete.split(" ");
           
           for(i=1;i<GlobalDelete2.length;i++)
           {

            if (document.getElementById("travelModesLatitudeLongitude" + GlobalDelete2[i]) !== null)
                {
                   if(document.getElementById("travelModesLatitudeLongitude" + GlobalDelete2[i]).style.display !== "none")
                   {
                       document.getElementById("travelModesLatitudeLongitude" + GlobalDelete2[i]).style.display="none";

                   }
                }
           }
           xhttpRequest.onreadystatechange = function() {
                if (xhttpRequest.readyState == 4 && xhttpRequest.status == 200) {
                  
                    
                     var JSONDOC1 = JSON.parse(xhttpRequest.responseText);
           
                     EventsTable1(JSONDOC1);
                    
                 }
            };
              xhttpRequest.open("GET", "index.php?"+maparams, true);
              xhttpRequest.setRequestHeader("Content-type", "application/x-www-from-urlencoded");
              xhttpRequest.send(); 
        
        }
        function EventsTable1(JSONDOC1)
        {
        if(JSONDOC1._embedded!=undefined && JSONDOC1!=undefined)    
        {    
           var name = JSONDOC1.name;
           var HTMLevent1 = "<div style='margin-top:30px'><table style='text-align:left'>";
           if(JSONDOC1.dates.start!=undefined)
            {
                HTMLevent1+="<tr><td><b>"+"Date"+"</b></td></tr>"
                var Localdate = JSONDOC1.dates.start.localDate;
                var LocalTime = JSONDOC1.dates.start.localTime;
                 HTMLevent1+="<tr><td>"+Localdate+" "+LocalTime;
            }
        var artist="NA"
        if(JSONDOC1._embedded.attractions!=undefined)
            {
                artist = "<a  class='second' target='_blank' href="+JSONDOC1._embedded.attractions[0].url+">"+JSONDOC1._embedded.attractions[0].name+"</a>";
                if(JSONDOC1._embedded.attractions.length>1){
                for(j=1;j<JSONDOC1._embedded.attractions.length;j++){
                    artist+="|"+"<a  class='second' target='_blank' href="+JSONDOC1._embedded.attractions[j].url+">"+JSONDOC1._embedded.attractions[j].name+"</a>";
                }
                }
                HTMLevent1+="<tr><td><b>"+"Artist/Team"+"</b></td></tr>"
                HTMLevent1+="<tr><td>"+artist+"</tr></td>"
            }
            
        var venue = "NA"
        if(JSONDOC1._embedded.venues!=undefined)
            {
                venue = JSONDOC1._embedded.venues[0].name;
                 HTMLevent1+="<tr><td><b>"+"Venue"+"</b></td></tr>"
                HTMLevent1+="<tr><td>"+venue+"</tr></td>"
            }
       
        if(JSONDOC1.classifications!=undefined)
            {
               HTMLevent1+="<tr><td><b>"+"Genre"+"</b></td></tr>"
               var temp=""; 
               i=0
               if(JSONDOC1.classifications[0].subGenre!=undefined && JSONDOC1.classifications[0].subGenre.name!=undefined && JSONDOC1.classifications[0].subGenre.name!="Undefined" ){
                    var Subgenre =JSONDOC1.classifications[0].subGenre.name;
                    temp +=Subgenre+" "
               }
               else
                   var Subgenre = "NA"
                if(JSONDOC1.classifications[0].genre!=undefined && JSONDOC1.classifications[0].genre.name!=undefined && JSONDOC1.classifications[0].genre.name!="Undefined"){
                    var genre=JSONDOC1.classifications[0].genre.name;
                    temp+=genre
                }
                else
                    var genre = "NA"
                if(JSONDOC1.classifications[0].segment!=undefined && JSONDOC1.classifications[0].segment.name!=undefined && JSONDOC1.classifications[0].segment.name!="Undefined" ){
                    var segment=JSONDOC1.classifications[0].segment.name;
                    temp+=segment+" "
                }
                else
                    var segment = "NA"
                if(JSONDOC1.classifications[0].subType!=undefined && JSONDOC1.classifications[0].subType.name!=undefined && JSONDOC1.classifications[0].subType.name!="Undefined"){
                  var subtype=JSONDOC1.classifications[0].subType.name;
                  temp+=subtype+" "
                }
                else
                  var subtype = "NA"
                if(JSONDOC1.classifications[0].type!=undefined && JSONDOC1.classifications[0].type.name!=undefined && JSONDOC1.classifications[0].type.name!="U ndefined"){
                    var type = JSONDOC1.classifications[0].type.name;
                    temp+=type+" "
                    
                }
                else
                    var type = "NA"
                temp=temp.replace(/ /g,"|"); 
                temp = temp.slice(0, -1)
                HTMLevent1+="<tr><td>";
                HTMLevent1+=temp;
                HTMLevent1+="</td><tr>";
            }
        if(JSONDOC1.priceRanges!=undefined)
            {
                HTMLevent1+="<tr><td><b>"+"Price Ranges"+"</b></td></tr>"
                var pricerangemax = "NA";
                var currency = JSONDOC1.priceRanges[0].currency;
                if(pricerangemax!=""||pricerangemax!=undefined)
                    {
                      var pricerangemax = JSONDOC1.priceRanges[0].max;
                      
                    }
                var pricerangemin = "NA";
                if(pricerangemin!=""||pricerangemin!=undefined)
                    {
                        pricerangemin = JSONDOC1.priceRanges[0].min;
                    }
                HTMLevent1+="<tr><td>"+pricerangemax+"-"+pricerangemin+" "+currency+"</td></tr>"
            }
        else{
            var pricerangemax = "NA"
            var pricerangemin = "NA"
        }

        if(JSONDOC1.dates!=undefined)
            {
                var status ="NA"
                HTMLevent1+="<tr><td><b>"+"Ticket Status"+"</b></td></tr>"
                if(status != ""||status!=undefined)
                    {
                        status = JSONDOC1.dates.status.code;
                        HTMLevent1+="<tr><td>"+status+"</td></tr>"
                    }
            }
        if(JSONDOC1.url!=undefined||JSONDOC1.url=="")
            {
        var url = "<a class='second' target='_blank'  href="+JSONDOC1.url+">"+"Ticketmaster"+"</a>"
        HTMLevent1+="<tr><td><b>"+"Buy Tickets At"+"</b></tr></td>"
        HTMLevent1+="<tr><td>"+url+"</td></tr>"
        }
            HTMLevent1+="</table></div>"
      var widthimg = "500px";
      var heightimg = "350px";
      var seatURL = "NA"
      if(JSONDOC1.seatmap!=undefined)
          {
              seatURL = JSONDOC1.seatmap.staticUrl;
          }
         
        if(seatURL!="NA")
        {
        HTMLEVENT = "<div style=text-align:center>"+"<h3>"+name+"</h3>"+"</div>";
        HTMLEVENT +="<div class='grid-container'>"
        HTMLEVENT +="<div class='grid-item'>"+HTMLevent1+"</div>"
        HTMLEVENT +="<div class='grid-item' style=margin-left:-50px>"+"<img src='" + seatURL + "' width='" + widthimg + "' height='" + heightimg + "'>"+"</div>"
        }
        else{
            
            HTMLEVENT = "<div style=margin-left:95px;text-align:center>"+"<h3>"+name+"</h3>"+"</div>";
            HTMLEVENT +="<div class='grid-container'>";
            HTMLEVENT +="<div class='grid-item' style='margin-left: 87%'>"+HTMLevent1+"</div>";
            
        }
        }
        else{
                 HTMLEVENT +="<table><tr><td>"+"NO Records Found"+"</table></td></tr>"
            }
        HTMLEVENT +="</div>";
        HTMLEVENT +="<div id ='Image1'"+" "+"venue1='"+venue+"' "+"style=margin-left:45%>"+"<figure>"+"<figcaption style='opacity:0.5;margin-left:-50px'>"+"Click show venue info"+"</figcaption>"+"<img id='toupArrow'  src='http://csci571.com/hw/hw6/images/arrow_down.png' style='width:42px;height:30px;opacity:0.5' onclick=htmlvenueTable(this)>"+"</figure>"+"</div>"
        HTMLEVENT +="<div id ='Image2'"+" "+"venue1='"+venue+"' "+"style=margin-left:45%>"+"<figure>"+"<figcaption style='opacity:0.5;margin-left:-50px'>"+"Click to show venue photos"+"</figcaption>"+"<img id='toupArrow1' src='http://csci571.com/hw/hw6/images/arrow_down.png' style='width:42px;height:30px;opacity:0.5' onclick=htmlvenuephotos(this)>"+"</figure>"+"</div>"
        document.getElementById("result_event").innerHTML =HTMLEVENT;
        document.getElementById("result").innerHTML = "";
        }
        
        
        
         function directionWithTravelMode123(element){
            var mapdeslat = element.getAttribute("deslat");
            var mapdeslng = element.getAttribute("deslng");
            var mapdesid  = element.getAttribute("mapid");
            var mapsid = "child"+mapdesid;
            var directionsDisplay = new google.maps.DirectionsRenderer;
            var directionsService = new google.maps.DirectionsService;
            var map = new google.maps.Map(document.getElementById(mapsid), {
                zoom: 14,
                center: {lat: parseFloat(mapdeslat), lng: parseFloat(mapdeslng)}
            });
            var selectedMode;
            directionsDisplay.setMap(map);
                if(element.innerText == "Walk there"){
                    selectedMode= "WALKING";
                }else if (element.innerText == "Bike there"){
                              selectedMode="BICYCLING";
                          }else if(element.innerText == "Drive there"){
                                selectedMode= "DRIVING";
                          }
            googlecalculateRoute(directionsService,directionsDisplay,selectedMode,mapdeslat,mapdeslng);
            
        }
        
        function directionWithTravelMode1234(element){
            var mapdeslat1 = element.getAttribute("VenueLat");
            var mapdeslng1 = element.getAttribute("VenueLong");
            var directionsDisplay1 = new google.maps.DirectionsRenderer;
            var directionsService1 = new google.maps.DirectionsService;
            var map = new google.maps.Map(document.getElementById("child"), {
                zoom: 14,
                center: {lat: parseFloat(mapdeslat1), lng: parseFloat(mapdeslng1)}
            });
            var selectedMode;
             directionsDisplay1.setMap(map);
                if(element.innerText == "Walk there"){
                    selectedMode= "WALKING";
                }else if (element.innerText == "Bike there"){
                              selectedMode="BICYCLING";
                          }else if(element.innerText == "Drive there"){
                                selectedMode= "DRIVING";
                          }
           googlecalculateRoute(directionsService1,directionsDisplay1,selectedMode,mapdeslat1,mapdeslng1);
            
        }
        
        function googlecalculateRoute(directionsService, directionsDisplay,selectedMode,mapdeslat,mapdeslng) {
          
            directionsService.route({
              origin: {lat:latitude1 ,lng:longitude1 },  
              destination: {lat: parseFloat(mapdeslat), lng: parseFloat(mapdeslng)}, 
              travelMode: google.maps.TravelMode[selectedMode]
            }, function(response, status) {
              if (status=='OK') {
                directionsDisplay.setDirections(response);
              } else {
                window.alert('Directions request fail'+status);
              }
            });
      }
        
        function htmlvenuephotos()
        {
        var venue = document.getElementById("Image1").getAttribute("venue1"); 
        venue1=venue.replace(/ /g ,'+')
           var xhttpRequest = new XMLHttpRequest(); 
           var maparams = "search=test&VENUES="+venue1;
           xhttpRequest.onreadystatechange = function() {
                if (xhttpRequest.readyState == 4 && xhttpRequest.status == 200) {
                  
                     var JSONDOC3 = JSON.parse(xhttpRequest.responseText);
                     htmlvenuephotos1(JSONDOC3)
                    
                 }
            };
              xhttpRequest.open("GET", "index.php?"+maparams, true);
              xhttpRequest.setRequestHeader("Content-type", "application/x-www-from-urlencoded");
              xhttpRequest.send(); 
        
        }
       
        function htmlvenueTable()
        {
             
        var venue = document.getElementById("Image1").getAttribute("venue1"); 
        venue1=venue.replace(/ /g ,'+')
        
           var xhttpRequest = new XMLHttpRequest(); 
           var maparams = "search=test&VENUES="+venue1;
    
           xhttpRequest.onreadystatechange = function() {
                if (xhttpRequest.readyState == 4 && xhttpRequest.status == 200) {
                     var JSONDOC3 = JSON.parse(xhttpRequest.responseText);
                     htmlvenueTable1(JSONDOC3)
                    
                 }
            };
              xhttpRequest.open("GET", "index.php?"+maparams, true);
              xhttpRequest.setRequestHeader("Content-type", "application/x-www-from-urlencoded");
              xhttpRequest.send(); 
        
            
        }
        
        
        function htmlvenueTable1(JSONDOC3)
        {
        var image1 = document.getElementById("toupArrow").getAttribute("src");
          
          if(JSONDOC3!=undefined && JSONDOC3._embedded!=undefined)
           {
           
            if(image1=="http://csci571.com/hw/hw6/images/arrow_down.png")
                {
                     HTMLVenue = "<div>"+"<figure>"+"<figcaption style='opacity:0.5;margin-left:-50px'>"+"Click here to hide venue info"+"</figcaption>"+"<img id='toupArrow' src='http://csci571.com/hw/hw6/images/arrow_up.png' style='width:42px;height:30px;opacity:0.5' onclick=htmlvenueTable(this)>"+"</figure>"+"</div>";
                     HTMLVenue += "<div id='temp1'><table border='1' style='border-collapse:collapse;width:110%;margin-left:-300px'>"+"<tr>";
                     name = JSONDOC3._embedded.venues[0].name;
                     HTMLVenue += "<td style='text-align:right;width:20%'><b>"+"Name"+"</b></td>";
                     HTMLVenue += "<td style='text-align:center'>"+name+"</td></tr>";
                     if(JSONDOC3._embedded.venues[0].location!=undefined)
                     {
                       var VenueLong= JSONDOC3._embedded.venues[0].location.longitude;
                       var VenueLat = JSONDOC3._embedded.venues[0].location.latitude;
                     }
                     HTMLVenue += "<tr style='height:300px'><td style='text-align:right'><b>"+"Map"+"</b></td>"; 
                    
                     var map2= "<div id='travelModes"+"' style='position:relative;top:10px;left:10px;width:80px;height:100px;z-index:10;background-color:#e9e7e9;'><div class='third' VenueLat='"+VenueLat+"' VenueLong='"+VenueLong+"'  onclick='directionWithTravelMode1234(this)'><lable>Walk there</lable></div><div onclick='directionWithTravelMode1234(this)' class='third' VenueLat='"+VenueLat+"' VenueLong='"+VenueLong+"'><lable>Bike there</lable></div><div onclick='directionWithTravelMode1234(this)' class='third' VenueLat='"+VenueLat+"' VenueLong='"+VenueLong+"' ><lable>Drive there</lable></div>"+"<div name='placesMaps1' id='child' style='display:block;position:relative;top:-226px;left:129%;z-index:5;background-color: #fff;padding: 5px;border: 1px solid #999; height:280px;width:300px;'></div></div>";
                     HTMLVenue += "<td style='text-align:center;'>"+map2+"</td></tr>";
                    var address ="NA"
                    if(JSONDOC3._embedded.venues[0].address!=undefined)
                        {
                            var address = JSONDOC3._embedded.venues[0].address.line1;
                        }
                    HTMLVenue += "<tr><td style='text-align:right'><b>"+"Address"+"</b></td>";  
                    HTMLVenue += "<td style='text-align:center'>"+address+"</td></tr>";
                    var city = "NA"
                    var state = "NA"
                    if(JSONDOC3._embedded.venues[0].city!=undefined)
                        {
                            city = JSONDOC3._embedded.venues[0].city.name;
                        }
                    if(JSONDOC3._embedded.venues[0].city!=undefined)
                        {
                            state = JSONDOC3._embedded.venues[0].state.stateCode;
                        }
                    HTMLVenue += "<tr><td style='text-align:right'><b>"+"City"+"</b></td>";  
                    HTMLVenue += "<td style='text-align:center'>"+city+","+state+"</td></tr>";
                    var Postalcode = "NA";
                    if(JSONDOC3._embedded.venues[0].postalCode!=undefined)
                        {
                            Postalcode = JSONDOC3._embedded.venues[0].postalCode;
                        }
                    HTMLVenue += "<tr><td style='text-align:right'><b>"+"Postal Code"+"</b></td>";  
                    HTMLVenue += "<td style='text-align:center'>"+Postalcode+"</td></tr>";
                    var UpcominEvents="NA"
                    if(JSONDOC3._embedded.venues[0].url!=undefined)
                        {
                            UpcominEvents = JSONDOC3._embedded.venues[0].url;
                        }
                    HTMLVenue += "<tr><td style='text-align:right'><b>"+"Upcoming Events"+"</b></td>";  
                    HTMLVenue += "<td style='text-align:center'><a class='second' target='_blank' href='"+UpcominEvents+"'>"+name+"</a>"+"</td></tr></table></div></div>";
                    document.getElementById("Image1").innerHTML = HTMLVenue;
                     var directionsDisplay = new google.maps.DirectionsRenderer;
                     var directionsService = new google.maps.DirectionsService;
                     var map = new google.maps.Map(document.getElementById("child"), {
                                zoom: 14,
                              center: {lat: parseFloat(VenueLat), lng: parseFloat(VenueLong)}
                    });
            
                     var marker = new google.maps.Marker({
                    position: {lat: parseFloat(VenueLat), lng: parseFloat(VenueLong)},
                    map: map,
                    title: ''
                    });
                  directionsDisplay.setMap(map);
                if(document.getElementById("temp2"))
                  document.getElementById("temp2").style.display = "none";
                  document.getElementById("Image2").innerHTML ="<div>"+"<figure>"+"<figcaption style='opacity:0.5;margin-left:-50px'>"+"Click to show photos"+"</figcaption>"+"<img id='toupArrow1' src='http://csci571.com/hw/hw6/images/arrow_down.png' style='width:42px;height:30px;opacity:0.5' onclick=htmlvenuephotos(this)>"+"</figure>"+"</div>"
                  
                }

            else
                document.getElementById("Image1").innerHTML ="<div>"+"<figure>"+"<figcaption style='opacity:0.5;margin-left:-50px'>"+"Click here to show venue info"+"</figcaption>"+"<img id='toupArrow' src='http://csci571.com/hw/hw6/images/arrow_down.png' style='width:42px;height:30px;opacity:0.5' onclick=htmlvenueTable(this)>"+"</figure>"+"</div>"
           }
           else
              {
                if(image1=="http://csci571.com/hw/hw6/images/arrow_down.png")
                {
                   HTMLVenue = "<div>"+"<figure>"+"<figcaption style='opacity:0.5';margin-left:-50px>"+"Click here to hide venue info"+"</figcaption>"+"<img id='toupArrow' src='http://csci571.com/hw/hw6/images/arrow_up.png' style='width:42px;height:30px;opacity:0.5' onclick=htmlvenueTable(this)>"+"</figure>"+"</div>";
                   HTMLVenue += "<table border='1' style='border-collapse:collapse;width:70%;margin-left:-220px'>"+"<tr><p><b>"+"No Venue Info Found"+"</b></p></tr></table>"
                   document.getElementById("Image1").innerHTML = HTMLVenue;
                }
                else
                document.getElementById("Image1").innerHTML ="<div>"+"<figure>"+"<figcaption style='opacity:0.5;margin-left:-50px'>"+"Click here to show venue info"+"</figcaption>"+"<img id='toupArrow' src='http://csci571.com/hw/hw6/images/arrow_down.png' style='width:42px;height:30px;opacity:0.5' onclick=htmlvenueTable(this)>"+"</figure>"+"</div>"
               }
        }
        
        function htmlvenuephotos1(JSONDOC3)
        {
         
         var image2 = document.getElementById("toupArrow1").getAttribute("src");
         if(JSONDOC3!=undefined &&  JSONDOC3._embedded.venues[0] != undefined && JSONDOC3._embedded != undefined && JSONDOC3._embedded.venues[0].images != undefined)
          {
            var imagelen =5;
            var i=0;
            if(image2=="http://csci571.com/hw/hw6/images/arrow_down.png")
                {
                     HTMLVenue = "<div>"+"<figure>"+"<figcaption style='opacity:0.5;margin-left:-50px'>"+"Click to hide venue photos"+"</figcaption>"+"<img id='toupArrow1' src='http://csci571.com/hw/hw6/images/arrow_up.png' style='width:42px;height:30px;opacity:0.5' onclick=htmlvenuephotos(this)>"+"</figure>"+"</div>";
                     HTMLVenue += "<div id='temp2'><table style='border-collapse:collapse;margin-left:-220px'>";
                     var venueImage = "NA"
                     var imageheight="300px"
                     var imagewidth="500px"
                     var imageLength = JSONDOC3._embedded.venues[0].images.length
                     
                     if(imageLength == 0)
                         {
                         HTMLVenue += "<table border='1' style='border-collapse:collapse;width:70%;margin-left:-220px'>"+"<tr><p><b>"+"No Venue Photo Found"+"</b></p></tr></table>";
                             return;
                         }
                     if(imageLength > 5)
                     var ImageDisplay = 5
                         
                     else if(imageLength < 5)
                         ImageDisplay = imageLength ;
                     if(JSONDOC3._embedded.venues[0].images!=undefined)
                     {
                      for(i=0;i<ImageDisplay;i++)
                         {
                             HTMLVenue+="<tr>"
                             venueImage = JSONDOC3._embedded.venues[0].images[i].url
                             HTMLVenue += "<td>"+"<img style='margin-left:8%' src='" + venueImage +"' height='" + imageheight +"'width='"+imagewidth+"'>"+"</td></tr>"
                
                         }
                     }
                     HTMLVenue+="</table></div></div>";
                     document.getElementById("Image2").innerHTML = HTMLVenue;
                    if(document.getElementById("temp1"))
                        document.getElementById("temp1").style.display = "none";
                    document.getElementById("Image1").innerHTML ="<div>"+"<figure>"+"<figcaption style='opacity:0.5;margin-left:-50px'>"+"Click to show venue info"+"</figcaption>"+"<img id='toupArrow' src='http://csci571.com/hw/hw6/images/arrow_down.png' style='width:42px;height:30px;opacity:0.5' onclick=htmlvenueTable(this)>"+"</figure>"+"</div>"
                }
            
            else
                document.getElementById("Image2").innerHTML ="<div>"+"<figure>"+"<figcaption style='opacity:0.5;margin-left:-50px'>"+"Click to show photos"+"</figcaption>"+"<img id='toupArrow1' src='http://csci571.com/hw/hw6/images/arrow_down.png' style='width:42px;height:30px;opacity:0.5' onclick=htmlvenuephotos(this)>"+"</figure>"+"</div>"
          }
         else
          {
                if(image2=="http://csci571.com/hw/hw6/images/arrow_down.png")
                {
                   HTMLVenue = "<div>"+"<figure>"+"<figcaption style='opacity:0.5;margin-left:-50px'>"+"Click here to hide venue info"+"</figcaption>"+"<img id='toupArrow1' src='http://csci571.com/hw/hw6/images/arrow_up.png' style='width:42px;height:30px;opacity:0.5' onclick=htmlvenuephotos(this)>"+"</figure>"+"</div>";
                   HTMLVenue += "<table border='1' style='border-collapse:collapse;width:70%;margin-left:-220px'>"+"<tr><p><b>"+"No Venue Photo Found"+"</b></p></tr></table>"
                
                }
                else
                document.getElementById("Image2").innerHTML ="<div>"+"<figure>"+"<figcaption style='opacity:0.5;margin-left:-50px'>"+"Click here to show venue info"+"</figcaption>"+"<img id='toupArrow1' src='http://csci571.com/hw/hw6/images/arrow_down.png' style='width:42px;height:30px;opacity:0.5' onclick=htmlvenuephotos(this)>"+"</figure>"+"</div>"
          }
                 
                 
    }
            

    function myDisplay(data){
            
            if(data.lat && data.lon){
                document.getElementById("ipLat").value = data.lat;
                document.getElementById("ipLon").value = data.lon;
                document.getElementById("searchButton").disabled = false;
            }else{
                document.getElementById("searchButton").disabled = true;
            }
        }
    function callReset()
        {
            document.getElementById("distance").value ='';
            document.getElementById("location").value = '';
            document.getElementById("selectOptions").selectedIndex = 0;
            document.getElementById("keyword").value = '';
            document.getElementById("result").innerHTML = '';
            document.getElementById("result_event").innerHTML = '';
            document.getElementById("location").required = false;
            document.getElementById("location").disabled = true;
            document.getElementById("here").checked = true;    
            var GlobalDelete3 = GlobalDelete.split(" ");
            
            for(i=1;i<GlobalDelete3.length;i++)
           {

            if (document.getElementById("travelModesLatitudeLongitude" + GlobalDelete3[i]) !== null)
                {
                   if(document.getElementById("travelModesLatitudeLongitude" + GlobalDelete3[i]).style.display !== "none")
                   {
                       document.getElementById("travelModesLatitudeLongitude" + GlobalDelete3[i]).style.display="none";

                   }
                }
         }
        }
    function setLocation(e)
        {
            if(e.defaultValue== "location"){
                document.getElementById("location").disabled = false;
                document.getElementById("location").required = true;
            }else if(e.defaultValue == "here"){
                document.getElementById("location").value = "";
                document.getElementById("location").disabled = true;
                document.getElementById("location").required = false;
            }
        }
 </script>

    <script type="text/javascript" src="http://ip-api.com/json?callback=myDisplay">
    </script>


<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBOuC1ADFFx_oSm3QYpKfbg8T0Rkp2yg9c"></script>

 
</body>
</html>