# Documentation for the OAI-PMH Module Refactoring for ABCD

## 1. Introduction

This document details the main improvements and changes made to the OAI-PMH module of the ABCD software. The goal of the refactoring was to modernize the protocol exploration interface, centralize and simplify configurations, improve code maintainability, and prepare the tool for future expansions, such as multi-language support.

## 2. Main Changes and Improvements

The changes can be summarized in four main areas:

### 2.1. New Exploration Interface (now `index.php`)

The original interface was completely replaced by a new, modern, and interactive one.

* **Clean and Responsive Layout:** The new interface uses a more organized layout, with a side menu for the OAI verbs and a main content area.

* **Dynamic Parameter Detection:** When selecting a verb (e.g., `ListRecords`), the interface dynamically displays only the relevant parameter fields for that verb.

* **Smart Selection Menus:** For the `set` and `metadataPrefix` fields, the interface now queries the OAI provider itself (`ListSets` and `ListMetadataFormats`) to populate dropdown menus, preventing the user from having to guess the valid values.

* **Date Pickers:** The `from` and `until` fields use a native browser date picker, facilitating input and preventing format errors.

* **Real-time URL Construction:** The complete OAI-PMH request URL is built and displayed in real-time as the user fills in the parameters.

* **Formatted Response Visualization:** The XML response from the server is displayed with syntax highlighting, making it easier to read and debug.

### 2.2. Configuration Unification and Simplification

The configuration files were unified, and the environment detection logic was improved.

* **Elimination of Duplicate Files:** The specific files for Windows and Linux (`oai-config-win.php`, `oai-config-lin.php`, etc.) have been eliminated.

* **Single Configuration Files:** Now, there are only two main configuration files in pure PHP format, which makes them more secure and robust:

  * `oai-config.php`: for general environment and repository settings.

  * `oai-databases.php`: for defining the databases (sets).

* **Environment Detection in PHP:** The logic to identify whether the server is Windows or Linux has been moved to the PHP scripts (`lib/parse_config.php` and `lib/parse_databases.php`). This makes the configuration files cleaner and the programming logic more centralized.

### 2.3. Internationalization System (i18n)

The interface is now prepared to support multiple languages in an organized manner.

* **JSON Translation Files:** All interface texts are externalized in `.json` files located in the `lang/` folder (e.g., `en.json`, `pt-br.json`).

* **Easy Addition of New Languages:** To add a new language, you just need to:

  1. Add the language entry in the `oai-config.php` file.

  2. Create the corresponding JSON file in the `lang/` folder.

* **Language Selector:** A dropdown menu in the page header allows the user to easily switch between available languages.

### 2.4. File Organization (`assets`)

For a better project structure, the frontend files have been reorganized.

* The `css` and `js` folders, which contain the stylesheets and interface scripts, have been moved into a new `assets/` folder.

## 3. Installation and Update Instructions

To apply this new version of the OAI-PMH module to an existing ABCD installation:

1. **Make a backup** of your original `isis-oai-provider` directory.

2. **Replace the modified files** with the new versions provided during the refactoring process.

3. **Create the new folders** `assets/` and `lang/` inside `isis-oai-provider/`.

4. **Move** the `css/` and `js/` folders into `assets/`.

5. **Create the translation files** (`en.json`, `pt-br.json`) inside the `lang/` folder.

6. **Delete the old and obsolete configuration files**:

   * `oai-config-win.php`

   * `oai-config-lin.php`

   * `oai-databases-win.php`

   * `oai-databases-lin.php`

7. **Adjust the paths** of the databases in the `oai-databases.php` file and, if necessary, in the `oai-config.php` file to match your local folder structure.

8. **Important Reminder:** After installation and configuration, **it is necessary to restart VS Code** to ensure that all file and configuration changes are correctly loaded by the environment.

## 4. Conclusion

This refactoring modernizes the OAI-PMH module for ABCD, making it a more powerful, flexible, and easy-to-use-and-maintain tool for both administrators and end-users who wish to explore the repository's resources.
