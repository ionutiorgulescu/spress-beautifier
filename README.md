## Beautify HTML

![Spress 2 ready](https://img.shields.io/badge/Spress%202-ready-brightgreen.svg)

Beautify your Spress HTML output

Inspired by [spress-html-compress](https://github.com/paramonovav/spress-html-compress)

### How do I install it?

Go to your Spress site and add the following to your `composer.json` and run 
`composer update`:

```json
"require": {
    "rattrap/spress-html-beautifier": "1.0.*"
}
```

### How do I use it?

Add the following to your config.yml to exclude some files from minify/compress process:

```yaml
html_beautifier_excluded: ['.htaccess', 'CNAME', 'robots.txt', 'crossdomain.xml', 'sitemap.xml', 'rss.xml']
```

And run the build command:

```bash
spress site:build
```