<?php
    $result = $pdo->prepare('SHOW TABLES;');
    $result->execute();
    while($row = $result->fetch(PDO::FETCH_NUM)){
        $tables[] = $row[0];
    }
    $return = '';

    foreach ($tables as $table) {
        $result = $pdo->prepare("SELECT * FROM ".$table);
        $result->execute();
        $num_fields = $result->columnCount();

        $return .= 'DROP TABLE '.$table.';';
        $query = $pdo->prepare('SHOW CREATE TABLE '.$table);
        $query->execute();
        $row2 = $query->fetch(PDO::FETCH_NUM);
        $return .= "\n\n".$row2[1].";\n\n";

        for ($i=0; $i < $num_fields; $i++) { 
            while ($row = $result->fetch(PDO::FETCH_NUM)) {
                $return .= 'INSERT INTO '.$table.' VALUES(';
                for ($j=0; $j < $num_fields; $j++) { 
                    $row[$j] = addslashes($row[$j]);
                    if (isset($row[$j])) {
                        $return .= '"'.$row[$j].'"';} else { $return .= '""';}
                        if($j<$num_fields-1){ $return .= ','; }
                    }
                    $return .= ");\n";
                }
            }
            $return .= "\n\n\n";
        
    }

    $date = date('d-m-y');
    $file = 'db_backup/backup_'.$date.'.sql';
    if(!is_file($file)){
        touch($file);
        $handle = fopen($file, 'w+');
        fwrite($handle, $return);
        fclose($handle);
    }
?>