<?php
namespace Translator;

ini_set('display_errors',true);
/**
 *  FRONT END CONTROLLER FOR /lib/Translator
 *
 *  This page will load another URL and allow the user to select different elements.
 *
 *  From these selected elements, the user can add, edit and remove them into "map list", a special container that allows the user to select, traverse then alter the contents within for translation.
 *
 */

//var_dump($_POST); exit;

include(dirname(__FILE__).'/lib/Translator.php');
include(dirname(__FILE__).'/lib/TranslatorView.php');
include(dirname(__FILE__).'/lib/TranslatorViewJs.php');

$Translator=new Translator();
$TranslatorView=new TranslatorView();
$Translator->setTranslatorView($TranslatorView);
$TranslatorView->setTranslatorViewJs(new TranslatorViewJs);

$Translator->buildPage();

