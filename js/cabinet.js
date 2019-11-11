
var onPageLoaded = function() {

    document.getElementById("addExpenseComment").onkeypress = function (event) {
        event = event || window.event;
        if (event.charCode && (event.charCode < 32 || event.charCode > 32)) {
            if (event.charCode && (event.charCode < 40 || event.charCode > 41)) {
                if (event.charCode && (event.charCode < 65 || event.charCode > 122)) {
                    return false;
                }
            }
        }
    };

};

document.addEventListener('DOMContentLoaded', onPageLoaded);