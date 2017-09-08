
# instapp

basic instagram macros and cli tool

## requirements

* php >= 5.6
* php-curl
* php-mbstring
* php-gd
* php-exif
* php-zlib
* php-gmp

## installation

    $ git clone https://github.com/funcphp/instapp.git
    $ cd instapp
    instapp$ composer install

## cli usage

**follow all users in locations**

    instapp$ php instapp-cli follow:location
    
**follow all users in user's followers**

    instapp$ php instapp-cli follow:user:follower
    
**follow all users in hashtags feeds**

    instapp$ php instapp-cli follow:hashtag
    
**like timeline feeds**

    instapp$ php instapp-cli like:timeline
    
required data will be asked when commands are run

or you can type data in command

ex:

    instapp$ php instapp-cli <your_command> --username=my_account_username --password=my_password --max=200 --wait=10
    
### list commands

    instapp$ php instapp-cli list <command_root>
    
ex:

    php instapp-cli list follow

### cli arguments

|argument|description|type|default|command|
|-|-|-|-|-|
|username|account username|string|*required*|*all commands*|
|password|account password|string|*required*|*all commands*|
|wait|duration between events (s)|integer|**20**|*all commands*|
|max|max number of follow / like|integer|**500**|**follow:\*** , **like:\***|
|locations|location ids|integer[] (commas)|*required for*|**follow:location**|
|persons|person usernames|string[] (commas)|*required for*|**follow:follower**|
|hashtags|hashtags|string[] (commas)|*required for*|**follow:hashtag**|

## todo list

|macro|description|status|
|-|-|:-:|
|`follow:user:followers`|Follow all users in a user's follower list|:heavy_check_mark:|
|`follow:user:following`|Follow all users in a user's following list|waiting|
|`follow:location`|Follow all users in location feed|:heavy_check_mark:|
|`follow:hashtag`|Follow all users in hashtag feed|:heavy_check_mark:|
|`follow:discover:all`|Follow all users in discover feed|waiting|
|`follow:discover:popular`|Follow all users in popular feed|waiting|
|`unfollow:following`|Unfollow all users who you following|waiting|
|`unfollow:followers`|Unfollow all users who you following in your follower list|waiting|
|`like:timeline`|Like all posts in timeline feed|:heavy_check_mark:|
|`like:location`|Like all posts in location feed|waiting|
|`like:hashtag`|Like all posts in hashtag feed|waiting|
|`like:user`|Like all posts in user feed|waiting|
|`like:discover:all`|Like all posts in discover feed|waiting|
|`like:discover:popular`|Like all posts in popular feed|waiting|