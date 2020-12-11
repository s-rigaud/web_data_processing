
#### ! Install dependencies
# sudo apt install python3-pip libxml2-utils
# pip3 install xmldiff


# run the 1.1 Question
java -jar saxon9he.jar -xsl:test.xsl -s:covid-tp.xml > info_xsl_process.xml
# Test if result follow dtd
xmllint --noout --dtdvalid info.dtd info_xsl_process.xml
# Test if result corresponds to target xml
xmldiff info.xml info_xsl_process.xml
# Compute transformation process time
time java -jar saxon9he.jar -xsl:test.xsl -s:covid-tp.xml > info_xsl_process.xml

# run the 1.2 Question
php test.php > info_sax_php_process.xml
# Test if result follow dtd
xmllint --noout --dtdvalid info.dtd info_sax_php_process.xml
# Test if result corresponds to target xml
xmldiff info.xml info_sax_php_process.xml
# Compute transformation process time
time php test.php


