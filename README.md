# Pico Pages Images

Access to the images of the current page in [Pico CMS](http://pico.dev7studios.com).

### Installation

Copy `pico_pages_images.php` to the `plugins/` directory of your Pico Project.

### Usage

Loop trough the Twig `images` variable in your theme, or access to an image directly.

```html
{% for image in images %}
	<img src="{{ image.url }}" alt="{{ image.name }}" {{ image.size }}>
{% endfor %}

{{ images[0].name }}
```

The images are nicely stored next to the page file, or in a folder using the same name.

	path/
		foo/
			foo-image_01.jpg
			foo-image_02.png
			index.md
		bar/
			bar-image_01.jpg
			bar-image_02.gif
		bar.md


The images contains the following data :

	image.url		:	http://mysite.com/page/image.jpg
	image.path	 	:	page/
	image.name	 	:	image
	image.ext		:	jpg
	image.width	 	:	800
	image.height	:	600
	image.size	 	:	width="800" height="600"