## Web des données - TP

###### Author

Samuel Rigaud & Gaetan Pellerin

###### Project

The main goal of this work is to exploit provided Covid19 XML data structure with XSLT, XPATH, SAX & DOM to find the best suitable process in term of time and memory complexity.

## Question 1 & 2 -> ./tp.sh

## Question 3

"After 10 tries, SAX seems to be the faster solution (two times faster than DOM or DOM/XPATH and 20 times faster than java XSLT)"
La solution SAX est la plus rapide. Cependant comme la structure attendue nécessite l'utilisation d'une liaison entre deux éléments éloignés du modèle
il est nécessaire de garder en mémoire un grand nombre d'information concernant les continents et les pays qui les composent avant de pouvoir enfin attribuer à chaque mois le nombre de cas et de décès de chaque continent. La solution faisant appel à DOMXpath est quelque peu contraingnante vu qu'elle repose sur XSLT 1. Un grand nombre d'opération doit donc être fait via l'utilisation du DOM ou des structures de données PHP. Enfin la solution basée sur XSLT est la plus lente mais elle repose sur la JVM qui est considérée comme plus lente que PHP7 donc la comparaison est plus complexe. Cette dernière solution est la plus complexe à aborder pour un développeur lambda car elle ne fait pas appel aux connaissances basique d'un langage de programmation populaire et une nouvelle logique est à appréhender : pile d'éléments, règles de traitements implicites, priorité du dépilement ....
On a gardé le fichier original avec l'écriture avec un exposant.