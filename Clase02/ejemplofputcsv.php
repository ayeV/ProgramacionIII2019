
<?php

$lista = array (
    array('aaa', 'bbb', 'ccc', 'dddd'),
    array('123', '456', '789'),
    array('"aaa"', '"bbb"')
);

$fp = fopen('fichero.csv', 'w');

foreach ($lista as $campos) {
    fputcsv($fp, $campos);
}

fclose($fp);
?>
