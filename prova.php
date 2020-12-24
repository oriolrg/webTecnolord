<?php 
// Definimos la función cURL
function curl($url) {
    $ch = curl_init($url); // Inicia sesión cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // Configura cURL para devolver el resultado como cadena
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Configura cURL para que no verifique el peer del certificado dado que nuestra URL utiliza el protocolo HTTPS
    $info = curl_exec($ch); // Establece una sesión cURL y asigna la información a la variable $info
    curl_close($ch); // Cierra sesión cURL
    return $info; // Devuelve la información de la función
}

$sitioweb = curl("https://app.weathercloud.net/d0997685975#profile");  // Ejecuta la función curl escrapeando el sitio web https://devcode.la and regresa el valor a la variable $sitioweb
//creamos nuevo DOMDocument y cargamos la url
$dom = new DOMDocument();
@$dom->loadHTML($sitioweb);
//obtenemos todos los div de la url
//Obtener el elemento por el id "textoejemplo"
$textoejemplo = $dom->getElementById('temp_cur');
    
//Obtener el texto del elemento
$texto = $textoejemplo->textContent;
echo $texto;
//recorremos los divs
//$dias = $dom->getElementById( 'temp_cur' );
//echo $doc->saveHTML($divs);
foreach( $textoejemplo as $div ){
    echo $div->nodeValue;
    //si encentramos la clase mc-title nos quedamos con el titulo
    if( $div->getAttribute( 'class' ) === 'forecast-table-time forecast-table__row' ){
        $hora = $div->nodeValue;
    }
    if( $div->getAttribute( 'class' ) === 'forecast-table-snow forecast-table__row' ){
        $neu = $div->nodeValue;
    }
    if( $div->getAttribute( 'class' ) === 'forecast-table-rain forecast-table__row' ){
        $pluja = $div->nodeValue;
    }
    if( $div->getAttribute( 'class' ) === 'forecast-table-humidity forecast-table__row' ){
        $humitat = $div->nodeValue;
    }
    //si encentramos la clase mr-rating nos quedamos con la puntuacion
    if( $div->getAttribute( 'class' ) === 'forecast-table-freezing-level forecast-table__row' ){
        $cota_neu = $div->nodeValue;
    }
}
$divs = $dom->getElementsByTagName( 'div' );
//recorremos los divs
foreach( $divs as $div ){
    //si encentramos la clase mc-title nos quedamos con el titulo
    if( $div->getAttribute( 'class' ) === 'current-temp' ){
        $temperatura = $div->nodeValue;
        $temperatura = (intval($temperatura) - 32) / 1.8;
    }
}
$divs = $dom->getElementsByTagName( 'span' );
//recorremos los divs
foreach( $divs as $div ){
    if( $div->getAttribute( 'class' ) === 'test-false wu-unit wu-unit-humidity ng-star-inserted' ){
        $humitat = $div->nodeValue;
    }
}
for($i=0;$i<strlen($cota_neu);$i+=4){
    echo 'Cota de neu:' . substr($cota_neu, $i, 4) . ' ';
    echo '<br>';
}
echo $hora.'<br>';
echo $cota_neu.'<br>';
echo $humitat.'<br>';
echo $temperatura.'<br>';
echo $neu.'<br>';
echo $dias.'<br>';
?>
