# instapp

## installation

    $ git clone https://github.com/funcphp/instapp.git
    $ cd instapp
    instapp$ composer install

## cli usage

**follow all users in locations**

    instapp$ ./instapp-cli follow:location
    
**follow all users in user's followers**

    instapp$ ./instapp-cli follow:follower
    
**follow all users in hashtags feeds**

    instapp$ ./instapp-cli follow:hashtag
    
**like timeline feeds**

    instapp$ ./instapp-cli like:timeline
    
necessary data will be taken when commands are run

or you can type data in command

ex:

    instapp$ ./instapp-cli <your_command> --username=my_account_username --password=my_password --max=200 --wait=10
    
### list commands

    instapp$ ./instapp-cli list <command_root>
    
ex:

    ./instapp-cli list follow
