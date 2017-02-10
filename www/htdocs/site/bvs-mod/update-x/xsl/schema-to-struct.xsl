<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:xs="http://www.w3.org/2001/XMLSchema">

	<xsl:output method="xml" indent="yes"/>

	<xsl:template match="xs:schema | xs:sequence">
		<xsl:apply-templates/>
	</xsl:template>

	<xsl:template match="xs:simpleType | text()"/>

	<xsl:template match="xs:element">
		<xsl:element name="element">
			<xsl:attribute name="name"><xsl:value-of select="@name"/></xsl:attribute>
			<xsl:apply-templates select="@maxOccurs"/>
			<xsl:apply-templates/>
		</xsl:element>
	</xsl:template>

	<xsl:template match="xs:element[@type]">
		<xsl:element name="edit">
			<xsl:attribute name="name"><xsl:value-of select="@name"/></xsl:attribute>
			<xsl:apply-templates select="@type"/>
		</xsl:element>
	</xsl:template>

	<xsl:template match="xs:element[@type and @maxOccurs = 'unbounded']">
		<xsl:element name="element">
			<xsl:attribute name="name"><xsl:value-of select="@name"/></xsl:attribute>

			<xsl:choose>
				<xsl:when test="starts-with(@type,'xs:')">
					<xsl:attribute name="repeat">list</xsl:attribute>
					<xsl:element name="edit">
						<xsl:attribute name="name">text()</xsl:attribute>
						<xsl:apply-templates select="@type"/>
					</xsl:element>
				</xsl:when>
				<xsl:otherwise>
					<xsl:attribute name="repeat">select</xsl:attribute>
					<xsl:apply-templates select="@type"/>
				</xsl:otherwise>
			</xsl:choose>
		</xsl:element>
	</xsl:template>

	<xsl:template match="xs:element[xs:complexType/xs:sequence/xs:any] | xs:element[@type = 'textarea']">
		<xsl:element name="edit">
			<xsl:attribute name="name"><xsl:value-of select="@name"/></xsl:attribute>
			<xsl:element name="textarea">
				<xsl:attribute name="cols">70</xsl:attribute>
				<xsl:attribute name="rows">12</xsl:attribute>
			</xsl:element>
		</xsl:element>
	</xsl:template>

	<xsl:template match="xs:element[xs:complexType/xs:sequence/xs:any and @maxOccurs = 'unbounded'] | xs:element[@type = 'textarea' and @maxOccurs = 'unbounded']">
		<xsl:element name="element">
			<xsl:attribute name="name"><xsl:value-of select="@name"/></xsl:attribute>
			<xsl:attribute name="repeat">list</xsl:attribute>
			<xsl:element name="edit">
				<xsl:attribute name="name">text()</xsl:attribute>
				<xsl:element name="textarea">
					<xsl:attribute name="cols">70</xsl:attribute>
					<xsl:attribute name="rows">12</xsl:attribute>
				</xsl:element>
			</xsl:element>
		</xsl:element>
	</xsl:template>
	
	<xsl:template match="@maxOccurs"/>

	<xsl:template match="@maxOccurs[. = 'unbounded']">
		<xsl:attribute name="repeat">list</xsl:attribute>
	</xsl:template>

	<xsl:template match="xs:complexType">
		<xsl:apply-templates select="xs:attribute"/>
		<xsl:apply-templates select="xs:sequence"/>
	</xsl:template>

	<xsl:template match="xs:attribute">
		<xsl:element name="edit">
			<xsl:attribute name="name"><xsl:value-of select="concat('@',@name)"/></xsl:attribute>
			<xsl:apply-templates select="@type"/>
		</xsl:element>
	</xsl:template>

	<xsl:template match="@type">
		<xsl:variable name="type" select="."/>
	
		<xsl:choose>
			<xsl:when test="starts-with($type,'xs:')"/>
			<xsl:when test="//xs:simpleType[@name = $type]/xs:restriction/xs:enumeration">
				<xsl:apply-templates select="//xs:simpleType[@name = $type]/xs:restriction" mode="typed">
					<xsl:with-param name="maxOccurs" select="../@maxOccurs"/>
				</xsl:apply-templates>
			</xsl:when>
			<xsl:otherwise>
				<xsl:comment>[schema-to-struct] type not found: "<xsl:value-of select="$type"/>"!</xsl:comment>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>

	<xsl:template match="xs:restriction" mode="typed">
		<xsl:param name="maxOccurs"/>
	
		<xsl:variable name="countEnumeration" select="count(xs:enumeration)"/>
	
		<xsl:choose>
			<xsl:when test="not($maxOccurs) and $countEnumeration &lt;= 2">
				<xsl:apply-templates select="xs:enumeration" mode="radio"/>
			</xsl:when>
			<xsl:when test="$maxOccurs and $countEnumeration &lt;= 5">
				<xsl:apply-templates select="xs:enumeration" mode="checkbox"/>
			</xsl:when>
			<xsl:otherwise>
				<xsl:element name="select">
					<xsl:apply-templates select="xs:enumeration"/>
				</xsl:element>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>

	<xsl:template match="xs:enumeration">
		<xsl:element name="option">
			<xsl:attribute name="value"><xsl:value-of select="@value"/></xsl:attribute>
			<xsl:value-of select="@value"/>
		</xsl:element>
	</xsl:template>

	<xsl:template match="xs:enumeration" mode="radio">
		<xsl:element name="input">
			<xsl:attribute name="type">radio</xsl:attribute>
			<xsl:attribute name="value"><xsl:value-of select="@value"/></xsl:attribute>
		</xsl:element>
		<xsl:value-of select="@value"/>
	</xsl:template>

	<xsl:template match="xs:enumeration" mode="checkbox">
		<xsl:element name="input">
			<xsl:attribute name="type">checkbox</xsl:attribute>
			<xsl:attribute name="value"><xsl:value-of select="@value"/></xsl:attribute>
		</xsl:element>
		<xsl:value-of select="@value"/>
	</xsl:template>

</xsl:stylesheet>
