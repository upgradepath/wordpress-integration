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

## License

This wordpress plugin is licensed under the GPLv2. Please see the [license file](license.md) for more information.
