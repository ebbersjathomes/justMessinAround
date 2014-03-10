justMessinAround
================

A simple PHP project that uses Epiphany framework. Allows basic crud operations on a user table. 

Setup Intruction
<ul>
  <li>Include or create the correct .config file from /apache/ into your apache httpd.conf file.
  <li>Edit your hosts file to point php.codesample.loc to 127.0.0.1
  <li>Import the Data schema located in /schema/sample_user.sql into your mysql instance.
  <li>Modify /lib/class/mySql/mySqlFactory.php with your MySQL connection infortmation
  <li>Once everything has been imported and set up run http://php.codesample.loc/editUser
</ul>
