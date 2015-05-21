# img_resize

To use this in a WordPress theme, simply include it in the functions.php file:

```PHP
include 'include/img_resize.php';
```

## Usage

### Arguments

```PHP
img_resize($imageURL, $width, $height, $crop = false);
```

Height can be left null to change height proportional to width.

#### Example

```PHP
$headerImage = img_resize(get_theme_mod('header_image'), 200, null);
```
