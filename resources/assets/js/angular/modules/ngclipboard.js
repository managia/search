/*! ngclipboard - v1.1.1 - 2016-02-26
 * https://github.com/sachinchoolur/ngclipboard
 * Copyright (c) 2016 Sachin; Licensed MIT */
(function () {
    'use strict';
    var MODULE_NAME = 'ngclipboard';
    var angular, Clipboard;

    // Check for CommonJS support
    if (typeof module === 'object' && module.exports)
    {
        angular = require('angular');
        Clipboard = require('clipboard');
        module.exports = MODULE_NAME;
    } else
    {
        angular = window.angular;
        Clipboard = window.Clipboard;
    }

    angular.module(MODULE_NAME, []).directive('ngclipboard', function ($timeout) {
        return {
            restrict: 'A',
            scope: {
                ngclipboardSuccess: '&',
                ngclipboardError: '&'
            },
            link: function (scope, element) {
                $timeout(function () {
                    var hasMark = element.has('mark');
                    if (hasMark.length) {
                        var mark = element.find('mark');
                        var clipboardMark = new Clipboard(mark[0]);
                        clipboardMark.on('success', function (e) {
                            scope.$apply(function () {
                                scope.ngclipboardSuccess({
                                    e: e
                                });
                            });
                            return false;
                        });
                        clipboardMark.on('error', function (e) {
                            scope.$apply(function () {
                                scope.ngclipboardError({
                                    e: e
                                });
                            });
                        });
                    }
                }, 0);
                var clipboard = new Clipboard(element[0]);
                clipboard.on('success', function (e) {
                    scope.$apply(function () {
                        scope.ngclipboardSuccess({
                            e: e
                        });
                    });
                });
                clipboard.on('error', function (e) {
                    scope.$apply(function () {
                        scope.ngclipboardError({
                            e: e
                        });
                    });
                });
            }
        };
    });
}());
