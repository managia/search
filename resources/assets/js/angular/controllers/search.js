(function (c, d) {
    var app = angular.module('main', []);
    app.controller('SearchController', ['$scope', '$http', '$timeout', function ($scope, $http, $timeout) {
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
        }]);
}(config, document));


