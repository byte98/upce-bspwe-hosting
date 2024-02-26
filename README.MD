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
    > ssh-keygen -t ed25519 -C ```root@server```
    >```
    > Replace [server] by actual address of server (like 192.168.0.1).
    >```
    >ssh-copy-id root@server
    >```
3. Make sure to have installed PowerShell at version 7.1 or later.
    > How to install PowerShell can be found at [official documentation](https://learn.microsoft.com/en-us/powershell/scripting/install/installing-powershell?view=powershell-7.4).
### 2. Running the installer
This application comes with quite helpful installer. Installer can be downloaded here:
> [Simple Hosting installer](https://github.com/byte98/upce-bspwe-hosting-installer/releases/latest/download/sh_installer.zip)

Unzip downloaded file and then continue. There are seweral ways how to run installer.

- **Windows**
    - Locate the file **install.ps1**
    - Right click
    - Run with PowerShell
- **Linux**
    - Run following command:
        ```
            pwsh /path/to/installer/install.ps1
        ```
Installer leads you through the whole installation process. It requires some additional information and could take some time, so be patient. In some cases, installer will lead you through steps, which installer cannot do itself. For these cases, be prepared to connect to the server and follow commands given by installer.

### 4. Handling errors
This section describes possible errors which can occure during installation process. Exit codes table shows exit codes of installer with commands which has been tried to execute, but execution failed.
Commands in exit codes table may or may not contain some value of variable. Meaning of this variables is in followiing table.
| Variable | Description                                                                                                        | Value            |
|:--------:|:-------------------------------------------------------------------------------------------------------------------|:-----------------|
| $WWWHome | Path, where Simple Hosting application will be installed. This value is hardcoded in installer and can be changed. | ``` /var/www ``` |
| $address | Address of server. This value is get by user during installation of web application (example: example.com)         |                  |
| $ip      | IP address of server. This value is get by installer dynamically.                                                  |                  |

Table with exit codes:
| Exit code | Command (or description)                                                                                                            |
| ----------|-------------------------------------------------------------------------------------------------------------------------------------|
| 0         | Simple Hosting was successfully installed on the server.                                                                            |
| 10        | SSH running on server was not confirmed.                                                                                            |
| 11        | SSH connection cannot be established.                                                                                               |
| 20        | ``` dnf install httpd -y ```                                                                                                        |
| 21        | ``` dnf install bind bind-utils -y ```                                                                                              |
| 30        | ``` rm -r -f $WWWHome ```                                                                                                           |
| 31        | ```mkdir -p $WWWHome```                                                                                                             |
| 32        | ```chown -R apache:apache $WWWHome```                                                                                               |
| 33        | ```wget -O /etc/httpd/conf.d/$address.conf https://github.com/byte98/upce-bspwe-hosting/releases/latest/download/root.conf.d```     |
| 34        | ```sed -i 's/`${name}/$address/g' /etc/httpd/conf.d/$address.conf```                                                                |
| 35        | ```wget -O $WWWHome/simple_hosting.zip https://github.com/byte98/upce-bspwe-hosting/releases/latest/download/simple_hosting.zip```  |
| 36        | ```unzip -o $WWWHome/simple_hosting.zip -d $WWWHome```                                                                              |
| 37        | ```rm -f $WWWHome/simple_hosting.zip```                                                                                             |
| 40        | ```wget -O /etc/named.conf https://github.com/byte98/upce-bspwe-hosting/releases/latest/download/named.conf.d```                    |
| 41        | ```sed -i 's/`${name}/$address/g' /etc/named.conf```                                                                                |
| 42        | ```sed -i 's/`${domain}/$address/g' /etc/named.conf```                                                                              |
| 43        | ```sed -i 's/`${ip}/$ip/g' /etc/named.conf```                                                                                       |
| 44        | ```chown -R named:named /etc/named```                                                                                               |
| 50        | ```firewall-cmd --add-service=http --permanent```                                                                                   |
| 51        | ```firewall-cmd --add-servtice=https --permanent```                                                                                 |
| 52        | ```firewall-cmd --add-service=dns --permanent```                                                                                    |
| 53        | ```firewall-cmd --reload```                                                                                                         |
| 60        | ```systemctl start httpd.service```                                                                                                 |
| 61        | ```systemctl enable httpd.service```                                                                                                |
| 62        | ```systemctl restart httpd.service```                                                                                               |
| 63        | ```systemctl start named.service```                                                                                                 |
| 64        | ```systemctl enable named.service```                                                                                                |
| 65        | ```systemctl restart named.service```                                                                                               |
