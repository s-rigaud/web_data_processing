java -jar saxon9he.jar -xsl:test.xsl -s:covid-tp.xml > info_xsl_process.xml
time //
xmldiff info.xml info_xsl_process.xml

php test.php
time //

sudo apt install python3-pip
pip3 install xmldiff
