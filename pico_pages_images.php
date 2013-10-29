<?php
/**
 * Access to the images of the current page folder with {{ images }} in Pico CMS.
 *
 * @author  Nicolas Liautaud
 * @link http://nliautaud.fr
 * @link http://pico.dev7studios.com
 * @license http://opensource.org/licenses/MIT
 */
class Pico_Pages_Images
{
	private $path;

	// Pico hooks ---------------

	/**
	 * Register the images path.
	 */
	public function request_url(&$url)
	{
		$this->path = $this->format($url);
	}

	/**
	 * Register the images data in {{ images }} Twig variable.
	 */
	public function before_render(&$twig_vars, &$twig)
	{
		$twig_vars['images'] = $this->images_list($twig_vars['base_url']);
	}


	// CORE ---------------

	/**
	 * Return the images path based on the given path.
	 */
	private function format($path)
	{
		$is_index = strripos($path, 'index') === strlen($path)-5;
		if($is_index) return substr($path, 0, -5);
		elseif($path) $path .= '/';

		return $path;
	}
	/**
	 * Return the list and infos of images in the current directory.
	 */
	private function images_list($base_url)
	{
		$data = array();
		$pattern = '*.{[jJ][pP][gG],[jJ][pP][eE][gG],[pP][nN][gG],[gG][iI][fF]}';
		$images = glob(CONTENT_DIR . $this->path . $pattern, GLOB_BRACE);

		foreach ($images as $path)
		{
			list(, $basename, $ext, $filename) = array_values(pathinfo($path));
			list($width, $height, $type, $size, $mime) = getimagesize($path);

			$data[] = array (
				'url' => $base_url . '/content/' . $this->path . $basename,
				'path' => $this->path,
				'name' => $filename,
				'ext' => $ext,
				'width' => $width,
				'height' => $height,
				'size' => $size
			);
		}
		return $data;
	}
}
?>