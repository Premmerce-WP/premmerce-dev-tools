# PLugin name
PLUGIN = $(notdir $(CURDIR))

# Build directory name
BUILD_DIR = $(CURDIR)/build
# Temp folder
BUILD_TMP = $(CURDIR)/../tmp
# Test wordpress site directory
TEST_DIR = /var/www/wp-test/wp-content/plugins/$(PLUGIN)
SVN_DIR = /var/www/svn_premmerce_plugins/$(PLUGIN)/trunk

all: composer publish

#Update composer scope sdk remove package from vendor and update autoload
composer:
	composer update --no-dev
	composer dumpautoload -o

publish: create_build clear create_test

#Create plugin build
create_build:
	rm -rf $(BUILD_TMP)
	rm -rf $(BUILD_DIR)
	rm -f $(PLUGIN).zip
	cp -ar . $(BUILD_TMP)
	mv $(BUILD_TMP) $(BUILD_DIR)

#Move plugin to test
create_test:
	rm -rf $(TEST_DIR)
	cp -ar $(BUILD_DIR) $(TEST_DIR)

create_svn:
	rm -rf $(SVN_DIR)
	cp -ar $(BUILD_DIR) $(SVN_DIR)

#Create zip archive
create_zip:
	rm -f $(PLUGIN).zip
	cd $(BUILD_DIR); zip -r $(PLUGIN).zip *; cd -;
	mv $(BUILD_DIR)/$(PLUGIN).zip $(PLUGIN).zip

#Remove unused files from plugin
clear:
	rm -f $(BUILD_DIR)/.gitignore
	rm -f $(BUILD_DIR)/.php_cs.dist
	rm -f $(BUILD_DIR)/composer.json
	rm -f $(BUILD_DIR)/composer.lock
	rm -f $(BUILD_DIR)/custom-strings.php
	rm -f $(BUILD_DIR)/fix_freemius
	rm -f $(BUILD_DIR)/makefile
	rm -f $(BUILD_DIR)/readme.md
	rm -rf $(BUILD_DIR)/.git


