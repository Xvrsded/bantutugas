#!/bin/bash

# Railway start script for Laravel
cd /app
php -S 0.0.0.0:${PORT:-8080} -t public/
