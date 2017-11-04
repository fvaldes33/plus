<?php
namespace fvaldes\plus\twigextensions;

use Craft;
use fvaldes\plus\Plugin;

/**
 * Twig can be extended in many ways; you can add extra tags, filters, tests, operators,
 * global variables, and functions. You can even extend the parser itself with
 * node visitors.
 *
 * http://twig.sensiolabs.org/doc/advanced.html
 *
 * @author    UNION
 * @package   Union
 * @since     1.0.1
 */
class PlusTwigExtension extends \Twig_Extension
{
    // Public Methods
    // =========================================================================

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'Plus';
    }

    /**
     * Returns an array of Twig filters, used in Twig templates via:
     *
     *      {{ 'something' | someFilter }}
     *
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('videoEmbedUrl', [$this, 'videoEmbedUrl'], [
                'is_safe' => [
                    'evaluate' => true
                ]]
            )
        ];
    }

    /**
     * Returns an array of Twig functions, used in Twig templates via:
     *
     * {% set this = plus('service').method() %}
     *
     * @return mixed
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('plus', [$this, 'findService']),
        ];
    }

    /**
     * Service Locator
     *
     * @param null $name
     * @return service
     */
    public function findService($name)
    {
        return Plugin::$plugin->{$name};
    }

    /**
     * Currently supports vimeo and youtube urls in the following formats:
     * - https://vimeo.com/VIDEO_ID
     * - https://player.vimeo.com/video/VIDEO_ID
     * - https://www.youtube.com/watch?v=VIDEO_ID
     * - https://youtu.be/VIDEO_ID
     * - https://www.youtube.com/embed/VIDEO_ID
     * @param null $source string
     * @return service
     */
    public function videoEmbedUrl($sourceUrl)
    {
        $stripProtocol = preg_replace('/^((https?:)?\/\/(www.)?)?/', '', $sourceUrl);

        if (
            strpos($stripProtocol, 'player.vimeo.com/video/') === 0
            ||
            strpos($stripProtocol, 'youtube.com/embed/') === 0
        ) {
            // embed ready
            return $sourceUrl;
        }

        if (strpos($stripProtocol, 'vimeo.com/') === 0) {
            preg_match('/vimeo.com\/(\d+)/', $stripProtocol, $parts);
            $id = $parts[1];
            return "https://player.vimeo.com/video/{$id}";
        }

        if (strpos($stripProtocol, 'youtu.be') === 0) {
            preg_match('/youtu.be\/([^?]+)/', $stripProtocol, $parts);
            $id = $parts[1];
            return "https://www.youtube.com/embed/{$id}";
        }

        if (strpos($stripProtocol, 'youtube.com/watch') === 0) {
            preg_match('/[?&]v=([^\&]+)/', $stripProtocol, $parts);
            $id = $parts[1];
            return "https://www.youtube.com/embed/{$id}";
        }

        return false;
    }
}
