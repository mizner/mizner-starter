Mizner Starter Theme
=======================
- First, get your local site running `Vagrant`, `Docker`, `Local by Flywheel`, `MAMP`, etc.
- In your Terminal (iTerm, Hyper, etc.) cd until you're in the `themes` directory
- Clone this Repo
     - Run `git clone https://github.com/Mizner/mizner-starter`
- Recommended: delete the `.git` folder
     - Run `rm -rf .git` *(Make sure you're in the right directory)*
- Install NPM packages 
     - (**Bonus**: use YARN!) run `yarn install` *it's just like `npm install`*
- No more `bower`, that's so over.
- Open `gulpfile.js` and edit the `const project = "starter";` to match your local url
     - e.g. `http://myproject.dev` would mean you should change that line to `const project = "myproject";`
- Open `functions.php` and edit `define( 'PROJECT', 'starter' );` to match your local url
     - e.g. `http://myproject.dev` would mean you should change that line to `define( 'PROJECT', 'myproject' );`
- Run `gulp` to update your `/dist` folder to the new info
- Now you should be able to run `gulp watch` and have BrowserSync stream `.css` changes and Reload on most `.js` and `.php` changes.  

Recommended First Steps 
-----------------------
1. Get brand colors
     - add to `_variables.scss`
2. Open `_header.scss`
     - choose options by commenting out what you don't want

Plugins You Probably Need
-----------------------
- **Gravity Forms**
- **WP Migrate DB**
- **CPT UI** (easy custom post types)

Features
=======================
Better Logo Support
-----------------------
Okay, so: there's a few things to know. It's somewhat dynamic.
1. `images/logo.svg` will take priority
2. `images/logo.png` is the first fallback
3. `images/logo.jpg` is the second fallback
4. If none of these exist, you can upload a logo via the `Customizer`
5. Lastly, if no image is set via any of the above options it will display text in an `h` tag

SVG's
-----------------------
Let's say you have an SVG "`icon.svg`" saved to the images folder.

You can use `the_svg('images/icons.svg')` in a `.php` file and it should load that `.svg` without any trouble... hopefully.
 
**Note:** Keep an eye out for any `?` characters in the `.svg` file, especially if you downloaded the file from a place like FlatIcon

Popups 
-----------------------
First off, just keep in mind... there's probably no popup library that will take care of all the possible use cases... "probably".  If you find one, let me know.

Secondly, I wrote it a while ago. It could probably use improvements or refactoring. 

Anyways, here's what I came up with:
- **Clicked Element**: on some `<button>` or `<a>` element, give it:
     - `class="popupTrigger"`
     - `name="exampleTrigger"` note: (`exampleTrigger`) could be anything.  
- **Popped Element**: on the corresponding element, give it: 
     - `class="popupWrapper exampleTrigger"`
     
Basically, we're associating the name attribute on the *clicked* element to a matching element with that as a class.  **So make sure it's fairly unique.** 

On Scroll Elements 
-----------------------
Note: not currently working with Fixed Header (You can use either/or). 

If `visibile-in-browser.js` is compiled:

You can use class `on-screen` that will populate class `visible` when element is scrolled over


