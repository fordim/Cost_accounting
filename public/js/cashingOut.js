var onPageLoaded = function() {

    $('input[name="percent"]').ready(function(){
        $('input:checkbox').click(function() {
            $('input:checkbox').not(this).prop('checked', false);
        });
    });
};

window.addEventListener('load', onPageLoaded);