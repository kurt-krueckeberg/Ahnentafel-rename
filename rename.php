<?php
$a = array("[ Johann Jungmann ] [ Anna Jungfleisch ]",
"[ Johann Bartold Beerman ] [ Unknown ]",
"[ Johann Paul Zollinger ] [ Johannette Margarethe Unknown_Surname ]",
"[ Gottlieb Krückeberg ] [ Unknown ]",
"[ Friedrich Wilhelm Weiland ] [ Unknown ]",
"[ Johann Dietrich Kleinschmidt ] [ Marg ]",
"[ Johannes Vollmer ] [ Wildburga Ensinger ]",
"[ Friederich Maier ] [ Maria Agnes Bossler ]",
"[ Unknown_firstname Feld ] [ Elisabeth Unknown ]",
"[ Jacob Feld ] [ Catherine Elisabeth Jungmann ]",
"[ Johann Henrich Beerman ] [ Caroline Stuber ]",
"[ Ernest Geble ] [ Eleonora Geberelia ]",
"[ Johann \"Christian\" Zollinger ] [ Dorothee Catharine Elisabethe Kühn ]",
"[ Jacob Heinrich Kohlinger ] [ Mary Christina Weber ]",
"[ Carl Friedrich Gottlieb Krückeberg ] [ Philippine Leonore Bleeken ]",
"[ Johann Heinrich Christian Kleinschmidt ] [ Clare Christine Elisabeth Brandhorst ]",
"[ Johann Georg Vollmer ] [ Johanna Dorothea Attinger ]",
"[ Gottlieb Maier ] [ Maria Agnes Wieland ]",
"[ Friedrich Heine ] [ Marie Sophie Franke ]",
"[ Johann Jacob Peppler ] [ Maria Magdalene Platt ]",
"[ Johannes Bender ] [ Katharine Elisabeth Rühl ]",
"[ Friedrich Albersmeier ] [ Hanne Marie Sophie Louise Heine ]",
"[ Ludwig \"Louis\" Peppler ] [ Mary Bender ]",
"[ Peter Phillip Felt ] [ Margaret K ]",
"[ Heinrich \"henry\" Behrman ] [ Justine Justina L Grieble ]",
"[ Frederick Wilhelm Georg Zollinger ] [ Catharine Elizabeth Koehlinger ]",
"[ Carl Friedrich Krückeberg ] [ Luise Dorothea Weiland ]",
"[ Louis H Peppler ] [ Catherine Felt ]",
"[ Louis L Behrman ] [ Wilhelmina \"Minnie\" Zollinger ]",
"[ Carl Heinrich Wilhelm Krückeberg ] [ Caroline Wilhelmine Marie Kleinschmidt ]",
"[ Karl Henry Ludwig (Lewis) Koldewey ] [ Sophie Margarite \"Louise\" Tiemann ]",
"[ Johann Christian Vollmer ] [ Rosina Katharina \"katherine\" Maier ]",
"[ Friedrich Christian Wilhelm Krueckeberg ] [ Emma Maria Katharine Koldewey ]",
"[ Johann Christian Vollmer  ] [ Marie Louise Lisette Albersmeier ]",
"[ Walter Louis Pepler ] [ Mae Behrman ]",
"[ Ferdinand Heinrich Krueckeberg ] [ Ruth Modesta Vollmer ]",
"[ John Howard Krueckeberg ] [ Bonnie Carolyn Pepler ]");

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
 
$regex = '@\[\s([A-Za-zöäüAÖÄÜß"_ ]+)\]@';

$dir = dirname(__FILE__);

$dir_iter = new DirectoryIterator($dir);
    
$dir_only_iter = new \CallbackFilterIterator($dir_iter, function(\SplFileInfo $file_info) {
                 return $file_info->isDir();
             });
             
foreach($dir_only_iter as $file_info) {

   $dir_name = $file_info->getFilename();

   $pos_space = strpos($dir_name, ' ');

   $str = substr($dir_name, $pos_space);

   $rc = preg_match_all($regex, $str, $matches);

   $new_dir_name = substr($dir_name, 0, $pos_space + 1 ) . get_new_bracketed_name($matches[1]);

   $cmd = "mv '$dir_name' '$new_dir_name'";

   exec($cmd);
}
