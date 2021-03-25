# Change Log
All changes to `Hangman Game` will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).
  
## [0.2.5] - 2021-03-25

### Added
-	Bots are rerouted to the site's index page and users not logged in are rerouted to the login page in `controller/main.php`
	(courtesy of Dr.Death)
-	A mirgation file (`migrations/v_0_2_5.php`) to update `config` version number
	
### Changed
-	All links to Hangman tabs are using routes now (courtesy of Dr.Death), and these are defined only once and these definitions are used throughout
	`controller/main.php`
-	Layout of all three tabs is responsive
	
### Fixed

### Removed
  
  
## [0.2.4] - 2021-03-17

### Added
-	A migration file `v_0_2_4.php` to update config version number and to rename tables to avoid conflicts with another extension which uses identical table
	names
-	css class `bg2` to input fields to prevent bright letters on bright background with dark prosilver styles
	(courtesy of Dr.Death)

### Changed
-	Table names in migration file `v_0_2_0.php` to avoid conflicts with another extension which uses identical table names
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

### Changed

### Fixed
-	A bug which counted points and lives if a letter was selected by keyboard more than once (keyboard input wasn't monitored). Solved by monitoring used
	letters in a new array and checking each input against this array, affected file is `styles/all/template/hangman_game.js`
-	Displaying the Hangman tabs to parties not logged into the board by checking whether user is logged in in `styles/prosilver/template/hangman.html`

### Removed


## [0.2.1] - 2021-03-01

### Added
-	An event handler to accept keyboard input
-	A migration file `v_0_2_1.php` to update config version number

### Changed
-	Display of start game button affecting `styles/prosilver/template/hangman_game.html` and `styles/prosilver/theme/hangman.css` files

### Fixed

### Removed


## [0.2.0] - 2021-02-28

### Added
-	A migrition file (`migrations/v_0_2_0.php`) to introduce new config variables, new tables and an ACP module
-	An ACP settings module
-	A highscore table
-	A form to enable users to define terms and quotes

### Changed
-	The game form
-	The Javascript code to play the game

### Fixed

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
