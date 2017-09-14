/*global
  angular
 */
angular.module('starter').controller('FaqListController', function ($scope, $log, $state, $stateParams, $http,
                                                                          $translate, Dialog, Customer, Faq) {
    angular.extend($scope, {
        value_id: $stateParams.value_id,
        form: {
            question: ''
        }
    });

    Faq.setValueId($stateParams.value_id);

    $scope.loadContent = function () {
        Faq.findAll()
            .then(function (response) {
                console.log(response);
                $scope.page_title = response.page_title;
                $scope.faqs = response.faqs;
            }, function () {

            });
    };

    /**
     * Prune form
     */
    $scope.resetForm = function () {
        $scope.form = {
            question: ''
        };
    };

    /**
     * Handle clicks on the form submission!
     */
    $scope.submit = function () {
        Faq.submit($scope.form)
            .then(function (response) {
                    Dialog.alert('Success', 'You have successfully sent your question!', 'OK', -1);
                    $scope.resetForm();
            }, function (error) {
                Dialog.alert('Error', error.message, 'OK', -1);
            });
    };

    $scope.loadContent();
});
