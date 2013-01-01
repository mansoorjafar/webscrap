<?php

//	 $_REQUEST['postal']	= '03900';
   	 
	 $_REQUEST['postal'] = (isset($_REQUEST['postal']) && !empty($_REQUEST['postal'])) ? $_REQUEST['postal'] : '00000';
	 $locNum = locNumber($_REQUEST['postal']);   // TRUE NJ

	  // print validstatezip("03900")."<br>";   //  ME
	  // print validstatezip("73949")."<br>";   // TX
	  // print validstatezip("88599")."<br>";   // TX	

   	  $_REQUEST['cpt'] = (isset($_REQUEST['cpt']) && !empty($_REQUEST['cpt'])) ? $_REQUEST['cpt'] : '90806';
	  $url = "https://ocm.ama-assn.org/OCM/CPTRelativeValueSearchResults.do?locality={$locNum}&keyword={$_REQUEST['cpt']}";
	  
	  $ch = curl_init();
	  curl_setopt($ch,CURLOPT_URL, $url);
	  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	  $data = curl_exec($ch);
	  if(curl_errno($ch)){
		  echo 'Curl error: ' . curl_error($ch);
	  }
	  curl_close($ch);

      $domDocument = new DOMDocument();
  	  $domDocument->loadHTML($data );
	  $domXPath = new DOMXPath($domDocument);
	  
	  $domNodeList = $domXPath->query(".//*[@id='rvs-table']/tbody/tr/td[2]");
	  $domDocument = new DOMDocument();
	  $node = $domNodeList->item(0);   
	  foreach($node->childNodes as $childNode)
		  $domDocument->appendChild($domDocument->importNode($childNode, true));
	  $description = $domDocument->saveHTML();
	
	  $domNodeList = $domXPath->query(".//*[@id='rvs-table']/tbody/tr/td[3]");
	  $domDocument = new DOMDocument();
	  $node = $domNodeList->item(0);   
	  foreach($node->childNodes as $childNode)
		  $domDocument->appendChild($domDocument->importNode($childNode, true));
	  $payment1 = $domDocument->saveHTML();


	  $domNodeList = $domXPath->query(".//*[@id='rvs-table']/tbody/tr/td[4]");
	  $domDocument = new DOMDocument();
	  $node = $domNodeList->item(0);   
	  foreach($node->childNodes as $childNode)
		  $domDocument->appendChild($domDocument->importNode($childNode, true));
	  $payment2 = $domDocument->saveHTML();
	
	  print($description.'</br>'.$payment1.'</br>'.$payment2);

  function locNumber($zip5)
  {
	  $allstates = array (
	   1=>array ("0000000000"),
	   2=>array ("9950099929"),
	   3=>array ("3500036999"),
	   4=>array ("7160072999", "7550275505"),
	   5=>array ("8500086599"),
	   6=>array ("9000096199"),
	   16=>array ("8000081699"),
	   17=>array ("0600006999"),
	   18=>array ("2000020099", "2020020599"),
	   19=>array ("1970019999"),
	   20=>array ("3200033999", "3410034999"),
	   23=>array ("3000031999"),
	   25=>array ("9670096798", "9680096899"),
	   26=>array ("5000052999"),
	   27=>array ("8320083899"),
	   28=>array ("6000062999"),
	   32=>array ("4600047999"),
	   33=>array ("6600067999"),
	   34=>array ("4000042799", "4527545275"),
	   35=>array ("7000071499", "7174971749"),
	   37=>array ("0100002799"),
	   39=>array ("2033120331", "2060021999"),
	   41=>array ("0380103801", "0380403804", "0390004999"),
	   43=>array ("4800049999"),
	   45=>array ("5500056799"),
	   46=>array ("6300065899"),
	   49=>array ("3860039799"),
	   50=>array ("5900059999"),
	   51=>array ("2700028999"),
	   52=>array ("5800058899"),
	   53=>array ("6800069399"),
	   54=>array ("0300003803", "0380903899"),
	   55=>array ("0700008999"),
	   57=>array ("8700088499"),
	   58=>array ("8900089899"),
	   59=>array ("0040000599", "0639006390", "0900014999"),
	   64=>array ("4300045999"),
	   65=>array ("7300073199", "7340074999"),
	   66=>array ("9700097999"),
	   68=>array ("1500019699"),
	   71=>array ("0280002999", "0637906379"),
	   72=>array ("2900029999"),
	   73=>array ("5700057799"),
	   74=>array ("3700038599", "7239572395"),
	   75=>array ("7330073399", "7394973949", "7500079999", "8850188599"),
	   83=>array ("8400084799"),
	   84=>array ("2010520199", "2030120301", "2037020370", "2200024699"),
	   86=>array ("0500005999"),
	   87=>array ("9800099499"),
	   89=>array ("4993649936", "5300054999"),
	   90=>array ("2470026899"),
	   91=>array ("8200083199")
	   );
  
	   foreach($allstates as $key=>$postal)
	   {    
		  foreach($postal as $ziprange)
		  { 
			if (($zip5 >= substr($ziprange, 0, 5)) && ($zip5 <= substr($ziprange,5)))
			{
			   return ($key);
			 }
		  }
		}
		return 1;
  }


?>