version: ## Application: displays the PHP version
	$(call runDockerComposeExec,php -v)

run: require-as-number-concurrency ## Application: run the main application script
	$(call runDockerComposeExec,php ./bootstrap/app.php ${concurrency})
