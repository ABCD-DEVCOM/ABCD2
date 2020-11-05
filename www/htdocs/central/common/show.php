<html>
 <script>
        window.oncontextmenu = function () {
            console.log("Right Click Disabled");
            return false;
        }
    </script>

<body>
<embed src="http://localhost:9090/bases/WWWISIS-IsisScript-en.pdf#toolbar=0&navpanes=0&scrollbar=0" width="500" height="500"  style="border:0;pointer-events:none;" >'

<hr>
// Store the file name into variable
$file = '/abcd/www/htdocs/bases/WWWISIS-IsisScript-en.pdf';
$filename = 'WWWISIS-IsisScript-en.pdf';

// Header content type
header('Content-type: application/pdf');

header('Content-Disposition: inline; filename="' . $filename . '"');

header('Content-Transfer-Encoding: binary');

header('Accept-Ranges: bytes');

// Read the file
@readfile($file);


