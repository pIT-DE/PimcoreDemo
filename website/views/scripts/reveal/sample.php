

<section>
    <h1>Reveal.js</h1>

    <h3 class="inverted">CSS 3D Presentations</h3>
    <script>
        // Delicously hacky. Look away.
        if (navigator.userAgent.match(/(iPhone|iPad|iPod|Android)/i)) document.write('<p style="color: rgba(0,0,0,0.3); text-shadow: none;">(' + 'Tap to navigate' + ')</p>');
    </script>
</section>

<section>
    <h2>Heads Up</h2>

    <p>
        reveal.js is an easy to use, HTML based, presentation tool. You'll need a modern browser with
        support for CSS 3D transforms to see it in its full glory.
    </p>

    <p>
        <i>
            <small>- <a href="http://hakim.se">Hakim El Hattab</a> / <a href="http://twitter.com/hakimel">@hakimel</a>
            </small>
        </i>
    </p>

    <aside class="notes">
        Oh hey, these are some notes. They'll be hidden in your presentation, but you can see them if you run the
        speaker notes server.
    </aside>
</section>

<!-- Example of nested vertical slides -->
<section>
    <section>
        <h2>Vertical Slides</h2>

        <p>
            Slides can be nested inside of other slides,<br/>
            try pressing <a href="#/2/1">down</a>.
        </p>
        <a href="#/2/1" class="image">
            <img width="178" height="238" src="https://s3.amazonaws.com/hakim-static/reveal-js/arrow.png">
        </a>
    </section>
    <section>
        <h2>Basement Level 1</h2>

        <p>Press down or up to navigate.</p>
    </section>
    <section>
        <h2>Basement Level 2</h2>

        <p>Cornify</p>
        <a class="test" href="http://cornify.com">
            <img width="280" height="326" src="https://s3.amazonaws.com/hakim-static/reveal-js/cornify.gif">
        </a>
    </section>
    <section>
        <h2>Basement Level 3</h2>

        <p>That's it, time to go back up.</p>
        <a href="#/2" class="image">
            <img width="178" height="238" src="https://s3.amazonaws.com/hakim-static/reveal-js/arrow.png" style="-webkit-transform: rotate(180deg);">
        </a>
    </section>
</section>

<section>
    <h2>Holistic Overview</h2>

    <p>
        Press <strong>ESC</strong> to enter the slide overview!
    </p>
</section>

<section>
    <h2>Works in Mobile Safari</h2>

    <p>
        Try it out! You can swipe through the slides pinch your way to the overview.
    </p>
</section>

<section>
    <h2>Transition Styles</h2>

    <p>
        You can select from different transitions, like:
    </p>
    <ul>
        <li><a href="http://lab.hakim.se/reveal-js/?transition=cube">Cube</a></li>
        <li><a href="http://lab.hakim.se/reveal-js/?transition=page">Page</a></li>
        <li><a href="http://lab.hakim.se/reveal-js/?transition=concave">Concave</a></li>
        <li><a href="http://lab.hakim.se/reveal-js/?transition=linear">Linear</a></li>
    </ul>
</section>

<section>
    <h2>Marvelous Unordered List</h2>
    <ul>
        <li>No order here</li>
        <li>Or here</li>
        <li>Or here</li>
        <li>Or here</li>
    </ul>
</section>

<section>
    <h2>Fantastic Ordered List</h2>
    <ol>
        <li>One is smaller than...</li>
        <li>Two is smaller than...</li>
        <li>Three!</li>
    </ol>
</section>

