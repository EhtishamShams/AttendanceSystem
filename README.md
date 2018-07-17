# AttendanceSystem
PHP Training Project

This Project uses the raw PHP, mySQL and Bootstrap 4 to create an Attendance Management System.

Before using this site use the 'db_dump.sql' file to create the database schema on your server. As, all the passwords are encrypted so you'll simply see hashes of passwords in the DB. All current accounts have the password 'test'.

The scripts 'lateEmail.php' and 'absentEmail.php' will be used in cron jobs to excecute on 11:00 and 12:00 repectively on each workday. The site is secured so that no user can access any other user's data. Admin panel can only be accessed by the users having the designation 'HR Manager'.

The 'admin' folder contains all the admin panel files for HR Manager.
