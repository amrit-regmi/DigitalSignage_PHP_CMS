
<div class="row"  style="border:1px solid green">
  
    <div class="col-md-9"  style="border:1px solid red">
        <div id="slideshow">
     <?php foreach($data->getData() as $ads){
         echo'<div>
     <img src="'.Yii::app()->getBaseUrl().$ads->Source.'"/> 
   </div>';
                }
                ?>
</div>
        
        
    </div>
  <div class="col-md-3"  style="border:1px solid red">  
    <div id="w_background">
        
    </div>
    
    <div id="weather"> 
        <div class="row" style="padding: 0px; margin:0px;"><p id="clock" ></p></div>
    <div class="row" style="font-size:20px; font-weight: bold; text-align: center; padding: 0px; margin:0px;">KATHMANDU</div>
    <div class ="row" id="dicon" ><img id="icon" src= "<?php //echo Yii::app()->getBaseUrl().'/weathericon/'.$basicinfiWeather['icon'].'.png'?>"/></div>
    <div id="temprature">
        <p id="tem" style="font-size: 12.0vmin;"></p>  
    
    </div>
    <div id="ddescription"><p id="description" style="font-size:4vmin; line-height:4vmin;"></p></div>
    <div id= "more" style="margin-top:15px;text-align: center; font-size: 20px; ">
        <p id="humidity" style="margin-top:15px;"></p>
        <p id="clouds" style="margin-top:15px;"></P>
        <p id="wind" style="margin-top:15px;"></P>
    </div><div id="power_by"><p id="powered_by">Powered by:</p>
    <img id="powered_by_img" src= "<?php echo Yii::app()->getBaseUrl().'/weathericon/ntc1.png'?>"></div>
</div></div>
</div>  
<div class="row" style="border:1px solid black">
    <div class="row" style="border:1px solid red">.col-md-10</div>
</div>




</p>
<style>
     @media only screen and (max-width: 320px) {

   body { font-size: 2em; }

}
h1 {
  font-size: 5.9vw;
}
h2 {
  font-size: 3.0vh;
}
p {
  font-size: 3.0vmin;
 
}

#news{
  //background:hsla(210,100%,50%,0.2);
  height:99%;
  //width:99999px;
  overflow:hidden;
  position:relative;
}
#news_scrool{
  font-size: 28px;
  padding-top:10px; line-height:100%;
  overflow:hidden;
  position:absolute;
  height:100%;
  //padding-bottom: 7vh;
  //width :auto;
  //white-space: nowrap;
  
}
#news_scrool p{
    font-weight: bold;
    font-size: 45px;
    padding: 15px;
}

 
    #main{
        top:0px;
        width:99%;
        height:99%;
        position:absolute;
    }
    #weather{
    color: rgb(19, 71, 82);
    background-color: transparent;
    ///background:url( ); 
  width:100%;
    height:100%;
    border-radius: 3%;
    box-shadow: -4px -4px 19px 0px rgba(50, 50, 50, 0.75);
    background-size: 100%;
    font-family: Verdana, Geneva, sans-serif;
        
    }
    
    #w_background{
    width:100%;
    position:absolute;
    height:100%;
    top:3px;
    right:0px;
    border-radius: 3%;
    box-shadow: -4px -4px 19px 0px rgba(50, 50, 50, 0.75);
    opacity:0.4;
        
    }
    
    #dicon{
        position: relative;
        width:auto;
        padding: 0px; margin:0px;
        
    }
    #dicon img{
        display: table-cell;
        vertical-align: middle;
        width:auto;
        height:50%;
    }
    #temprature{
        margin-top:20px;
        position: relative;
        font-size: 100px;
        line-height:100%;
        text-align: center;
        position: relative;
        overflow: hidden;
        
        
        
    }
    #ddescription{
         vertical-align:text-top;
        padding-right:25px;
       text-align: center;
       position:relative;
       font-size:35px; margin-top:5px; margin-bottom:20px;
       
     
    }
    #more{
        position: relative;
        text-align: center;
        //height:auto;
       
    }
    
 #slideshow {  
   margin:auto; 
   width:100%;
   position:relative;
   height:100%;
   top:0px;
   left:0px;
  // padding: auto; 
    box-shadow: 0 0 20px rgba(0,0,0,0.4); 
}

