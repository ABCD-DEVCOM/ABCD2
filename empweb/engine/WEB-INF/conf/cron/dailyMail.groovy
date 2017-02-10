

/*
 * TODO: no contempla los titulos de los objetos. Agregar usando getMODS pero reevaluara para que sea eficiente
 */

/*
 Sends a daily notification to each user that has:
    late loans
    upcoming returns
    upcoming reservations

*/


/* ---------------------------------------------------- */
/* MailContents class                                   */ 
class MailContents
{
    /* date format */
    def dateFormatter = new java.text.SimpleDateFormat("dd-MM-yyyy")

    def logger   = null
    def contents = [:]
    def engine   = new groovy.text.SimpleTemplateEngine()

    def mailTemplate = engine.createTemplate('''
A contunuación le enviamos un resumen de su situación en biblioteca.

${getStatus(user)}

Este e-mail ha sido enviado por el Sistema de Préstamos de Biblioteca.
''')
    
    def titleMsgs = [
        'LateLoan'   :"Prestamos atrasados:\n",
        'Loan'       :"Proximos vencimientos de prestamos:\n",
        'Reservation':"Proximas reservas:\n"
    ]
    def itemMsgs = [
        'LateLoan'           : engine.createTemplate('''   * $endDate $recordId ($location)\n'''),
        'UpcomingReturn'     : engine.createTemplate('''   * $endDate $recordId ($location)\n'''),
        'UpcomingReservation': engine.createTemplate('''   * $endDate $recordId ($location)\n'''),
    ]

    def appendLateLoan(Loan loan)
    {
        def userId = loan.getUserId();
        def userDb = loan.getUserDb();
        def binding = [
            userId      : loan.getUserId(),
            endDate     : formatDate(loan.getEndDate()),
            location    : loan.getLocation(),
            recordId    : loan.getRecordId()
        ]
        /* recordTitle = getMODS(recordId, loan.getObjectDb()); */
        if (!contents[userId+userDb])
        {
            contents[userId+userDb] = [:]
            contents[userId+userDb]['LateLoans'] = ""
        }
        contents[userId+userDb]['LateLoans'] = contents[userId+userDb]['LateLoans'] + itemMsgs['LateLoan'].make(binding);
    }

    def appendUpcomingReturn(Loan loan)
    {
        def userId = loan.getUserId();
        def userDb = loan.getUserDb();
        def binding = [
            userId      : loan.getUserId(),
            endDate     : formatDate(loan.getEndDate()),
            location    : loan.getLocation(),
            recordId    : loan.getRecordId()
        ]
        /* recordTitle = getMODS(recordId, loan.getObjectDb()); */
        if (!contents[userId+userDb])
        {
            contents[userId+userDb] = [:]
            contents[userId+userDb]['UpcomingReturns'] = ""
        }
        contents[userId+userDb]['UpcomingReturns'] = contents[userId+userDb]['UpcomingReturns'] + itemMsgs['UpcomingReturn'].make(binding);
    }
    
    def appendUpcomingReservation(Reservation reservation)
    {
        def userId = reservation.getUserId();
        def userDb = reservation.getUserDb();
        def binding = [
            userId      : reservation.getUserId(),
            endDate     : formatDate(reservation.getEndDate()),
            location    : reservation.getObjectLocation(),
            recordId    : reservation.getRecordId()
        ]
        /* recordTitle = getMODS(recordId, loan.getObjectDb()); */
        if (!contents[userId+userDb])
        {
            contents[userId+userDb] = [:]
            contents[userId+userDb]['UpcomingReservations'] = ""
        }
        contents[userId+userDb]['UpcomingReservations'] = contents[userId+userDb]['UpcomingReservations'] + itemMsgs['UpcomingReservation'].make(binding);

    }

    def formatDate(ts)
    {
        return dateFormatter.format(Calendars.parseTimestamp(ts).getTime())
    }

    def getUsers()
    {
        return contents.keySet()
    }

    def getStatus(user)
    {
        String content = "\n"
        if(contents[user]['LateLoans'])
          content = content + titleMsgs['LateLoan'] + contents[user]['LateLoans'] + "\n"
        if(contents[user]['UpcomingReturns'])
          content = content + titleMsgs['UpcomingReturn'] + contents[user]['UpcomingReturns'] + "\n"
        if(contents[user]['UpcomingReservations'])
          content = content + titleMsgs['UpcomingReservation'] + contents[user]['UpcomingReservations'] + "\n"
        return content
    }

    def getMail(userId,userDb)
    {
        def binding = [
            userId : userId
            userDb : userDb
            userName : net.kalio.empweb.engine.util.EngineUtil.getUserDOM(user
        ]
        return mailTemplate.make(binding)
    }

    def print()
    {
        String r = "";
        contents.keySet().each() { user ->
                r = r + getMailContent(user)+"\n"
        }
        return r
    }

}
/* end MailContents                                     */ 
/* ---------------------------------------------------- */


def smtpServer = params.get("smtpServer")
def from       = params.get("from")
def replyTo    = (params.get("replyTo"))?params.get("replyTo"):from

/* check required info */
if (!smtpServer)
{
    logger.warning("smtpServer parameter missing for cron '${filePath}'")
    throw new Exception("smtpServer parameter missing")
}

if (!from)
{
    logger.warning("from parameter missing for cron '${filePath}'")
    throw new Exception("from parameter missing")
}

/* object to store user mail contents.  */
MailContents mailContents = new MailContents();
mailContents.logger = logger;

/* get late loans and put them in the list */
Loan lateLoanF = ewof.createLoan()
GregorianCalendar gcNow = new GregorianCalendar()
lateLoanF.setEndDate("<"+Calendars.getFullTimestamp(gcNow));
List lateLoans = ewdb.listCurrentTransactions(lateLoanF);
lateLoans.each() { loan -> 
        mailContents.appendLateLoan(loan)
}


/* get upcoming returns for the next day */
Loan upcomingReturnF = ewof.createLoan()
GregorianCalendar gcRet = new GregorianCalendar()
gcRet.add(Calendar.DAY_OF_MONTH,2)
upcomingReturnF.setEndDate(">"+Calendars.getFullTimestamp(gcNow)+"<"+Calendars.getFullTimestamp(gcRet));
List upcomingReturns = ewdb.listCurrentTransactions(upcomingReturnF);
upcomingReturns.each() { loan -> 
        mailContents.appendUpcomingReturn(loan)
}


/* get upcoming reservations */
Reservation upcomingReservationF = ewof.createReservation()
GregorianCalendar gcRes = new GregorianCalendar()
gcRes.add(Calendar.DAY_OF_MONTH,2)
upcomingReservationF.setStartDate("<"+Calendars.getFullTimestamp(gcRes));
List upcomingReservations = ewdb.listCurrentTransactions(upcomingReservationF);
upcomingReservations.each() { reservation -> 
        mailContents.appendUpcomingReservation(reservation)
}


/*  debug */
/* System.out.println("a ver:"+mailContents.print()) */

/* send mails */ 
mailContents.getUsers().each() { user -> 
    System.out.println("user:"+user+"\n"+mailContents.getMailContent(user))
    def message = header + 
}

