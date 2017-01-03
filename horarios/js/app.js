/**
 * Created by mgutierrez on 7/7/15.
 */

angular.module('app', ['ngTable'])
    .controller('SchedulesTableController', function ($scope, ngTableParams, $filter, $timeout, $http) {

        $scope.init = function () {
            $http.get("get-data.php").success(function (response) {
                $scope.actualData = response.schedules;
                $scope.tableParams = new ngTableParams({
                    page: 1,
                    count: 1000,
                    sorting: {
                        building: 'asc',
                        startTime: 'asc',
                        academicUnit: 'asc',
                        subject: 'asc'
                    }
                }, {
                    total: 0,
                    filterDelay: 0,
                    counts: [],
                    defaultSort: 'asc',
                    groupBy: 'building',
                    getData: function ($defer, params) {
                        var data = $scope.actualData;
                        data = params.filter() ? $filter('filter')(data, params.filter()) : data;
                        data = params.sorting() ? $filter('orderBy')(data, params.orderBy()) : data;
                        params.total(data.length);
                        data = data.slice((params.page() - 1) * params.count(), params.page() * params.count());
                        $defer.resolve(data);
                    }
                });
            });
        };

        $scope.init();
        $scope.hideSchedules = false;
    });