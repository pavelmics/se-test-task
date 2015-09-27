(function(w, $) {

    var factory = function($scope, Utils, Teacher) {
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

                }, Utils.formError($form));
        }
    };

    angular.module('controllers')
        .controller('AddTeacherController', ['$scope', 'Utils', 'Teacher', factory]);
})(window, $);