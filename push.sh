#!/bin/bash
git add .
if (($# < 1)) # $# contient le nombre d'argument
then
	git commit -m "basic commit"
else
	git commit -m "$1" # $1 contient un argument
fi
git push
