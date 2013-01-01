<?php

	$_REQUEST['cpt']=(isset($_REQUEST['cpt']) && !empty($_REQUEST['cpt'])) ? $_REQUEST['cpt'] : '90806';
     $domDocument=new DOMDocument();
	 $url = "https://ocm.ama-assn.org/OCM/CPTRelativeValueSearchResults.do?locality=3&keyword={$_REQUEST['cpt']}";
     $data = file_get_contents($url);
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
	
	//print '<pre>';print_r($node->nodeValue);
	  print($description.'</br>'.$payment1.'</br>'.$payment2);


?>