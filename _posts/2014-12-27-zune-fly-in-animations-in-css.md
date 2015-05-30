---
layout: post
title: Zune fly-in animations in CSS
---

A few years before the [Metro interface](http://en.wikipedia.org/wiki/Metro_%28design_language%29) reached broader audiences through Windows Phone and Windows 8, Microsoft pioneered the Metro interface in the *Zune* app. The early versions of Metro, especially the one seen in Zune, was focused on typography. Currently, "metro interface" is associated with colorful, rectangular tiles:

![Search results for "Metro Interface" in 2010](/content/images/2015/01/OriginalMetro-1.png) 
{<1>}![Current search results for "Metro Interface"](/content/images/2015/01/CurrentMetro-1.PNG)

***

I enjoyed the way Zune software looked and felt, and I wanted to create similar effect on my website

<video width="706" height="222" autoplay loop>
  <source src="http://blog.amadeusw.com/content/images/zune.webm" type="video/webm">  </video>

Through experimenting I found that the fly-in effect looks great when navigation flies in form one direction and the article flies in from another direction. The bottom part of the header, which consists of smaller letters, flies in from a further source, appearing to be faster. Additionally, each of the navigation elements' animation is delayed relatively to the previous element.

<video width="794" height="186" autoplay loop>
  <source src="http://blog.amadeusw.com/content/images/portfolioArticles.webm" type="video/webm">  </video>

The origin and destination of movement are controlled by `paddingLeft` and `paddingRight` CSS properties. Fading is accomplished using the `opacity` property.

The first part of javascript selects the **header**, and sets up its animation to full opacity and 20px to the right.

```javascript
  $( "#"+id+" > header" ).stop()
    .css({
      'paddingLeft': '20px',
      'opacity': '0'
    })
    .animate({
      'paddingLeft': '40px',
      'opacity': '1'
    }, 'slow');
```

<pre><code class="javascript">  $( "#"+id+" > header" ).stop()
    .css({
      'paddingLeft': '20px',
      'opacity': '0'
    })
    .animate({
      'paddingLeft': '40px',
      'opacity': '1'
    }, 'slow');
</code></pre>

The second part selects the **navigation bar** below the header and sets up its animation 30px to the right.

```js
  $( "#"+id+" > nav" ).stop()
    .css({
      'paddingLeft': '10px',
    })
    .animate({
      'paddingLeft': '40px',
    }, 'slow')
    /* continued: */
```

<pre><code class="javascript">  $( "#"+id+" > nav" ).stop()
    .css({
      'paddingLeft': '10px',
    })
    .animate({
      'paddingLeft': '40px',
    }, 'slow')
    /* continued: */
</code></pre>

The code then continues to find **each contained navigation element** and individually animates it to full opacity and adding extra 10px of movement. Navigation elements are dound using [`each`](https://api.jquery.com/each/) method, and animation [`delay`](https://api.jquery.com/delay/) increases for consecutive elements.

```javascript
    .find( "li" ).each(function(childId) {
      $(this).stop().css({
        'opacity': '0',
        'margin-right': '20px'
      })
      .delay(100 + childId*200)
      .animate({
        'opacity': '1',
        'margin-right': '30px'
      }, 'slow');
    });
```

<pre><code class="javascript">    .find( "li" ).each(function(childId) {
      $(this).stop().css({
        'opacity': '0',
        'margin-right': '20px'
      })
      .delay(100 + childId*200)
      .animate({
        'opacity': '1',
        'margin-right': '30px'
      }, 'slow');
    });
</code></pre>

***

[@Honzie](https://twitter.com/honzie) helped me improve the fly-in animation for the article content: he pointed me to [Google's *Material Design*](http://www.google.com/design/spec/material-design/introduction.html) which reminds that *everything that moves should move for a reason*, in order to mimic a physical object.

Hence, navigation left causes the article to fly in from the left side, and navigation right causes the article to fly in from the right side.

<video width="526" height="160" autoplay loop>
  <source src="http://blog.amadeusw.com/content/images/portfolioSections.webm" type="video/webm">  </video>

The origin and destination of animation are similarly controlled by `paddingLeft` and `paddingRight` CSS properties. `newSectionId` and `lastSectionId` are global variables that control direction of animation, and they are set in methods that handle link clicks.

```javascript
var initialPaddingLeft = '30px';
var initialPaddingRight = '20px';
if (newSectionId > lastSectionId)
{
  initialPaddingLeft = '50px';
  initialPaddingRight = '0px';
}
```

<pre><code class="javascript">var initialPaddingLeft = '30px';
var initialPaddingRight = '20px';
if (newSectionId > lastSectionId)
{
  initialPaddingLeft = '50px';
  initialPaddingRight = '0px';
}
</code></pre>

When changing articles (this causes the header to fly in from the left), `newSectionId` and `lastSectionId` are both equal to `0` and therefore the content flies in from the right.

```javascript
$( "#" + id ).stop().show()
  .css({
    'paddingLeft': initialPaddingLeft,
    'paddingRight': initialPaddingRight,
     'opacity': '0'})
  .animate({
    'paddingLeft': '40px',
    'paddingRight': '10px',
    'opacity': '1'
  }, 'slow');
```

<pre><code class="javascript">$( "#" + id ).stop().show()
  .css({
    'paddingLeft': initialPaddingLeft,
    'paddingRight': initialPaddingRight,
     'opacity': '0'})
  .animate({
    'paddingLeft': '40px',
    'paddingRight': '10px',
    'opacity': '1'
  }, 'slow');
</code></pre>

Check out the final result on [my portfolio](http://amadeusw.com) or [browse its source on github](https://github.com/AmadeusW/amadeusw.github.io)
