## Repository for learning development Magento 2 ##

### Deployment ###
After running the `composer install` command revert the following files:
```bash
# .htaccess - checkout due to websites mapping and custom rewrite rules
git checkout .htaccess
```