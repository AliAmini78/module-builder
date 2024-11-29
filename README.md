Laravel Module Builder Package Documentation
============================================

Overview
--------

The ModuleBuilder package provides a console command to automate the creation of module directories within a Laravel
application. It allows developers to easily generate structured directories and files for different types of modules (
e.g., Api, Web) through a simple Artisan command.

### Command

* **Command Name**: module:create

* **Description**: This command creates a module directory with predefined structure and files for either Api or Web
  modules.

Installation
------------
1. for install the package

        composer require aliamini78/module-builder 

2. After installation, you may need to publish any configuration or assets that are part of the package. This can
   usually be done with the following command:

         php artisan vendor:publish --provider="Aliamini78\\ModuleBuilder\\ModuleBuilderServiceProvider"

Usage
-----

To create a new module directory, you can run the Artisan command provided by the package:

    php artisan module:create

### Command Flow

1. The default is Api.

* Api

* Web

2. **Module Name**: You will be asked to input the name of the module. The name will be capitalized.

3. **Directory and Files Creation**: The package will automatically create the required directories for the selected
   module type (Api or Web) and will add any predefined files with their corresponding content.

Code Explanation
----------------

### 1\. Command Definition

The command is defined as follows:

    protected $signature = 'module:create';

* The command is accessible via php artisan module:create.

### 2\. Description

The description of the command is set to:

    protected $description = 'Command for make module directory'; 

This appears when you run php artisan list or php artisan help module:create.

### 3\. handle() Method

The handle() method is responsible for executing the main logic of the command:

```php
    public function handle(): void 
    {
        $moduleType = ucfirst($this->choice("what is your module type ? ", ["Api", "Web"], "api"));
        $moduleName = ucfirst($this->ask("what is your module name ? "));
        $this->makeDirectories($moduleType, $moduleName);
        $this->comment("$moduleName module created in $moduleType directory!!");
    }
```

* The user is prompted to select the module type (Api or Web).

* The user is asked to enter the module name.

* The makeDirectories() method is called to create the directories and files based on the module type and name.

### 4\. makeDirectories() Method

The makeDirectories() method handles the creation of directories and files:

```php
public function makeDirectories(string $moduleType, string $moduleName): void
{
    foreach ($this->files($moduleName, $moduleType) as $file) {
        File::makeDirectory($file["directory"], 0777, true, true);

        if (isset($file["content"])) {
            File::put($file["directory"] . $file['name'], $file['content']);
        }
    }
}
```


* The files() method (from the FilesList trait) provides an array of files and directories that need to be created for
  the module.

* File::makeDirectory() is used to create the required directories with 0777 permissions.

* If a file has content, File::put() is used to write the content to the file.

### 5\. FilesList Trait

The command uses the FilesList trait to manage the list of files and directories to be created for each module. The
trait provides the files() method, which returns an array of files and directories based on the module type and name.

Example
-------

### Running the Command
```shell
    php artisan module:create
```
```text
    * What is your module type? (Api, Web)
```
You select Api.

```text
    * What is your module name?
```
You type UserManagement.

```text
    * UserManagement module created in Api directory!!
```

Customization
-------------

You can customize the directories and files created for each module by modifying the files() method inside the FilesList
trait.

For example, you can add additional directories or files specific to your project’s needs.
