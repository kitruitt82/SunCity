
$(document).ready(function() {
    var calendar = $('#calendar').fullCalendar({
        header:{
            left:'today',
            center:'prev, title, next',
            right:''
        },

        dayClick:function(date,jsEvent,view) {
            $('.modal').modal();
        }
    })


});