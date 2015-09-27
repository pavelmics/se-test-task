(function(w) {

    var factory = function($scope, Teacher) {
        $scope.teachers = [];

        /**
         * Init list of teachers with april-born students
         */
        $scope.initList = function() {
            Teacher.getAprilStudents()
                .$promise
                .then(function(res) {
                    $scope.teachers = res;
                });
        };
    };

    angular.module('controllers')
        .controller('TeachersAprilController', ['$scope', 'Teacher', factory]);
})(window);