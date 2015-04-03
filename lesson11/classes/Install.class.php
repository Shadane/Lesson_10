<?php

class Install {

    private $ads_db;
    

    function __construct($post) {
        self::saveToConfig($post);
        $this->ads_db = DBsingleton::getInstance();
        
    }
    function saveToConfig($post){
        $contents='<?php '."\r\n".' '
            . '$config_arr = array('."\r\n".''
            . '\'server_name\'=> \''.$post['server_name'].'\','."\r\n".''
            . '\'user_name\' => \''.$post['user_name'].'\','."\r\n".''
            . '\'password\'=> \''.$post['password'].'\','."\r\n".''
            . '\'database\' => \''.$post['database'].'\');';
    
        file_put_contents('./config.php', $contents);
        
    }
    
    
    
function buildTables() {
        // Read in entire file
        if (!file_exists('./ads.sql')) {
            die('Cannot locate file to parse tables');
        }
// Temporary variable, used to store current query
        $templine = '';
        $lines = file('./ads.sql');
// Loop through each line
        foreach ($lines as $line) {
            // Skip it if it's a comment
            if (substr($line, 0, 2) == '--' || $line == '')
                continue;

            // Add this line to the current segment
            $templine .= $line;
            // If it has a semicolon at the end, it's the end of the query
            if (substr(trim($line), -1, 1) == ';') {
                // Perform the query
                $this->ads_db->query($templine);
                // Reset temp variable to empty
                $templine = '';
            }
        }
    }
}

