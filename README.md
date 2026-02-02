# WooCommerce My Account – Favorites Endpoint

A lightweight boilerplate to add a **Favorites** section inside the WooCommerce *My Account* area.  
Favorites are stored in **user meta only** (not in product meta) to avoid duplication and performance overhead.

## Quick Start

1. Copy `enqueue.php` and `favorite-functions.php` into your theme’s `/includes/` folder.  
2. Include them in your `functions.php`:
```php
require_once get_theme_file_path( '/includes/enqueue.php' );
require_once get_theme_file_path( '/includes/favorite-functions.php' );
```
3. Copy favorite.php into your-theme/woocommerce/myaccount/favorite.php.
4. Access favorites at /my-account/favorites/ and start adding/removing favorites on shop or product pages.

---

## Features

- Adds a new **/favorites** endpoint to My Account  
- AJAX add/remove favorite from:
  - Shop loop  
  - Single product page  
- Stores data in `user_meta`  
- Displays favorite products using native WooCommerce templates  
- Loads assets only on WooCommerce pages  
- Versioning based on file modified time  
- Translation ready with **custom text domain**

---


## Installation

1. **Add files to your theme**
- Copy `enqueue.php` and `favorite-functions.php` into your theme’s `/includes/` folder.  
- Include them in your theme’s `functions.php`:
```php
require_once get_theme_file_path( '/includes/enqueue.php' );
require_once get_theme_file_path( '/includes/favorite-functions.php' );
```
2. Add template
- Copy favorite.php into your WooCommerce folder inside your theme:
```php
your-theme/woocommerce/myaccount/favorite.php
```
3. Translation
- The code uses woocommerce as the text domain by default.
- You can replace it with your own theme or plugin text domain if needed.

## How to Use
- Users can view their favorites at: `/my-account/favorites/`
- Flush permalinks once for the new endpoint to be accessible.
- Add / Remove Favorites: Click the favorite icon/button to add or remove products on shop loop and product details page.

## Notes
- Favorite products are displayed using native WooCommerce hooks, making further customization easy.
- Scripts and styles are loaded conditionally to optimize performance.
- Favorites are stored in user meta only, so no duplication or performance overhead occurs.