<section>
    <section data-state="alert">
        <h2>Global State</h2>

        <p>
            Set <code>data-state="something"</code> on a slide and <code>"something"</code>
            will be added as a class to the document element when the slide is open. This let's you
            apply broader style changes, like switching the background.
        </p>
        <a href="#/7/1" class="image">
            <img width="178" height="238" src="https://s3.amazonaws.com/hakim-static/reveal-js/arrow.png">
        </a>
    </section>
    <section data-state="blackout">
        <h2>"blackout"</h2>
        <a href="#/7/2" class="image">
            <img width="178" height="238" src="https://s3.amazonaws.com/hakim-static/reveal-js/arrow.png">
        </a>
    </section>
    <section data-state="soothe">
        <h2>"soothe"</h2>
        <a href="#/7/0" class="image">
            <img width="178" height="238" src="https://s3.amazonaws.com/hakim-static/reveal-js/arrow.png" style="-webkit-transform: rotate(180deg);">
        </a>
    </section>
</section>

<section data-state="customevent">
    <h2>Custom Events</h2>

    <p>
        Additionally custom events can be triggered on a per slide basis by binding to the <code>data-state</code> name.
    </p>
					<pre><code contenteditable style="font-size: 18px; margin-top: 20px;">Reveal.addEventListener(
                        'customevent', function() {
                        console.log( '"customevent" has fired' );
                        } );
                    </code></pre>
</section>

<section>
    <h2>Clever Quotes</h2>

    <p>
        These guys come in two forms, inline:
        <q cite="http://searchservervirtualization.techtarget.com/definition/Our-Favorite-Technology-Quotations">
            The nice thing about standards is that there are so many to choose from</q> and block:
    </p>
    <blockquote cite="http://searchservervirtualization.techtarget.com/definition/Our-Favorite-Technology-Quotations">
        For years there has been a theory that millions of monkeys typing at random on millions of typewriters would
        reproduce the entire works of Shakespeare. The Internet has proven this theory to be untrue.
    </blockquote>
</section>

<section>
    <h2>Pretty Code</h2>
					<pre><code contenteditable>
                        function linkify( selector ) {
                        if( supports3DTransforms ) {

                        var nodes = document.querySelectorAll( selector );

                        for( var i = 0, len = nodes.length; i < len; i++ ) {
                        var node = nodes[i];

                        if( !node.className ) ) {
                        node.className += ' roll';
                        }
                        };
                        }
                        }
                    </code></pre>
    <p>Courtesy of <a href="http://softwaremaniacs.org/soft/highlight/en/description/">highlight.js</a>.</p>
</section>

<section>
    <h2>Intergalactic Interconnections</h2>

    <p>
        You can link between slides internally,<br/>
        <a href="#/2/3">like this</a>.
    </p>
</section>

<section>
    <h2>Fragmented Views</h2>

    <p>Hit the next arrow...</p>

    <p class="fragment">... to step through ...</p>
    <ol>
        <li class="fragment"><code>any type</code></li>
        <li class="fragment"><em>of view</em></li>
        <li class="fragment"><strong>fragments</strong></li>
    </ol>
</section>

<section>
    <h2>Spectacular image!</h2>
    <a class="image" href="http://hakim.se/experiments/html5/breakdom/" target="_blank">
        <img width="320" height="412" src="https://s3.amazonaws.com/hakim-static/reveal-js/breakdom.png">
    </a>
</section>

<section>
    <h2>Stellar Links</h2>
    <ul>
        <li><a href="https://github.com/hakimel/reveal.js">Source code on github</a></li>
        <li><a href="http://hakim.se/projects/reveal-js">Read more on my site</a></li>
        <li><a href="http://twitter.com/hakimel">Follow me on Twitter</a></li>
    </ul>
</section>

<section>
    <h1>THE END</h1>

    <h3 class="inverted">BY Hakim El Hattab / hakim.se</h3>
</section>
</div>

<!-- The navigational controls UI -->
<aside class="controls">
    <a class="left" href="#">&#x25C4;</a>
    <a class="right" href="#">&#x25BA;</a>
    <a class="up" href="#">&#x25B2;</a>
    <a class="down" href="#">&#x25BC;</a>
</aside>

<!-- Displays presentation progress, max value changes via JS to reflect # of slides -->
<div class="progress"><span></span></div>

</div>

<!-- Optional libraries for code syntax highlighting and classList support in IE9 -->


<script>

</script>

</body>
</html>
