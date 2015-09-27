(function(w, $) {

    var factory = function($scope, $location, Utils, Student, LanguageLevel) {
        var $form = $('#new-student-form');
        $scope.formData = {};

        $scope.createNewStudent = function() {
            Utils.clearForm($form);

            Student
                .create($scope.formData)
                .$promise
                .then(function(res) {
                    $location.path("/students");
                }, Utils.formError($form));
        };

        /**
         * List of language levels
         */
        $scope.initForm = function() {
            $form.find('#student-birthdate').datepicker({
                format: 'yyyy-mm-dd'
                , orientation: "bottom"
                , autoclose: true
            });

            LanguageLevel.all()
                .$promise
                .then(function(res) {
                    $scope.levels = res;
                    res.length >= 1
                        ? $scope.formData.level_id = res[0].id
                        : null;
                });
        };
    };

    angular.module('controllers')
        .controller('AddStudentController', ['$scope'
            , '$location'
            , 'Utils'
            , 'Student'
            , 'LanguageLevel'
            , factory]);
})(window, $);