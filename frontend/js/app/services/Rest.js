(function(w, _) {
    var baseRestMethods = {
        all: {method: 'GET', isArray: true}
        , update: {method: 'PUT'}
        , create: {method: 'POST'}
    };

    var rest = angular.module('rest', ['ngResource']);

    // Teacher
    rest.factory('Teacher', ['$resource', function($resource) {
        return $resource('/rest/teachers/:id', {}, _.extend(baseRestMethods, {
            getCount: {
                method: 'GET'
                , url: '/rest/teachers/count'
            }
            , getAprilStudents: {
                method: 'GET'
                , url: '/rest/teachers/april-born'
                , isArray: true
            }
        }));
    }]);

    // Student
    rest.factory('Student', ['$resource', function($resource) {
        return $resource('/rest/students/:id', {}, _.extend(baseRestMethods, {
            getCount: {
                method: 'GET'
                , url: '/rest/students/count'
            }
        }));
    }]);

    rest.factory('StudentTeacher', ['$resource', function($resource) {
        return $resource('/rest/student-teacher', {}, _.extend(baseRestMethods, {

        }));
    }]);

    // Language Level
    rest.factory('LanguageLevel', ['$resource', function($resource) {
        return $resource('/rest/language-levels', {}
            , _.extend(baseRestMethods, {})
        );
    }]);

})(window, _);
