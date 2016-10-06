![CraftPlus](http://i.imgur.com/WOyDB0x.png)

![Craft](https://img.shields.io/badge/craft-v2.6-red.svg)

CraftPlus adds an easy to use way of attaching behaviors to your elements using Craft's own $element->attachBehavior() method. 
In addition CraftPlus adds a useful global variable 'plus' that will expose all available services you create within the CraftPlus\Services namespace.

It's maintained by [Franco Valdes](https://github.com/fvaldes33).


## Features
- Attach behaviors the Craft way and clean up your templates.
- Eager load what you need.
- Create services that are available both in templates and php.

### Installation

To install CraftPlus, just follow these steps:

1. Upload the craftplus/ folder to your craft/plugins/ folder.
2. Go to Settings > Plugins from your Craft control panel.
3. Enable the CraftPlus plugin and DONE.

On install, CraftPlus will copy over the Plus directory into your config directory.
This allows you to create your own behaviors and services outside of the plugin itself 
as all it does is attach the behaviors you create. 

Folder Structure:
- plus
    - Behaviors
        - Assets
        - Categories
        - Entries
        - Globals
        - MatrixBlocks
        - Traits
    - Services
        - LogService.php **

Log Service is for basic debugging. 
Usage: 
- Twig: {{ plus.log.write(key, value) }}
- PHP: craft()->craftPlus->log('hello', 'world');

### How does it work?

It is pretty simple. Recently CraftCms gave us the power to attach behaviors to our element instances. With this ability also came the ability to eager load related data to help with performance. Due to this update we decided to simplify how these behaviors are used and also keep them out of your twig templates. To get a bit more technical, on crafts "onPopulateElement" event, we scan and attach behviors matching some of your elements criteria.


## Usage

CraftCMS ships with a "Homepage" section so we've decided to ship with an example "HomepageBehavior" so that you can see how it works. It is quite straight forward, for each section you wish to attach behaviors to simply create a behavior with the same name (+ the word behavior) inside it's element types directory. 


### Example

Your blog channel section has a gallery and you want to eager load the assets needed to populate that page. Perfect! You would create a BlogBehavior.php file (extend the BaseEntryBehavior as showed on the Homepage example) and add a method to help you eager load those assets. In the hopes of clean and reusable code, if any of these behaviors are common, create a Trait and just use that OR you can add a method directly to the Basebehavior class itself.

To learn about eager loading check this out https://craftcms.com/docs/templating/eager-loading-elements.


## Feature Requests & Issues

If you need a feature, let me know and I'll add it as soon as reasonably possible. CraftPlus is actively maintained, and I accept relevant, feature-adding pull requests. If you encounter any issues, please open an issue and I'll work with you and patch the problem. Thanks!


## Feature Roadmap
As we approach Craft3 and the difficulties of multisite we will be making improvements as well to support any known changes.
