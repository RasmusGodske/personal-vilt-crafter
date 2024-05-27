# Introduction

ViltCraft is a simple way to get a VILT-stack up and running. It is a perfect combination of:
- [Vue.js](https://vuejs.org/)
- [Inertia.js](https://inertiajs.com/)
- [Laravel 11](https://laravel.com/docs/11.x)
- [Tailwind CSS](https://tailwindcss.com/).

Furthermore I have added a few extra things to make the development process easier:
- [Ziggy](https://github.com/tighten/ziggy): (Use Laravel routes in JavaScript)
- [Typescript](https://www.typescriptlang.org/): (Type checking for JavaScript)
- Optional Bootstrap Script: Bootstrap script to quickly get appication up and running
- Optional VSCode Debugging: Debugging configuration for Visual Studio Code

This stack is perfect for developers who want to build a modern web application with minimal setup.

# Motivation

I have been working with Laravel for a few years now and I have always been a fan of the Laravel ecosystem. However, as a individual with lots of ideas, I found myself starting lots of new Laravel projects. I always found myself doing the same setup over and over again and I wanted to automate this process. I wanted to build something that would allow me to get up and running quickly. Very similar to what [Laravel Jetstream](https://github.com/laravel/jetstream) does, but with a few tweaks.


# Installation

To get started, you need to install the ViltCraft package. You can do this by running the following command:

```bash
composer require rasmusgodske/vilt-crafter
```

# Usage

Once you have installed the ViltCraft package, you can run the following command to setup the ViltCraft stack:
```bash
php artisan vilt-crafter:install
```

### Options:
You can add the following options to the `vilt-crafter:install` command eg.
```bash
php artisan vilt-crafter:install --vscode --bootstrap-script
```

**Below are the available options:**

**`--vscode`**

This option will create a `.vscode` folder in the root of your project with a `launch.json` file. This file will allow you to debug your application using Visual Studio Code.

**`--bootstrap-script`**

This option will create a `scripts/` folder in the root of your project with a `bootstrap.sh` file. This file will allow you to quickly get your application up and running. I personally use this script all the time in my Laravel sail projects.


## Development
I have tried to make the development process of this package as easy as possible. I have done this by creating DevContainer with all the necessary tools to get started. The only requirement is that you have Docker installed on your machine and have the Remote - Containers extension installed in Visual Studio Code.

This devcontainer also comes with a list of available useful VSCode tasks that you can use to get started:

- `Setup Laravel Project`: This task will setup a new Fresh Laravel Sail project in the `example-app` directory.
- `Start Laravel Sail`: This task will start the Laravel Sail containers.
- `Composer update`: This task will update the composer dependencies within the running sail environment.
- `Composer Install`: This task will install the composer dependencies within the running sail environment.
- `Run Vite`: This task will start the vite server.
- `Migrate Database`: This task will migrate the database within the running sail environment.



### 1. Clone the repository
```bash
git clone git@github.com:RasmusGodske/vilt-crafter.git
```

### 2. Open project in VSCode
Next open the project in Visual Studio Code

```bash
cd vilt-crafter
code .
```

### 3. Open DevContainer in VSCode
Next open the DevContainer in VSCode(Make sure you have the Remote - Containers extension installed).

You can do this by pressing `CMD + Shift + P` -> `Remote-Containers: Reopen in Container`

This might take a few minutes to setup the container.

After the container is setup, you will now sett the following file structure:
```
├── vilt-crafter
└── .vscode
```

`vilt-crafter` is the root of the project and `.vscode` is mounted to the workspace root, so you can acccess the tasks and debugging configuration.

### 4. Bootstrap Local Laravel Sail Project

Next you need to bootstrap the Laravel Sail project. You can do this by running running the following VSCode task: `Setup Laravel Project`.

`cmd + shift + p` -> `Tasks: Run Task` -> `Setup Laravel Project`

This will create a new directory called `example-app` and setup the Laravel Sail project.

Furthermore, it will also initialize a new git repository in the `example-app` directory. This is used to be able to reset all changes vilt-crafter has made to the project.


### 6. Launch Sail

`cmd + shift + p` -> `Tasks: Run Task` -> `Setup Laravel Project`

This will start the Laravel Sail containers and you should now be able to access the Laravel application on [localhost:8080](http://localhost:8080).


### 6. Update composer dependencies

Next you need to update the composer dependencies by running the following VSCode task: `Composer update`.

`cmd + shift + p` -> `Tasks: Run Task` -> `Composer update`

### 7. Install composer dependencies

Next you need to install the composer dependencies by running the following VSCode task: `Composer Install`.

`cmd + shift + p` -> `Tasks: Run Task` -> `Composer Install`


### 8. Migrate Database

Next you need to migrate the database by running the following VSCode task: `Migrate Database`.

If skipped you will get an error when trying to access the application.

`cmd + shift + p` -> `Tasks: Run Task` -> `Migrate Database`

### 9. Confirm ViltCraft is detected

Next confirm that ViltCraft is detected by running the following command:

```bash
sail artisan list
```

This should output a list of artisan commands and you should see the following command:

```bash
# ... Other artisan commands
 viltcrafter
  viltcrafter:install       Install the viltcrafter components and resources
```

### 10. Run ViltCraft Installer

You can now run the ViltCrafter installer by opening a terminal within `example-app` and running the following command:

```bash
php artisan vilt-crafter:install
```


