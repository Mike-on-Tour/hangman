# Change Log
All changes to `Hangman Game` will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).
  
## [0.8.0] - 2023-10-20

### Added
-	A (by default disabled) modal window to congratulate the user if improving the ranking by gaining either game or word points, this feature can be enabled in the ACP
-	Notifications if a user looses the ranking (by default disabled), this feature can be enabled in the ACP
-	A Hall of Fame displaying the best players of current month and year and the best players of the last months and the last years (by default disabled), this
	feature (displaying the tab, storing points in the applicable table is enabled and can not be disabled) can be enabled in the ACP as well as select the number of players to
	be displayed
-	A link to the breadcrumbs
-	A copyright in the overall footer if Hangman game is displayed

### Changed
-	Various code improvements
-	Renamed language file `info_acp_hangman.php` into `info_acp_mot_hangman`

### Fixed

### Removed
  
  
## [0.7.0] - 2023-06-15

### Added
-	A setting to enable displaying of hangman players in the "who is online" section
-	Additional points for solving the riddle without failure including according settings

### Changed
-	The radio buttons in `adm/style/acp_hangman_settings.html` to sliders with the possibility to change back to radio buttons by setting a variable to false
-	The check for PHP version during activation to check for maximum version, too

### Fixed

### Removed
  
  
## [0.6.0] - 2022-07-04

### Added
-	An `ext.php` file to check for the correct prerequisites and for compatibility with ExtMgrPlus

### Changed
-	Minimum PHP version to 7.2 (from 7.0)
-	The coding for radio buttons in `adm/style/acp_hangman_settings.html` to short form of TWIG syntax

### Fixed
-	Two missing spaces after `controller:` in `config/routing.yml`, lines 3 and 7 which prevented enabling on a phpBB 4.0 board
-	Migration file `migrations/v_0_5_0.php` to set permissions for a user role only if that role exists in order to prevent error messages if standard roles
	were deleted

### Removed
  
  
## [0.5.0] - 2022-02-02

### Added
-	A settings function to export the `phpbb_mot_hangman_words` table as a XML file
-	A function to display the term in clear after loosing a game, function is selectable in the ACP
-	A system (including ACP setting) to block players from playing if their ratio of game points to term input points exceeds a value
	defined by the administrator (in the ACP)
-	A function to `event/listener.php` to delete `mot_hangman_score_table` entries if a user gets deleted
-	A rudimentary permissions system to allow user to enter search terms

### Changed
-	Shifted the setting for 'Count a game as lost if game is left?' to the 'Game settings' section
-	The search term input field from 'text' to 'textarea' in order to make it look more comfortable with long terms
  
  
## [0.4.0] - 2022-01-18

### Added
-	A check for a minimum length of the search term, minimum length is selectable in the ACP setting tab
-	A summary tab in the main window
-	Importing search terms from two types of xml files
-	Importing search terms from existing `dmzx/hangmangame` extension
  
### Changed
-	Messages in the term input tab are using `phpbb.alert` now instead of `alert`
-	`pagination` class is loaded as a service now and no longer via the `phpbb_container` in `controller/main.php`
-	Function to select a quote now uses the `array_rand()` function instead of the `rand()` function based on the count of elements in the quotes array
	in `controller/main.php`
-	Input type of all game settings (points) is now `number` instead of `text`
-	ACP module is a controller with service injection now instead of a module with global variables
  
