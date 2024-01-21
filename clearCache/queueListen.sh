# !bin/bash

#============================================================
#   PHP Artisan Queue - Wrok Jobs (8000s timeout set and retry thrice, every failed event)
#============================================================

php artisan queue:listen  --tries=3 --timeout=8000
#php artisan queue:work redis --tries=3 --timeout=8000
