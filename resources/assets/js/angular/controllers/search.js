/* global config */

(function (c, d) {
    var app = angular.module('main', ['ngclipboard', 'ngFlash']);
    app.controller('SearchController', ['$scope', '$http', '$timeout', 'Flash', function ($scope, $http, $timeout, Flash) {
            $scope.url = 'search';
            $scope.keywords = d.forms['searchForm']['keywords'].value;
            $scope.categories = d.forms['searchForm']['categories'].value;
            var searchHandler;
            $scope.$watchGroup(['keywords', 'categories'], function (val) {
                if (searchHandler)
                {
                    $timeout.cancel(searchHandler);
                }
                searchHandler = $timeout(function () {
                    $scope.search();
                }, c.timeout);
            });
            $scope.search = function () {
                if ($scope.keywords.length >= c.minimum_length)
                {
                    $http.post($scope.url, {
                        keywords: $scope.keywords,
                        categories: $scope.categories
                    })
                            .success(function (data, status) {
                                $scope.status = status;
                                $scope.data = data;
                                $scope.result = data;
                            })
                            .error(function (data, status) {
                                $scope.data = data || "Request failed";
                                $scope.status = status;
                            });
                }
            };
            $scope.onClipboardSuccess = function (e) {
                var text = $(e.trigger).find('.list-group-item-text');
                text.addClass('bg-info');
                setTimeout(function () {
                    text.removeClass('bg-info');
                }, 3000);
                var message = '<strong>Copied to clipboard!</strong>';
                var id = Flash.create('info', message, 3000, {}, true);
            };
            $(document).on('keydown', function (e) {
                if (e.ctrlKey == false && e.shiftKey == true && e.altKey == false && e.keyCode == 67)
                {
                    $('[ng-controller="SearchController"] .list-group-item').first().trigger('click');
                }
            });
        }]);
}(config, document));


