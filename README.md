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
