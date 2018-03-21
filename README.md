# hypeUI

![Elgg 2.3](https://img.shields.io/badge/Elgg-2.3-orange.svg?style=flat-square)

## Features

 * Strips core CSS and rewrites everything from scratch using [Bulma.io](http://bulma.io)
 * Reimagines layouts, item views and navigation
 

## Notes

Note that this plugin/theme will likely have incompatibilities with other third party plugins.
The intention here is not to ensure broad compatibility, rather to demonstrate best practices for reducing boilerplate and implementing scalable/extendable themes.

## Screenshots

![Walled Garden](https://raw.github.com/hypeJunction/hypeUI/master/screenshots/walled-garden.png "Walled Garden")
![Files](https://raw.github.com/hypeJunction/hypeUI/master/screenshots/files.png "Files")
![Blog](https://raw.github.com/hypeJunction/hypeUI/master/screenshots/blog.png "Blog")
![Groups](https://raw.github.com/hypeJunction/hypeUI/master/screenshots/groups.png "Groups")
![Admin](https://raw.github.com/hypeJunction/hypeUI/master/screenshots/admin.png "Admin")

## Development

To start development, download the sources and run

    npm install

To build the needed css files, run

    grunt build

Releases are done using grunt and can only be used when having push access to official repository.

To create a new release, run

    grunt release:<version>
    e.g. grunt release:1.3.2

Please adhere to the [SemVer](https://semver.org/) standard when choosing version numbers.