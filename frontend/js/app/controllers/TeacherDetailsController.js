(function(w, $) {

    var factory = function($scope, $routeParams, $location, Teacher, Student
                            , StudentTeacher) {
        var teacherId = $routeParams.id;
        $scope.teacher = {};
        $scope.student = false;

        $scope.loadTeacher = function() {
            Teacher
                .get({id: teacherId})
                .$promise
                .then(function(res) {
                    $scope.teacher = res;
                }, function(res) {
                    if (404 === res.status) {
                        $scope.notFound = true;
                    }
                });
        };

        $scope.initStudentSearch = function() {
            $('#student-search').autocomplete({
                serviceUrl: '/rest/students/search'
                , minChars: 2
                , deferRequestBy: 200
                , transformResult: function(response) {
                    var res = [];
                    response = JSON.parse(response);
                    console.dir(response);
                    for (var i = 0, j = response.length; i !== j; i++) {
                        res.push({
                            value: response[i].name
                            , data: response[i]
                        });
                    }

                    return {suggestions: res};
                }
                , onSelect: function (suggestion) {
                    Student.get({id: suggestion.data.id})
                        .$promise
                        .then(function(res) {
                            $scope.student = res;
                        });
                }
            });
        };

        $scope.bindStudentToTeacher = function(teacherId, studentId) {
            StudentTeacher.create({
                student_id: studentId
                , teacher_id: teacherId
            })
                .$promise
                .then(function() {
                    w.location.reload();
                }, function(res) {
                    if (res.data.errors.student_id && 400 ==res.status) {
                        alert('This student has been already bound to the teacher!');
                    }
                });
        }

    };

    angular.module('controllers')
        .controller('TeacherDetailsController', ['$scope'
                                                , '$routeParams'
                                                , "$location"
                                                , 'Teacher'
                                                , 'Student'
                                                , 'StudentTeacher'
                                                , factory]);
})(window, $);