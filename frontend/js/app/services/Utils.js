(function(w) {
    angular.module('skyeng').factory('Utils', [function() {
        return {

            /**
             * Clear errors messages of forms
             * @param {$} $form
             */
            clearForm: function($form) {
                if (!$form instanceof $) {
                    throw '$form must be instance of jquery';
                }
                $form.find('.form-group').removeClass('has-error');
            },

            /**
             * Render errors on bootstrap form
             *
             * @param $form
             * @returns {Function}
             */
            formError: function($form) {
                if (!$form instanceof $) {
                    throw '$form must be instance of jquery';
                }

                return function(res) {
                    var errors = res.data.errors;
                    if (errors) {
                        for (var e in errors) {
                            $form.find('[name=' + e + ']')
                                .parents('.form-group')
                                .addClass('has-error')
                                .find('.error-message')
                                .text(errors[e]);
                        }
                    }
                }
            }

        };
    }]);
})(window);
