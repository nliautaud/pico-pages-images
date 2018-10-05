<?php
/**
 * Get the images of the current page with {{ images }} in Pico CMS.
 * Edited September 2018 by Brian Goncalves
 *
 * @author  Nicolas Liautaud <contact@nliautaud.fr>
 * @license http://opensource.org/licenses/MIT The MIT License
 * @link    http://nliautaud.fr
 * @link    http://picocms.org
 */
class PicoPagesImages extends AbstractPicoPlugin
{
    const API_VERSION = 2;
    private $path;
    private $root;

    /**
     * Register path relative to content without index and extension
     * var/html/content/foo/bar.md => foo/bar/
     *
     * Triggered after Pico has discovered the content file to serve
     *
     * @see Pico::resolveFilePath()
     * @see Pico::getRequestFile()
     *
     * @param string &$file absolute path to the content file to serve
     *
     * @return void
     */
    public function onRequestFile(&$file)
    {
        $contentDir = $this->getConfig('content_dir');
        $contentDirLength = strlen($contentDir);
        if (substr($file, 0, $contentDirLength) !== $contentDir) {
            return;
        }
        $contentExt = $this->getConfig('content_ext');
        $this->path = substr($file, $contentDirLength);
        $this->path = rtrim($this->path, "index$contentExt");
        $this->path = rtrim($this->path, $contentExt);
        if ($this->path) {
            $this->path .= '/';
        }
    }
    /**
     * Triggered after Pico has read its configuration
     *
     * @see    Pico::getConfig()
     * @param  array &$config array of config variables
     * @return void
     */
    public function onConfigLoaded(array &$config)
    {
        if (!empty($config['images_path'])) {
            $this->root = rtrim($config['images_path'], '/') . '/';
        } else {
            $this->root = 'images/';
        }
    }
    /**
     * Triggered before Pico renders the page
     *
     * @see DummyPlugin::onPageRendered()
     *
     * @param string &$templateName  file name of the template
     * @param array  &$twigVariables template variables
     *
     * @return void
     */
    public function onPageRendering(&$templateName, array &$twigVariables)
    {
        // Create images array
        $twigVariables['images'] = $this->getImages();
    }
    /**
     * Return the list and infos of images in the current directory.
     *
     * @return array
     */
    private function getImages()
    {
        $images_path = $this->root . $this->path;
        // Filter images path for extra slashes
        $images_path = preg_replace('/(\/+)/','/',$images_path);

        $data = array();
        $pattern = '*.{[jJ][pP][gG],[jJ][pP][eE][gG],[pP][nN][gG],[gG][iI][fF]}';
        $images = glob($images_path . $pattern, GLOB_BRACE);
        $meta = array();

        if (!is_array($images)) {
            return array();
        }

        foreach ($images as $path) {
            $imagesize = getimagesize($path);
            if (!is_array($imagesize)) {
                $imagesize = array();
            }
            list($width, $height,, $size) = array_pad($imagesize, 4, '');

            // Find meta files for images if they exist
            $metapath = $path . '.meta.yml';
            if (is_file($metapath)) {
                $yamlparser = $this->getPico()->getYamlParser();
                $meta = $yamlparser->parse(file_get_contents($metapath));
            }

            $data[] = array (
                'url' => $this->getBaseUrl() . $images_path . pathinfo($path, PATHINFO_BASENAME),
                'path' => $images_path,
                'name' => pathinfo($path, PATHINFO_FILENAME),
                'ext' => pathinfo($path, PATHINFO_EXTENSION),
                'width' => $width,
                'height' => $height,
                'size' => $size,
                'meta' => $meta
            );


        }
        return $data;
    }
}
