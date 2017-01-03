/**
 * Created by Nico Burroni on 7/16/2015.
 */

var days = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];

$(function(){
    var filters = $('.ng-table-filters input.input-filter');
    for (var i = 0; i < filters.length; i++) {
        var filter = filters[i];
        filter.placeholder = "Buscar...";
    }

    var date = new Date();
    document.getElementById('day').innerHTML = days[date.getDay()] + ' ' + date.getDate() + '/' + (date.getMonth() + 1) + '  ' + date.getHours() + ':' + date.getMinutes();
    updateDate();
    setInterval(updateDate, 60000);

    getWeather(); // Get the initial weather.
    setInterval(getWeather, 1000 * 60 * 30); // Update weather every 30 minutes
});

var updateDate = function() {
    date = new Date();
    var minutes = ('0' + date.getMinutes()).slice(-2);
    document.getElementById('day').innerHTML = days[date.getDay()] + ' ' + date.getDate() + '/' + (date.getMonth() + 1) + '  ' + date.getHours() + ':' + minutes;
};

var getWeather = function() {
    $.simpleWeather({
        location: 'Buenos Aires',
        unit: 'c',
        success: function(weather) {
            var weatherElement = '<h2><i class="icon-'+weather.code+'"></i> '+weather.temp+'&deg;'+weather.units.temp+'</h2>';

            $("#weather").html(weatherElement);
        },
        error: function(error) {
            $("#weather").html('<p>'+error+'</p>');
        }
    });
}
