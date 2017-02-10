<user>
<id><?php echo $row[0]; ?></id>
<name><?php echo utf8_encode($row[1].", ".$row[2]); ?></name>
<userClass><?php echo $row[3]; ?></userClass>
<expirationDate><?php echo $row[4]; ?></expirationDate>
<login><?php echo $row[5]; ?></login>
<password><?php echo $row[6]; ?></password>
</user>