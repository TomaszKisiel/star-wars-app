# :rocket: Star Wars App

Star Wars API with token-based registration and authentication.
It includes a cache engine, docker, API documentation and test
coverage. App based one [SW API](https://swapi.dev). Each user
is assigned a Star Wars hero during the registration process. 
Users can access videos and planets related to their heroes and 
edit their own account details. Users only have access to their 
heroes' data and cannot see any unrelated data.


## :rabbit: Quickstart

To start working with this project, clone it in your environment.

```
git clone https://github.com/TomaszKisiel/star-wars-app
```

Install all dependencies.

```
composer install
```

This project use [Laravel Sail](https://laravel.com/docs/8.x/sail) which is handly docker wrapper for laravel.
Start docker service on your machine and issue the command.

```
vendor/bin/sail up -d --build
```

Thanks to the fact that Sail will take care of the database configuration, you can start working with the API right after the migration.

```
vendor/bin/sail artisan migrate
```

Now the project is running on ```localhost``` port ```80```. Have fun!


## :memo: API documentation

Under the main route ([http://localhost](http://localhost)) in the project, there is swagger documentation that can help you find your way around the API.
If something is missing or the page cannot load properly, please issue the command below and check again.

```
vendor/bin/sail artisan l5-swagger:generate
```


## :blue_book: Artisan commands

An artisan command has been prepared for developers to display a list of users along with their assigned Star Wars hero. 
As a result of its execution, the user's id and email will be displayed, as well as the id, name and url of the hero's resource.
The list is paginated and can be customized with the ```--page``` and ```--per-page``` option. Type ```--help``` to see more.

```
vendor/bin/sail artisan hero:list {--per-page=10} {--page=1}
```

The table below is an example of the execution result.

| id | email                       | hero_id | hero_name      | hero_url                        |
|----|-----------------------------|---------|----------------|---------------------------------|
| 56 | jane.doe@example.com        | 58      | Plo Koon       | http://swapi.dev/api/people/58/ |
| 57 | robert.smith@example.com    | 24      | Mon Mothma     | http://swapi.dev/api/people/24/ |
| 58 | tomaszz.pudding@example.com | 1       | Luke Skywalker | http://swapi.dev/api/people/1/  |


## :sob: Troubleshooting

If you have a problem with the permissions of files created by
docker, you should first take over them and try again.

```
chown -R <your_user>:<your_group> .
```


## :clipboard: License

Open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
