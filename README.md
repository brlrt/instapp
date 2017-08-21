# instapp

## installation

    $ git clone https://github.com/funcphp/instapp.git
    $ cd instapp
    instapp$ composer install

## cli usage

**Follow all users in locations**

    instapp$ ./instapp-cli follow:location
    
**Follow all users in user's followers**

    instapp$ ./instapp-cli follow:follower
    
**Follow all users in hashtags feeds**

    instapp$ ./instapp-cli follow:hashtag
    
**Like timeline feeds**

    instapp$ ./instapp-cli like:timeline
    
Necessary data will be taken when commands are run

Or you can type data in command

Ex:

    instapp$ ./instapp-cli <your_command> --username=my_account_username --password=my_password --max=200 --wait=10
