<?php 
function curl($url) {
    $ch = curl_init($url); // Inicia sesión cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // Configura cURL para devolver el resultado como cadena
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Configura cURL para que no verifique el peer del certificado dado que nuestra URL utiliza el protocolo HTTPS
    $info = curl_exec($ch); // Establece una sesión cURL y asigna la información a la variable $info
    curl_close($ch); // Cierra sesión cURL
    return $info; // Devuelve la información de la función
}
function direccioVent($direccioVent){
    $windDir =  array (
        array ( 'minVal'=> 0, 'maxVal'=> 30, 'direction'=> 'N' ),
        array ( 'minVal'=> 31, 'maxVal'=> 45, 'direction'=> 'NNE' ),
        array ( 'minVal'=> 46, 'maxVal'=> 75, 'direction'=> 'NE' ),
        array ( 'minVal'=> 76, 'maxVal'=> 90, 'direction'=> 'ENE' ),
        array ( 'minVal'=> 91, 'maxVal'=> 120, 'direction'=> 'E' ),
        array ( 'minVal'=> 121, 'maxVal'=> 135, 'direction'=> 'ESE' ),
        array ( 'minVal'=> 136, 'maxVal'=> 165, 'direction'=> 'SE' ),
        array ( 'minVal'=> 166, 'maxVal'=> 180, 'direction'=> 'SSE' ),
        array ( 'minVal'=> 181, 'maxVal'=> 210, 'direction'=> 'S' ),
        array ( 'minVal'=> 211, 'maxVal'=> 225, 'direction'=> 'SSW' ),
        array ( 'minVal'=> 226, 'maxVal'=> 255, 'direction'=> 'SW' ),
        array ( 'minVal'=> 256, 'maxVal'=> 270, 'direction'=> 'WSW' ),
        array ( 'minVal'=> 271, 'maxVal'=> 300, 'direction'=> 'W' ),
        array ( 'minVal'=> 301, 'maxVal'=> 315, 'direction'=> 'WNW' ),
        array ( 'minVal'=> 316, 'maxVal'=> 345, 'direction'=> 'NW' ),
        array ( 'minVal'=> 346, 'maxVal'=> 360, 'direction'=> 'NNW' )
    );
    for ($i = 0; $i < count($windDir); $i++ ) {
        if ($direccioVent >= $windDir[$i]['minVal'] && $direccioVent <= $windDir[$i]['maxVal']) {
            return $windDir[$i]['direction'];  
        }
    }
}
function dadesMeteo($url, $im, $text, $posicio){
    $sitioweb = curl($url);
    //encode passo a string
    $dom = new DOMDocument();
    @$dom->loadHTML($sitioweb);
    $divs = $dom->getElementsByTagName( 'div' );
    //recorremos los divs
    foreach( $divs as $div ){
        //si encentramos la clase mc-title nos quedamos con el titulo
        if( $div->getAttribute( 'class' ) === 'current-temp' ){
            $temperatura = $div->nodeValue;
            $temperatura = round((intval($temperatura) - 32) / 1.8 ,1);
        }
    }
    $divs = $dom->getElementsByTagName( 'span' );
    //recorremos los divs
    foreach( $divs as $div ){
        if( $div->getAttribute( 'class' ) === 'test-false wu-unit wu-unit-humidity ng-star-inserted' ){
            $humitat = $div->nodeValue;
        }
    }
    //$pressio = $res->observations[0]->metric->pressure;
    //$precipitacio = $res->observations[0]->metric->precipTotal;
    //$direccioVent = $res->observations[0]->winddir;
    // Creo el recuadre imagecreatetruecolor(ample, alt);
    if($temperatura != null){
        $stamp = imagecreatetruecolor(500, 250);
        imagefilledrectangle($stamp, 0, 0, 400, 470, 0x000000);
        $font = './Roboto-Bold.ttf';
        $white = imagecolorallocate($im, 255, 255, 255);
        // Add some shadow to the text
        imagettftext($stamp, 40, 0, 10, 50, $white, $font, $text);
        //imagestring($stamp, 7, 20, 20, 'TecnoLord', 0xFFFFFF);

        imagettftext($stamp, 35, 0, 10, 120, $white, $font, 'Temperatura:'.$temperatura.chr(176).'C');
        //imagestring($stamp, 43, 20, 60, 'Temperatura:'.$temperatura.chr(176).'C', 0xFFFFFF);
        imagettftext($stamp, 35, 0, 10, 190, $white, $font, 'Humitat:'.$humitat);
        //imagestring($stamp, 13, 20, 100, 'Humitat:'.$humitat.'%', 0xFFFFFF);
        //imagestring($stamp, 13, 20, 120, 'Vent:'.direccioVent($direccioVent), 0xFFFFFF);
        // Obting marges i mida requadre
        $marge_right = 10;
        $marge_bottom = 10;
        $sx = imagesx($stamp);
        $sy = imagesy($stamp);

        // Uneixo imatge amb foto amb una opacitat del 50%
        imagecopymerge($im, $stamp, 0, $posicio, 0, 0, imagesx($im), imagesy($stamp), 80);
    }
    header('Content-Type: image/jpeg'); 
    imagejpeg($im, NULL, 40); 
    imagedestroy($im); 
}
$cam = $_GET['cam'];
function file_get_contents_curl($url) { 
    $ch = curl_init(); 
    $timeout=14;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
    
  
    $data = curl_exec($ch); 
    curl_close($ch); 
  
    return $data; 
} 
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
    //$url = 'https://www.wunderground.com/weather/es/la-coma/ILACOM4';
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
    if($data){
        return "hola";
    }else{
        return "adeu";
    }
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
