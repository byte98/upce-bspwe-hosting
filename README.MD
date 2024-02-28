# Simple Hosting
This repository contains application Simple Hosting, which provides basic web hosting services. This application has been created as semestral project for 'Web-Server Administration' subject at Faculty of Electrical Engineering and Informatics, University of Pardubice.

## Installation
Installation is pretty straight-forward. Just follow next steps.

### 1. Prerequisities
Before starting installation process, there are some steps needed to do.
1. Make sure that you have prepared server with Fedora Server running (all files can be downladed [here](https://fedoraproject.org/server/download]) ).
2. Be sure to have created SSH key on your system and uploaded to the server.
    > If you don't have created SSH key on your system, it can be done with following commands:
    >```
    > ssh-keygen -t ed25519 -C "root@[server]"
    >```
    > Replace [server] by actual address of server (like 192.168.0.1).
    >```
    >ssh-copy-id root@[server]
    >```
3. Make sure to have installed PowerShell at version 7.1 or later.
    > How to install PowerShell can be found at [official documentation](https://learn.microsoft.com/en-us/powershell/scripting/install/installing-powershell?view=powershell-7.4).
### 2. Running the installer
This application comes with quite helpful installer. Installer can be downloaded here:
> [Simple Hosting installer](https://github.com/byte98/upce-bspwe-hosting-installer/releases/latest/download/sh_installer.zip)

Unzip downloaded file and then continue. There are seweral ways how to run installer.

- **Windows**
    1. Locate the file **install.ps1**
    2. Right click
    3 Run with PowerShell
- **Linux**
    1. Run following command:
        ```
            pwsh /path/to/installer/install.ps1
        ```
Installer leads you through the whole installation process. It requires some additional information and could take some time, so be patient. In some cases, installer will lead you through steps, which installer cannot do itself. For these cases, be prepared to connect to the server and follow commands given by installer.

### 3. Post-installation
If you want to test hosting service on your local environment, then you need to slightly modify your network settings. Luckily, only thing, which needs modification, is DNS settings. On your machine, add address of server as the first entry in DNS servers list. Following guide expects using IPv4 protocol. If you are using IPv6, please, use internet search engine to find guide for your platform.
- **Windows**
    1. Open 'run' window (Win + R)
    2. Type ```ncpa.cpl``` and press 'Run' (Enter)
    3. Right click on your actual connection
    4. Select 'Properties'
    5. Select 'Networking' tab
    6. In the list, find 'Internet Protocol Version 4 (TCP/IPv4)'
    7. Click on 'Advanced'
    8. Select option 'Use the following DNS server addresses:'
    9. As preferred DNS server, set IP address of server with installed Simple Hosting
    10. As alternate DNS server, set any valid DNS server (defined by your ISP or any public DNS server)
    11. Click 'OK'
- **Linux**
    1. Open ```/etc/resolv.conf``` file with root priviledges using your faviourite text editor (example: ```sudo nano /etc/resolv.conf```)
    2. Add following entry above all existing nameserver directives:
        ``` nameserver [address]```
    3. Replace ```[address]``` with actual IP address of server with installed Simple Hosting
    4. Save file
    >
    > When using DHCP to manage network information, this solution is just temporal. When DHCP settings will be renewed, these steps must be done again.
    >

### 4. Handling errors
This section describes possible errors which can occure during installation process. Exit codes table shows exit codes of installer with commands which has been tried to execute, but execution failed.
Commands in exit codes table may or may not contain some value of variable. Meaning of this variables is in following table.
| Variable       | Description                                                                                                        | Value                 |
|:--------------:|:-------------------------------------------------------------------------------------------------------------------|:----------------------|
| ```$WWWHome``` | Path, where Simple Hosting application will be installed. This value is hardcoded in installer and can be changed. | ``` /var/www/html ``` |
| ```$address``` | Address of server. This value is get by user during installation of web application (example: contoso.com).        |                       |
| ```$ip```      | IP address of server. This value is get by installer dynamically.                                                  |                       |
| ```$admin```   | E-mail address of administrator. This is get from user by installer.                                               |                       |

Table with exit codes:
| Exit code | Command (or description)                                                                                                                                                                                |
| :--------:|:--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| 0         | Simple Hosting was successfully installed on the server.                                                                                                                                                |
| 10        | SSH running on server was not confirmed.                                                                                                                                                                |
| 11        | SSH connection cannot be established.                                                                                                                                                                   |
| 12        | Installation of PowerShell on server was not confirmed.                                                                                                                                                 |
| 20        | <code>dnf install httpd -y </code>                                                                                                                                                                        |
| 21        | <code>dnf install bind bind-utils -y </code>                                                                                                                                                              |
| 22        | <code>dnf install snapd -y </code>                                                                                                                                                                        |
| 23        | Installer cannot reconnect to the server using SSH.                                                                                                                                                     |
| 24        | <code>rm -r -f /snap && rm -r -f /usr/bin/certbot && ln -s /var/lib/snapd/snap /snap && snap install --classic certbot && ln -s /snap/bin/certbot /usr/bin/certbot</code>                                 |
| 30        | <code>rm -f /etc/httpd/conf/httpd.conf </code>                                                                                                                                                            |
| 31        | <code>wget -O /etc/httpd/conf/httpd.conf https://github.com/byte98/upce-bspwe-hosting/releases/latest/download/httpd.conf </code>                                                                         |
| 32        | <code>sed -i 's#`${www}#<b><i>$WWWHome</i></b>#g' /etc/httpd/conf/httpd.conf </code>                                                                                                                      |
| 33        | <code>sed -i 's#`${admin}#<b><i>$admin</b></i>#g' /etc/httpd/conf/httpd.conf</code>                                                                                                                       |
| 34        | <code>sed -i '/^[^#]/ s/^/# /' /etc/httpd/conf.d/welcome.conf </code>                                                                                                                                     |
| 35        | <code>wget -O /etc/httpd/conf.d/<b><i>$address</b></i>.conf </code>                                                                                                                                       |
| 36        | <code> sed -i 's#`${admin}#$admin#g' /etc/httpd/conf.d/$address.conf && sed -i 's#`${www}#$WWWHome#g' /etc/httpd/conf.d/$address.conf && sed -i 's#`${name}#$address#g' /etc/httpd/conf.d/$address.conf </code>|
| 37        | <code>systemctl restart httpd</code>                                                                                                                                                                      |
| 40        | <code>dnf install mod_ssl -y</code>                                                                                                                                                                       |
| 50        | <code>rm -r -f <b><i>$WWWHome</i></b> </code>                                                                                                                                                             |
| 51        | <code>mkdir -p <b><i>$WWWHome</i></b> </code>                                                                                                                                                             |
| 52        | <code>chown -R apache:apache <b><i>$WWWHome</i></b> </code>                                                                                                                                               |
| 53        | <code>wget -O <b><i>$WWWHome/</i></b>simple_hosting.zip https://github.com/byte98/upce-bspwe-hosting/releases/latest/download/simple_hosting.zip </code>                                                  |
| 54        | <code>unzip -o <b><i>$WWWHome</i></b>/simple_hosting.zip -d <b><i>$WWWHome </code>                                                                                                                        |
| 55        | <code>rm -f <b><i>$WWWHome</i></b>/simple_hosting.zip </code>                                                                                                                                             |
| 60        | <code>certbot run -n --apache -d <b><i>$address</i></b>,www.<b><i>$address</i></b> -m <b><i>$admin</i></b> --redirect --agree-tos</code>                                                                  |
| 61        | <code>crontab -l > tmp && echo '0 */12 * * * certbot renew' >> tmp && crontab tmp && rm -f tmp</code>                                                                                                     |
| 70        | <code>wget -O /etc/named.conf https://github.com/byte98/upce-bspwe-hosting/releases/latest/download/named.conf.d </code>                                                                                  |
| 71        | <code>sed -i 's/`${name}/<b><i>$address</i></b>/g' /etc/named.conf </code>                                                                                                                                |
| 72        | <code>sed -i 's/`${domain}/<b><i>$address</i></b>/g' /etc/named.conf </code>                                                                                                                              |
| 73        | <code>sed -i 's/`${ip}/<b><i>$ip</i></b>/g' /etc/named.conf </code>                                                                                                                                       |
| 74        | <code>chown -R named:named /etc/named </code>                                                                                                                                                             |
| 80        | <code>firewall-cmd --add-service=http --permanent </code>                                                                                                                                                 |
| 81        | <code>firewall-cmd --add-service=https --permanent </code>                                                                                                                                                |
| 82        | <code>firewall-cmd --add-service=dns --permanent </code>                                                                                                                                                  |
| 83        | <code>firewall-cmd --reload </code>                                                                                                                                                                       |
| 90        | <code>systemctl start httpd.service </code>                                                                                                                                                               |
| 91        | <code>systemctl enable httpd.service </code>                                                                                                                                                              |
| 92        | <code>systemctl restart httpd.service </code>                                                                                                                                                             |
| 93        | <code>systemctl start named.service </code>                                                                                                                                                               |
| 94        | <code>systemctl enable named.service </code>                                                                                                                                                              |
| 95        | <code>systemctl restart named.service </code>                                                                                                                            |
