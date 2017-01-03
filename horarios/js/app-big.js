angular.module('app', ['ngTable'])
    .controller('SchedulesBigTableController', function($scope, ngTableParams, $filter, $timeout, $http, $interval) {

        $scope.init = function () {
            $http.get("get-data.php").success(function (response) {
                $scope.actualData = response.schedules;
                $scope.tableParams = new ngTableParams({
                    page: 1,
                    count: 8,
                    sorting: {
                        building: 'asc',
                        startTime: 'asc',
                        academicUnit: 'asc',
                        subject: 'asc',
                        classroom: 'asc',
                        endTime: 'asc'
                    }
                }, {
                    total: 0,
                    filterDelay: 0,
                    counts: [],
                    defaultSort: 'asc',
                    groupBy: 'building',
                    getData: function($defer, params) {
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
        $interval($scope.init, 30 * 60 * 1000); //Recargar los datos cada media hora

        $scope.hideSchedules = false;

        $scope.pageTimeout = 12000;
        $timeout(init, $scope.pageTimeout);

        function init(){
            $scope.hideSchedules = !$scope.hideSchedules;
            $timeout(function () {
                var pageNumber = $scope.tableParams.page();
                var newPage = pageNumber == Math.ceil($scope.tableParams.total() / $scope.tableParams.count()) ? 1 : pageNumber + 1;
                $scope.tableParams.page(newPage);
                $scope.tableParams.reload();
                $scope.hideSchedules = !$scope.hideSchedules;

                $timeout(init, $scope.pageTimeout);
            }, 1500);
        }
    });