#slideshow > div { 
    background-color: whitesmoke;
    border-right:1px solid black;
     border-bottom:1px solid black;
    position:relative; 
    width:100%;
    height:100%;
   
    overflow:hidden;
   
}
#news_seperator{
    display: inline-block;
    height:75%;
    padding: 5px;
    overflow: hidden;
}
#news_seperator img{
    margin-top:1vh;
    height:95%;
}
img{
  // position: relative;
   margin:auto;
   height:100%;
   display: table-cell;
   vertical-align: middle;
}
#clock{
    font-size:50px;
    font-weight: bold;
    text-align: center;
    
}
#power_by{
    font-size:10px;
    width:255px;
    margin: auto;
}
#powered_by{
    padding: 0px;
margin: 0px;
line-height: 10px;
font-size: 10px;
}
#powered_by_img{
     display: table-cell;
        vertical-align: middle;
        height:20%;
        margin-top: 0px;
}
</style>
<script>
    $("#slideshow > div:gt(0)").hide();
    setInterval(function() {
    if($("#slideshow > div").length != 1){
    $('#slideshow > div:first')
    .fadeToggle(10)
    .next()
    .fadeToggle(10)
    .end()
    .appendTo('#slideshow');
    }
},  6000);

$("#news_scrool > p:gt(0)").hide();
    setInterval(function() {
    if($("#news_scrool > p").length != 1){
    $('#news_scrool > p:first')
    .fadeToggle(10)
    .next()
    .fadeToggle(10)
    .end()
    .appendTo('#news_scrool');
    }
},  6000);


function startTime() {
    var today=new Date();
    var h=today.getHours();
    var m=today.getMinutes();
    var s=today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    $('#clock').html (checkTime(h)+":"+m);
    var t = setTimeout(function(){startTime()},500);
}

function checkTime(i) {
    if (i<10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}


startTime();
updateWeather();
refreshNews();

setInterval(function(){
  updateWeather();
  refreshNews();
},30000);

//marquee($('#news'), $('#news_scrool'));

function updateWeather(){
     
   
    $.ajax({
    url: "<?php echo Yii::app()->urlManager->createUrl('screens/weather') ?>",
    //data:locate()
    success: function(data) {
      var weatherdata = JSON.parse(data);
      console.log('weather updated : '+(weatherdata.weather[0].description).toUpperCase());
      var background_url= '<?php echo Yii::app()->getBaseUrl()?>'+'/weathericon/b' + weatherdata.weather[0].icon + '.gif';
      console.log(background_url);
      $('#w_background').css("background", 'url('+background_url+')');
       $('#w_background').css("background-size",'cover')

      $('#icon').attr("src","<?php echo Yii::app()->getBaseUrl()?>"+'/weathericon/' + weatherdata.weather[0].icon + '.png');
      $('#tem').html(Math.round(weatherdata.main.temp) + '<sup><span style="font-size:40px;"> °C</span></sup>');
      $('#description').html((weatherdata.weather[0].description).toUpperCase());
      $('#humidity').html('Humidity  '+ weatherdata.main.humidity+ ' %');
       $('#clouds').html('Clouds  ' +weatherdata.clouds.all+ ' %');
        $('#wind').html('Wind  ' +weatherdata.wind.speed+ ' mps');
    },
  });
  

}

function refreshNews(){
$.ajax({
    
    url: "<?php echo Yii::app()->urlManager->createUrl('screens/news') ?>",
    success: function(data) {
        $('#news_scrool').text('');
        console.log(JSON.parse(data));
        var obj= JSON.parse(data);
        for(var k in obj)
        if ({}.hasOwnProperty.call(obj, k)){
            var title =  obj[k][0]
            title=title.replace('(भिडियोसहित)','');
            title=title.replace('</br>','');
            $('#news_scrool').append('<p>'+title + '</p>');
        }

    }
    
})
}

//Enter name of container element & marquee element

/*var locationa= 'abcd';
locate();

function locate(){

if(navigator.geolocation)
{
    navigator.geolocation.getCurrentPosition(showPosition);
}


}
function showPosition(pos){
     locationa = ("Lat=" + pos.coords.latitude + "&Long=" + pos.coords.longitude);
     return locationa;
   
}
console.log(locationa);*/

//console.log(locate());



</script>

   

