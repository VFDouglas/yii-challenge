<span>
    <h1 style="text-align: center">Yii 2 Challenge</h1>
</span>

This project was made using a [Yii 2](https://www.yiiframework.com/) Basic Project
Template as a skeleton.

It contains some features including user login/logout, a home page with the weather
of some cities (you can search for your city as well) and a page to manage books.
All of that with a responsive design.

This project uses PHP (Yii Framework), MySQL and Redis.

REQUIREMENTS
------------

- Docker Engine >= 17.04
- Git Bash

INSTRUCTIONS
------------

- Clone the project

```
git clone https://github.com/VFDouglas/yii-challenge.git
```

- Open your IDE/editor and enter the project directory using Git as a terminal.
  Then run the install script

```
./install.sh
```

Confirm the asked prompts.

- Run the command `docker-compose ps` and copy the MySQL container name.
- Go to the file `/config/db.php` and change the content of the variable `$host` to the respective container name.
- Go to the file `/models/Redis.php` and change the content of the constant `REDIS_CONTAINER` to the respective
  container name.
- Run the command:

```
docker-compose exec php php yii migrate --interactive=0 && rm -rf ./init.txt
```

When the script finishes, you should be able to run the project on http://localhost:8000/.