
var onPageLoaded = function() {

    document.getElementById("signUnInputName").onkeypress = function (event) {
        event = event || window.event;
        if (event.charCode && (event.charCode < 65 || event.charCode > 90) && (event.charCode < 97 || event.charCode > 122)
            && (event.charCode < 1040 || event.charCode > 1103)){
            return false;
        }
    };
};

document.addEventListener('DOMContentLoaded', onPageLoaded);