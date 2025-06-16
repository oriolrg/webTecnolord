<?php
if($cam == "querol"){
    $urlCam = "http://109.167.55.247:8001/record/current.jpg";

    $data = file_get_contents_curl($urlCam);
    header('Content-type: image/jpeg');
}elseif ($cam == "donador") {
    $urlCam = "http://109.167.55.247:89/cgi-bin/CGIProxy.fcgi?cmd=snapPicture2&amp;usr=visitant&amp;pwd=visitant";

    $data = file_get_contents_curl($urlCam);
    header('Content-type: image/jpeg');
}elseif ($cam == "golf") {
    $urlCam = "http://109.167.55.247:85/cgi-bin/CGIProxy.fcgi?cmd=snapPicture2&amp;usr=visitant&amp;pwd=visitant1";
    $data = file_get_contents_curl($urlCam);
    $im = imagecreatefromstring($data);
    //$url = 'https://www.wunderground.com/weather/es/la-coma/ILACOM4';>
    $text = 'Port del Comte Golf';
    //$stamp = dadesMeteo($url, $im, $text, 850);
}elseif ($cam == "debutants") {
    $urlCam = "http://109.167.55.247:8999/cgi-bin/api.cgi?cmd=Snap&channel=0&rs=wuuPhkmUCeI9WG7C&user=user&password=useruser";
    $data = file_get_contents_curl($urlCam);
    $im = imagecreatefromstring($data);
    $url = 'https://www.wunderground.com/weather/es/la-coma/ICATALUN31';
    $text = 'Port del Comte 1730';
    $stamp = dadesMeteo($url, $im, $text, 0);

}elseif ($cam == "bofia") {
    $urlCam = "http://109.167.55.247:86/snapshot.jpg?user=visitor&pwd=visitor";

    $data = file_get_contents_curl($urlCam);
    header('Content-type: image/jpeg');
}elseif ($cam == "prova") {
    $urlCam = "http://109.167.55.247:8999/cgi-bin/api.cgi?cmd=Snap&channel=0&rs=wuuPhkmUCeI9WG7C&user=user&password=useruser";
    $data = file_get_contents_curl($urlCam);
    $im = imagecreatefromstring($data);
    $url = 'https://api.weather.com/v2/pws/observations/current?stationId=ICATALUN31&format=json&units=m&apiKey=979bf738d55144929bf738d551f49248&numericPrecision=decimal';
    $text = 'Port del Comte 1730';
    $stamp = dadesMeteo($url, $im, $text, 0);
}
//mostrar imatge
echo $data;
?>