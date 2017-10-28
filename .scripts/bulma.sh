#!/usr/bin/env bash

# Based on https://gist.github.com/knowuh/1189728

# This script copies Bulma source files and converts them to .scss

#convert .sass files to scss files:
sass-convert -R --from sass --to scss ./node_modules/bulma/sass/ ./views/default/bulma/
sass-convert --from sass --to scss ./node_modules/bulma/bulma.sass ./views/default/bulma/bulma.scss

# replace local @imports what include the .sass extension
find ./views/default/bulma/ -name "*.scss" | xargs sed -i "s/\.sass//g"
find ./views/default/bulma/ -name "*.scss" | xargs sed -i "s/sass\///g"


#ensure that we got them all
grep -R "@import" ./views/default/bulma/