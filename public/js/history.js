var onPageLoaded = function() {

        $('input[name="dateRange"]').daterangepicker({
            opens: 'center',
            locale: {
                format: 'YYYY-MM-DD'
            }
        }, function(start, end, label) {
            document.getElementById('dateFrom').value = start.format('YYYY-MM-DD');
            document.getElementById('dateTo').value = end.format('YYYY-MM-DD');
            document.getElementById('formDatePicker').submit();
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });
};

window.addEventListener('load', onPageLoaded);