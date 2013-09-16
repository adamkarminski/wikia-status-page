# Wikia Status Page

It is a documentation for a status page for Wikia.com. Its goal is to provide users with current statistics regarding Wikia's condition.
The status page is based on [Laravel Framework](http://laravel.com/). Official [Laravel docs](http://laravel.com/docs) are available on their site.
This site also uses [Twitter Bootstrap](http://getbootstrap.com/) and [jQuery](http://jquery.com) for front-end.

## Important notes

### Config

You can find config files in ```app/config/``` and the most important ones are ```app.php``` and ```database.php```.

### Login

Visit ```http://domain name/login```.

### Requests to external APIs

All requests to external APIs start in ```public/public/scripts.js``` with AJAX requests to ```app/controllers/ApiController.php```.

### Messages feed

Messages are controlled by ```app/controllers/MessagesController.php```. The feed has two Views layouts - for anonymous and authenticated users (check ```app/views/templates```). You can find message deletion and flagging scripts in ```scripts.js```.

### Views

Status page has one master layout ```app/views/layouts/master.blade.php``` and a few templates stored in ```app/views/templates```:
* ```login.blade.php``` - the login form
* ```feed.blade.php``` - messages feed for anonymous users
* ```feed-auth.blade.php``` - messages feed for authenticated users
* ```feed-form.blade.php``` - messages form available for authenticated users
* ```message.blade.php``` - single message formating
* ```status.blade.php``` - a template for everything below the messages feed