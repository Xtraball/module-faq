#!/usr/bin/env bash
name=`cat ./package.json |grep "name" |sed -n '1p' |cut -d '"' -f 4`
deployfolder=`cat ./package.json |grep "deployfolder" |sed -n '1p' |cut -d '"' -f 4`

# rsync -avu ./ /home/dev-arno/htdocs/siberian/app/local/modules/Subscribe/
# rsync -avu ./resources/var/apps/modules/subscribe/ /home/dev-arno/htdocs/siberian/var/apps/browser/modules/subscribe/
rsync -avu ./ $deployfolder/app/local/modules/$name/
rsync -avu ./resources/var/apps/modules/layout/ $deployfolder/var/apps/browser/modules/layout/
