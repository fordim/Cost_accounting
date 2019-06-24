var onPageLoaded = function() {

    function includeJs(url) {
        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = url;
        document.getElementsByTagName('head')[0].appendChild(script);
    }

    function css_add(url) {
        var tag_css = document.createElement('link');
        tag_css.type = 'text/css';
        tag_css.rel = 'stylesheet';
        tag_css.href = url;
        var tag_head = document.getElementsByTagName('head');
        tag_head[0].appendChild(tag_css);
    }

    includeJs("https://cdn.jsdelivr.net/jquery/latest/jquery.min.js");
    includeJs("https://cdn.jsdelivr.net/momentjs/latest/moment.min.js");
    includeJs("https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js");
    css_add("https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css");
};

document.addEventListener('DOMContentLoaded', onPageLoaded);