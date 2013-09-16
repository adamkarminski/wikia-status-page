# Wikia Status Page

It is a documentation for a status page for Wikia.com. Its goal is to provide users with current statistics regarding Wikia's condition.
The status page is based on [Laravel Framework](http://laravel.com/). Official [Laravel docs](http://laravel.com/docs) are available on their site.
This site also uses [Twitter Bootstrap](http://getbootstrap.com/) and [jQuery](http://jquery.com) for front-end.

## Important notes

### Login

### Requests to external APIs

All requests to external APIs start in ```public/builds/js/scripts-\*.js``` with AJAX requests to ```app/controllers/ApiController.php```.

### Messages feed

Messages are controlled by ```app/controllers/MessagesController.php```. The feed has two Views layouts - for anonymous and authenticated users.