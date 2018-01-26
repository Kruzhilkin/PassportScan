<?php
  /**
  * 
  */
class PassportClass 
{
  //private $passport;
  private $K_PASP_NUMBER; 
  private $K_NAME;
  private $K_IMYA;
  private $K_OTCH;
  private $K_BITHDAY; 
  private $PERSONAL_N;  
  private $K_PASP_AUTHORITY;
  private $K_PASP_DATE_IS;
  private $K_PASP_DATE_EX;
  private $K_SEX;
  private $link_Photo;
  private $AN_AMBKART;
  function setPassportFromArray($arg){
    $passport = $arg;
    $this-> K_PASP_NUMBER = $passport->ListVerifiedFields->pFieldMaps['2']->Field_Visual;
    $this-> K_BITHDAY = date("Y-m-d", strtotime($passport->ListVerifiedFields->pFieldMaps['5']->Field_Visual));
    $this-> K_NAME = $passport->ListVerifiedFields->pFieldMaps['11']->Field_Visual;
    $this-> K_IMYA = $passport->ListVerifiedFields->pFieldMaps['14']->Field_Visual;
    $this-> K_OTCH = $passport->ListVerifiedFields->pFieldMaps['31']->Field_Visual;
    $this-> PERSONAL_N = $passport->ListVerifiedFields->pFieldMaps['9']->Field_Visual;
    $this-> K_PASP_AUTHORITY = $passport->ListVerifiedFields->pFieldMaps['18']->Field_Visual;
    $this-> K_PASP_DATE_IS =date("Y-m-d", strtotime($passport->ListVerifiedFields->pFieldMaps['4']->Field_Visual));
    $this-> K_PASP_DATE_EX = date("Y-m-d", strtotime($passport->ListVerifiedFields->pFieldMaps['3']->Field_Visual));
    $this-> K_SEX = $passport->ListVerifiedFields->pFieldMaps['16']->Field_Visual;
   if($this->K_SEX == "M")
        $this->K_SEX = 1;
      else
        $this->K_SEX = 2;
 

  }

  function updatePassportData($linkBood, $personal_n){
    $sql = "UPDATE KARTOTEK SET 
          PERSONAL_N = '".$personal_n."', 
          K_PASP_NUMBER = '".$this->K_PASP_NUMBER."',
          K_NAME = '".$this->K_NAME."',
          K_IMYA = '".$this->K_IMYA."',
          K_OTCH = '".$this->K_OTCH."',
          K_BITHDAY = '".$this->K_BITHDAY."',
          K_PASP_AUTHORITY = '".$this->K_PASP_AUTHORITY."',
          K_PASP_DATE_IS = '".$this->K_PASP_DATE_IS."',
          K_PASP_DATE_EX = '".$this->K_PASP_DATE_EX."',
          K_URL_FOTO  = '".$this->link_Photo."',
          K_SEX = '".$this->K_SEX."'  
          WHERE PERSONAL_N = '$personal_n'";
    if($result = mysqli_query($linkBood, $sql)){
     // echo "Успешно обнавлено";    
      echo "true";
    }
    else{
      echo "Ошибка при обнавлении!";
    }
  }


  
  function insertPassportData($linkBood, $personal_n){
    $sql = "INSERT INTO KARTOTEK_ID SET 
      ID_DOC='".$_SESSION['user_id']."'  ";
    if(!$result = mysqli_query($linkBood, $sql)){
      echo "Не удалость вставить автоинкрементное поле в KARTOTEK". $sql;
      exit(); 
    }
    else{
      $this->AN_AMBKART = mysqli_insert_id($linkBood);

      

          $sql = "INSERT INTO KARTOTEK SET 
          AN_AMBKART = '".$this->AN_AMBKART."',
          PERSONAL_N = '".$personal_n."', 
          K_PASP_NUMBER = '".$this->K_PASP_NUMBER."',
          K_NAME = '".$this->K_NAME."',
          K_IMYA = '".$this->K_IMYA."',
          K_OTCH = '".$this->K_OTCH."',
          K_BITHDAY = '".$this->K_BITHDAY."',
          K_PASP_AUTHORITY = '".$this->K_PASP_AUTHORITY."',
          K_PASP_DATE_IS = '".$this->K_PASP_DATE_IS."',
          K_PASP_DATE_EX = '".$this->K_PASP_DATE_EX."',
          K_URL_FOTO  = '".$this->link_Photo."',
          K_SEX = '".$this->K_SEX."' ";
        if($result = mysqli_query($linkBood, $sql)){
          echo "Успешно записано в KARTOTEK"; 
        }
    }
    
  }

