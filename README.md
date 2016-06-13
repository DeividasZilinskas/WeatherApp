#WeatherApp
==========
This App shows current temperature ant wind speed.
##Requirements:
- [Requirements for Running Symfony 2.8](http://symfony.com/doc/2.8/reference/requirements.html)

##Setup:

Using GIT and Composer:
```
$ git clone https://github.com/DeividasZilinskas/WeatherApp.git
$ cd WeatherApp/
$ composer install 
```

**__weather_api_key: 1bcf80f3b46574427d94ad070fd741ed (I will leave this here, so you could quickly test my app)__**

##Usage:
```
$ cd WeatherApp/
$ php app/console server:run
```
Now you can access the application in your browser at http://localhost:8000. Application is setup to show Vilnius city data, but you can access other cities by adding /cityname to url (ex. **http://localhost:8000/london**). You can stop the built-in web server by pressing Ctrl + C while you're in the terminal.
- - - - - - -  
###### &copy; 2016 [Deividas Žilinskas](https://github.com/DeividasZilinskas)
