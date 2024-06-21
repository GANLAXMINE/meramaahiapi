

  cp .env.example .env
  php artisan key:generate
  
  #env file
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=root
  DB_USERNAME=hito_wb
  DB_PASSWORD=
  
  #Run Migrations
  php artisan migrate
  #Seed the database
  php artisan db:seed
  #Serve the Application
  php artisan serve

  #Clearing Cache
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  php artisan cache:clear

  #Queue Worker
  php artisan queue:work

 #Latest Branch
  dev-0.0.1




