# chat_001
Minimalistic chat for Lamp-stack

Since it has no log-in, and one use it online, it's better to have it's folder password-protected:

From https://stackoverflow.com/questions/5229656, instruction for that:

It's a simple two step process

In your .htaccess put

AuthType Basic
AuthName "restricted area"
AuthUserFile /path/to/the/directory/you/are/protecting/.htpasswd
require valid-user
use http://www.htaccesstools.com/htpasswd-generator/ or command line to generate password and put it in the .htpasswd

Note 1: If you are using cPanel you should configure in the security section "Password Protect Directories"

EDIT: If this didn't work then propably you need to do a AllowOverride All to the directory of the .htaccess (or atleast to previous ones) in http.conf followed by a apache restart

<Directory /path/to/the/directory/of/htaccess>
      Options Indexes FollowSymLinks MultiViews
      AllowOverride All
</Directory>
