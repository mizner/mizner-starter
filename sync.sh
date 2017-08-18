#!/bin/bash
# http://shellcheck.net (Debugger)
# https://coderwall.com/p/moabdw/using-rsync-to-deploy-a-website-easy-one-liner-command (original idea)
# Requires jq to be installed https://stedolan.github.io/jq/

function _jsonValue(){
 CONFIG=$(cat config.json);
 echo $CONFIG | jq -r '.["'$1'"]';
}

function _rsync() {

     Username=$(_jsonValue 'RemoteUsername');
     Password=$(_jsonValue 'RemotePassword');
     RemoteSite=$(_jsonValue 'RemoteSite');
     RemoteDir=$(_jsonValue 'RemoteDir');
     Port=$(_jsonValue 'RemotePort');
     LocalDir=$(_jsonValue 'DevDirectory');

    # source config;

    if [ $1 == "down" ]
    then
        echo "INCOMING!";
        sshpass -p $Password rsync -e "ssh -p $Port" --progress --partial -avz  $Username@$RemoteSite:/home/$RemoteDir/public_html/wp-content/* ~/Local\ Sites/$LocalDir/app/public/content;

    elif [ $1 == "up" ]
    then
        echo "...hold on to your butts";
        sshpass -p $Password rsync -e "ssh -p $Port" -azP --exclude-from=.gitignore ~/Local\ Sites/$LocalDir/app/public/content/* $Username@$RemoteSite:/home/$RemoteDir/public_html/wp-content;

    else
        echo "Uh... I need a paramater to work with buddy e.g \"up\" ";
    fi
}

_rsync $1;