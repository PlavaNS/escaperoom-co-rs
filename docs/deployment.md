# Safe deployment path

Production is not connected to this repository yet. Do not treat a merge as a live-site deployment.

## Recommended sequence

1. Keep this public repository limited to reviewed, non-sensitive plugin code and documentation.
2. Test `door404-site-tools` on a staging WordPress copy.
3. Install the reviewed plugin through WordPress admin or an approved server deployment channel.
4. Migrate one WPCode snippet at a time, verify the public page, then disable only the matching WPCode snippet to prevent duplicate execution.
5. Roll back by re-enabling the matching WPCode snippet and deactivating the plugin release.

## Automation options

- Preferred: GitHub Actions deploying only `wp-content/plugins/door404-site-tools/` through an approved SSH/SFTP account stored as encrypted repository secrets.
- Fallback without server access: build a plugin ZIP in GitHub and upload the reviewed release through WordPress admin.
- Never commit passwords, application passwords, cookies, database exports, uploads, backups, or customer data.

## Required before production connection

- explicit approval of the deployment channel
- staging or equivalent pre-production verification
- confirmed rollback procedure
- secret storage in GitHub, never in files
- one monitored production release with public smoke tests
