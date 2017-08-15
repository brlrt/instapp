# instapp

## installation
`git clone https://github.com/funcphp/instapp.git`

## cli usage

    $ cd instapp
    
Necessary data will be taken when commands are run

**Follow all users in a location**

    instapp$ ./instapp-cli follow:location
    
**Follow all users in a user's follower list**

    instapp$ ./instapp-cli follow:follower
    
**Like timeline feeds**

    instapp$ ./instapp-cli like:timeline

Or you can type data in command
Ex:

    instapp$ ./instapp-cli like:timeline --username=my_account_username --password=my_password --max=200 --wait=10
