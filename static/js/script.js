function gotoLink(htmlElement) {

    var destinationURL = "";
    var target = "";

    if (htmlElement.href) {
        destinationURL = htmlElement.href;
        target = htmlElement.getAttribute("target");
    }
    else {
        if (htmlElement.childNodes) {
            if (htmlElement.getElementsByTagName("a")) {
                destinationURL = htmlElement.getElementsByTagName("a")[0].href;
                target = htmlElement.getElementsByTagName("a")[0].getAttribute("target");
            }
        }
    }

    if (destinationURL.length > 0) {
        if (target == "_blank") {
            window.open(destinationURL);
        }
        else {
            location.href = destinationURL;
        }
    }
    return false;
}

/**
 * All for Loading
 */

$(document).ready(function () {

});