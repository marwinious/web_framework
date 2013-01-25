jQuery.ScrollTo

Introduction

An article about animated scrolling with jQuery inspired me to make a small, customizable plugin for scrolling elements, or the window itself. 

How to specify what to scroll ?

Simple, all the matched elements will be scrolled, for example:

$('div.pane').scrollTo(...);//all divs w/class pane

If you need to scroll the window (screen), then use:

$.scrollTo(...);//the plugin will take care of this


How to specify where ?

There are many different ways to specify the target position.
These are:

A raw number
A string('44', '100px', '+=30px', etc )
A DOM element (logically, child of the scrollable element)
A selector, that will be relative to the scrollable element
The string 'max' to scroll to the end.
A string specifying a percentage to scroll to that part of the container (f.e: 50% goes to to the middle).
A hash { top:x, left:y }, x and y can be any kind of number/string like above.
Note that you only need to use the hash form, if you are scrolling on both axes, and they have different positions.
Don't use the hash to scroll on both axes. Instead, keep reading :)

Settings

The plugin offers you many options to customize the animation and also the final position.
The settings are:

axis: Axes to be scrolled, 'x', 'y', 'xy' or 'yx'. 'xy' is the default.

duration: Length of the animation, none (sync) by default.

easing: Name of the easing equation.

margin: If true, target's border and margin are deducted.

offset: Number or hash {left: x, top:y }. This will be added to the final position(can be negative).

over: Add a fraction of the element's height/width (can also be negative).

queue: If true and both axes are scrolled, it will animate on one axis, and then on the other. Note that 'axis' being 'xy' or 'yx', concludes the order

onAfterFirst: If queing, a function to be called after scrolling the first axis.

onAfter: A function to be called after the whole animation ended.

These settings are very well explained in the demo. Make sure to check it to understand them all. 


Getting the real scrollable element out of a node

In order to find the real element whose attributes will be animated, you need to call $.fn._scrollable. The underscore has been added to avoid conflicts with other jQuery plugins. Here's an example:

$(window)._scrollable(); // When scrolling the window

Manually finding the scrolling limit

ScrollTo always had an internal function that calculates the scrolling limit for both axes. Since 1.4.2, this function is exposed as $.scrollTo.max.

It's not too nice to use yet but it's probably not something you'll need, you must pass two arguments: a jQuery object and an axis string ('x' or 'y') and it will return the max number.


Overloading

This plugin accepts the arguments in two ways, like $.animate().

$(...).scrollTo( target, duration, settings );

$(...).scrollTo( target, settings );

In this second case, you can specify the duration in the hash. You don't need to include any setting, not even the duration, everything has defaults.
The hash of defaults can be accessed at: $.scrollTo.defaults. 

jQuery.ScrollTo's sons

Indeed, jQuery.ScrollTo has offspring :)

jQuery.LocalScroll: Will add a scroll effect, to any anchor navigation. Ideal for slides, table of contents, etc. It's small, and incredibly easy to implement.

jQuery.SerialScroll: It's a multi-purpose plugin to animate any kind of sequential navigation(prev/next). It's also small and highly customizable.


These plugins require jQuery.ScrollTo and can use its settings!.
That makes around 20 options to fully customize each of them.
They are wrappers for common situations where you might need this plugin.
Using them will save you a lot of time and will give you even more customization.
They can be safely used simultaneously and the 3 of them minified, take merely 3.5kb altogether! 

Troubleshooting

Doesn't scroll on IE

Sometimes, you need to set a position (relative or absolute) to the container and give it fixed dimensions, in order to hide the overflow.
If this doesn't work, try giving the container fixed dimensions (height & width). 