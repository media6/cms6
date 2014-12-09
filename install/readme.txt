You should run those  lines using ssh 


git clone https://github.com/media6/cms6.git
cd cms6
  
git clone https://github.com/media6/prog6.git
git clone https://github.com/trembmat/webext.git

git checkout -b "clientside"

mkdir "config"
touch "config/index.php"

echo "<?" >> "config/db.php"
echo "\$my_db_host = '';" >> "config/db.php"
echo "\$my_db_user = '';" >> "config/db.php"
echo "\$my_db_pass = '';" >> "config/db.php"
echo "\$my_db_name = '';" >> "config/db.php"
echo "?>" >> "config/db.php"                                

echo "<?" >> "config/config.php"
echo "/*****************************************************/" >> "config/config.php"
echo "/* You use paths relative to your cms6 root directory */" >> "config/config.php"
echo "/*****************************************************/" >> "config/config.php"
echo "\$my_prog6_folder = 'prog6';" >> "config/config.php"
echo "\$my_db_config = 'config/db.php';" >> "config/config.php"
echo "/*****************************************************/" >> "config/config.php"
echo "?>" >> "config/config.php"

mkdir "public"
mkdir "public/images"
mkdir "public/thumbs"
chmod 755 -R "public"

mkdir "tmp"
chmod 755 -R "tmp"

