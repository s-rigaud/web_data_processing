
#### ! Install dependencies
# sudo apt install python3-pip libxml2-utils
# pip3 install xmldiff
# Make sure you have php-dom installed !

echo "Look in the tp.sh file if you are missing one dependency"

echo "Running the 1.1 Question -> Java XSLT"
echo "Computing time taken"
if time java -jar saxon9he.jar -xsl:xslt.xsl -s:covid-tp.xml > info_xslt_process.xml; then
    echo "Result in file info_xslt_process.xml"
    if xmllint --noout --dtdvalid info.dtd info_xslt_process.xml ; then
        echo "Result is valid to DTD"
    fi

    if xmldiff info.xml info_xslt_process.xml ; then
        echo -e "Result match exactly what is inside covid-tp.xml file\n"
    fi
fi

echo "■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■"
echo "Running the 1.2 Question -> PHP Sax"
echo "Computing time taken"
if time php sax.php > info_sax_php_process.xml; then
    echo "Result in file info_sax_php_process.xml"
    if xmllint --noout --dtdvalid info.dtd info_sax_php_process.xml; then
        echo "Result is valid to DTD"
    fi

    if xmldiff info.xml info_sax_php_process.xml; then
        echo -e "Result match exactly what is inside covid-tp.xml file\n"
    fi
fi

echo "■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■"
echo "Running the 1.2 Question -> PHP DOM"
echo "Computing time taken"
if time php dom.php > info_dom_php_process.xml; then
    echo "Result in file info_dom_php_process.xml"
    if xmllint --noout --dtdvalid info.dtd info_dom_php_process.xml; then
        echo "Result is valid to DTD"
    fi

    if xmldiff info.xml info_dom_php_process.xml; then
        echo -e "Result match exactly what is inside covid-tp.xml file\n"
    fi
fi

echo "■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■"
echo "Running the 1.2 Question -> PHP DOM/XPATH"
echo "Computing time taken"
if time php dom.php > info_dom_xpath_php_process.xml; then
    echo "Result in file info_dom_xpath_php_process.xml"
    if xmllint --noout --dtdvalid info.dtd info_dom_xpath_php_process.xml; then
        echo "Result is valid to DTD"
    fi

    if xmldiff info.xml info_dom_xpath_php_process.xml; then
        echo -e "Result match exactly what is inside covid-tp.xml file\n"
    fi
fi
