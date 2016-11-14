![Plus](http://i.imgur.com/r3EwP1W.png)

![Craft](https://img.shields.io/badge/craft-v2.6-red.svg) ![PHP](https://img.shields.io/badge/php-v7.0-blue.svg)

Plus (for CraftCMS) adds an easy to use way of attaching behaviors to your elements using Craft's own $element->attachBehavior() method. 
In addition Plus adds a useful global variable 'plus' that will expose all available services you create within the Plus\Services namespace.

It's maintained by [Franco Valdes](https://github.com/fvaldes33).


## Features
- Attach behaviors the Craft way and clean up your templates.
- Eager load what you need.
- Create services that are available both in templates and php.

### Installation

To install Plus, just follow these steps:

1. Upload the Plus/ folder to your craft/plugins/ folder.
2. Go to Settings > Plugins from your Craft control panel.
3. Enable the Plus plugin and DONE.

On install, Plus will copy over the install/plus directory into your root directory.
This allows you to create your own behaviors and services outside of the plugin itself 
as all it does is attach the behaviors you create. 

Folder Structure:
- plus
    - Behaviors
        - Categories
            - BaseCategoryBehavior.php
        - Entries
            - BaseEntryBehavior.php
            - HomepageBehavior.php
        - Globals
            - BaseGlobalsBehavior.php
        - MatrixBlocks
            - BaseMatrixBlocksBehavior.php
        - Traits
            - ExampleAssetTrait.php
    - Services
        - LogService.php **

Log Service is for basic debugging. 
Usage: 
- Twig: {{ plus.log.write(key, value) }}
- PHP: craft()->plus->log('hello', 'world');

### How does it work?

It is pretty simple. Recently CraftCms gave us the power to attach behaviors to our element instances. With this ability also came the ability to eager load related data to help with performance. Due to this update we decided to simplify how these behaviors are used and also keep them out of your twig templates. To get a bit more technical, on crafts "onPopulateElement" event, we scan and attach behviors matching some of your elements criteria.

On the services end, we expose a plus global twig variable that has access to all created services inside the plus/Services directory. Take a look at our LogService example for more details on how that is used.


## Usage

CraftCMS ships with a "Homepage" section so we've decided to ship with an example "HomepageBehavior" so that you can see how it works. It is quite straight forward, for each section you wish to attach behaviors to simply create a behavior with the same name (+ the word behavior) inside it's element types directory. 

==UPDATE==

Every public method inside this newly created behavior will be available in your templates attached to the handle you have attached it to.
Take a look at this https://craftcms.com/classreference/etc/behaviors/BaseBehavior for more information about behaviors. 

In short, behaviors are methods that will be attached to your [entry, matrix, category, globals] models on the fly. Saying that if you need a {% set array = entry.loadsomethingfaster %} in your template you can easily add that method inside the element you are trying to use it on. For a more resuable case, use traits or add methods to the Base[ElementType]Behavior.php instead.

New example added to HomepageBehavior.php to show how to eager load fields across channels and matrix block fields.

### Example

Your blog channel section has a gallery and you want to eager load the assets needed to populate that page. Perfect! You would create a BlogBehavior.php file (extend the BaseEntryBehavior as showed on the Homepage example) and add a method to help you eager load those assets. In the hopes of clean and reusable code, if any of these behaviors are common, create a Trait and just use that OR you can add a method directly to the Basebehavior class itself.

To learn about eager loading check this out https://craftcms.com/docs/templating/eager-loading-elements.


## Feature Requests & Issues

If you need a feature, let me know and I'll add it as soon as reasonably possible. Plus is actively maintained, and I accept relevant, feature-adding pull requests. If you encounter any issues, please open an issue and I'll work with you and patch the problem. Thanks!


## Feature Roadmap
As we approach Craft3 and the difficulties of multisite we will be making improvements as well to support any known changes.
