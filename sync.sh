#!/bin/bash

function _rsync() {

    source config;

    if [ $1 == "down" ]
    then
        echo "INCOMING!"
        sshpass -p $Password rsync -e "ssh -p $Port" --progress --partial -avz  $Username@$RemoteSite:/home/$RemoteDir/public_html/wp-content/* ~/Local\ Sites/$LocalDir/app/public/content

    elif [ $1 == "up" ]
    then
        echo "...hold on to your butts"
        sshpass -p $Password rsync -e "ssh -p $Port" -azP --exclude-from=.gitignore ~/Local\ Sites/$LocalDir/app/public/content/* $Username@$RemoteSite:/home/$RemoteDir/public_html/wp-content

    else
        echo "Uh... I need a paramater to work with buddy e.g \"up\" "
    fi
}

_rsync $1;