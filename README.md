# Phramz/Commons [![Build Status](https://travis-ci.org/Phramz/commons.png?branch=master)](https://travis-ci.org/Phramz/commons)

Commons is a php-library that comes with some handy utilities to ease your daily coding-business.

Install
------

It's easy if you use composer!

edit your `composer.json`

``` json
"require" : {
    "phramz/commons" : "*"
}  
```

or via command line

```
php composer.phar require phramz/commons
```


Examples
------

Picture this ....

``` php
<?php

use Phramz\Commons\Property\PropertyUtils;

class Contact
{
    private $email = 'info@phramz.com';
    private $phone = '123'
    
    public function getEmail()
    {
        return $this->email;
    }
    
    public function setEmail($email)
    {
        $this->email = $email;
    }
    
    public function getPhone()
    {
        return $this->phone;
    }
    
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }
}

class User
{
    private $name = 'foo';
    private $contact = null;

    public function __construct()
    {
        $this->contact = new Contact();
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getContact()
    {
        return $this->contact;
    }

    public function setContact(Contact $contact)
    {
        $this->contact = $contact;
    }
}

// get an instance of our User class
$example = new User();
```

Now, maybe you want to access the private member `name`
``` php
// get an instance of PropertyUtils
$propertyUtils = new PropertyUtils();

$propertyUtils->getProperty('name', $example); // will return 'foo'
```

Wow! Not very exciting, as long as you could call `getName()` directly, right!? But what if you have an abritary
object and you do not know exactly if there is a public method `getName()` or maybe `name` is just a public member
and therefore no need for getter? The object may not even have a member by the name of `name` and implements
`ArrayAccess`? The `getProperty()` - method can deal with all of these usecases.

Well, by the same way you can also set `name` to another value:
``` php
// get an instance of PropertyUtils
$propertyUtils = new PropertyUtils();

$propertyUtils->setProperty('name', 'bar', $example);
$propertyUtils->getProperty('name', $example); // will now return 'bar' ... as well as
$example->getName(); // ... will also return 'bar'
```

If you need to you can also access nested members like `email` at any depth by using the path seperator `.`
``` php
// get an instance of PropertyUtils
$propertyUtils = new PropertyUtils();

$propertyUtils->getProperty('contact.email', $example); // will return 'info@phramz.com'
```

Do you need to deal with arrays? No problem, at all:
``` php
// if our User-object were an array it would look like this
$example = array(
    'name' => 'foo',
    'contact' => array(
        'email' => 'info@phramz.com',
        'phone' => '123'
    )
);

// get an instance of PropertyUtils
$propertyUtils = new PropertyUtils();

$propertyUtils->getProperty('name', $example); // will still return 'foo'
$propertyUtils->getProperty('contact.email', $example); // will still return 'info@phramz.com'
```

There is one difference if you're working with arrays due these values are no references like objects. So
if we want to set a new value to a member we need to save the manipulated array.
``` php
// get an instance of PropertyUtils
$propertyUtils = new PropertyUtils();

// setProperty() will return the manipulated array, so we write it back to $example
$example = $propertyUtils->setProperty('name', 'bar', $example);

$propertyUtils->getProperty('name', $example); // will return 'bar' ... as well as
$example->getName(); // ... will also return 'bar'
```

That's it! I hope this peace of software will be helpful!
Have fun!
