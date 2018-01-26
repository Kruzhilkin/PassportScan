<?php

class ListPassportsClass
{
  public $ArrayOfPassports;

  function getListPassorts($linkCurrent)     
  {
    $dir = scandir($linkCurrent);
    foreach ($dir as $passports) 
    {
      if (strpos($passports, 'BLR_P') !== false) 
      {
        //echo $passport;
        // echo "<br>";
        $linkForder = $linkCurrent.$passports."/LexicalAnalyze_Data.json"; 
        $fr = file_get_contents($linkForder, true);

        $dataScan = json_decode($fr);

        if ($dataScan->ListVerifiedFields->pFieldMaps['11']->FieldType == '68747272') 
        {
          $pass = new PassportClass();
          $pass -> setPassportFromArray($dataScan);
          $this -> ArrayOfPassports[] = $pass;
          /*
          echo"<pre>";
          print_r($dataScan->ListVerifiedFields->pFieldMaps);
          echo"</pre>";
          */
          $K_NAME = $dataScan->ListVerifiedFields->pFieldMaps['11']->Field_Visual;
          $K_IMYA = $dataScan->ListVerifiedFields->pFieldMaps['14']->Field_Visual;
          $K_OTCH = $dataScan->ListVerifiedFields->pFieldMaps['31']->Field_Visual;
          $PERSONAL_N = $dataScan->ListVerifiedFields->pFieldMaps['9']->Field_Visual;
          echo'<a href="/?&personal_n='.$PERSONAL_N.'">'. $K_NAME." ".$K_IMYA." ".$K_OTCH. '</a>';
          echo "<br>";
       
        }      
      }     
    }
    return $this->ArrayOfPassports;     
  }

  function displayListPassports()
  {

  }
  function getPassportFromUid($arg, $linkCurrent)
  {
    
    $dir = scandir($linkCurrent);

    foreach ($dir as $passports) 
    {
      if (strpos($passports, 'BLR_P') !== false) 
      {
        $link2 = $linkCurrent.$passports."/LexicalAnalyze_Data.json"; 
        $fr = file_get_contents($link2, true);

        $dataScan = json_decode($fr);
        if ($dataScan->ListVerifiedFields->pFieldMaps['11']->FieldType == '68747272') 
        {
          if ($dataScan->ListVerifiedFields->pFieldMaps['9']->Field_Visual == $arg) 
          {
            $pass = new PassportClass();
            $pass -> setPassportFromArray($dataScan);
            return $pass;
          }
        
        }      
       
      }     
    }
  }

  
    
}



  
?>