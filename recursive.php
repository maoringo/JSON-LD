<?php
  $json = '{
  "@context": "http://schema.org",
  "@type": "BiologicalDatabaseEntry",
  "taxon" : {
    "@type" : "BiologicalDatabaseEntry",
    "name"  : "Homo sapiens",
    "url"   : "http://www.uniprot.org/taxonomy/9606",
    "entryID" : "9606"
    }
}';

  $dec_arr=json_decode($json,true);
#    print_r($dec_arr);
function search_name($arr)
{
    foreach ($arr as $key => $value) {
# Extrac type
    if($key == "@type"){
        $type = $value;
        continue;
      }
    elseif(strstr($key,"@")){
       continue;
    } 

       if (is_array($value)) {
            $value2 = search_name($value);
        }
        else{
        print $type."_".$key.'=>'.$value."\n";
    }
}
    return "";
}
search_name($dec_arr);
?>
