# reglog
OOP Login and registration system that allows file upload to Google Cloud bucket using JSON API

# Description
This is just a simple PHP OOP login and registration system, that you can tweak to your taste.

The purpose of the task is to be able to upload files to Google Cloud Bucket and also to fetch the objects from the bucket.
# Simple Flow
A user login or register on the platform (if don't have an account before).
He is directed to the dashboard where he see an upload form... On media file (only accept, image, audion, and video) upload a frontend(jquery), and backend(php) check is made to validate the submission. On success, PHP make a cURL call to Google Cloud JSON API, to upload it on the project bucket.

- The user can move the media file uploaded to thrash, that means it should no longer show on the dashboard. All this are simplified with jQuery Ajax.

- The user can as well restore the media file back to file manager.

# What you need
<a href="https://cloud.google.com/" target="_blank">Create a project on Google cloud</a> with your Gmail Account if you don't have.

Follow the quickstart tutorial on the dashboard, it is very simple to create a bucket, the bucket will serve as a container for the files you will be uploading... You can create many buckets as you wish.

I am hosting the script on <a href="heroku.com" target="_blank">Heroku</a> You will need to create an account for that if you don't already have... And to manage the MySQL, this was achieved using Heoku Addon(ClearDB), please if all this are strange, you can google them up. I can also be available to put you through.<strong>LIKE I SAID, THIS RESPOSITORY WAS CREATED FOR A TASK.</strong>

# Configuration
Download the script on your local drive, and enter the <strong>core</strong> and open the  <strong>init</strong> Change the host, username, password that was generated for you from ClearDB or you will be using.

Open the process.php on the root folder, and enter the Google OAuth Token, which was created for you while creating the project on Google Cloud Bucket, you can also generate one here which will always be regenerated every 3600secs. >>> <a href="https://developers.google.com/oauthplayground/" target="_blank">Google OAuth Playgroud</a>.

# Database
Upload the reglog.sql to the database you created. if created using Heroku addon(ClearDB), you can achieve that with Workbench.

# All well and good?
Navigate to the project URL on your browser...

