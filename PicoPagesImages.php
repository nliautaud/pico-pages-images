<?php

/**
 * Access the images of the current page with {{ images }} in Pico CMS.
 *
 * @author  Nicolas Liautaud
 * @link    http://nliautaud.fr
 * @link    http://picocms.org
 * @license http://opensource.org/licenses/MIT The MIT License
 */
class PicoPagesImages extends AbstractPicoPlugin
{
    private $path = '';
    private $root;

    /**
     * Register path relative to content without index and extension
     * var/html/content/foo/bar.md => foo/bar/
     *
     * Triggered after Pico has discovered the content file to serve
     *
     * @see    Pico::getBaseUrl()
     * @see    Pico::getRequestFile()
     * @param  string &$file absolute path to the content file to serve
     * @return void
     */
    public function onRequestFile(&$requestFile)
    {
        $contentDir = $this->getConfig('content_dir');
        $contentDirLength = strlen($contentDir);
        if (substr($requestFile, 0, $contentDirLength) !== $contentDir)
          return;
        $contentExt = $this->getConfig('content_ext');
        $this->path = substr($requestFile, $contentDirLength);
        $this->path = rtrim($this->path, "index$contentExt");
        $this->path = rtrim($this->path, $contentExt);
        if ($this->path) $this->path .= '/';
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
        if (!empty($config['images_path']))
            $this->root = rtrim($config['images_path'], '/') . '/';
        else $this->root = 'images/';
    }
    /**
     * Triggered before Pico renders the page
     *
     * @see    Pico::getTwig()
     * @see    DummyPlugin::onPageRendered()
     * @param  Twig_Environment &$twig          twig template engine
     * @param  array            &$twigVariables template variables
     * @param  string           &$templateName  file name of the template
     * @return void
     */
    public function onPageRendering(Twig_Environment &$twig, array &$twigVariables, &$templateName)
    {
        $twigVariables['images'] = $this->images_list();
    }
    /**
     * Return the list and infos of images in the current directory.
     *
     * @return array
     */
    private function images_list()
    {
        $images_path = $this->root . $this->path;

        $data = array();
        $pattern = '*.{[jJ][pP][gG],[jJ][pP][eE][gG],[pP][nN][gG],[gG][iI][fF]}';
        $images = glob($images_path . $pattern, GLOB_BRACE);

        if (!is_array($images)) return array();

        foreach( $images as $path )
        {
            list($width, $height, $type, $size, $mime) = array_pad(getimagesize($path), 5, '');

            $data[] = array (
                'url' => $this->getBaseUrl() . $images_path . pathinfo($path, PATHINFO_BASENAME),
                'path' => $images_path,
                'name' => pathinfo($path, PATHINFO_FILENAME),
                'ext' => pathinfo($path, PATHINFO_EXTENSION),
                'width' => $width,
                'height' => $height,
                'size' => $size
            );
        }
        return $data;
    }
}
?>
