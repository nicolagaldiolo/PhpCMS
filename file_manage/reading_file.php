<?php

    $file = "example.txt";

    $handle = fopen($file, 'r');

    // fread vuole un numero di caratteri da visualizzare, lo posso impostare con un intero esempio 100
    // oppure posso usare una funzione buil-in filesize($file_manage) che calcola la dimensione del file_manage e imposta il
    // numero di caratteri se voglio visualizzare tutto il contenuto del file_manage.
    echo $content2 = fread($handle, filesize($file));

    fclose($handle);


?>