# UpgradePath wordpress integration

![GitHub](https://img.shields.io/github/license/upgradepath/wordpress-integration?style=flat-square)

## Contributing

### Local installation

```
cd docker
cp .env.local .env
docker-compose up -d
```

### Generating pot file

```bash
docker-compose exec wordpress bash
cd wp-content/plugins/upgradepath
wp i18n make-pot . assets/languages/upgradepath.pot
```

## Release

1. Update "Stable tag" in `readme.txt`
1. Change "Version" in `upgradepath.php`
1. Create release in GitHub
1. GitHub Action will deploy the created release to [wordpress.org](https://wordpress.org/plugins/upgradepath/).

## License

This wordpress plugin is licensed under the GPLv2. Please see the [license file](license.md) for more information.
