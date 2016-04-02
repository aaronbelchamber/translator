<?php
namespace Translator;

/**
 *  Translator class is the interface and handler for this translator tool
 *
 *
 */

 class Translator {

	protected $urlToMap;

	protected $retrieveUrlContents;

	protected $TranslatorView;

	protected $TranslatorViewJs;


    function __construct(){

	    $this->urlToMap=filter_var($_POST['url'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);

		if(!empty($this->urlToMap)){
			//  $this->urlToMap='https://'.$this->urlToMap;
			// Try and retrieve the URL contents
			$this->retrieveUrlContents=file_get_contents($this->urlToMap);
			if(empty($this->retrieveUrlContents)) $this->retrieveUrlContents="<h4 class='text-danger text-center' rel='retrievalFailed'>Could not retrieve contents from URL '$this->urlToMap'</h4>";
		}
    }


	 function buildPage(){

		 $this->TranslatorView->htmlHeader();
		 $this->TranslatorView->htmlBody($this->urlToMap,array('contentFromUrl'=>$this->retrieveUrlContents));
	 }

	 /**
	  * @return mixed
	  */
	 public function getUrlToMap() {
		 return $this->urlToMap;
	 }

	 /**
	  * @param mixed $urlToMap
	  */
	 public function setUrlToMap( $urlToMap ) {
		 $this->urlToMap = $urlToMap;
	 }

	 /**
	  * @return mixed
	  */
	 public function getTranslatorView() {
		 return $this->TranslatorView;
	 }

	 /**
	  * @param mixed $TranslatorView
	  */
	 public function setTranslatorView( $TranslatorView ) {
		 $this->TranslatorView = $TranslatorView;
		 $this->TranslatorView->setTranslatorViewJs($this->getTranslatorViewJs());
	 }

	 /**
	  * @return mixed
	  */
	 public function getTranslatorViewJs() {
		 return $this->TranslatorViewJs;
	 }

	 /**
	  * @param mixed $TranslatorViewJs
	  */
	 public function setTranslatorViewJs( $TranslatorViewJs ) {
		 $this->TranslatorViewJs = $TranslatorViewJs;
	 }


 }