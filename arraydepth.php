<?
  $json = '{
  "@context": "http://schema.org",
  "@type": "BiologicalDatabaseEntry",
  "sample" : "this",
  "seeAlso" : {
    "@type" : "BiologicalDatabaseEntry",
    "entryID" : "154700",
    "url" : "http://omim.org/entry/154700",
    "isEntryOf" : {
    "@type" : "BiologicalDatabase",
    "name"  : "OMIM"
    }
    },
  "taxon" : {
    "@type" : "BiologicalDatabaseEntry",
    "name"  : "Homo sapiens",
    "url"   : "http://www.uniprot.org/taxonomy/9606",
    "entryID" : "9606"
    },
  "entryID" : "10",
  "ingredients": [
    "3 or 4 ripe bananas, smashed",
    "1 egg",
    "3/4 cup of sugar"
  ]
}';

  $dec_arr=json_decode($json,true);
  print_r($dec_arr);
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
    if ($key == "seeAlso" or $key == "taxon"){
        $nesttype = $type;
        $nestkey = $key;
    }
    elseif($key == "isEntryOf"){
        $nesttype = $type;
        $nestkey = "seeAlso";
    }
   else{
    echo "else\n";
       # print "@".$type."_".$key;
        $nesttype = $type;
        $nestkey=$key; 
       # search_name($value,$num,$nesttype,$nestkey);
       }
$num = count($value);
search_name($value,$num,$nesttype,$nestkey);
$flag = 1;
}
else{
if($num ==0 or $flag == 1){
echo "here\n";
print "@".$type."_".$key.'='.$value."\n";
}
else{
$flag = 0;
//echo "koko\n";
        print "@".$nesttype."_".$nestkey.'_'.$type."_".$key.'='.$value."\n";
}
}
}
}
$num = 0;
search_name($dec_arr,$num);
/*
function search_name($arr,$parent_key)
{
foreach ($arr as $key => $value) {
if (is_array($value)){
$parent_key = $key;
$value2 = search_name($value,$parent_key);
}
else{
        print $parent_key.':'.$key.'='.$value."\n";
}
}
}
$parent_key = "";
search_name($dec_arr,$parent_key);
*/
?>
