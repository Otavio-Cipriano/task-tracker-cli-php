# task-tracker-cli-php

CLI application developed in PHP for task management, with SQLite persistence and application of Object-Oriented Programming concepts and layered architecture.


## Table of Contents

- [Objective](#objective)
- [Features](#features)
- [Technical Decisions](#-technical-decisions)
- [Limitations and Future Improvements](#-limitations-and-future-improvements)
- [Technologies](#-technologies)
- [How to Run](#-how-to-run)
- [Lessons Learned](#-lessons-learned)

## 🎯 Objective

This project was developed with the goal of practicing:

- Structuring PHP applications using OOP
- Working with .JSON files
- Layered organization (CLI, Service, Repository)
- Integration with SQLite database using PDO
- Usage of Enums in PHP
- Handling command-line arguments

The project also served as preparation for backend API development.

## Features

- [x] User can add a task with description and status being optional.
- [x] User can list all tasks.
- [x] User can list tasks by status.
- [x] User can mark task with a status.
- [x] User can update task with a description and status.
- [x] User can delete task.

## 🧠 Technical Decisions

### Using SQLite
Chosen for its simple configuration and suitability for local applications and prototypes.

### Using Enums
Used to ensure task status integrity and avoid magic strings scattered throughout the code.

### Layered Separation
The application was structured into the following layers:

- CLI → Data input and output
- Service → Business rules
- Repository → Data access

## ⚠️ Limitations and Future Improvements

During development, some responsibilities were temporarily coupled to facilitate quick testing, such as:

- `echo` outputs present in the Service layer

In a future evolution, data output should be centralized in the CLI layer, better respecting separation of responsibilities.

Other possible improvements:

- Implementation of global error handling
- Creation of automated tests
- Transformation of the project into a REST API

## 🛠️ Technologies

- PHP 8+
- PDO
- SQLite

## ▶️ How to Run

```bash
git clone ...
cd project
php index.php command
```
It is also necessary to create the tasks table and the update trigger:

````sql
CREATE TABLE tasks(
  id INTEGER PRIMARY KEY,
  description TEXT NOT NULL,
  status TEXT CHECK (status in ('done', 'todo', 'in-progress')) NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME
);

CREATE TRIGGER task_updated_at_trigger
    AFTER UPDATE ON tasks
    FOR EACH ROW
BEGIN
    UPDATE tasks
    SET updated_at = CURRENT_TIMESTAMP
    WHERE id = NEW.id;
end;
````

### Usage

Entry point:

```bash
php src/index.php <command> [options]
```

### Available Commands

#### Add Task
If status is not provided, the default status is todo.

```bash
    add "Buy groceries" [status]
    add "Buy groceries" in-progress
    add "Buy groceries" done
```

### List tasks

You can filter the tasks by status, if no status is provided all tasks will be printed
```bash
    list [status]
    list in-progress
    list todo
    list done
```

### Mark a task

You can mark a task as done, todo, in-progress
```bash
  mark-[status] <id>
  mark-done <id>
  mark-in-progress <id>
  mark-todo <id>
```

### Update a task

Updating the status is optional, 
but when updating a task you must update the 
description. If you only want to update the status, use mark.
```bash
  update <id> "New task description" [status]
```

### Delete a task
```bash
  delete <id>
```

## 📚 Lessons Learned
- This was my first time using SQLite with PDO. Until then, I had only used it with MySQL. It was also the first project I developed entirely using PHPStorm.
- During development, I decided to use enums, which are a 
recent feature in PHP 8. They are quite different from the 
enums I am used to in TypeScript and Java, since in those 
languages I do not need to use ::tryFrom, among other enum methods.


## Author

Made by [@Otavio-Cipriano](https://github.com/Otavio-Cipriano) 🤖

<br/>
<br/>

<a href="https://www.linkedin.com/in/otaviocipriano/">
<img src="https://img.shields.io/badge/LinkedIn-0077B5?style=for-the-badge&logo=linkedin&logoColor=white" alt="linkedin"/>
</a>
<a href="https://twitter.com/otaviodv">
<img src="https://img.shields.io/badge/Twitter-1DA1F2?style=for-the-badge&logo=twitter&logoColor=white" alt="twitter"/>
</a>