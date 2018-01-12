##Activity-sniper
![Image of screenshot]
(https://github.com/jczzz/ActivitySniper-SocialMediaApp/blob/master/Screen%20Shot%202.png)


URL: localhost:9000/index.php/


initial admin user:

	email: admin@admin.com

	password: admin
	
3 initial regular accounts that you can use once the system is ready:

  	email: hza83@sfu.ca

	password: 12345
	
	email: junbob@sfu.ca

	password: 12345
	
	email: zgeng@sfu.ca

	password: 12345


Register page:

	1. Users can input their information to create a new account. 
	(Firstname must be entered,
	 Lasttname must be entered,
	 Password must be entered,
	 Email must be entered and unique,
	 Phone Number (if entered) must in the specified format)

	2. Users can upload a picture for their account. (default picture is a smiling face)


Login page: Users can log into the application by typing email and password.


Admin page: 

If the user logged in as admin(email:admin@admin.com, password:admin),
The page will list all registered users, and admin can view a user's information and can delete a user.

Each user (admin or regular users) can 
    see own account information, edit own account information by clicking 'view your account' in the right-up corner.
    
Each user can leave comments on all other people's account informaiton page when visiting the information page(including himself).
The leaved comments can be seen by everyone.

Each regular user can send messages to all people other than himself in the information page of the other people,
and other people will get the messages by clicking the messages button in the header.
(the number in the button will show how many people have sent him messages). After clicking 'view all conversation with this person', 
the number will drop by 1.

Activity List page: This is the main page for each user. User can see their joined activities and their own activities.

	1. User can edit or delete their own activities.

	2. User can cancel their joined activities.

	3. User can create a new activity by clicking on "Add a new activity"

	4. User can see all activities in database by clicking on "See All activities"

	5. User can see his/her friends by clicking on "Friend List".

	6. User can see detail joined activities information by clicking on the google map dots or clicking on the name of activity or clicking on the date of calendar.


Add a new activity page:

	1. User can input the information to create a new activity.

	2. User can get some hints (address auto complete) in the input field of address.

	3. User can show the chosen address on the google map.

	4. User can upload a picture for this activity.


See all activities page:

	1. User can see all activities which are in database.

	2. User can type the key word to search the specified activities.

	3. User can join into activities by clicking on "join".

	4. User can edit or delete their own activities by clicking on "Delete" or "edit"

	5. User can see the detail information for each activity by clicking on the name of activity.

	6. User can see the location of all searched activities in the google map, and can also see the details of each activity by clicking on "show details".

	7. User can see the information of activities' owner by clicking on their email.

	8. User can go back to the "main page" by clicking on "Back to your activities".

	9. When searching the wanted activities, user can check some additional time requirement, to search activities more detaily


Friend list page:

	1. User can see all friend's email in this page.

	2. User can see the detail information of each friend by clicking on their email.


activity owner information page:

	1. User can see the information of activity owner.

	1. User can add activity owner into friend list.

	2. If this activity owner is already the friend of user, user can see his/her activities or delete this friend from friend list.


Activity information page:

	1. User can see the information of this activity.

	2. User can see the location of this activity on the google map.

	3. User can add some comments in the bottom.

	4. User can see all the participants for this activities, and click their email to see the information page of this person.

    
Calendar:

    1. There is a big calendar in 'My Activities' and 'All Activities' page to show all activities in corresponding time slot in the calendar

    2. User can click a activity in the calendar to see the detaild infomation page of the activity.
