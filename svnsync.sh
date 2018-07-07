#!/bin/sh

message='';
tag="$(git tag | head -n 1)";
commit="$(git rev-parse --short HEAD)";

if [ -z "$1" ]; then
        if [ ! -z $tag ]; then 
                message=$tag;
            else
                message=$commit;
        fi
    else
        message=$1;
fi


if [ ! -d "svn" ]; then
    echo svn co https:plugins.svn/wordpress.org/franklin svn
    svn co https:plugins.svn/wordpress.org/franklin svn
fi


echo cd svn
cd svn

echo svn update
svn update

echo svn add
svn add

echo svn ci -m "$message"
svn ci -m "$message"