  function insertPassportInKARTOTEK_PASP($linkBood, $personal_n){
    $sql = "INSERT INTO KARTOTEK_PASP SET 
      ID_PACIENT = '".$this->PERSONAL_N."',
      AN_AMBKART = '".$this->AN_AMBKART."',
      DATE_IS = '".$this->K_PASP_DATE_IS."',
      DATE_EX = '".$this->K_PASP_DATE_EX."',
      PASP_ORGAN = '".$this->K_PASP_AUTHORITY."',
      NAME =  '".$this->K_NAME."',
      IMYA = '".$this->K_IMYA."',
      OTCN = '".$this->OTCH."' ";
    if($result = mysqli_query($linkBood, $sql)){
      echo "Успешно записано в KARTOTEK";
      echo "<br>"; 
    }

  }


  public function moveImage($linkCurrent)
  {
    GLOBAL $linkdirPhoto;

    $date = new DateTime($this->K_BITHDAY);
    $Y = $date->format('Y');
    $m = $date->format('m');
    $d = $date->format('d');

     
    $dir = scandir($linkCurrent);

    foreach ($dir as $passports) 
    {
      if (strpos($passports, $this->K_PASP_NUMBER) !== false) 
      {
        $link_old = $linkCurrent . $passports . "/Photo.jpg"; 
        $link_dir = $linkdirPhoto . "/" . $Y . "/" . $m . "/";
        $this->link_Photo = $link_dir . $this->PERSONAL_N . ".jpg";
        if (!is_dir($link_dir)) {
          mkdir($link_dir, 0777, true);
    
          if (copy($link_old, $this->link_Photo))
          {
            //echo "Фото Успешно перемещено";
            //exit();
          }else{
            echo "Фото не удалось переместить!";
            exit();
          } 
        }
      }     
    }
  }

  public function moveFolder($linkCurrent)
  {

    GLOBAL $linkZip;
    $date = new DateTime($this->K_PASP_DATE_EX);
    $Y = $date->format('Y');
    $m = $date->format('m');
    $d = $date->format('d');

    $dest = $linkZip ."/" . $Y . "/" . $m . "/" . $d . "/" . $this->K_PASP_NUMBER;

    $dir = scandir($linkCurrent);

    foreach ($dir as $passports) 
    {
      if (strpos($passports, $this->K_PASP_NUMBER) !== false) 
      {
        $link_old = $linkCurrent . $passports; 
        $dirname = $linkCurrent . $passports. '/Page1'; 

        if (file_exists($dirname)) {
          $this->copyDirectory($link_old, $dest); 
        }

      //  $this->removeDirectory($link_old);
      }     
    }
  }



  function copyDirectory($source, $dest)
  {
   
    // Check for symlinks
    if (is_link($source)) {
        return symlink(readlink($source), $dest);
    }
    
    // Simple copy for a file
    if (is_file($source)) {
      copy($source, $dest);
        unlink($source);
      return true;
    }

    // Make destination directory
    if (!is_dir($dest)) {
        mkdir($dest, 0777, true);
    }

    // Loop through the folder
    $dir = dir($source);
    while (false !== $entry = $dir->read()) {
        // Skip pointers
        if ($entry == '.' || $entry == '..') {
            continue;
        }

        // Deep copy directories
        $this->copyDirectory("$source/$entry", "$dest/$entry");
    }

    // Clean up
    $dir->close();
    return true;
  }
  
  function removeDirectory($dir) {
    if ($objs = glob($dir."/*")) {
       foreach($objs as $obj) {
         is_dir($obj) ? $this->removeDirectory($obj) : unlink($obj);
       }
    }
    rmdir($dir);
  } 

  

}

  


  

  
?>