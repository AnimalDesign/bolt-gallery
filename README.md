# ANIMAL Gallery

This [Bolt CM](https://bolt.cm) extension provides a little twig function to list images from a custom folder inside the `files` directory.

## Example Usage

```
{% set images = imagelist(folder = 'gallery/' ~ record.slug) %}

{% if images %}
<ul>
	{% for image in images %}
	<li>
		<img src="{{ image(image) }}">
	</li>
	{% endfor %}
</ul>
{% endif %}
```

## About

„We build it“ — [ANIMAL](http://animal.at)