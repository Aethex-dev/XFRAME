# XFRAME
###### Advanced PHP Framework
 
## Introduction
Hello, if you are reading this, then your probably ready to learn how to use XFRAME and all of its components! <br>
Note the installer and framewrok are not done, so trying to get access to the framewrok wont help <br>
[Installation](#Installation)<br>
[Basic-Usage](#Basic-Usage)<br>
[Simple Blog Site](#Simple-Blog-Site)

## Installation

###### Installing with composer

Installing with composer is much quicker and easier to do, the steps are simple, first make you that you have composer installed on your website, either globaly or localy, tutorial can be found [here](https://getcomposer.org), once you have composer installed, you need to open up your SSH command line or the windows command line, preferably, you can even use windows/linux powershell. Once its open, make sure you can see a directory address before the flashing carret, this might be something like this, `Users\username\apache\htdocs\>`, different server and composer operating systems have different direcotory paths, now, navigate to where you want to install the framework, for example, you want to access it via the url `https://your-website/community`, then you would create a folder in the root of your webserver called community, next go to that folder and copy the file path, then go to the ssh, powershell, bash, etc.. terminal and type `cd /your-file-path`, if all the slashes in the copied file path are in a direction, then the first slash after cd must be that way too, finaly, run the following commands, `composer init`, after runnign this, follow the on screen directions and once finished, run the final command, `composer require xenonmc/xframe`, after that, you have successfuly installed XFRAME onto your webserver

###### Installing with the install GUI
First download the latest installer from our website <br>
[xenonmc.xyz/resouces/xenonmc/xframe](https://xenonmc.xyz/resources/xenonmc/xframe)
Next, upload the installer to your webserver where you want the framework accessable, for example, you want to access this site from `https://your-website.com/community`, you would create a folder called commnity and then upload the installer there 
Next, you need to run the installer, you have multiple ways of doing so, the most recommended way of doign it is to navigate to where you uploaded your installer fro the website like so, if your website is located in the folder community, then you need to access the installer like this, `https://your-website.com/community/install.php`, if your installer is in the front most folder of your website, then you would access it via `https://your-website.com/install.php`. One you navgiate to that file, the installer will promt you be confirm installation as the installer will overwrite any files with the same name or directorys, it will also give you the list of files and folders that it may overwrite. Now just follow the install directions and once it prompts you that the framework has been installed, you can close the webpage and return to you websites file manager

## Basic Usage
PLEASE NOTE, when using this framework, do **NOT** edit the index.php file in the root of the framework, instead, go to the public folder inside and edit that index.php,
the public folder is the one specificly for your project.

### Simple error handling

This framework has multiple ways of displaying formated errors,

First lets display a simple error, 
```php
error("Hello world, I am an error");
```
this outputs
```
ERROR: Hello world, I am an error
```


We can also make the error fatal by entering true as the functions second parameter
```php
error("Hello world, this is a fatal error", true);
```
this outputs
```
FATAL ERROR: Hello world, this is a fatal error
```

### Simple AJAX

This framework also has AJAX support,

First, lets detect an AJAX message. When an AJAX request is sent, XFRAME will detect it an call a callback function, 
```php
function onMessage() {

 // code to run once an AJAX call is sent

}
```

you can also assign ids of the AJAX calls to find out which part of your page called it, for example a search query
```php
function onMessage() {

    if(messageID() == "search_query") {

        echo "A search query was performed";

    }

}
```

The above method works but we have a problem, a you can see, we are echoing the result and that means we cant change where it outputs, we could use JavaScript to output in a formated way, but thats not such a good idea as that means we have to echo js code in our php app meaning we mix code. 

So solve this, we can output json instead
## Simple Blog site
###### Coming Soon
