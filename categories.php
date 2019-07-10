<?php
    $handle = fopen("kategorie.txt", "r");
    $handle_des = fopen("kategorie2.txt", "r");
    if ($handle && $handle_des) {
        while (($line = fgets($handle)) !== false) {
            $line_des = fgets($handle_des);
            echo<<<END
            <option value="$line">$line_des</option>
END;
        }
    
        fclose($handle);
    } else {
        // error opening the file.
    } 
?>
