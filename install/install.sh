#!/bin/bash
git clone https://github.com/trembmat/cms6.git

cd cms6
git clone https://github.com/trembmat/prog6.git
git clone https://github.com/trembmat/webext.git

git checkout -b clientside

mkdir config
touch config/index.php

echo "$db_host = \"\";\n" >> db.php
echo "$db_user = \"\";\n" >> db.php
echo "$db_pass = \"\";\n" >> db.php
echo "$db_name = \"\";\n" >> db.php
   
echo "/*****************************************************/\n" >> config.php
echo "/* You use paths relative to your cms6 root directory */\n" >> config.php
echo "/*****************************************************/\n" >> config.php
echo "$my_prog6_folder = \"prog6/\";\n" >> config.php
echo "$my_db_config = \"config/db.php\"; \n" >> config.php
echo "/*****************************************************/\n" >> config.php

mkdir public
mkdir public/images
mkdir public/thumbs
chmod 755 -R public

mkdir tmp
chmod 755 -R tmp

