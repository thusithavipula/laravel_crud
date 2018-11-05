## About This project

This is a simple web application made using Larave 5.5 to manage Students, Instructors and Subjects in a simple environment

Installation 
- Copy .env.example to .env 
- Run php artisan migrate --seed to buld the db
- run php artisan serve
- That should be all

If test data is needed run these factory commands
- factory('App\Instructor', 50)->create();
- factory('App\Subject', 50)->create();
- factory('App\Student', 50)->create();

Login 
- Username : admin@email.com
- Password : 123456

Todo 
Improve the user role module to integrate it with Student and Instructors for multiple user role management 
Have to learn about updated laravel 5.5 test cases to write better unit tests
