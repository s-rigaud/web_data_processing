<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="2.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" indent="yes" doctype-system="info.dtd" version="1.0"/>

    <!-- Put continents in pile -->
    <xsl:template match="/">
        <bilan-continents>
            <xsl:apply-templates select="/covid-eu/country_list/continent" />
        </bilan-continents>
    </xsl:template>

    <!-- For each continent, extract records where some data concerned some of its countries-->
    <xsl:template match="continent">
        <continent name="{@name}" population="{sum(./country/@population)}" area="{sum(./country/@area)}">

            <!-- Only month that contains data about the continent's countries-->
            <xsl:apply-templates select="/covid-eu/record_list/year/month[day/record/@country = current()/country/@xml:id]">
                <xsl:sort select="concat(../@no, '-', ./@no)" />
                <xsl:with-param name="country_ids" select="./country/@xml:id"/>
            </xsl:apply-templates>
        </continent>
    </xsl:template>

    <!-- For each month, sum and display data-->
    <xsl:template match="month">
        <xsl:param name="country_ids" />
        <xsl:variable
            name="records"
            select="/covid-eu/record_list/year[@no = current()/../@no]/month[@no = current()/@no]/day/record[@country = $country_ids]"
        />

        <month
            no="{concat(../@no, '-', @no)}"
            cases="{sum($records/@cases)}"
            deaths="{sum($records/@deaths)}"
        />
    </xsl:template>

</xsl:stylesheet>
