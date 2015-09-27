(function(w) {

    var factory = function($scope, Teacher) {
        $scope.teachers = [];
        $scope.pages = [];
        $scope.page = 1;
        $scope.count = 0;

        /**
         * Manages the table of teachers
         */
        $scope.updateTable = function() {
            $scope.teachers = Teacher.query(_getLimitOffset());

            // render pagination
            Teacher.getCount()
                .$promise
                .then(function(res) {
                    var pages = []
                        , count = parseInt(res.count);
                    $scope.count = count;
                    if (count <= 10) {
                        $scope.pages = [1];
                    } else {
                        var i = $scope.page === 1 ? 1 : $scope.page - 1
                            , j = Math.ceil(count / 10) + 1;
                        j - i > 10
                            ? j = i + 10
                            : null;
                        for (;i !== j; i++) {
                            pages.push(i);
                        }
                        $scope.pages = pages;
                    }
                });
        };

        /**
         * updates page
         * @param page
         */
        $scope.updatePage = function(page) {
            $scope.page = page;
        };

        /**
         * Returns object with pagination params for query
         * @returns {{limit: number, offset: number}}
         * @private
         */
        var _getLimitOffset = function() {
            return {
                limit: 10
                , offset: ($scope.page-1) * 10
            }
        };
    };

    angular.module('controllers')
        .controller('TeachersController', ['$scope', 'Teacher', factory]);
})(window);