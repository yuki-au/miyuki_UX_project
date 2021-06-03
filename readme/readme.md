# Match 

## Introduction 

>This web application “match” is a shopping website aims at women that sells items collated by category list the user creates. 
Each user creates a category list as they register and log-in. Category list contains multiple categories. In this prototype, I created unique categories which represent moods such as “cheerful”, “mysterious”, “Energistics”, “Peaceful” and more. 
This feeling category aims to make users who are not looking for specific things narrow down their potential needs by their current mood category.  

## features

- Mood category list
- The consistancy of the colours
- Shopping web app


## Technical implementation matters
the shopping application Match includes the followting components:

- Login 
- Register 
- Category list (Register/Update)
- Shopping screen 

Match is created by the follwing technoligies:

UserInterface:
- Bootstrap 
- Javascript

Back-end 
- PHP
- symfony 
- composer



## Each file contents

#### UX2(UI)/Project2(PHP)

1. index.html

    It contains 5 pages. 
    Sign in page/Register page/Category list page (part of registration part)/Shopping page/Update category list page 


2. JS folder 
app.js - used to integrate the user interface and each php file 
function.js - includes the functions to control the web application  

 

3. CSS folder 
Style.css  

 

4. Image folder 
Contains the graphical elements used in my user interface 

 

5. Api folder 

api.php  - responsible for main routing, contains http response and output json 
db.php -used to manipulate database. 
se.php - used to manage session information and secure the app 


6. Admin folder 
admin-api.php - responsible for main routing, contains http response and output json for admin panel
db.php -used to manipulate database from admin panel 
se.php - used to manage session information and secure the app for admin panel 



#### Project3(Admin panel)
In src folder 
1. component folder
includes the menu component for the admin panel

2. image folder
Contains the graphical elements used in my admin panel

3. routes folder
includes adminlogin, dashboard, logout, product and user js files 

4. App.css

5. App.js

6. index.css

7. index.js
file to store main Render call from ReactDOM.

↓I haven't touched the following folder for the project
- App.test.js
- Panel.js
- react-app-env.d.ts
- reactWebVitals.js
- setupTests.js
- Title.js


## Installation 

### UX3/Project2 installation and set up  

* Download Symfony
https://symfony.com/download 

1. Install wamp / Set up

2. Import the folder with your www folder

3. Open new terminal in your code editor 

4. Install composor with your terminal
```
composer install
```

*  Install symfony http foundation with your terminal 
```
composer require symfony/http-foundation
```

### PROJECT3 admin panel installation 

1. Import whole project3 folder

2. Install node.js

3. Open Command prompt 

4. Go to this file directly
```
cd this folder name
```

5. Run the following command

```
npm install --save react
```

```
npm start 
```


# All Technologies I used in Application 

-Local server 
Wamp v3.2.3.0

- UX2
Bootstrap v5.0 
Fontawesome v5.6.1

- Project2 
php 7.4.19
apache 2.4.46
symfony v4.23.2
composer 2.0.11

- Project3 Admin panel
node.js 14.17.0 LTS  
react 17.0.2
Material-UI v4.11.1 
Formik(for validation) v2.2.8







 