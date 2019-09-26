var onPageLoaded = function() {

        $('input[name="daterange"]').daterangepicker({
            opens: 'center'
        }, function(start, end, label) {
            //обратится к скрытым элементам по id и записать в них значения (value = start) и потом во вторую
            //для формы событие сделать id, и сделать сабмит что-бы она была $POST
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });
};

window.addEventListener('load', onPageLoaded);