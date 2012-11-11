$(document).ready(function () {
    $.backstretch("/static/img/training/background.jpg", ({ centeredX:true, centeredY:true}));
// Load the main reveal.js script
    head.js('/static/js/reveal/js/reveal.js', function () {
        // Parse the query string into a key/value object
        var query = {};

        location.search.replace(/[A-Z0-9]+?=(\w*)/gi, function (a) {
            query[ a.split('=').shift() ] = a.split('=').pop();
        });

        // Fires when a slide with data-state=customevent is activated
        Reveal.addEventListener('customevent', function () {
            console.log('"customevent" has fired');
        });

        // Fires each time a new slide is activated
        Reveal.addEventListener('slidechanged', function (event) {
            // event.previousSlide, event.currentSlide, event.indexh, event.indexv
        });

        // Full list of configuration options available here:
        // https://github.com/hakimel/reveal.js#configuration

        if (typeof (pimcore) == "object") {
//        Reveal.initialize({
//            controls:true,
//            progress:false,
//            history:false,
//            mouseWheel:false,
//
//            theme:query.theme || 'neon', // default/neon/beige
//            transition:query.transition || 'cube' // default/cube/page/concave/linear(2d)
//        });
        }
        else {
            Reveal.initialize({
                controls:true,
                progress:true,
                history:true,
                rollingLinks:false,

                theme:query.theme || 'default', // default/neon/beige
                transition:query.transition || 'default' // default/cube/page/concave/linear(2d)
            });
        }


    });

// Load third party scripts
    head.js('/static/js/reveal/lib/js/classList.js');
    head.js('/static/js/reveal/lib/js/highlight.js', function () {
        // Fire off syntax highlighting for potential code samples in the slides
        hljs.initHighlightingOnLoad();
    });

// If we're runnning the notes server we need to include some additional JS
// TODO Is there a better way to determine if we're running the notes server?
    if (window.location.host === 'localhost:1947') {
        head.js('socket.io/socket.io.js', '/static/js/reveal/plugin/speakernotes/client.js');
    }
});
