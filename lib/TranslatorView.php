<?php
namespace Translator;

/**
 *  This handles the view for the Translator library and builds the basic shell of the page, parses the form.
 *
 *  Most of the heavy lifting will be done through JS, though
 *
 */
 class TranslatorView{

	protected $title='Translator Setup Tool';

	protected $TranslatorViewJs;


	function __construct(){


	}


	function htmlHeader($addHeadHtml=null){
		?><!doctype html>
			<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
			<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
			<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
			<!--[if gt IE 8]><!-->
			<html class="">
			<!--<![endif]-->
			<head>
				<?php echo $this->customCss(); $addHeadHtml ?>

				<title><?php echo $this->title ?></title>
				<meta charset="utf-8">
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<meta name="referrer" content="unsafe-url">
				<meta name="ROBOTS" content="NOINDEX, NOFOLLOW">

				<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>

				<!-- Latest compiled and minified CSS -->
				<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

				<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0-rc.1/jquery-ui.min.js"/>
				<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0-rc.1/themes/smoothness/jquery-ui.css"/>

				<!-- Optional theme -->
				<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

				<!-- Latest compiled and minified JavaScript -->
				<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

			</head><?php
	}


	function htmlBody($urlToMap,$htmlArr=null){
		/**
		 *  $htmlArr will have different associative element blocks, like $htmlArr['contentFromUrl'], ['top'], ['bottom'], which can be expanded here
		 *
		 *  Content will be pulled into top
		 */

		// echo "DEBUG ".__FUNCTION__.": ".print_r($htmlArr,true); exit;
		?><body>
			<div class="container-fluid">
			<div id="adminSection" class="col-lg-12">
				<?php
						echo $this->formUrlRetriever($urlToMap);
						echo $this->adminMapEditBox();  // This creates the container for ALL edits of the mapping
				?>

			</div>
			<div id="contentFromUrl" class="col-lg-12">
				<?php
					if(isset($htmlArr['contentFromUrl'])) echo $htmlArr['contentFromUrl'];
							else echo "<p class='text-warning text-center'>No URL has been fetched for processing.</p>";
				?>
			</div></div>
			<?php echo $this->htmlFooter();?>
		</body></html><?php
	}


	function formUrlRetriever($urlToMap){

		?><form method="post" id="formUrlRetriever">
			URL to map for translation:  <input name="url" size="60" value="<?php echo urldecode($urlToMap) ?>"/>

			<input type="submit" value="Fetch URL" class="btn btn-sm btn-success"/>
		</form><?php
	}


	function adminMapEditBox(){

		?><div id="adminMapEditBox">
			This is where each container from the Url you retrieve can be brought in, further define it's internal section selection, then update the mappings and create translation actions.
		</div><?php
	}


	function htmlFooter(){
		/**
		 *  This is where we pull in the Javascript library that performs all the front-end interactions
		 *
		 */
		echo $this->TranslatorViewJs->fetchJs();

	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}/**
	 * @param string $title
	 */
	public function setTitle( $title ) {
		$this->title = $title;
	}/**
	 * @return mixed
	 */
	public function getTranslatorViewJs() {
		return $this->TranslatorViewJs;
	}/**
	 * @param mixed $TranslatorViewJs
	 */
	public function setTranslatorViewJs( $TranslatorViewJs ) {
		$this->TranslatorViewJs = $TranslatorViewJs;
	}

	function customCss(){
		?><style>
			#adminMapEditBox,#adminSection{text-align:center;padding:15px 2%;width:100%}
			#contentFromUrl,#adminMapEditBox{width:100%;padding:0;margin:0!important}
			#contentFromUrl{border:2px solid orange}
			.admin-selected{background-color:#AAA;cursor:pointer}
			.admin-selected-temp{opacity:.7;background:
			linear-gradient(
				rgba(255, 0, 0, 0.45),
				rgba(255, 0, 0, 0.45)
			)}
			.adminElement{width:auto;max-width:20%;float:left;padding:5px;border:1px solid gray;height:100px;max-height:120px;white-space: normal;text-overflow: clip;word-wrap: break-word;
							overflow:hidden;text-size:7px; cursor:pointer}
			.adminBoxSelected{background-color:lightgreen}
		</style><?php
	}

 }