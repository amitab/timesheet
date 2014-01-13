# Getting started.
See Getting started to setup your application.
Drop in your application into your apache web folder to have your first multi-channel application on the Native5 Platform.

#Accessing the application
Credentials for demo application : demo/demo

#Structure (Understanding the app folder hierarchy)
* controllers   # Store your request handlers for incoming web requests.
* models        # Application specific data structures
* views         # Store all your dynamic UX content here.
    ** templates # Twig markup based templates
    ** resources # JS/CSS (Can also include SASS files) 
* libs          ##  Reusable application code.
* index.php     # Entry point for Application
* config        # Configuration
* composer.json # Define your third party libraries/dependencies which can be downloaded using composer.
* .htaccess     # Used by Apache to redirect incoming calls onto index.php #Change at own risk. 
