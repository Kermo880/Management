# Personnel Management System

The human-based information system, which reflects very important stages in the work of personnel management, simplifies the work of personnel. Its purpose is to ensure the highest result of work based on employees and the company.

## Features

With this management system, you can do the following:

- List employees
- ADD / EDIT employees form
- Delete employees

## Tools

- Drupal
- Git
- DDEV

## Languages

- PHP
- MySQL
- JavaScript

## Start Up

Start up for the project is very easy. Using these steps you will clone existing project of personal management system. Configurate, make a root folder and create a composer for the project, so it's compatible with Drupal.

1. git clone https://github.com/Kermo880/Personal-Management-System.git
2. cd Management
3. ddev config --project-type=drupal9 --docroot=web --create-docroot
4. ddev start
5. ddev composer create "drupal/recommended-project"
6. ddev composer require drush/drush