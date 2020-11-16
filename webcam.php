<?php 
$cam = $_GET['cam'];
function file_get_contents_curl($url) { 
    $ch = curl_init(); 
  
    curl_setopt($ch, CURLOPT_HEADER, 0); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_URL, $url); 
  
    $data = curl_exec($ch); 
    curl_close($ch); 
  
    return $data; 
} 
if($cam == "querol"){
    $urlCam = "http://109.167.55.247:8001/record/current.jpg";
}elseif ($cam == "donador") {
    $urlCam = "http://109.167.55.247:89/cgi-bin/CGIProxy.fcgi?cmd=snapPicture2&amp;usr=visitant&amp;pwd=visitant";
}elseif ($cam == "golf") {
    $urlCam = "http://109.167.55.247:85/cgi-bin/CGIProxy.fcgi?cmd=snapPicture2&amp;usr=visitant&amp;pwd=visitant1";
}elseif ($cam == "debutants") {
    $urlCam = "http://109.167.55.247:8000/record/current.jpg";
}
$data = file_get_contents_curl( 
$urlCam); 

header('Content-type: image/jpeg');
echo $data;

?>
