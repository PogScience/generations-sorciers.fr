if [ "$1" = "watch" ]; then
  sass --watch --sourcemap=auto sass/generations-sorciers.sass:htdocs/assets/generations-sorciers.min.css
else
  rm htdocs/assets/generations-sorciers.min.css.map
  sass --sourcemap=none --style compressed sass/generations-sorciers.sass:htdocs/assets/generations-sorciers.min.css
fi
