/* global config */

(function (c, d) {
    var app = angular.module('main', ['ngclipboard', 'ngFlash']);
    app.controller('SearchController', ['$scope', '$http', '$timeout', 'Flash', '$sce', function ($scope, $http, $timeout, Flash, $sce) {
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
            function signMark(answer) {
                return $sce.trustAsHtml(answer.replace(/(.*)[<](.*)[>](.*)/, '$1<mark data-clipboard-text="$2"><$2></mark>$3'));
            }
            $scope.search = function () {
                if ($scope.keywords.length >= c.minimum_length)
                {
                    $http.post($scope.url, {
                        keywords: $scope.keywords,
                        categories: $scope.categories
                    })
                            .success(function (data, status) {
                                $scope.status = status;
                                for (i in data.suggests) {
                                    var marked = signMark(data.suggests[i].answer),
                                            mark = $(marked).has('mark');
                                    if (mark.length) {
                                        data.suggests[i].mark = mark.text();
                                    } else {
                                        data.suggests[i].mark = '';
                                    }
                                    data.suggests[i].markedAnswer = marked;
                                }
                                for (i in data.popular) {
                                    var marked = signMark(data.popular[i].answer),
                                            mark = $(marked).has('mark');
                                    if (mark.length) {
                                        data.popular[i].mark = mark.text();
                                    } else {
                                        data.popular[i].mark = '';
                                    }
                                    data.popular[i].markedAnswer = marked;
                                }
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
                if ($(e.trigger).is('mark')) {
                    element = $(e.trigger);
                } else {
                    element = $(e.trigger).find('.list-group-item-text');
                }
                element.addClass('bg-info');
                function rmClass(el) {
                    el.removeClass('bg-info');
                }
                setTimeout(function () {
                    rmClass(element);
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


