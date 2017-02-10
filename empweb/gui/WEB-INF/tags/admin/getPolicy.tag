<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="io" uri="http://jakarta.apache.org/taglibs/io-1.0" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>

<%@ tag body-content="empty" %>
<%@ attribute name="id" required="true" %>

<io:soap url="${config['ewengine.admin_service']}" SOAPAction="" encoding="UTF-8">
  <io:body>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
      <soapenv:Body>
        <getPolicy xmlns="http://kalio.net/empweb/engine/admin/v1">
          <id>${fn:trim(id)}</id>
        </getPolicy>
      </soapenv:Body>
    </soapenv:Envelope>
  </io:body>
</io:soap>
