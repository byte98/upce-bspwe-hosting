# Simple Hosting
This repository contains application Simple Hosting, which provides basic web hosting services. This application has been created as semestral project for 'Web-Server Administration' subject at Faculty of Electrical Engineering and Informatics, University of Pardubice.

## Installation
Installation is pretty straight-forward. Just follow next steps.

### 0. Prerequisities
Before starting installation process, there are some steps needed to do.
1. Make sure that you have prepared server with Fedora Server running (all files can be downladed [here](https://fedoraproject.org/server/download]) ).
2. Be sure to have created SSH key on your system and uploaded to the server.
    > If you don't have created SSH key on your system, it can be done with following commands:
    >```
    > ssh-keygen -t ed25519 -C "root@server"
    >```
    > Replace [server] by actual address of server (like 192.168.0.1).
    >```
    >ssh-copy-id root@server
    >```
3. Make sure to have installed PowerShell at version 7.1 or later.
    > How to install PowerShell can be found at [official documentation](https://learn.microsoft.com/en-us/powershell/scripting/install/installing-powershell?view=powershell-7.4).
### 1. Running the installer
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
