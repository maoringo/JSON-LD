<?
/*
Copyright (c) 2014, MAORI ITO
All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
Neither the name of the <ORGANIZATION> nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.
THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

*/

#Get metadata from web page.
function getPageMetadata( $url ) {
$html = file_get_contents($url);
$html = mb_convert_encoding($html, mb_internal_encoding(), "auto" ); 
preg_match_all('/type=\"application\/ld\+json\">(.*?)<\/script>/is', $html, $matches,PREG_PATTERN_ORDER);
return $matches[1];
}
#Extract type and print for search engine index.
function search_name($arr,$num,$nesttype="",$nestkey="")
{
foreach ($arr as $key => $value) {
# Extract type
    if($key == "@type"){
        $type = $value;
        continue;
      }
# Eliminate the other @related object
    elseif(strstr($key,"@")){
       continue;
    } 
# Nest
if (is_array($value)){
#If $key is related to nest
$key_value = key($value);
    if ($key == "seeAlso" or $key == "taxon" ){
        $nesttype = $type;
        $nestkey = $key;
    }
    elseif($key == "isEntryOf"){
        $nesttype = $type;
        $nestkey = "seeAlso";
    }
#If value is simple nest, non @type, expand brackets. 
elseif($key_value == "0"){
        foreach ($value as $key2 => $value2){
        print "@".$type."_".$key.'='.$value2."\n";
        }
        continue;
    }
elseif($key_value == "@type"){
        $nesttype = $type;
        $nestkey=$key; 
}
   else{
        $nesttype = $type;
        $nestkey=$key; 
       }
$num = count($value);
search_name($value,$num,$nesttype,$nestkey);
$flag = 1;
}
else{
if($num ==0 or $flag == 1){
print "@".$type."_".$key.'='.$value."\n";
}
else{
$flag = 0;
        print "@".$nesttype."_".$nestkey.'_'.$type."_".$key.'='.$value."\n";
}
}
}
}


#getPageMetadata and return as array by each script tag.
$jsonarray = getPageMetadata($argv[1]);

foreach($jsonarray as $jkey => $jvalue){
$json =  preg_replace("/\n/","",$jvalue,1);
$dec_arr=json_decode($json,true);
// print_r($dec_arr);

search_name($dec_arr,0);
}

?>
