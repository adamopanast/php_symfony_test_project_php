#!/bin/bash

echo '(1) User exists (user 1), no api key '
echo '$1/symfony/auth/auth/web/app_dev.php/user/1'
echo `curl $1/symfony/auth/auth/web/app_dev.php/user/1`
echo '\n\n'
sleep 1
echo '(2) User exists (user 2), no api key'
echo 'curl $1/symfony/auth/auth/web/app_dev.php/user/2'
echo `curl $1/symfony/auth/auth/web/app_dev.php/user/2`
echo '\n\n'
sleep 1
echo '(3) User does not exist (user 5)'
echo 'curl $1/symfony/auth/auth/web/app_dev.php/user/5'
echo `curl $1/symfony/auth/auth/web/app_dev.php/user/5`
echo '\n\n'
sleep 1
echo '(4) User exists, api key matches, should return user 1 details'
echo 'curl $1/symfony/auth/auth/web/app_dev.php/user/1 -u b48d0416-bc38-467d-8066-cd14bb7ead5e:'
echo `curl $1/symfony/auth/auth/web/app_dev.php/user/1 -u b48d0416-bc38-467d-8066-cd14bb7ead5e:`
echo '\n\n'
sleep 1
echo '(5) User exists, api key does not match'
echo 'curl $1/symfony/auth/auth/web/app_dev.php/user/2 -u b48d0416-bc38-467d-8066-cd14bb7ead5e:'
echo `curl $1/symfony/auth/auth/web/app_dev.php/user/2 -u b48d0416-bc38-467d-8066-cd14bb7ead5e:`
echo '\n\n'
sleep 1
echo '(6) User does not exists, call contains api key'
echo 'curl $1/symfony/auth/auth/web/app_dev.php/user/5 -u b48d0416-bc38-467d-8066-cd14bb7ead5e:'
echo `curl $1/symfony/auth/auth/web/app_dev.php/user/5 -u b48d0416-bc38-467d-8066-cd14bb7ead5e:`
echo '\n\n'
sleep 1
echo '(7) User exists, api key does not match'
echo 'curl $1/symfony/auth/auth/web/app_dev.php/user/1 -u b71fe516-efc2-479f-a986-4c58ae7b2ea8:'
echo `curl $1/symfony/auth/auth/web/app_dev.php/user/1 -u b71fe516-efc2-479f-a986-4c58ae7b2ea8:`
echo '\n\n'
sleep 1
echo '(8) User exists, api key matches, should return user 2 details'
echo 'curl $1/symfony/auth/auth/web/app_dev.php/user/2 -u b71fe516-efc2-479f-a986-4c58ae7b2ea8:'
echo `curl $1/symfony/auth/auth/web/app_dev.php/user/2 -u b71fe516-efc2-479f-a986-4c58ae7b2ea8:`
echo '\n\n'
sleep 1
echo '(9) User does not exist, call contains api key'
echo 'curl $1/symfony/auth/auth/web/app_dev.php/user/5 -u b71fe516-efc2-479f-a986-4c58ae7b2ea8:'
echo `curl $1/symfony/auth/auth/web/app_dev.php/user/5 -u b71fe516-efc2-479f-a986-4c58ae7b2ea8:`
