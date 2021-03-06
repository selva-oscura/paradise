#!/bin/sh

#################################################
# Paradise ~ centerkey.com/paradise             #
# GPLv3 ~ Copyright (c) individual contributors #
#################################################

# Update Web Files:
# Copies files to FTP folder

websiteFolder=$(cd $(dirname $0); pwd)
httpdConf=/private/etc/apache2/httpd.conf
webServerRoot=$(grep ^DocumentRoot $httpdConf | awk -F\" '{ print $2 }')
webServerPath=centerkey.com/paradise
ftpFolder=$webServerRoot/$webServerPath

viewWebsite() {
   echo "*** Open HTML files"
   cd $websiteFolder
   pwd
   ls -l *.html
   open logo.html
   open index.html
   echo
   }

copyToFtpFolder() {
   echo "*** Copy to FTP folder"
   cd $websiteFolder
   echo $ftpFolder
   mkdir -p $ftpFolder/graphics
   cp -v *.css *.html $ftpFolder
   cp -v graphics/*   $ftpFolder/graphics
   open http://localhost/$webServerPath
   echo
   }

echo
echo "Paradise ~ View Project Website"
echo "==============================="
echo
viewWebsite
test -w $ftpFolder && copyToFtpFolder
