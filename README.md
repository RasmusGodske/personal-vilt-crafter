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
<!-- TODO: Add description -->


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

Next you need to bootstrap the Laravel Sail project. You can do this by running running the following VSCode task: `Bootstrap Laravel Sail Project`.

`cmd + shift + p` -> `Tasks: Run Task` -> `Bootstrap Laravel Sail Project`

This will create a new directory called `example-app` and setup the Laravel Sail project.

### 5. Start Laravel Sail



