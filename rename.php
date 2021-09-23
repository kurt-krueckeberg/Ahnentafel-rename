<?php

// Break the file name into two parts.
function get_new_bracketed_name($match)
{
    $names = array();
    
    foreach ($match as $s) {
      
          $x = trim($s);
      
          $a = explode(' ', $x);
   
          $surname = array_pop($a);

          $reordered_name = ''; 
          
          if (count($a) >= 1) {
                     
             $given_names = implode(' ', $a); 
          
             $reordered_name = "$surname, $given_names"; 
            
          } else {
              
             $reordered_name = $surname;
          }
          
          $names[] = '[ ' . $reordered_name . ' ]';
    }
     
    return implode(' ', $names);
}

$dir_name_iter = new \CallbackFilterIterator(new DirectoryIterator(dirname(__FILE__)), function(\SplFileInfo $file_info) { return $file_info->isDir(); }
						);
             
$regex = '@\[\s([A-Za-zöäüAÖÄÜß"_ ]+)\]@';

foreach($dir_names_iter as $file_info) {

   $dir_name = $file_info->getFilename();

   $pos_space = strpos($dir_name, ' ');

   $str = substr($dir_name, $pos_space);

   $rc = preg_match_all($regex, $str, $matches);

   $new_dir_name = substr($dir_name, 0, $pos_space + 1 ) . get_new_bracketed_name($matches[1]);

   $cmd = "mv '$dir_name' '$new_dir_name'";

   exec($cmd);
}
