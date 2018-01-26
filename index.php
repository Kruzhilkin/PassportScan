<?php
include 'db.inc.php';
include 'settings.php';
include 'ListPassports.php';
include 'Passport.php';


  
    


if (!$_GET['personal_n']) {
	$list = new ListPassportsClass();
	$list->getListPassorts($linkCurrent);
	
}
elseif ($_GET['personal_n'] and $_GET['AN_AMBKART']) {
	$l = new ListPassportsClass();
	$a[] = $l -> getPassportFromUid($_GET['personal_n'], $linkCurrent);
		/*
		foreach ($a as $value) {
			echo"<pre>";
			print_r($value) ;
			echo"</pre>";
		}
		*/
	$a[0]-> moveImage($linkCurrent);
	$a[0]-> moveFolder($linkCurrent);
	$a[0]-> updatePassportData($linkBood, $_GET['personal_n']);
	//$a[0]-> insertPassportData($linkBood, $_GET['personal_n']);
	
}

elseif ($_GET['personal_n'] and !$_GET['AN_AMBKART'] and $_GET['new']) {
	$l = new ListPassportsClass();
	$a[] = $l -> getPassportFromUid($_GET['personal_n'], $linkCurrent);
		/*
		foreach ($a as $value) {
			echo"<pre>";
			print_r($value) ;
			echo"</pre>";
		}
		*/
	$a[0]-> moveImage($linkCurrent);
	$a[0]-> moveFolder($linkCurrent);
	//$a[0]-> updatePassportData($linkBood, $_GET['personal_n']);
	$a[0]-> insertPassportData($linkBood, $_GET['personal_n']);
	

	
}


  
  
     
  


 
?>

