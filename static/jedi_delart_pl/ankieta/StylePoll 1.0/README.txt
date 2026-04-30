				©Style poll 1.0 Installation Instructions
					     www.stylusinc.com
					Email contact: stylusinc@aol.com



Please read the license agreement before installing this script for payment and other licensing information. The license agreement is included in a file called license.htm in this zip file.



System requirements:
a.Windows NT workstation/95/98 with PWS 
 or Windows NT with IIS 4.0 
b. MS Access



 
1.  Create a folder on your server under the present site location where you want to set up the         poll. The folder name can be like "poll" for example e:\databases\polldb\
2.  Unzip the StylePoll 1.0.zip you downloaded 
3.  Place the database, StylePoll.MDB in "polldb" folder. You don't
    have to set up any special permissions on this folder.
4.  Create a SYSTEM DSN (a Data Source Name that is specific to
    the machine on which it resides). To do this, do these:
	1:	Goto START/SETTINGS/CONTROL PANEL in your machine
	2:	ODBC (maybe 32-Bit ODBC, depending on how your machine 
		named it)
	3:	Click on the tab marked SYSTEM DSN.
	4:	Click on ADD
	5:	Microsoft Access Driver, then FINISH
	6:	In DataSource Name box, type stylepolldsn
	7:	Click the SELECT Button
	8:	Go to e:\databases\polldb\ in the right window
	9:	Select StylePoll.mdb in the left Window
       10:	You will see the filename next to "Database"
		list the file e:\databases\polldb\styllpoll.mdb
       11:	Click OK
       12:	Now you will see stylepolldsn in the list of sources
       13:	Click OK
       14:	Now You've done setting up the Data Source.

5.   Create a folder in your server folder called Discussion.
     Thus, the path will probably be 
	       c:\InetPub\wwwroot\poll

6.   Copy all of the .asp and global.asa files into this directory. 


7.   Create another folder in your server under c:\InetPub\wwwroot\ and copy PollAdmin.asp,                      GeneratePoll.asp & GenerateForm.asp. These three files are used to generate the polls                      that should be away from the user to access by the browser.For example    				c:\InetPub\wwwroot\poll_admin_directory\

8.   You should be ready to go now. Now open up a browser
     and type the URL,
	        http://yourservername/poll_admin_directory/PollAdmin.asp

9.   Start using the admin to create new polls.
10.  Open poll.asp, You can test and Use the poll.
11.  If you want the poll to appear in another excisting webpage copy the poll.asp and results.asp,   
     Global.asa and images folder into the same folder where the existing webpage is located. Open the asp file in any editor, where you can find the code to cut and paste. You can use the code between the  comment tags and you can use it at your desired location.
	 Keep the image files under the images folder itself.  If you want to change the location  you need to edit the results.asp to change the location of the images. Open the poll.asp file in a text editor, go through the code,
	 where you will find a BEGIN - END comment tags. Cut and paste all the code resides between thses comment tags in to your desired location in your webpage.
 	 If you want to add the poll into your excisting webpage open the poll.asp
     	 
     Any other problem and bugs please report at  stylusinc@aol.com .


