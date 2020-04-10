<?php
$myDirectory = '.' ;                           //the script works from the current directory
//this script is to be run from within the directory wwhere the list of journal IDs, created with 'mx Title "pft=v30/" now -all >IDs.list, is saved.
    $lines="";
    $lastline=0;
    $iline=0;

foreach(glob("$myDirectory/*.list") as $file) {          // MAIN LOOP for each .list-file in current directory
    $lines=file($file);                              // array $lines contains all lines of text-file
    $lastline=count($lines);
    for ($iline=0; $iline<=$lastline-1; $iline++) { // main loop for all lines in the file
          $line=$lines[$iline];                      // put the current line in $line
          $command = "./shortcut.bat $line";
          exec($command);
  echo "Holdings record created for journal $line\n";
    }
}                                         // end of loop for all files in directory
  echo "Holdings creation for all journals finished\n";
?>