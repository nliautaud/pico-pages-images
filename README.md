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

### Adding metadata captions

Create a YAML file in the same directory as the image and append `.meta.yml` to the image filename. 

For example: `bar-image_01.jpg.meta.yml`

```yml
title: Fido Playing with his Bone
description: The other day, Fido got a new bone, and he became really captivated by it.
```

Example loop with metadata as captions :

```html
{% for image in images %}
    <img src="{{ image.url }}" alt="{{ image.name }}" {{ image.size }}>
    {% if image.metatitle and image.metadesc %}
        <p>{{ image.metatitle }}<br />{{ image.metadesc }}</p>
    {% endif %}
{% endfor %}
```

An image corresponding to the page `http://mysite.com/foo/bar` may contain the following data :

Data | Example
---|---
`image.url` | http://mysite.com/images/foo/bar/bar-image_01.jpg
`image.path` | images/foo/bar/
`image.name` | bar-image_01
`image.ext` | jpg
`image.width` | 800
`image.height` | 600
`image.size` | width="800" height="600"
`image.metatitle` | Fido Playing with his Bone
`image.metadesc` | The other day, Fido got a new bone, and he became really captivated by it.

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

You can specify a different location in the Pico config file with the setting `images_path` :

```yml
images_path: images/
```
If you want to use your `content/` directory as the images path  you must also add the following to your `.htaccess` file :

```
# Allow loading images
RewriteRule ^.*\.(gif|jpe?g|png|webp)$ - [NC,L]
```
