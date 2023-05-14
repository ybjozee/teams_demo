# Internet Projects Ltd

## Teams Demo Application

This is a demo application required as part of the recruitment process

System Requirements
------------

* PHP 8.0 and above
* PDO-SQLite PHP extension enabled;
* [Git][2]
* [Composer][3]
* [Symfony CLI][4]
* and the [usual Symfony application requirements][5].


How to set up
------------

Run the following commands to clone the repository from Github:

```bash
 git clone https://github.com/ybjozee/teams_demo.git
 cd teams_demo
```

Next, make a local version of the `.env` file

```bash
 cp .env .env.local
```

Update `DATABASE_URL` as required - by default, SQLite is used

``` ini
DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
```

Run the following command to install the packages and set up the database

```bash
 composer setup
```

This command will install the project dependencies, create a new database, and add the default fixtures 
(a new user, and the list of countries).

Additionally, you will be prompted to respond whether you want to add extra fixtures (teams and players). 
Press `y` if you do and `n` if you don't, then press `enter`.


Run the application with the following command

```bash
$ symfony serve
```

**NB: To complete the sale of a player (accept or reject), you must be logged in. The default user credentials are shown below:**

- username: **_demo_**
- password: **_demo12345_**

[2]: https://git-scm.com/
[3]: https://getcomposer.org/
[4]: https://symfony.com/download
[5]: https://symfony.com/doc/current/reference/requirements.html
