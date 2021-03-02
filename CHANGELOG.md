# Change Log
All changes to `Hangman Game` will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).
  
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
-	A migrition file (`migritions/v_0_2_0.php`) to introduce new config variables, new tables and an ACP module
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
