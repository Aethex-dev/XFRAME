# XFRAME

Advanced PHP Framework

## Introduction

- ### [Installation](#Installation)

- ### [Basic-Usage](#Basic-Usage)

- ### [Simple Blog Site](#Simple-Blog-Site)

## Installation

### Installing with `Composer`

1. Install `Composer` with its dependancies. View how to do that [here](https://getcomposer.org).
   - `composer init`
     Add xframe as a dependancy:
   - `composer require xenonmc/xframe`
2. Install `PHP 8.0.2`

## Basic Usage

PLEASE NOTE, when using this framework, do **NOT** edit the index.php file in the root of the framework, instead, go to the public folder inside and edit that index.php; the public folder is the one needed for your project.

### Simple Error Handling

This framework has multiple ways of displaying formatted errors,

First, let's display an error,

```php
error("Warning: fopen(mytestfile.txt) [function.fopen]: failed to open stream:
No such file or directory in C:\webfolder\test.php on line 2");
```

this outputs

```text
Warning: fopen(mytestfile.txt) [function.fopen]: failed to open stream:
No such file or directory in C:\webfolder\test.php on line 2
```

We can also make the error fatal by entering true as the functions second parameter

```php
error("Hello world, this is a fatal error", true);
```

This gives the following output:

```text
FATAL ERROR: Hello world, this is a fatal error
```

### Simple AJAX

This framework also includes AJAX support,

We need to detect an AJAX message. When an AJAX request is sent, XFRAME will detect it an call the callback function,

```php
function onMessage() {

 // code to run once an AJAX call is sent

}
```

you can also assign ids of the AJAX calls to find out which part of your page called it, for example, a search query:

```php
function onMessage() {

    if(messageID() == "search_query") {

        echo "A search query was performed";

    }

}
```

The above method works but we have a problem, a you can see, we are echoing the result and that means we can't change where it outputs, we could use JavaScript to output in a formatted way, but that's not such a good idea as that means we have to echo js code in our php app meaning we mix code.

To solve this, we can output JSON instead
