<?php ob_start(); ?>
  @include("web.common.header")

@yield("content")
    @include("web.common.footer")




<?php
$ob_get_clean_css = ob_get_clean();

$cssmain  = $ob_get_clean_css;
if($_SERVER['HTTP_HOST'] == 'localhost')
  echo $cssmain;
else{
  $search = array(
  	'/<!--(.|s)*?-->/',  //Remove HTML Comments
  	'/\>[^\S ]+/s', 	//strip whitespaces after tags, except space
  	'/[^\S ]+\</s', 	//strip whitespaces before tags, except space
  	'/(\s)+/s'  		//shorten multiple whitespace sequences
  );
  $replace = array(
      '',
      '>',
      '<',
      '\\1'
  );
  $cssmain2 =  preg_replace($search, $replace, $cssmain);
  $cssmain2 = str_replace('//due99y4btowlv.cloudfront.net/web/SSM/assets/font', 'https://due99y4btowlv.cloudfront.net/web/SSM/assets/font', $cssmain2);
  $cssmain2 = str_replace('http://due99y4btowlv', 'https://due99y4btowlv', $cssmain2);
  if($cssmain2 == null) { $forecho = $cssmain; } else{ $forecho = $cssmain2; }
  echo $forecho;
}
?>