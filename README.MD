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
| ```$address``` | Address of server. This value is get by user during installation of web application (example: example.com)         |                       |
| ```$ip```      | IP address of server. This value is get by installer dynamically.                                                  |                       |

Table with exit codes:
| Exit code | Command (or description)                                                                                                                                |
| :--------:|:--------------------------------------------------------------------------------------------------------------------------------------------------------|
| 0         | Simple Hosting was successfully installed on the server.                                                                                                |
| 10        | SSH running on server was not confirmed.                                                                                                                |
| 11        | SSH connection cannot be established.                                                                                                                   |
| 20        | <pre>dnf install httpd -y </pre>                                                                                                                        |
| 21        | <pre>dnf install bind bind-utils -y </pre>                                                                                                              |
| 30        | <pre>rm -f /etc/httpd/conf/httpd.conf </pre>                                                                                                            |
| 31        | <pre>wget -O /etc/httpd/conf/httpd.conf https://github.com/byte98/upce-bspwe-hosting/releases/latest/download/httpd.conf </pre>                         |
| 32        | <pre>sed -i 's#`${www}#<b><i>$WWWHome</i></b>#g' /etc/httpd/conf/httpd.conf </pre>                                                                      |
| 33        | <pre>sed -i '/^[^#]/ s/^/# /' /etc/httpd/conf.d/welcome.conf </pre>                                                                                     |
| 40        | <pre>rm -r -f <b><i>$WWWHome</i></b> </pre>                                                                                                             |
| 41        | <pre>mkdir -p <b><i>$WWWHome</i></b> </pre>                                                                                                             |
| 42        | <pre>chown -R apache:apache <b><i>$WWWHome</i></b> </pre>                                                                                               |
| 43        | <pre>wget -O <b><i>$WWWHome/</i></b>simple_hosting.zip https://github.com/byte98/upce-bspwe-hosting/releases/latest/download/simple_hosting.zip </pre>  |
| 44        | <pre>unzip -o <b><i>$WWWHome</i></b>/simple_hosting.zip -d <b><i>$WWWHome </pre>                                                                        |
| 45        | <pre>rm -f <b><i>$WWWHome</i></b>/simple_hosting.zip </pre>                                                                                             |
| 50        | <pre>wget -O /etc/named.conf https://github.com/byte98/upce-bspwe-hosting/releases/latest/download/named.conf.d </pre>                                  |
| 51        | <pre>sed -i 's/`${name}/<b><i>$address</i></b>/g' /etc/named.conf </pre>                                                                                |
| 52        | <pre>sed -i 's/`${domain}/<b><i>$address</i></b>/g' /etc/named.conf </pre>                                                                              |
| 53        | <pre>sed -i 's/`${ip}/<b><i>$ip</i></b>/g' /etc/named.conf </pre>                                                                                       |
| 54        | <pre>chown -R named:named /etc/named </pre>                                                                                                             |
| 60        | <pre>firewall-cmd --add-service=http --permanent </pre>                                                                                                 |
| 61        | <pre>firewall-cmd --add-service=https --permanent </pre>                                                                                                |
| 62        | <pre>firewall-cmd --add-service=dns --permanent </pre>                                                                                                  |
| 63        | <pre>firewall-cmd --reload </pre>                                                                                                                       |
| 70        | <pre>systemctl start httpd.service </pre>                                                                                                               |
| 71        | <pre>systemctl enable httpd.service </pre>                                                                                                              |
| 72        | <pre>systemctl restart httpd.service </pre>                                                                                                             |
| 73        | <pre>systemctl start named.service </pre>                                                                                                               |
| 74        | <pre>systemctl enable named.service </pre>                                                                                                              |
| 75        | <pre>systemctl restart named.service </pre>                                                                                                             |
