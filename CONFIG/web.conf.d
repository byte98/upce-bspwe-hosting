<VirtualHost *:80>
    ServerAdmin webmaster@${name}
    DocumentRoot /home/${name}
    ServerName ${name}
    ErrorLog /var/log/httpd/${name}_error.log
    CustomLog /var/log/httpd/${name}_access.log combined
</VirtualHost>
