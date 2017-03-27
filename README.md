### **Registered Community Organization (RCO) Engagement**

#### Improving Citizen Engagement with RCO's. 3.25.2017

#
![screenshot of landing page]

### **Description**

A tool bringing Registered Community Organization (RCO) information to the forefront for community members by [Code For Philly](https://codeforphilly.org/) volunteers.

----
### **Setup/Installation Requirements**

#### Setting up the front-end

Instructions on running the angular installation

#### Setting up the API

The API is a Laravel 5.4 API with a requirement of running on PHP 7.  It resides in the 'api' directory.

This project uses composer to install its dependencies.  If you don't have composer installed, you can get it from [here](https://getcomposer.org/).

To set up the API, run the following commands from the project root folder:

```
pushd api
cp .env.example .env
php artisan key:generate
composer install

popd
```

That should set up your default environment file, and install project dependencies.  The simplest way to get the API running is to run the following:
```
cd api
php artisan serve
```

This will start a very simple server listening on a default port (8000).  You can specify the port with the `--port=XXXX` option.  From there, you should be able to send a GET request as defined in the API documentation.

----
### **Known Bugs**

No known bugs.

----
### **Support and Contact Details**

Chat with us on Slack at codeforphilly.slack.com - '#rcos' channel

----
### **Technologies Used**

* TO-DO
* Angular2
* Bootstrap 4
* npm
* PHP 7
* Laravel 5.4
----
### **License**

*This application is licensed under the MIT license*
