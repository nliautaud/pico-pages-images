# Pico Pages Images

Find images corresponding to the current page in [Pico CMS](http://picocms.org).

## Installation

Copy `PicoPagesImages.php` to the `plugins/` directory of your Pico Project.

## Usage

Images are listed in the Twig variable `{{ images }}` accessible in your theme.

Example of using a loop :

```html
{% for image in images %}
    <img src="{{ image.url }}" alt="{{ image.name }}" {{ image.size }}>
{% endfor %}
```

An image corresponding to the page `http://mysite.com/content/foo/bar` may contain the following data :

Data | Example
---|---
`image.url` | http://mysite.com/images/foo/bar/bar-image_01.jpg
`image.path` | images/foo/bar/
`image.name` | bar-image_01
`image.ext` | jpg
`image.width` | 800
`image.height` | 600
`image.size` | width="800" height="600"

## Files location

Images are listed from a directory reproducting the pages path (in `images/` next to content by default).

    content/
        foo/
            bar.md
    images/
        foo/
            foo-image_01.jpg
            foo-image_02.png
            bar/
                bar-image_01.jpg
                bar-image_02.gif

You can specify a different location by using the configuration setting `images_path` :

```php
$config['images_path'] = 'images/';
```
