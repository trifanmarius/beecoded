# beecoded

Use the below commands in the root directory

Commands:
- To start the project, use: docker compose up -d --build
- To access the main container, use: docker compose exec php bash
- Use inside the main container: composer install
- To search for emails, use: php artisan search:user <user name> <company name> <linked_in url> (use this command inside the main container)
