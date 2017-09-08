
# instapp

## installation

    $ git clone https://github.com/funcphp/instapp.git
    $ cd instapp
    instapp$ composer install

## cli usage

**follow all users in locations**

    instapp$ php instapp-cli follow:location
    
**follow all users in user's followers**

    instapp$ php instapp-cli follow:follower
    
**follow all users in hashtags feeds**

    instapp$ php instapp-cli follow:hashtag
    
**like timeline feeds**

    instapp$ php instapp-cli like:timeline
    
required data will be asked when commands are run

or you can type data in command

ex:

    instapp$ ./instapp-cli <your_command> --username=my_account_username --password=my_password --max=200 --wait=10
    
### list commands

    instapp$ ./instapp-cli list <command_root>
    
ex:

    ./instapp-cli list follow

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
