(function(w, $) {

    var factory = function($scope, $location, Utils, Teacher) {
        $scope.formData = {
            sex: '1'
        };

        $scope.createNewTeacher = function() {
            var $form = $('#new-teacher-form');
            Utils.clearForm($form);

            Teacher
                .create($scope.formData)
                .$promise
                .then(function(res) {
                    $location.path('/teachers/' + res.id);
                }, Utils.formError($form));
        }
    };

    angular.module('controllers')
        .controller('AddTeacherController', ['$scope', '$location', 'Utils', 'Teacher', factory]);
})(window, $);