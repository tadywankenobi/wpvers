WordPress Versions (for hosting solutions)
=====

The company I work for provides hosting to our clients. We work a lot with WordPress and, as a result, need to keep these sites up to date. Part of the problem is not always knowing when they are out of date. This script just runs through all the sites that have the file "wp-includes/version.php" (the WordPress version file) and compares it to the current release version, as pulled from the WordPress API site. If it's the current version, or the unpatched current version (e.g. 3.7 or 3.7.1), it's a green alert. If it's just a little older, it's an amber alert. If it's a lot older (more than one release older), it's a red alert.

Feel free to use it as you wish.

![Alt text](https://raw.github.com/tadywankenobi/wpvers/master/wpvers.png)