### Fixed
-	A faulty error message for a missing category (no ' in the `lang()` statement) in `styles/prosilver/template/hangman_input_word.html`
  
  
## [0.3.0] - 2021-10-20

### Added
-	A mirgation file (`migrations/v_0_3_0.php`) to remove `config` version number, add four new config variables and insert a new column into the
	`MOT_HANGMAN_WORDS` table
-	Tables are now defined in `config/tables.yml` and injected via services
-	A category to each search term, the usage can be switched on or off in the ACP
-	Made the deletion of used search terms an admin's selection in the ACP
-	An auto-refresh to all term input pages to automatically return to the input form after 1 or 2 seconds respectively
-	Leaving a running game results in a penalty of adding the loosing points to the player's account (function is selectable in the ACP)
-	The usage of punctuation marks is now possible, admin can define in the ACP what punctuation marks are available
  
### Changed
-	All DOM operations are now done using jQuery
-	Input field gets the focus on loading the Search Term Input page
-	Selection of the quote is now done in the PHP script and no longer within Javascript to reduce the traffic to the client
-	Language files `common.php` to reflect the change in deleting the used search term and to display the possible characters in the term input tab
-	Position of modal window in the game tab
-	Version number is now extracted from the `composer.json` file
  
### Fixed
-	Put `public` and `static` into the correct order in all migration files and in `event/listener.php`
  
### Removed
-	`config` variable `mot_hangman_version`, version is now extracted from `composer.json` file
  
  
## [0.2.5] - 2021-03-25

### Added
-	Bots are rerouted to the site's index page and users not logged in are rerouted to the login page in `controller/main.php`
	(courtesy of Dr.Death)
-	A migration file (`migrations/v_0_2_5.php`) to update `config` version number
	
### Changed
-	All links to Hangman tabs are using routes now (courtesy of Dr.Death), and these are defined only once and these definitions are used throughout
	`controller/main.php`
-	Layout of all three tabs is responsive
  
  
## [0.2.4] - 2021-03-17

### Added
-	A migration file `v_0_2_4.php` to update config version number and to rename tables to avoid conflicts with another extension which uses identical table
	names
-	css class `bg2` to input fields to prevent bright letters on bright background with dark prosilver styles
	(courtesy of Dr.Death)

### Changed
-	Table names from migration file `v_0_2_0.php` to avoid conflicts with another extension which uses identical table names
-	Letter buttons on the game tab
	(courtesy of Dr.Death)
-	Messages to the user are now displayed with a modal window instead of doing it with a Javascript alert window
-	Changed letter container in game tab from table to div to prevent the letters from "hiding" in mobile devices if screen width is less than table width

### Fixed
-	Handling for clearing a table depending on the type of database (SQLite3 and all others)
	(courtesy of 3Di)

### Removed
-	Reference to `app.php` from all links
-	min-width for main Hangman panel from `styles/prosilver/theme/hangman.css`
  
  
## [0.2.3] - 2021-03-09

### Added
-	A migration file `v_0_2_3.php` to update config version number
-	New hangman images (SVG files)
-	An ACP function to clear the highscore table, affected files are `acp/settings_module.php`, `adm/style/acp_hangman_settings.html`,
	`adm/style/acp_hangman_acp.css` and all `info_acp_hangman.php` language files
-	A js function (new file `styles/all/template/hangman_input.js`) to check and adjust the term input

### Changed
-	Layout of tabs and panels to meet prosilver criteria and enable customisation with styles inherited from prosilver
-	Some minor code changes to clean up the code
-	Possible letters to use are now obtained from the board's default language and no longer from the user's language

### Fixed
-	Two misspellings in English language pack
-	Hangman tabs obscuring drop down menu (Quick links)

### Removed
-	Hangman images (GIF files)
-	The `styles/all/template/event` subdirectory and its content, the `overall_footer_after.html` file which just included `hangman_game.js`.
	Including this file is now done within `styles/prosilver/template/hangman_game.html`
  
  
## [0.2.2] - 2021-03-02

### Added
-	A migration file `v_0_2_2.php` to update config version number

### Fixed
-	A bug which counted points and lives if a letter was selected by keyboard more than once (keyboard input wasn't monitored). Solved by monitoring used
	letters in a new array and checking each input against this array, affected file is `styles/all/template/hangman_game.js`
-	Displaying the Hangman tabs to parties not logged into the board by checking whether user is logged in in `styles/prosilver/template/hangman.html`


## [0.2.1] - 2021-03-01

### Added
-	An event handler to accept keyboard input
-	A migration file `v_0_2_1.php` to update config version number

### Changed
-	Display of start game button affecting `styles/prosilver/template/hangman_game.html` and `styles/prosilver/theme/hangman.css` files


## [0.2.0] - 2021-02-28

### Added
-	A migration file (`migrations/v_0_2_0.php`) to introduce new config variables, new tables and an ACP module
-	An ACP settings module
-	A highscore table
-	A form to enable users to define terms and quotes

### Changed
-	The game form
-	The Javascript code to play the game

### Removed
-	French language pack

## [0.1.0] - 2021-02-13

### Added
-	A CHANGELOG.md file to document changes
-	German language packs (de and de_x_sie)

### Changed
-	The `composer.json` file to take over the extension
-	The extension prefix from `dmzx` to `mot` in `config/routing.yml` and `config/services.yml`
-	The namespace in `controller/main.php`
-	The namespace in `event/listener.php`
-	All HTML files are now in TWIG syntax
-	The navigation icon into a Font Awesome icon

### Fixed
-	Missing single quotes in `config/services.yml`
-	Deprecated "pattern" in `config/routing.yml`

### Removed
-	The file `styles/all/template/event/overall_header_head_append.html` since its sole purpose was to include the css file which is done in `hangman.html`, too
