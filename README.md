# Pico Pages Images

Access to the images of the current page in [Pico CMS](http://pico.dev7studios.com).

### Installation

Copy `pico_pages_images.php` to the `plugins/` directory of your Pico Project.

### Usage

Images are listed in the Twig variable `images` accessible in your theme, for example using a loop :

```html
{% for image in images %}
	<img src="{{ image.url }}" alt="{{ image.name }}" {{ image.size }}>
{% endfor %}
```

An image corresponding to the page `http://mysite.com/images/foo/bar` may contain the following data :

	image.url		:	http://mysite.com/content/foo/bar/bar-image_01.jpg
	image.path	 	:	content/foo/bar/
	image.name	 	:	bar-image_01
	image.ext		:	jpg
	image.width	 	:	800
	image.height	:	600
	image.size	 	:	width="800" height="600"

### Files location

By default, images are stored in the `content/` folder, next to the pages.

	content/
		bar/
			bar-image_01.jpg
			bar-image_02.gif
			index.md
		foo/
			foo-image_01.jpg
			foo-image_02.png
			index.md

-------------
*The following structure, clearer, may be possible too with a slightly fix in Pico (allowing a directory with the same name that a page) :*

	content/
		bar/
			bar-image_01.jpg
			bar-image_02.gif
		foo/
			foo-image_01.jpg
			foo-image_02.png
		bar.md
		foo.md
---------------

Thus, if you don't want to place images directly in the content folder you can specify a different location by using the configuration setting `images_path` :

	$settings['images_path'] = 'images/';

Using the example above, the system structure will be :

	content/
		bar.md
		foo.md
	images/
		bar/
			bar-image_01.jpg
			bar-image_02.gif
		foo/
			foo-image_01.jpg
			foo-image_02.png

