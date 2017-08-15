#!/bin/bash



function _rsync() {

    source config;

    if [ $1 == "down" ]
    then
        echo "...hold on to your butts"
        rsync -e "ssh -p 2204" --progress --partial -avz  $Username@$RemoteSite:/home/$RemoteDir/public_html/content ~/Local\ Sites/$LocalDir/app/public/wp-content

    elif [ $1 == "up" ]
    then
        rsync -e "ssh -p 2204" -azP --exclude .DS_Store ~/Local\ Sites/$LocalDir/app/public/content $Username@$RemoteSite:/home/$RemoteDir/public_html/wp-content

    else
    echo "not going live"
    fi
}

_rsync $1;