justMessinAround
================

A simple PHP project that uses Epiphany framework. Allows basic crud operations on a user table. 

To start it up include or create the correct .config file from /apache/ into your apache httpd.conf file.
Edit your hosts file to point php.codesample.loc to 127.0.0.1
Import the Data schema located in /schema/sample_user.sql into your mysql instance. 
Modify /lib/class/mySql/mySqlFactory.php with your MySQL connection infortmation

Once everything has been imported and set up run http://php.codesample.loc/editUser

You have a simple html page that supports basic CRUD operations
