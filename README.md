## Quantox School Board  (test)

### Setup & initialization

* Create config from sample

```bash
cp etc/config.php.sample etc/config.php
```

* Edit the config if need.
* Create database and import `dump.sql`

```bash
mysql -u root -p <database name> < dump.sql
```

* Update composer autoload

```bash
composer dump-autoload
```

### Launch

```bash
./bin/dev.sh
```
