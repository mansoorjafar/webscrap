<?php

class WebScrap
	{
	private $url;
	private $xpath;

	public function WebScrap($url,$xpath)
		{
		$this->url = $url;
		$this->xpath = $xpath;
		}

	public function GetScrap()
		{
		// use Tidy to try to make the page well formed
		$page = $this->TidyIt($this->url);
		// create a document out of the well formed content
		$domDocument=new DOMDocument();
		$domDocument->loadHTML($page);
//die($domDocument->loadHTML($page));
//print '<pre>';print_r($domDocument);die();
		// create an XPath object out of the document and query it for the supplied xpath
		$domXPath = new DOMXPath($domDocument);
	
		$domNodeList = $domXPath->query($this->xpath);
//print '<pre>';print_r($domNodeList);die();
	
		// Get the content (HTML) out of the NodeList returned by the DOMXPath::query
		$content = $this->GetHTMLFromNodeList($domNodeList);

		return $content;
		}

	private function TidyIt($url)
		{
		$tidy = new tidy();
		//$tidy->parseFile($url);
		$tidy->parseString($url);
		$tidy->cleanRepair();
		return $tidy;
		}

	private function GetHTMLFromNodeList($domNodeList)
		{
			
	//		print '<pre>';print_r($domNodeList);die();
		$domDocument = new DOMDocument();

		$node = $domNodeList->item(0);   

		foreach($node->childNodes as $childNode)
			$domDocument->appendChild($domDocument->importNode($childNode, true));

		return $domDocument->saveHTML();
		}

	}


?>