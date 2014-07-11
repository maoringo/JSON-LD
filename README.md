# JSON-LD Crawler
JSON-LD is a JSON for Linking Data.
JSON-LD Crawler is a crawler for [Sagace](http://sagace.nibio.go.jp) (a web-based search engine to discover and retrieve information from biomedical databases).
If you are interested in JSON-LD, please refer to these sites.

 * [JSON for Linking Data](http://json-ld.org/)
 * [http://schema.org/](http://schema.org/)


##Usage
```
php urljson-ld.php sample.html 
@BiologicalDatabaseEntry_seeAlso_BiologicalDatabaseEntry_entryID=154700
@BiologicalDatabaseEntry_seeAlso_BiologicalDatabaseEntry_url=http://omim.org/entry/154700
@BiologicalDatabaseEntry_seeAlso_BiologicalDatabase_name=OMIM
@BiologicalDatabaseEntry_taxon_BiologicalDatabaseEntry_name=Homo sapiens
@BiologicalDatabaseEntry_taxon_BiologicalDatabaseEntry_url=http://www.uniprot.org/taxonomy/9606
@BiologicalDatabaseEntry_taxon_BiologicalDatabaseEntry_entryID=9606
@MedicalCondition_code_MedicalCode_codeValue=Q87.4
@MedicalCondition_code_MedicalCode_codingSystem=ICD-10
```



