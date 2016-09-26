# shorturls-mediawiki
Add a SHORTURL magic word that generates a short URL for the current article

## Usage
Add this to your .htaccess file:
```
RewriteRule (\d+) extensions/ShortUrls/redirect/redirect.php [QSA,L]
```

# Known issues
* The namespace is currently hardcoded
* Deleting an article breaks the numbering
