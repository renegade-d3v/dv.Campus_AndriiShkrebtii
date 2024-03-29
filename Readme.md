## Repository for learning development Magento 2 ##

### Deployment ###
After running the `composer install` command revert the following files:
```bash
# .htaccess - checkout due to websites mapping and custom rewrite rules
git checkout .htaccess
```

# Deploying changes to the server #

Deployment is automated to decrease the possible downtime. Files to run:
- `deploy-theme-only.sh` - deploy changes to templates, layouts, CSS, DI etc., without installing new modules, upgrading them or changing modules sequence.
- `deploy-full.sh` - deploy changes that include installing new modules, or data/schema upgrades.
  

To use this scripts the following environment variables must be set:
- `BUILD_SYSTEM_PATH` - path to the build system without `/` at the end (not visible from the web);
- `LIVE_SYSTEM_PATH` - path to the live system `/` at the end (development, staging, production etc.);
- `GIT_BRANCH` - branch to checkout and deploy.
  

To add these variables to the environment, run the following commands and restart the terminal session. Ensure that
`.bash_aliases` is available in your OS (debian-based mostly), use `~/.bash_profile` or other respective file otherwise:

```bash
export BUILD_SYSTEM_PATH="/path/to/the/build/system/" >> ~/.bash_aliases
export PRODUCTION_SYSTEM_PATH="/path/to/the/production/system/" >> ~/.bash_aliases
export GIT_BRANCH="name-of-you-branch" >> ~/.bash_aliases
```

Deployment process flow implemented in the above files:

1) go to the build system located in `/path/to/the/build/system/`;
2) pull changes, install modules, compile code and assets;
3) go to the live system in `/path/to/the/production/system/`;
4) enter maintenance mode (only for `deploy-full.sh`);
5) pull changes, run `composer install` (only for `deploy-full.sh`) and `setup:upgrade`;
6) copy generated files from the build system;
7) switch to the production mode;
8) turn off maintenance (only for `deploy-full.sh`).

### Compilation LESS files ###
For compilation CSS files, republish symlinks to the source files run commands and stay watch less files.
```bash
grunt exec:AndriiShkrebtii_luma_en_us && grunt less:AndriiShkrebtii_luma_en_us && grunt watch
```
After adding ru_RU local for site use new grunt command:
```bash
grunt exec:AndriiShkrebtii_luma_ru_ru && grunt less:AndriiShkrebtii_luma_ru_ru && grunt watch
```

## Hint for workinkg with layouts ##
For working with layout files created module 
### LayoutDebug Module ###
For start module edit config.php at string: 
```bash
'AndriiShkrebtii_LayoutDebug' => 0
```
switch to
```bash
'AndriiShkrebtii_LayoutDebug' => 1
```
and watch file: `var/log/layout_block.xml`


### Create and Update Database Dump ###
```bash
docker exec -it mysql80 sh -c "mysqldump -u<user> -p <db_name> --no-tablespaces | gzip > /tmp/db.sql.gz"
```
Move DB-file from container
```bash
docker container cp mysql80:/tmp/db.sql.gz db.sql.gz
```


## Applied Patches ##

Patches location: `var/patches/`

---

**Issue**: The command `i18n:collect-phrases` does not collect phrases defined in HTML files via `translate` and `$t()`.

**Issue info**: [i18n:collect-phrases -m can't find many important magento phrases](https://github.com/magento/magento2/issues/11175#)

**Affected component(s)**: `magento/magento2-base`

**Patch file(s)**:
- GitHub-11175_Fix-for-html-parser-in-i18n-collect-phrases.patch

**Fixed in**: Magento 2.4.2 (possibly only a partial fix will be shipped)

---
