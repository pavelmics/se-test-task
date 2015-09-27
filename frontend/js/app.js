var app = angular.module('skyeng', [
    'ngRoute'
    , 'ngResource'
    , 'templates'
    , 'initialValue'
    , 'ngTable'

    // my own modules and services
    , 'controllers'
    , 'rest'
]);

app.config(['$routeProvider', '$locationProvider'
    , function($routeProvider, $locationProvider) {
        $routeProvider
            // rules for routing
            .when('/', {
                templateUrl: 'app/views/home.html',
                controller: 'HomeController'
            })
            .when('/teachers', {
                templateUrl: 'app/views/teachers.html',
                controller: 'TeachersController'
            })
            .when('/teachers/add', {
                templateUrl: 'app/views/add-teacher.html',
                controller: 'AddTeacherController'
            })
            .when('/teachers/april', {
                templateUrl: 'app/views/teachers-april.html'
                , controller: 'TeachersAprilController'
            })
            .when('/teachers/:id', {
                templateUrl: 'app/views/teacher-details.html',
                controller: 'TeacherDetailsController'
            })

            .when('/students', {
                templateUrl: 'app/views/students.html',
                controller: 'StudentsController'
            })
            .when('/students/add', {
                templateUrl: 'app/views/add-student.html',
                controller: 'AddStudentController'
            })
            // use this "redirect" if neither of patterns haven`t matched
            .otherwise({
                templateUrl:'app/views/404.html'
            });
        $locationProvider.html5Mode(true);
    }]);

// define modules
angular.module('controllers', []);
angular.module('rest', []);